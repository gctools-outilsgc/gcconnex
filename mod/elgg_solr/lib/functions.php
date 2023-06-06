<?php

function elgg_solr_reindex() {
	set_time_limit(0);

	$is_elgg18 = elgg_solr_is_elgg18();

	$guid_getter = 'elgg_solr_get_entity_guids';
	if ($is_elgg18) {
		$guid_getter = 'elgg_solr_get_entity_guids_18';
	}

	$ia = elgg_set_ignore_access(true);
	$show_hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	// lock the function
	elgg_set_plugin_setting('reindex_running', 1, 'elgg_solr');

	if (!file_exists(elgg_get_config('dataroot') . 'elgg_solr')) {
		mkdir(elgg_get_config('dataroot') . 'elgg_solr');
	}

	$logtime = elgg_get_config('elgg_solr_restart_logtime');
	if (!$logtime) {
		$logtime = time();
	}
	$log = elgg_get_config('dataroot') . 'elgg_solr/' . $logtime . '.txt';
	elgg_set_plugin_setting('current_log', $logtime, 'elgg_solr');

	// initialize the csv
	$report = array(
		'percent' => '',
		'count' => 0, // report prior to indexing this entity
		'typecount' => 0,
		'fullcount' => 0,
		'type' => '',
		'querytime' => 0,
		'message' => 'Initializing Reindex',
		'date' => date('Y-M-j H:i:s'),
		'logtime' => $logtime
	);
	file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);


	$debug = get_input('debug', false);
	if ($debug) {
		elgg_set_config('elgg_solr_debug', 1);
	}

	$registered_types = elgg_get_config('elgg_solr_reindex_options');
	if (!$registered_types) {
		$registered_types = get_registered_entity_types();
	}

	// build our options and cache them in case we need to restart it
	$cacheoptions = array(
		'types' => $registered_types
	);

	$options = array();
	$time = elgg_get_config('elgg_solr_time_options');
	if ($time && is_array($time)) {
		$options['wheres'] = array(
			"e.time_created >= {$time['starttime']}",
			"e.time_created <= {$time['endtime']}",
		);

		$cacheoptions['starttime'] = $time['starttime'];
		$cacheoptions['endtime'] = $time['endtime'];
	}

	elgg_set_config('elgg_solr_nocommit', true); // tell our indexer not to commit right away

	$fullcount = 0;
	foreach ($registered_types as $type => $subtypes) {
		$options['type'] = $type;
		$options['subtypes'] = ELGG_ENTITIES_ANY_VALUE;
		$options['limit'] = false;

		$restart_time = elgg_get_config('elgg_solr_restart_time');
		if ($restart_time) {
			elgg_set_config('elgg_solr_restart_time', false);

			$options['wheres'][1] = "e.time_created <= {$restart_time}";
		} elseif ($time['endtime']) {
			$options['wheres'][1] = "e.time_created <= {$time['endtime']}";
		}

		if ($subtypes) {
			if (!is_array($subtypes)) {
				$options['subtypes'] = array($subtypes);
			}
			else {
				$options['subtypes'] = $subtypes;
			}
		}

		// this iteration fixes a bug https://github.com/Elgg/Elgg/issues/7561
		// uses a custom getter which only fetches the guids in a single large-batch query
		// which is much more efficient than standard egef
		$batch_size = elgg_get_plugin_setting('reindex_batch_size', 'elgg_solr');
		$entities = new ElggBatch($guid_getter, $options, null, $batch_size);
		$final_count = $guid_getter(array_merge($options, array('count' => true)));

		elgg_set_config('elgg_solr_nocommit', true); // disable committing on each entity for performance
		$count = 0;
		$fetch_time_start = microtime(true);
		foreach ($entities as $e) {
			$count++;
			$fullcount++;
			$first_entity = (bool) (($count % $batch_size) == 1);
			$last_entity = (bool) (($count % $batch_size) == 0);

			if ($first_entity) {
				// this is the first entity in the new batch
				$fetch_time = microtime(true) - $fetch_time_start; // the query time in seconds
			}

			$entity = get_entity($e->guid);
			if ($entity) {
				elgg_solr_add_update_entity(null, null, $entity);
				elgg_set_config('elgg_solr_nocommit', true);
			}

			if (!($count % 200)) {
				$qtime = round($fetch_time, 4);
				$percent = round($count / $final_count * 100);
				if ($entity) {
					$restart_time = $entity->time_created;
				}
				$report = array(
					'percent' => $percent,
					'count' => $count,
					'typecount' => $final_count,
					'fullcount' => $fullcount,
					'type' => $type,
					'querytime' => $qtime,
					'message' => '',
					'date' => date('Y-M-j H:i:s'),
					'cacheoptions' => $cacheoptions,
					'logtime' => $logtime,
					'restart_time' => $restart_time
				);

				file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);
				elgg_set_config('elgg_solr_nocommit', false); // push a commit on this one

				// check for the termination signal
				if ($logtime == elgg_get_plugin_setting('stop_reindex', 'elgg_solr')) {
					$report = array(
						'percent' => $percent,
						'count' => $count,
						'typecount' => $final_count,
						'fullcount' => $fullcount,
						'type' => $type,
						'querytime' => $qtime,
						'message' => 'Reindex has been stopped',
						'date' => date('Y-M-j H:i:s'),
						'cacheoptions' => $cacheoptions,
						'logtime' => $logtime,
						'restart_time' => $restart_time
					);
					
					file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);
					error_log('Stopping reindex due to termination signal');
					exit;
				}
			}

			if ($last_entity) {
				$fetch_time_start = microtime(true);
			}
		}

		// we've finished this type, unset from the cache options
		unset($cacheoptions['types'][$type]);
	}

	$report = array(
		'percent' => '',
		'count' => 0, // report prior to indexing this entity
		'typecount' => 0,
		'fullcount' => 0,
		'type' => '',
		'querytime' => 0,
		'message' => 'Reindex complete',
		'date' => date('Y-M-j H:i:s'),
		'logtime' => $logtime
	);
	file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);
	elgg_set_plugin_setting('reindex_running', 0, 'elgg_solr');

	// commit the last of the entities
	$client = elgg_solr_get_client();
	$query = $client->createUpdate();
	$query->addCommit();

	try {
		$client->update($query);
	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	}

	access_show_hidden_entities($show_hidden);
	elgg_set_ignore_access($ia);
}

function elgg_solr_comment_reindex() {
	set_time_limit(0);

	$ia = elgg_set_ignore_access(true);
	$show_hidden = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	$debug = get_input('debug', false);
	if ($debug) {
		elgg_set_config('elgg_solr_debug', 1);
	}

	// lock the function
	elgg_set_plugin_setting('reindex_running', 1, 'elgg_solr');

	if (!file_exists(elgg_get_config('dataroot') . 'elgg_solr')) {
		mkdir(elgg_get_config('dataroot') . 'elgg_solr');
	}

	$time = time();
	$log = elgg_get_config('dataroot') . 'elgg_solr/' . $time . '.txt';
	elgg_set_plugin_setting('current_log', $time, 'elgg_solr');

	// initialize the csv
	$report = array(
		'percent' => '',
		'count' => 0, // report prior to indexing this entity
		'typecount' => 0,
		'fullcount' => 0,
		'type' => 'Comments',
		'querytime' => 0,
		'message' => 'Initializing Reindex',
		'date' => date('Y-M-j H:i:s')
	);
	file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);


	elgg_set_config('elgg_solr_nocommit', true); // tell our indexer not to commit right away

	$count = 0;

	// index comments
	$options = array(
		'annotation_name' => 'generic_comment',
		'limit' => false
	);

	$time = elgg_get_config('elgg_solr_time_options');
	if ($time && is_array($time)) {
		$options['annotation_created_time_lower'] = $time['starttime'];
		$options['annotation_created_time_upper'] = $time['endtime'];
	}

	$batch_size = elgg_get_plugin_setting('reindex_batch_size', 'elgg_solr');
	$comments = new ElggBatch('elgg_get_annotations', $options, null, $batch_size);

	$final_count = elgg_get_annotations(array_merge($options, array('count' => true)));
	$fetch_time_start = microtime(true);

	foreach ($comments as $comment) {
		$count++;
		$first_entity = (bool) (($count % $batch_size) == 1);
		$last_entity = (bool) (($count % $batch_size) == 0);

		if ($first_entity) {
			// this is the first entity in the new batch
			$fetch_time = microtime(true) - $fetch_time_start; // the query time in seconds
		}

		if ($count % 10000) {
			elgg_set_config('elgg_solr_nocommit', false); // push a commit on this one
		}

		if ($comment) {
			elgg_solr_index_annotation($comment);
			elgg_set_config('elgg_solr_nocommit', true);
		}

		if (!($count % 200)) {
			$qtime = round($fetch_time, 4);
			$percent = round($count / $final_count * 100);
			$report = array(
				'percent' => $percent,
				'count' => $count,
				'typecount' => $final_count,
				'fullcount' => $count,
				'type' => 'Comments',
				'querytime' => $qtime,
				'message' => '',
				'date' => date('Y-M-j H:i:s')
			);

			file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);
		}

		if ($last_entity) {
			$fetch_time_start = microtime(true);
		}
	}

	if ($debug) {
		elgg_solr_debug_log($count . ' entities sent to Solr');
	}

	$report = array(
		'percent' => 100,
		'count' => $count,
		'typecount' => $final_count,
		'fullcount' => $count,
		'type' => 'Comments',
		'querytime' => 0,
		'message' => 'Comment Reindex has been completed',
		'date' => date('Y-M-j H:i:s')
	);

	file_put_contents($log, json_encode($report) . "\n", FILE_APPEND);

	elgg_set_ignore_access($ia);
	access_show_hidden_entities($show_hidden);
	elgg_set_plugin_setting('reindex_running', 0, 'elgg_solr');
}

function elgg_solr_get_indexable_count() {
	$registered_types = get_registered_entity_types();

	$ia = elgg_set_ignore_access(true);

	$count = 0;
	foreach ($registered_types as $type => $subtypes) {
		$options = array(
			'type' => $type,
			'count' => true
		);

		if ($subtypes) {
			$options['subtypes'] = $subtypes;
		}

		$count += elgg_get_entities($options);
	}

	// count comments
	$options = array(
		'annotation_name' => 'generic_comment',
		'count' => true
	);
	$count += elgg_get_annotations($options);

	elgg_set_ignore_access($ia);

	return $count;
}

function elgg_solr_get_indexed_count($query = '*:*', $fq = array()) {
	$select = array(
		'query' => $query,
		'start' => 0,
		'rows' => 1,
		'fields' => array('id'),
	);

	// create a client instance
	$client = elgg_solr_get_client();

	// get an update query instance
	$query = $client->createSelect($select);

	if (!empty($fq)) {
		foreach ($fq as $key => $value) {
			$query->createFilterQuery($key)->setQuery($value);
		}
	}

	try {
		$resultset = $client->select($query);
	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	}

	return $resultset->getNumFound();
}

function elgg_solr_get_client() {
	elgg_load_library('Solarium');

	Solarium\Autoloader::register();

	$options = elgg_solr_get_adapter_options();

	$config = array('endpoint' => array(
			'localhost' => $options
	));

	// create a client instance
	return new Solarium\Client($config);
}

function elgg_solr_get_adapter_options() {
	return array(
		'host' => elgg_get_plugin_setting('host', 'elgg_solr'),
		'port' => elgg_get_plugin_setting('port', 'elgg_solr'),
		'path' => elgg_get_plugin_setting('solr_path', 'elgg_solr'),
		'core' => elgg_get_plugin_setting('solr_core', 'elgg_solr'),
	);
}

function elgg_solr_has_settings() {
	$host = elgg_get_plugin_setting('host', 'elgg_solr');
	$port = elgg_get_plugin_setting('port', 'elgg_solr');
	$path = elgg_get_plugin_setting('path', 'elgg_solr');

	if (empty($host) || empty($port) || empty($path)) {
		return false;
	}

	return true;
}

/**
 * get default filter queries based on search params
 * 
 * @param type $params
 * 
 * return array
 */
function elgg_solr_get_default_fq($params) {
	$fq = array();

	// type/types
	if (isset($params['type']) && $params['type'] !== ELGG_ENTITIES_ANY_VALUE) {
		if ($params['type'] === ELGG_ENTITIES_NO_VALUE) {
			//$fq['type'] = '-type:[* TO *]';
			$fq['type'] = 'type:""';
		} else {
			$fq['type'] = 'type:' . $params['type'];
		}
	}

	if ($params['types'] && $params['types'] !== ELGG_ENTITIES_ANY_VALUE) {
		if (is_array($params['types'])) {
			$fq['type'] = 'type:(' . implode(' OR ', $params['types']) . ')';
		} else {
			if ($params['types'] === ELGG_ENTITIES_NO_VALUE) {
				//$fq['type'] = '-type:[* TO *]';
				$fq['type'] = 'type:""';
			} else {
				$fq['type'] = 'type:' . $params['types'];
			}
		}
	}

	//subtype
	if (isset($params['subtype']) && $params['subtype'] !== ELGG_ENTITIES_ANY_VALUE) {
		if ($params['subtype'] === ELGG_ENTITIES_NO_VALUE) {
			//$fq['subtype'] = '-subtype:[* TO *]';
			$fq['subtype'] = 'subtype:""';
		} else {
			$fq['subtype'] = 'subtype:' . $params['subtype'];
		}
	}

	if (isset($params['subtypes']) && $params['subtypes'] !== ELGG_ENTITIES_ANY_VALUE) {
		if (is_array($params['subtypes'])) {
			$fq['subtype'] = 'subtype:(' . implode(' OR ', $params['subtypes']) . ')';
		} else {
			if ($params['subtypes'] === ELGG_ENTITIES_NO_VALUE) {
				//$fq['subtype'] = '-subtype:[* TO *]';
				$fq['subtype'] = 'subtype:""';
			} else {
				$fq['subtype'] = 'subtype:' . $params['subtypes'];
			}
		}
	}


	//container
	if (isset($params['container_guid']) && $params['container_guid'] !== ELGG_ENTITIES_ANY_VALUE) {
		$fq['container'] = 'container_guid:' . $params['container_guid'];
	}

	if (isset($params['container_guids']) && $params['container_guids'] !== ELGG_ENTITIES_ANY_VALUE) {
		if (is_array($params['container_guids'])) {
			$fq['container'] = 'container_guid:(' . implode(' OR ', $params['container_guids']) . ')';
		} else {
			$fq['container'] = 'container_guid:' . $params['container_guid'];
		}
	}

	//owner
	if (isset($params['owner_guid']) && $params['owner_guid'] !== ELGG_ENTITIES_ANY_VALUE) {
		$fq['owner'] = 'owner_guid:' . $params['owner_guid'];
	}

	if (isset($params['owner_guids']) && $params['owner_guids'] !== ELGG_ENTITIES_ANY_VALUE) {
		if (is_array($params['owner_guids'])) {
			$fq['owner'] = 'owner_guid:(' . implode(' OR ', $params['owner_guids']) . ')';
		} else {
			$fq['owner'] = 'owner_guid:' . $params['owner_guid'];
		}
	}

	$access_query = elgg_solr_get_access_query();
	if ($access_query) {
		$fq['access'] = $access_query;
	}

	return $fq;
}

/**
 * Register a function to define specific configuration of an entity in solr
 * 
 * @param type $type - the entity type
 * @param type $subtype - the entity subtype
 * @param type $function - the function to call for updating an entity in solr
 */
function elgg_solr_register_solr_entity_type($type, $subtype, $function) {
	$solr_entities = elgg_get_config('solr_entities');

	if (!is_array($solr_entities)) {
		$solr_entities = array();
	}

	$solr_entities[$type][$subtype] = $function;

	elgg_set_config('solr_entities', $solr_entities);
}

/**
 * 
 * 
 * @param type $type
 * @param type $subtype
 * @return boolean
 */
function elgg_solr_get_solr_function($type, $subtype) {
	if (elgg_get_config('elgg_solr_debug')) {
		$debug = true;
	}

	$solr_entities = elgg_get_config('solr_entities');

	if (isset($solr_entities[$type][$subtype]) && is_callable($solr_entities[$type][$subtype])) {
		return $solr_entities[$type][$subtype];
	}

	if (isset($solr_entities[$type]['default']) && is_callable($solr_entities[$type]['default'])) {
		return $solr_entities[$type]['default'];
	}

	if (isset($solr_entities['entity']['default']) && is_callable($solr_entities['entity']['default'])) {
		return $solr_entities['entity']['default'];
	}

	if ($debug) {
		elgg_solr_debug_log('Solr function not callable for type: ' . $type . ', subtype: ' . $subtype);
	}

	return false;
}

/**
 * Index a file entity
 * 
 * @param type $entity
 * @return boolean
 */
function elgg_solr_add_update_file($entity) {

	$client = elgg_solr_get_client();
	$commit = elgg_get_config('elgg_solr_nocommit') ? false : true;

	$extract = elgg_get_plugin_setting('extract_handler', 'elgg_solr');
	$extracting = false;
	if (file_exists($entity->getFilenameOnFilestore()) && $extract == 'yes') {
		$extracting = true;
	}

	if ($extracting) {
		// get an extract query instance and add settings
		$query = $client->createExtract();
		$query->setFile($entity->getFilenameOnFilestore());
		$query->addFieldMapping('content', 'attr_content');
		$query->setUprefix('attr_');
		$query->setOmitHeader(true);
	} else {
		$query = $client->createUpdate();
	}
	
	$subtype = $entity->getSubtype() ? $entity->getSubtype() : '';

	// add document
	$doc = $query->createDocument();
	$doc->id = $entity->guid;
	$doc->type = $entity->type;
	$doc->subtype = $subtype;
	$doc->owner_guid = $entity->owner_guid;
	$doc->container_guid = $entity->container_guid;
	$doc->access_id = $entity->access_id;
	$doc->title = gc_explode_translation(elgg_strip_tags($entity->title), get_current_language());
	$doc->description = gc_explode_translation(elgg_strip_tags($entity->description), get_current_language());
	$doc->time_created = $entity->time_created;
	$doc = elgg_solr_add_tags($doc, $entity);
	$doc->enabled = $entity->enabled;

	$params = array('entity' => $entity);
	$doc = elgg_trigger_plugin_hook('elgg_solr:index', $entity->type, $params, $doc);
	
	if (!$doc) {
		return true; // a plugin hook has stopped the indexing
	}

	if ($extracting) {
		$query->setDocument($doc);
		if ($commit) {
			$query->setCommit(true);
		}
		try {
			$client->extract($query);
		} catch (Exception $exc) {
			error_log($exc->getMessage());
		}
	} else {
		$query->addDocument($doc);
		if ($commit) {
			$query->addCommit();
		}

		try {
			$client->update($query);
		} catch (Exception $exc) {
			error_log($exc->getMessage());
		}
	}

	return true;
}

/**
 * Index a generic elgg object
 * 
 * @param type $entity
 * @return boolean
 */
function elgg_solr_add_update_object_default($entity) {

	if (!is_registered_entity_type($entity->type, $entity->getSubtype())) {
		return false;
	}

	$client = elgg_solr_get_client();
	$commit = elgg_get_config('elgg_solr_nocommit') ? false : true;

	$query = $client->createUpdate();
	
	$subtype = $entity->getSubtype() ? $entity->getSubtype() : '';

	// add document
	$doc = $query->createDocument();
	$doc->id = $entity->guid;
	$doc->type = $entity->type;
	$doc->subtype = $subtype;
	$doc->owner_guid = $entity->owner_guid;
	$doc->container_guid = $entity->container_guid;
	$doc->access_id = $entity->access_id;
	$doc->title = gc_explode_translation(elgg_strip_tags($entity->title), get_current_language());
	$doc->name = gc_explode_translation(elgg_strip_tags($entity->name), get_current_language());
	$doc->description = gc_explode_translation(elgg_strip_tags($entity->description), get_current_language());
	$doc->time_created = $entity->time_created;
	$doc = elgg_solr_add_tags($doc, $entity);
	$doc->enabled = $entity->enabled;

	$params = array('entity' => $entity);
	$doc = elgg_trigger_plugin_hook('elgg_solr:index', $entity->type, $params, $doc);
	
	if (!$doc) {
		return true; // a plugin has stopped the index
	}

	$query->addDocument($doc);
	if ($commit) {
		$query->addCommit($commit);
	}

	// this executes the query and returns the result
	try {
		$client->update($query);
	} catch (Exception $exc) {
		error_log($exc->getMessage());
	}

	return true;
}

function elgg_solr_add_update_user($entity) {

	if (!elgg_instanceof($entity, 'user')) {
		return false;
	}

	if (!is_registered_entity_type($entity->type, $entity->getSubtype())) {
		return false;
	}

	// lump public profile fields in with description
	$profile_fields = elgg_get_config('profile_fields');
	$desc = '';
	if (is_array($profile_fields) && sizeof($profile_fields) > 0) {
		$walled = elgg_get_config('walled_garden');
		foreach ($profile_fields as $shortname => $valtype) {
			$md = elgg_get_metadata(array(
				'guid' => $entity->guid,
				'metadata_names' => array($shortname)
			));

			foreach ($md as $m) {
				if ($m->access_id == ACCESS_PUBLIC || ($walled && $m->access_id == ACCESS_LOGGED_IN)) {
					$desc .= $m->value . ' ';
				}
			}
		}
	}

	$client = elgg_solr_get_client();
	$commit = elgg_get_config('elgg_solr_nocommit') ? false : true;

	$query = $client->createUpdate();
	$subtype = $entity->getSubtype() ? $entity->getSubtype() : '';

	// add document
	$doc = $query->createDocument();
	$doc->id = $entity->guid;
	$doc->type = $entity->type;
	$doc->subtype = $subtype;
	$doc->owner_guid = $entity->owner_guid;
	$doc->container_guid = $entity->container_guid;
	$doc->access_id = $entity->access_id;
	$doc->title = elgg_strip_tags($entity->title);
	$doc->name = elgg_strip_tags($entity->name);
	$doc->username = $entity->username;
	$doc->description = elgg_strip_tags($desc);
	$doc->time_created = $entity->time_created;
	$doc = elgg_solr_add_tags($doc, $entity);
	$doc->enabled = $entity->enabled;
	$doc->user_type = $entity->user_type;

	$params = array('entity' => $entity);
	$doc = elgg_trigger_plugin_hook('elgg_solr:index', $entity->type, $params, $doc);
	
	if (!$doc) {
		return true; // a plugin has stopped the index
	}

	$query->addDocument($doc, true);
	if ($commit) {
		$query->addCommit();
	}

	// this executes the query and returns the result
	try {
		$client->update($query);
	} catch (Exception $exc) {
		error_log($exc->getMessage());
	}
	return true;
}

function elgg_solr_debug_log($message) {
	error_log($message);
}

function elgg_solr_get_access_query() {

	if (elgg_is_admin_logged_in() || elgg_get_ignore_access()) {
		return false; // no access limit
	}

	static $return;

	if ($return) {
		return $return;
	}

	$access = get_access_array();

	// access filter query
	if ($access) {
		$access_list = implode(' ', $access);
	}

	if (elgg_is_logged_in()) {

		// get friends
		// @TODO - is there a better way? Not sure if there's a limit on solr if
		// someone has a whole lot of friends...
		$friends = elgg_get_entities_from_relationship(array(
			'type' => 'user',
			'relationship' => 'friend',
			'relationship_guid' => elgg_get_logged_in_user_guid(),
			'inverse_relationship' => true,
			'limit' => false,
			'callback' => false // keep the query fast
		));

		$friend_guids = array();
		foreach ($friends as $friend) {
			$friend_guids[] = $friend->guid;
		}

		$friends_list = '';
		if ($friend_guids) {
			$friends_list = elgg_solr_escape_special_chars(implode(' ', $friend_guids));
		}
	}

	//$query->createFilterQuery('access')->setQuery("owner_guid: {guid} OR access_id:({$access_list}) OR (access_id:" . ACCESS_FRIENDS . " AND owner_guid:({$friends}))");
	if (elgg_is_logged_in()) {
		$return = "owner_guid:" . elgg_get_logged_in_user_guid();
	} else {
		$return = '';
	}

	if ($access_list) {
		if ($return) {
			$return .= ' OR ';
		}
		$return .= "access_id:(" . elgg_solr_escape_special_chars($access_list) . ")";
	}

	$fr_prefix = '';
	$fr_suffix = '';
	if ($return && $friends_list) {
		$return .= ' OR ';
		$fr_prefix = '(';
		$fr_suffix = ')';
	}

	if ($friends_list) {
		$return .= $fr_prefix . 'access_id:' . elgg_solr_escape_special_chars(ACCESS_FRIENDS) . ' AND owner_guid:(' . $friends_list . ')' . $fr_suffix;
	}

	return $return;
}

/**
 * by default there's nothing we need to do different with this
 * so it's just a wrapper for object add
 * 
 * @param type $entity
 */
function elgg_solr_add_update_group_default($entity) {
	elgg_solr_add_update_object_default($entity);
}

function elgg_solr_escape_special_chars($string) {
	// Lucene characters that need escaping with \ are + - && || ! ( ) { } [ ] ^ " ~ * ? : \
	$luceneReservedCharacters = preg_quote('+-&|!(){}[]^"~*?:\\');
	$query = preg_replace_callback('/([' . $luceneReservedCharacters . '])/', 'elgg_solr_escape_special_chars_callback', $string);
	return $query;
}

function elgg_solr_escape_special_chars_callback($matches) {
	return '\\' . $matches[0];
}

/**
 * 
 * @param type $time - timestamp of the start of the block
 * @param type $block - the block of time, hour/day/month/year/all
 * @param type $type
 * @param type $subtype
 * @return type
 */
function elgg_solr_get_stats($time, $block, $type, $subtype) {
	$options = array(
		'type' => $type
	);

	$fq = array();

	if ($subtype) {
		$options['subtype'] = $subtype;
		$fq['subtype'] = "subtype:{$subtype}";
	} else {
		$options['subtype'] = ELGG_ENTITIES_NO_VALUE;
	}

	$stats = array();
	switch ($block) {
		case 'minute':
			for ($i = 0; $i < 60; $i++) {
				$starttime = mktime(date('G', $time), date('i', $time), $i, date('m', $time), date('j', $time), date('Y', $time));
				$endtime = mktime(date('G', $time), date('i', $time), $i + 1, date('m', $time), date('j', $time), date('Y', $time));

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[date('s', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => false
				);
			}
			break;
		case 'hour':
			for ($i = 0; $i < 60; $i++) {
				$starttime = mktime(date('G', $time), $i, 0, date('m', $time), date('j', $time), date('Y', $time));
				$endtime = mktime(date('G', $time), $i + 1, 0, date('m', $time), date('j', $time), date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[date('i', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => false
				);
			}
			break;
		case 'day':
			for ($i = 0; $i < 24; $i++) {
				$starttime = mktime($i, 0, 0, date('m', $time), date('j', $time), date('Y', $time));
				$endtime = mktime($i + 1, 0, 0, date('m', $time), date('j', $time), date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[date('H', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'hour'
				);
			}
			break;
		case 'month':
			for ($i = 1; $i < date('t', $time) + 1; $i++) {
				$starttime = mktime(0, 0, 0, date('m', $time), $i, date('Y', $time));
				$endtime = mktime(0, 0, 0, date('m', $time), $i + 1, date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[date('d', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'day'
				);
			}
			break;
		case 'year':
			for ($i = 1; $i < 13; $i++) {
				$starttime = mktime(0, 0, 0, $i, 1, date('Y', $time));
				$endtime = mktime(0, 0, 0, $i + 1, 1, date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[date('F', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'month'
				);
			}
			break;

		case 'all':
		default:
			$startyear = date('Y', elgg_get_site_entity()->time_created);
			$currentyear = date('Y');

			for ($i = $currentyear; $i > $startyear - 1; $i--) {
				$starttime = mktime(0, 0, 0, 1, 1, $i);
				$endtime = mktime(0, 0, 0, 1, 1, $i + 1) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_solr_get_system_count($options, $starttime, $endtime);

				$stats[$i] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'year'
				);
			}

			break;
	}

	return $stats;
}

function elgg_solr_get_system_count($options, $starttime, $endtime) {
	$options['wheres'] = array(
		"e.time_created >= {$starttime}",
		"e.time_created <= {$endtime}"
	);

	$options['count'] = true;

	$access = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	$count = elgg_get_entities($options);
	access_show_hidden_entities($access);

	return $count;
}

function elgg_solr_get_display_datetime($time, $block) {

	switch ($block) {
		case 'year':
			$format = 'Y';
			break;
		case 'month':
			$format = 'F Y';
			break;
		case 'day':
			$format = 'F j, Y';
			break;
		case 'hour':
			$format = 'F j, Y H:00';
			break;
		case 'minute':
			$format = 'F j, Y H:i';
			break;
		case 'all':
		default:
			return elgg_echo('elgg_solr:time:all');
			break;
	}

	return date($format, $time);
}

/**
 * Returns an array of tags for indexing
 * 
 * @param type $entity
 * @return string
 */
function elgg_solr_get_tags_array($entity) {
	$valid_tag_names = elgg_get_registered_tag_metadata_names();

	$t = array();
	if ($valid_tag_names && is_array($valid_tag_names)) {
		foreach ($valid_tag_names as $tagname) {
			$tags = $entity->$tagname;
			if ($tags && !is_array($tags)) {
				$tags = array($tags);
			}

			if ($tags && is_array($tags)) {
				foreach ($tags as $tag) {
					$t[] = $tagname . '%%' . $tag;
				}
			}
		}
	}

	return $t;
}


function elgg_solr_add_tags($doc, $entity) {
	if (!elgg_instanceof($entity)) {
		return $doc;
	}
	
	// store tags the old way - lumped together in $doc->tags as $name . '%%' . $value'
	$doc->tags = elgg_solr_get_tags_array($entity);
	
	// also store them separately with magick fields
	// store in different field types for different search types
	$valid_tag_names = elgg_get_registered_tag_metadata_names();

	if ($valid_tag_names && is_array($valid_tag_names)) {
		foreach ($valid_tag_names as $tagname) {
			$tags = $entity->$tagname;
			if ($tags && !is_array($tags)) {
				$tags = array($tags);
			}

			$name = 'tag_' . $tagname . '_ss'; // multivalued string
			$doc->$name = $tags;
		}
	}
	
	return $doc;
}

function elgg_solr_get_title_boost() {
	static $title_boost;

	if ($title_boost) {
		return $title_boost;
	}

	$title_boost = elgg_get_plugin_setting('title_boost', 'elgg_solr');
	if (!is_numeric($title_boost)) {
		$title_boost = 1.5;
	}

	return $title_boost;
}

function elgg_solr_get_description_boost() {
	static $description_boost;

	if ($description_boost) {
		return $description_boost;
	}

	$description_boost = elgg_get_plugin_setting('description_boost', 'elgg_solr');
	if (!is_numeric($description_boost)) {
		$description_boost = 1.5;
	}

	return $description_boost;
}

function elgg_solr_get_boost_query() {
	static $boostquery;

	if ($boostquery || $boostquery === false) {
		return $boostquery;
	}

	$use_boostquery = elgg_get_plugin_setting('use_time_boost', 'elgg_solr');
	if ($use_boostquery != 'yes') {
		$boostquery = false;
		return $boostquery;
	}

	$num = elgg_get_plugin_setting('time_boost_num', 'elgg_solr');
	$interval = elgg_get_plugin_setting('time_boost_interval', 'elgg_solr');
	$time_boost = elgg_get_plugin_setting('time_boost', 'elgg_solr');
	$starttime = strtotime("-{$num} {$interval}");
	$now = time();

	if (!is_numeric($num) || !is_numeric($starttime) || !is_numeric($time_boost)) {
		$boostquery = false;
		return $boostquery;
	}

	$boostquery = "time_created:[{$starttime} TO {$now}]^{$time_boost}";
	return $boostquery;
}

function elgg_solr_get_hl_prefix() {
	static $hl_prefix;

	if ($hl_prefix) {
		return $hl_prefix;
	}

	$hl_prefix = elgg_get_plugin_setting('hl_prefix', 'elgg_solr');

	return $hl_prefix;
}

function elgg_solr_get_hl_suffix() {
	static $hl_suffix;

	if ($hl_suffix) {
		return $hl_suffix;
	}

	$hl_suffix = elgg_get_plugin_setting('hl_suffix', 'elgg_solr');

	return $hl_suffix;
}

function elgg_solr_defer_index_update($guid) {
	$guids = elgg_get_config('elgg_solr_sync');
	if (!is_array($guids)) {
		$guids = array();
	}
	$guids[$guid] = 1; // use key to keep it unique

	elgg_set_config('elgg_solr_sync', $guids);
}

function elgg_solr_defer_index_delete($guid) {
	$delete_guids = elgg_get_config('elgg_solr_delete');
	if (!is_array($delete_guids)) {
		$delete_guids = array();
	}

	$delete_guids[$guid] = 1;

	elgg_set_config('elgg_solr_delete', $delete_guids);
}

function elgg_solr_defer_annotation_delete($id) {
	$delete_ids = elgg_get_config('elgg_solr_annotation_delete');
	if (!is_array($delete_ids)) {
		$delete_ids = array();
	}

	$delete_ids[$id] = 1;

	elgg_set_config('elgg_solr_annotation_delete', $delete_ids);
}


// 1.8 only
// copy of elgg_get_entities
// but only returns guids for performance
// ignores access
function elgg_solr_get_entity_guids_18($options) {
	global $CONFIG;

	$defaults = array(
		'types' => ELGG_ENTITIES_ANY_VALUE,
		'subtypes' => ELGG_ENTITIES_ANY_VALUE,
		'type_subtype_pairs' => ELGG_ENTITIES_ANY_VALUE,
		'guids' => ELGG_ENTITIES_ANY_VALUE,
		'owner_guids' => ELGG_ENTITIES_ANY_VALUE,
		'container_guids' => ELGG_ENTITIES_ANY_VALUE,
		'site_guids' => $CONFIG->site_guid,
		'modified_time_lower' => ELGG_ENTITIES_ANY_VALUE,
		'modified_time_upper' => ELGG_ENTITIES_ANY_VALUE,
		'created_time_lower' => ELGG_ENTITIES_ANY_VALUE,
		'created_time_upper' => ELGG_ENTITIES_ANY_VALUE,
		'reverse_order_by' => false,
		'order_by' => 'e.guid desc',
		'group_by' => ELGG_ENTITIES_ANY_VALUE,
		'limit' => 10,
		'offset' => 0,
		'count' => FALSE,
		'selects' => array(),
		'wheres' => array(),
		'joins' => array(),
		'callback' => false,
		'__ElggBatch' => null,
	);

	$options = array_merge($defaults, $options);

	// can't use helper function with type_subtype_pair because
	// it's already an array...just need to merge it
	if (isset($options['type_subtype_pair'])) {
		if (isset($options['type_subtype_pairs'])) {
			$options['type_subtype_pairs'] = array_merge($options['type_subtype_pairs'], $options['type_subtype_pair']);
		} else {
			$options['type_subtype_pairs'] = $options['type_subtype_pair'];
		}
	}

	$singulars = array('type', 'subtype', 'guid', 'owner_guid', 'container_guid', 'site_guid');
	$options = elgg_normalise_plural_options_array($options, $singulars);

	// evaluate where clauses
	if (!is_array($options['wheres'])) {
		$options['wheres'] = array($options['wheres']);
	}

	$wheres = $options['wheres'];

	$wheres[] = elgg_get_entity_type_subtype_where_sql('e', $options['types'], $options['subtypes'], $options['type_subtype_pairs']);

	$wheres[] = elgg_get_guid_based_where_sql('e.guid', $options['guids']);
	$wheres[] = elgg_get_guid_based_where_sql('e.owner_guid', $options['owner_guids']);
	$wheres[] = elgg_get_guid_based_where_sql('e.container_guid', $options['container_guids']);
	$wheres[] = elgg_get_guid_based_where_sql('e.site_guid', $options['site_guids']);

	$wheres[] = elgg_get_entity_time_where_sql('e', $options['created_time_upper'], $options['created_time_lower'], $options['modified_time_upper'], $options['modified_time_lower']);

	// see if any functions failed
	// remove empty strings on successful functions
	foreach ($wheres as $i => $where) {
		if ($where === FALSE) {
			return FALSE;
		} elseif (empty($where)) {
			unset($wheres[$i]);
		}
	}

	// remove identical where clauses
	$wheres = array_unique($wheres);

	// evaluate join clauses
	if (!is_array($options['joins'])) {
		$options['joins'] = array($options['joins']);
	}

	// remove identical join clauses
	$joins = array_unique($options['joins']);

	foreach ($joins as $i => $join) {
		if ($join === FALSE) {
			return FALSE;
		} elseif (empty($join)) {
			unset($joins[$i]);
		}
	}

	// evalutate selects
	if ($options['selects']) {
		$selects = '';
		foreach ($options['selects'] as $select) {
			$selects .= ", $select";
		}
	} else {
		$selects = '';
	}

	if (!$options['count']) {
		$distinct = '';
		if ($options['require_distinct']) {
			$distinct = ' DISTINCT';
		}
		$query = "SELECT{$distinct} e.guid FROM {$CONFIG->dbprefix}entities e ";
	} else {
		$query = "SELECT count(DISTINCT e.guid) as total FROM {$CONFIG->dbprefix}entities e ";
	}

	// add joins
	foreach ($joins as $j) {
		$query .= " $j ";
	}

	// add wheres
	$query .= ' WHERE ';

	foreach ($wheres as $w) {
		$query .= " $w AND ";
	}

	// Add access controls
	$query .= get_access_sql_suffix('e');

	// reverse order by
	if ($options['reverse_order_by']) {
		$options['order_by'] = elgg_sql_reverse_order_by_clause($options['order_by']);
	}

	if (!$options['count']) {
		if ($options['group_by']) {
			$query .= " GROUP BY {$options['group_by']}";
		}

		if ($options['order_by']) {
			$query .= " ORDER BY {$options['order_by']}";
		}

		if ($options['limit']) {
			$limit = sanitise_int($options['limit'], false);
			$offset = sanitise_int($options['offset'], false);
			$query .= " LIMIT $offset, $limit";
		}

		$dt = get_data($query);

		return $dt;
	} else {
		$total = get_data_row($query);
		return (int) $total->total;
	}
}

function elgg_solr_get_entity_guids(array $options = array()) {
	global $CONFIG;

	$defaults = array(
		'types' => ELGG_ENTITIES_ANY_VALUE,
		'subtypes' => ELGG_ENTITIES_ANY_VALUE,
		'type_subtype_pairs' => ELGG_ENTITIES_ANY_VALUE,
		'guids' => ELGG_ENTITIES_ANY_VALUE,
		'owner_guids' => ELGG_ENTITIES_ANY_VALUE,
		'container_guids' => ELGG_ENTITIES_ANY_VALUE,
		'site_guids' => $CONFIG->site_guid,
		'modified_time_lower' => ELGG_ENTITIES_ANY_VALUE,
		'modified_time_upper' => ELGG_ENTITIES_ANY_VALUE,
		'created_time_lower' => ELGG_ENTITIES_ANY_VALUE,
		'created_time_upper' => ELGG_ENTITIES_ANY_VALUE,
		'reverse_order_by' => false,
		'order_by' => 'e.time_created desc',
		'group_by' => ELGG_ENTITIES_ANY_VALUE,
		'limit' => 10,
		'offset' => 0,
		'count' => false,
		'selects' => array(),
		'wheres' => array(),
		'joins' => array(),
		'callback' => false,
		'__ElggBatch' => null,
	);

	$options = array_merge($defaults, $options);

	// can't use helper function with type_subtype_pair because
	// it's already an array...just need to merge it
	if (isset($options['type_subtype_pair'])) {
		if (isset($options['type_subtype_pairs'])) {
			$options['type_subtype_pairs'] = array_merge($options['type_subtype_pairs'], $options['type_subtype_pair']);
		} else {
			$options['type_subtype_pairs'] = $options['type_subtype_pair'];
		}
	}

	$singulars = array('type', 'subtype', 'guid', 'owner_guid', 'container_guid', 'site_guid');
	$options = _elgg_normalize_plural_options_array($options, $singulars);

	// evaluate where clauses
	if (!is_array($options['wheres'])) {
		$options['wheres'] = array($options['wheres']);
	}

	$wheres = $options['wheres'];

	$wheres[] = _elgg_get_entity_type_subtype_where_sql('e', $options['types'], $options['subtypes'], $options['type_subtype_pairs']);

	$wheres[] = _elgg_get_guid_based_where_sql('e.guid', $options['guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('e.owner_guid', $options['owner_guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('e.container_guid', $options['container_guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('e.site_guid', $options['site_guids']);

	$wheres[] = _elgg_get_entity_time_where_sql('e', $options['created_time_upper'], $options['created_time_lower'], $options['modified_time_upper'], $options['modified_time_lower']);

	// see if any functions failed
	// remove empty strings on successful functions
	foreach ($wheres as $i => $where) {
		if ($where === false) {
			return false;
		} elseif (empty($where)) {
			unset($wheres[$i]);
		}
	}

	// remove identical where clauses
	$wheres = array_unique($wheres);

	// evaluate join clauses
	if (!is_array($options['joins'])) {
		$options['joins'] = array($options['joins']);
	}

	// remove identical join clauses
	$joins = array_unique($options['joins']);

	foreach ($joins as $i => $join) {
		if ($join === false) {
			return false;
		} elseif (empty($join)) {
			unset($joins[$i]);
		}
	}

	// evalutate selects
	if ($options['selects']) {
		$selects = '';
		foreach ($options['selects'] as $select) {
			$selects .= ", $select";
		}
	} else {
		$selects = '';
	}

	if (!$options['count']) {
		$distinct = '';
		if ($options['require_distinct']) {
			$distinct = ' DISTINCT';
		}
		$query = "SELECT{$distinct} e.guid{$selects} FROM {$CONFIG->dbprefix}entities e ";
	} else {
		$query = "SELECT count(DISTINCT e.guid) as total FROM {$CONFIG->dbprefix}entities e ";
	}

	// add joins
	foreach ($joins as $j) {
		$query .= " $j ";
	}

	// add wheres
	$query .= ' WHERE ';

	foreach ($wheres as $w) {
		$query .= " $w AND ";
	}

	// Add access controls
	$query .= _elgg_get_access_where_sql();

	// reverse order by
	if ($options['reverse_order_by']) {
		$options['order_by'] = _elgg_sql_reverse_order_by_clause($options['order_by']);
	}

	if (!$options['count']) {
		if ($options['group_by']) {
			$query .= " GROUP BY {$options['group_by']}";
		}

		if ($options['order_by']) {
			$query .= " ORDER BY {$options['order_by']}";
		}

		if ($options['limit']) {
			$limit = sanitise_int($options['limit'], false);
			$offset = sanitise_int($options['offset'], false);
			$query .= " LIMIT $offset, $limit";
		}

		if ($options['callback'] === 'entity_row_to_elggstar') {
			$dt = _elgg_fetch_entities_from_sql($query, $options['__ElggBatch']);
		} else {
			$dt = get_data($query, $options['callback']);
		}

		if ($dt) {
			// populate entity and metadata caches
			$guids = array();
			foreach ($dt as $item) {
				// A custom callback could result in items that aren't ElggEntity's, so check for them
				if ($item instanceof ElggEntity) {
					_elgg_cache_entity($item);
					// plugins usually have only settings
					if (!$item instanceof ElggPlugin) {
						$guids[] = $item->guid;
					}
				}
			}
			// @todo Without this, recursive delete fails. See #4568
			reset($dt);

			if ($guids) {
				_elgg_get_metadata_cache()->populateFromEntities($guids);
			}
		}
		return $dt;
	} else {
		$total = get_data_row($query);
		return (int) $total->total;
	}
}

function elgg_solr_index_annotation($annotation) {
	$client = elgg_solr_get_client();
	$commit = elgg_get_config('elgg_solr_nocommit') ? false : true;

	$query = $client->createUpdate();

	// add document
	$doc = $query->createDocument();
	$doc->id = 'annotation:' . $annotation->id;
	$doc->type = 'annotation';
	$doc->subtype = $annotation->name;
	$doc->owner_guid = $annotation->owner_guid;
	$doc->container_guid = $annotation->entity_guid;
	$doc->access_id = $annotation->access_id;
	$doc->description = elgg_strip_tags($annotation->value);
	$doc->time_created = $annotation->time_created;
	$doc->enabled = $annotation->enabled;

	$doc = elgg_trigger_plugin_hook('elgg_solr:index', 'annotation', array('annotation' => $annotation), $doc);
	
	if (!$doc) {
		return true; // a plugin has stopped the index
	}

	$query->addDocument($doc);
	if ($commit) {
		$query->addCommit($commit);
	}

	// this executes the query and returns the result
	try {
		$client->update($query);
	} catch (Exception $exc) {
		error_log($exc->getMessage());
	}
}

/**
 * Note - only needed for 1.8
 * 
 * @param type $time
 * @param type $block
 * @return type
 */
function elgg_solr_get_comment_stats($time, $block) {
	$type = 'annotation';
	$fq = array(
		'subtype' => "subtype:generic_comment"
	);
	$stats = array();
	switch ($block) {
		case 'hour':
			// I don't think we need minute resolution right now...
			break;
		case 'day':
			for ($i = 0; $i < 24; $i++) {
				$starttime = mktime($i, 0, 0, date('m', $time), date('j', $time), date('Y', $time));
				$endtime = mktime($i + 1, 0, 0, date('m', $time), date('j', $time), date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_get_annotations(array(
					'annotation_name' => 'generic_comment',
					'annotation_created_time_lower' => $starttime,
					'annotation_created_time_upper' => $endtime,
					'count' => true
				));

				$stats[date('H', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => false
				);
			}
			break;
		case 'month':
			for ($i = 1; $i < date('t', $time) + 1; $i++) {
				$starttime = mktime(0, 0, 0, date('m', $time), $i, date('Y', $time));
				$endtime = mktime(0, 0, 0, date('m', $time), $i + 1, date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_get_annotations(array(
					'annotation_name' => 'generic_comment',
					'annotation_created_time_lower' => $starttime,
					'annotation_created_time_upper' => $endtime,
					'count' => true
				));

				$stats[date('d', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'day'
				);
			}
			break;
		case 'year':
			for ($i = 1; $i < 13; $i++) {
				$starttime = mktime(0, 0, 0, $i, 1, date('Y', $time));
				$endtime = mktime(0, 0, 0, $i + 1, 1, date('Y', $time)) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_get_annotations(array(
					'annotation_name' => 'generic_comment',
					'annotation_created_time_lower' => $starttime,
					'annotation_created_time_upper' => $endtime,
					'count' => true
				));

				$stats[date('F', $starttime)] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'month'
				);
			}
			break;

		case 'all':
		default:
			$startyear = date('Y', elgg_get_site_entity()->time_created);
			$currentyear = date('Y');

			for ($i = $currentyear; $i > $startyear - 1; $i--) {
				$starttime = mktime(0, 0, 0, 1, 1, $i);
				$endtime = mktime(0, 0, 0, 1, 1, $i + 1) - 1;

				$fq['time_created'] = "time_created:[{$starttime} TO {$endtime}]";
				$indexed = elgg_solr_get_indexed_count("type:{$type}", $fq);
				$system = elgg_get_annotations(array(
					'annotation_name' => 'generic_comment',
					'annotation_created_time_lower' => $starttime,
					'annotation_created_time_upper' => $endtime,
					'count' => true
				));

				$stats[$i] = array(
					'count' => $system,
					'indexed' => $indexed,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'block' => 'year'
				);
			}

			break;
	}

	return $stats;
}

function elgg_solr_get_log_line($filename) {
	$line = false;
	$f = false;
	if (file_exists($filename)) {
		$f = @fopen($filename, 'r');
	}

	if ($f === false) {
		return false;
	} else {
		$cursor = -1;

		fseek($f, $cursor, SEEK_END);
		$char = fgetc($f);

		/**
		 * Trim trailing newline chars of the file
		 */
		while ($char === "\n" || $char === "\r") {
			fseek($f, $cursor--, SEEK_END);
			$char = fgetc($f);
		}

		/**
		 * Read until the start of file or first newline char
		 */
		while ($char !== false && $char !== "\n" && $char !== "\r") {
			/**
			 * Prepend the new char
			 */
			$line = $char . $line;
			fseek($f, $cursor--, SEEK_END);
			$char = fgetc($f);
		}
	}

	return $line;
}


function elgg_solr_get_cores() {
	$options = elgg_solr_get_adapter_options();
	
	if (!$options['host'] || !$options['port'] || !$options['path']) {
		return array();
	}
	
	$cores = array();

    $url = "http://{$options['host']}:{$options['port']}{$options['path']}admin/cores?action=STATUS&wt=json";

    // Initialize cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    $response = curl_exec($ch);

    $status = json_decode($response);

	if (is_object($status)) {
		$array = json_decode(json_encode($status), true);
		
		foreach ($array['status'] as $name => $params) {
			$cores[] = $name;
		}
	}
	
	return $cores;
}


function elgg_solr_is_elgg18() {
	$version_getter = 'get_version';
	if (is_callable('elgg_get_version')) {
		$version_getter = 'elgg_get_version';
	}
	
	$is_elgg18 = (strpos($version_getter(true), '1.8') === 0);
	
	return $is_elgg18;
}


function elgg_solr_get_fragsize() {
	static $fragsize;
	if ($fragsize) {
		return (int) $fragsize;
	}
	
	$setting = elgg_get_plugin_setting('fragsize', 'elgg_solr');
	if (is_numeric($setting)) {
		$fragsize = (int) $setting;
	}
	else {
		$fragsize = 100;
	}
	
	return $fragsize;
}