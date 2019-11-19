<?php
/**
 * Custom core functions for speeding WET skin features.
 * @author Ilia Salem, customizing elgg core code
 */


/*
* customized, faster list_river function for main page news feed
*/

function newsfeed_list_river(array $options = array()) {
	global $autofeed;
	$autofeed = true;

	$defaults = array(
		'offset'     => (int) max(get_input('offset', 0), 0),
		'limit'      => (int) max(get_input('limit', max(20, elgg_get_config('default_limit'))), 0),
		'pagination' => true,
		'list_class' => 'elgg-list-river',
		'no_results' => '',
	);

	$options = array_merge($defaults, $options);

	if (!$options["limit"] && !$options["offset"]) {
		// no need for pagination if listing is unlimited
		$options["pagination"] = false;
	}

	// get the river items
	$options['count'] = false;
	$items = elgg_get_river($options);

	// get the river items count only if we need it for pagination
	if ( !is_null( get_input('offset', null) ) ){
		$options['count'] = true;
		$count = elgg_get_river($options);
		$options['count'] = $count;
	}

	$options['items'] = $items;

	return elgg_view('page/components/list', $options);
}


/**
 * Return entities from an SQL query generated by elgg_get_entities.
 *
 * @param string    $sql
 * @param \ElggBatch $batch
 * @return \ElggEntity[]
 *
 * @access private
 * @throws LogicException
 */
function _elgg_wet_fetch_entities_from_sql($sql, \ElggBatch $batch = null) {
	return fetchMessagesFromSql($sql, $batch);
}


/**
	 * Return entities from an SQL query generated by elgg_get_entities.
	 * Customized for fetching messages for the inbox's data table (speeds up loading in cases of 1000s + messages)
	 *
	 * @param string    $sql
	 * @param \ElggBatch $batch
	 * @return \ElggEntity[]
	 *
	 * @access private
	 * @throws \LogicException
	 */
	function fetchMessagesFromSql($sql, \ElggBatch $batch = null) {
		static $plugin_subtype;
		if (null === $plugin_subtype) {
			$plugin_subtype = get_subtype_id('object', 'plugin');
		}

		// Keys are types, values are columns that, if present, suggest that the secondary
		// table is already JOINed. Note it's OK if guess incorrectly because entity load()
		// will fetch any missing attributes.
		$types_to_optimize = array(
			'object' => 'title',
			'user' => 'password',
			'group' => 'name',
			'site' => 'url',
		);

		$rows = _elgg_services()->db->getData($sql);

		// guids to look up in each type
		$lookup_types = array();
		// maps GUIDs to the $rows key
		$guid_to_key = array();

		if (isset($rows[0]->type, $rows[0]->subtype)
				&& $rows[0]->type === 'object'
				&& $rows[0]->subtype == $plugin_subtype) {
			// Likely the entire resultset is plugins, which have already been optimized
			// to JOIN the secondary table. In this case we allow retrieving from cache,
			// but abandon the extra queries.
			$types_to_optimize = array();
		}

		// First pass: use cache where possible, gather GUIDs that we're optimizing
		foreach ($rows as $i => $row) {
			if (empty($row->guid) || empty($row->type)) {
				throw new \LogicException('Entity row missing guid or type');
			}
			$entity = _elgg_retrieve_cached_entity($row->guid);
			if ($entity) {
				$entity->refresh($row);
				$rows[$i] = $entity;
				continue;
			}
			if (isset($types_to_optimize[$row->type])) {
				// check if row already looks JOINed.
				if (isset($row->{$types_to_optimize[$row->type]})) {
					// Row probably already contains JOINed secondary table. Don't make another query just
					// to pull data that's already there
					continue;
				}
				$lookup_types[$row->type][] = $row->guid;
				$guid_to_key[$row->guid] = $i;
			}
		}
		// Do secondary queries and merge rows
		if ($lookup_types) {
			$dbprefix = _elgg_services()->config->get('dbprefix');

			foreach ($lookup_types as $type => $guids) {
				if ( $type = "object" ){
					$set = "(" . implode(',', $guids) . ")";
					$sql = "SELECT guid, title FROM {$dbprefix}{$type}s_entity WHERE guid IN $set";
					$secondary_rows = _elgg_services()->db->getData($sql);
					if ($secondary_rows) {
						foreach ($secondary_rows as $secondary_row) {
							$key = $guid_to_key[$secondary_row->guid];
							// cast to arrays to merge then cast back
							$rows[$key] = (object)array_merge((array)$rows[$key], (array)$secondary_row);
						}
					}
				}
				else {
					$set = "(" . implode(',', $guids) . ")";
					$sql = "SELECT * FROM {$dbprefix}{$type}s_entity WHERE guid IN $set";
					$secondary_rows = _elgg_services()->db->getData($sql);
					if ($secondary_rows) {
						foreach ($secondary_rows as $secondary_row) {
							$key = $guid_to_key[$secondary_row->guid];
							// cast to arrays to merge then cast back
							$rows[$key] = (object)array_merge((array)$rows[$key], (array)$secondary_row);
					}
				}
				}
			}
		}
		// Second pass to finish conversion
		foreach ($rows as $i => $row) {
			if ($row instanceof \ElggEntity) {
				continue;
			} else {
				try {
					$rows[$i] = entity_row_to_elggstar($row);
				} catch (IncompleteEntityException $e) {
					// don't let incomplete entities throw fatal errors
					unset($rows[$i]);

					// report incompletes to the batch process that spawned this query
					if ($batch) {
						$batch->reportIncompleteEntity($row);
					}
				}
			}
		}
		return $rows;
	}



/*
 * Customized for major speedup of group activity
 */

/**
 * List river items
 *
 * @param array $options Any options from elgg_get_river() plus:
 *   item_view  => STR         Alternative view to render list items
 *   pagination => BOOL        Display pagination links (true)
 *   no_results => STR|Closure Message to display if no items
 *
 * @return string
 * @since 1.8.0
 */
function elgg_list_group_river(array $options = array()) {
	global $autofeed;
	$autofeed = true;

	$defaults = array(
		'offset'     => (int) max(get_input('offset', 0), 0),
		'limit'      => (int) max(get_input('limit', max(20, elgg_get_config('default_limit'))), 0),
		'pagination' => true,
		'list_class' => 'elgg-list-river',
		'no_results' => '',
	);

	$options = array_merge($defaults, $options);

	if (!$options["limit"] && !$options["offset"]) {
		// no need for pagination if listing is unlimited
		$options["pagination"] = false;
	}

	if ( $options["pagination"] || $options['count'] ){
		$options['count'] = true;
		$count = elgg_get_group_river($options);
	}
	else
		$count = NULL;
	
	$options['count'] = false;
	$items = elgg_get_group_river($options);

	$options['count'] = $count;
	$options['items'] = $items;

	return elgg_view('page/components/list', $options);
}

/**
 * Get river items
 *
 * @note If using types and subtypes in a query, they are joined with an AND.
 *
 * @param array $options Parameters:
 *   ids                  => INT|ARR River item id(s)
 *   subject_guids        => INT|ARR Subject guid(s)
 *   object_guids         => INT|ARR Object guid(s)
 *   target_guids         => INT|ARR Target guid(s)
 *   annotation_ids       => INT|ARR The identifier of the annotation(s)
 *   action_types         => STR|ARR The river action type(s) identifier
 *   posted_time_lower    => INT     The lower bound on the time posted
 *   posted_time_upper    => INT     The upper bound on the time posted
 *
 *   types                => STR|ARR Entity type string(s)
 *   subtypes             => STR|ARR Entity subtype string(s)
 *   type_subtype_pairs   => ARR     Array of type => subtype pairs where subtype
 *                                   can be an array of subtype strings
 *
 *   relationship         => STR     Relationship identifier
 *   relationship_guid    => INT|ARR Entity guid(s)
 *   inverse_relationship => BOOL    Subject or object of the relationship (false)
 *
 * 	 limit                => INT     Number to show per page (20)
 *   offset               => INT     Offset in list (0)
 *   count                => BOOL    Count the river items? (false)
 *   order_by             => STR     Order by clause (rv.posted desc)
 *   group_by             => STR     Group by clause
 *
 *   distinct             => BOOL    If set to false, Elgg will drop the DISTINCT
 *                                   clause from the MySQL query, which will improve
 *                                   performance in some situations. Avoid setting this
 *                                   option without a full understanding of the
 *                                   underlying SQL query Elgg creates. (true)
 *
 * @return array|int
 * @since 1.8.0
 */
function elgg_get_group_river(array $options = array()) {
	global $CONFIG;
//error_log("group river");
	$defaults = array(
		'ids'                  => ELGG_ENTITIES_ANY_VALUE,

		'subject_guids'	       => ELGG_ENTITIES_ANY_VALUE,
		'object_guids'         => ELGG_ENTITIES_ANY_VALUE,
		'target_guids'         => ELGG_ENTITIES_ANY_VALUE,
		'annotation_ids'       => ELGG_ENTITIES_ANY_VALUE,
		'action_types'         => ELGG_ENTITIES_ANY_VALUE,

		'relationship'         => null,
		'relationship_guid'    => null,
		'inverse_relationship' => false,

		'types'	               => ELGG_ENTITIES_ANY_VALUE,
		'subtypes'             => ELGG_ENTITIES_ANY_VALUE,
		'type_subtype_pairs'   => ELGG_ENTITIES_ANY_VALUE,

		'posted_time_lower'	   => ELGG_ENTITIES_ANY_VALUE,
		'posted_time_upper'	   => ELGG_ENTITIES_ANY_VALUE,

		'limit'                => 20,
		'offset'               => 0,
		'count'                => false,
		'distinct'             => false,

		'order_by'             => 'u.posted desc',
		'group_by'             => ELGG_ENTITIES_ANY_VALUE,

		'wheres'               => array(),
		'wheres1'               => array(),
		'wheres2'               => array(),
		'joins'                => array(),
	);

	$options = array_merge($defaults, $options);

	$singulars = array('id', 'subject_guid', 'object_guid', 'target_guid', 'annotation_id', 'action_type', 'type', 'subtype');
	$options = _elgg_normalize_plural_options_array($options, $singulars);

	$wheres1 = $options['wheres1'];
	$wheres2 = $options['wheres2'];

/*
	$wheres[] = _elgg_get_guid_based_where_sql('rv.id', $options['ids']);
	$wheres[] = _elgg_get_guid_based_where_sql('rv.subject_guid', $options['subject_guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('rv.object_guid', $options['object_guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('rv.target_guid', $options['target_guids']);
	$wheres[] = _elgg_get_guid_based_where_sql('rv.annotation_id', $options['annotation_ids']);
	$wheres[] = _elgg_river_get_action_where_sql($options['action_types']);
	$wheres[] = _elgg_get_river_type_subtype_where_sql('rv', $options['types'],
		$options['subtypes'], $options['type_subtype_pairs']);
*/
	/*if ($options['posted_time_lower'] && is_int($options['posted_time_lower'])) {
		$wheres1[] = "rv.posted >= {$options['posted_time_lower']}";
		$wheres2[] = "rv.posted >= {$options['posted_time_lower']}";
	}

	if ($options['posted_time_upper'] && is_int($options['posted_time_upper'])) {
		$wheres1[] = "rv.posted <= {$options['posted_time_upper']}";
		$wheres2[] = "rv.posted <= {$options['posted_time_upper']}";
	}*/

	if (!access_get_show_hidden_status()) {
		$wheres1[] = "rv.enabled = 'yes'";
		$wheres2[] = "rv.enabled = 'yes'";
	}

	$dbprefix = elgg_get_config('dbprefix');
	$join1 = "JOIN {$dbprefix}entities oe ON rv.object_guid = oe.guid";
	// LEFT JOIN is used because all river items do not necessarily have target
	$join2 = "LEFT JOIN {$dbprefix}entities te ON rv.target_guid = te.guid";

	// see if any functions failed
	// remove empty strings on successful functions
	/*foreach ($wheres1 as $i => $where) {
		if ($where === false) {
			return false;
		} elseif (empty($where)) {
			unset($wheres1[$i]);
		}
	}
	foreach ($wheres2 as $i => $where) {
		if ($where === false) {
			return false;
		} elseif (empty($where)) {
			unset($wheres2[$i]);
		}
	}

	// remove identical where clauses
	$wheres1 = array_unique($wheres1);
	$wheres2 = array_unique($wheres2);
	*/
// Wheres for the 2 parts of the union query
	$w1 = "";
	foreach ($wheres1 as $w) {
		$w1 .= " $w AND ";
	}

	$w2 = "";
	foreach ($wheres2 as $w) {
		$w2 .= " $w AND ";
	}

	// Make sure that user has access to all the entities referenced by each river item
	$object_access_where = _elgg_get_access_where_sql(array('table_alias' => 'oe'));
	$target_access_where = _elgg_get_access_where_sql(array('table_alias' => 'te'));

	if (!$options['count']) {
		$GOL = "";	// Group by / order / limit
		$options['group_by'] = sanitise_string($options['group_by']);
		if ($options['group_by']) {
			$GOL .= " GROUP BY {$options['group_by']}";
		}

		$options['order_by'] = sanitise_string($options['order_by']);
		$GOL .= " ORDER BY {$options['order_by']}";

		if ($options['limit']) {
			$limit = sanitise_int($options['limit']);
			$offset = sanitise_int($options['offset'], false);
			$GOL .= " LIMIT $offset, $limit";
		}
// custom UNION - based query
		$query = "SELECT u.* FROM ( ( SELECT rv.* FROM {$CONFIG->dbprefix}river rv {$join1} WHERE {$w1} {$object_access_where} ) UNION ".
			"( SELECT rv.* FROM {$CONFIG->dbprefix}river rv {$join2} WHERE {$w2} ($target_access_where OR te.guid IS NULL) ) ) u {$GOL}";

		$river_items = get_data($query, '_elgg_row_to_elgg_river_item');
		_elgg_prefetch_river_entities($river_items);
	//	error_log($query);
		return $river_items;
	} else {
		$query = "SELECT sum(count) as total FROM ( ( SELECT count(*) as count FROM {$CONFIG->dbprefix}river rv {$join1} WHERE {$w1} {$object_access_where} ) UNION ".
			"( SELECT count(*) as count FROM {$CONFIG->dbprefix}river rv {$join2} WHERE {$w2} ($target_access_where OR te.guid IS NULL) ) ) u";
		//	error_log($query);
		$total = get_data_row($query);
		return (int)$total->total;
	}
}


/**
 * Provides an array of the latest n messages in the user's inbox
 * @param $user_id the guid of the user who is the recipient of the messages we will be looking for and returning
 * @param $type is this for the regular inbox ('inbox', the default) or the notification one ('notif')
 * @param $n the number of messages to return, default is 5
 *
 * @return array of entity objects
 */
 function latest_messages_preview( $user_guid, $type = 'inbox', $n = 5 ) {
	// prepare for query building
	$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1, 'fromId');
 	$map = array();
 	foreach ($strings as $string) {
 		$id = elgg_get_metastring_id($string);
 		$map[$string] = $id;
 	}

 	 $db_prefix = elgg_get_config('dbprefix');
	 // set up the joins and where for the query
	 $options = array(
 		'joins' => array(
 			"JOIN {$db_prefix}metadata msg_toId on e.guid = msg_toId.entity_guid",
 			"JOIN {$db_prefix}metadata msg_readYet on e.guid = msg_readYet.entity_guid",
 			"JOIN {$db_prefix}metadata msg_msg on e.guid = msg_msg.entity_guid",
 			"LEFT JOIN {$db_prefix}metadata msg_fromId on e.guid = msg_fromId.entity_guid",
 			"LEFT JOIN {$db_prefix}metastrings msvfrom ON msg_fromId.value_id = msvfrom.id",
 			"LEFT JOIN {$db_prefix}entities efrom ON msvfrom.string = efrom.guid",
 		),
 		'wheres' => array(
 			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
 			"msg_fromId.name_id='{$map['fromId']}' AND efrom.type = 'user'",
 			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
 			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
 		),
 		'owner_guid' => $user_guid,
 		'limit' => $n,
 		'offset' => 0,
 		'count' => false,
 		'distinct' => false,
 	);
	// only the wheres are a little different for notifications
	if ( $type === 'notif' )
		$options['wheres'] = array(
 			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
 			"msg_fromId.name_id='{$map['fromId']}' AND efrom.type <> 'user'",
 			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
 			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
 		);

	// run the query and retrieve the entities
	 $messages = elgg_get_entities_from_metadata($options);

	 return $messages;
 }

?>
