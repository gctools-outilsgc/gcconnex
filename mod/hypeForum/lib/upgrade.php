<?php

// hypeForum upgrade scripts
$ia = elgg_set_ignore_access(true);

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '500');

run_function_once('hj_forum_1358206168');
run_function_once('hj_forum_1358285155');
run_function_once('hj_forum_1359738428');
run_function_once('hj_forum_1360277917');
run_function_once('hj_forum_1360948016');
run_function_once('hj_forum_1360948621');
run_function_once('hj_forum_1361379905');
run_function_once('hj_forum_1372438394');

elgg_set_ignore_access($ia);

function hj_forum_1358206168() {


	$subtypes = array(
		'hjforum' => 'hjForum',
		'hjforumcategory' => 'hjForumCategory',
		'hjforumtopic' => 'hjForumTopic',
		'hjforumpost' => 'hjForumPost'
	);

	foreach ($subtypes as $subtype => $class) {
		if (get_subtype_id('object', $subtype)) {
			update_subtype('object', $subtype, $class);
		} else {
			add_subtype('object', $subtype, $class);
		}
	}

	$subtypeIdForum = get_subtype_id('object', 'hjforum');
	$subtypeIdForumTopic = get_subtype_id('object', 'hjforumtopic');
	$subtypeIdAnnotation = get_subtype_id('object', 'hjannotation');

	$dbprefix = elgg_get_config('dbprefix');

	$segments = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => 'hjsegment',
		'metadata_name_value_pairs' => array(
			'name' => 'handler',
			'value' => 'hjforumtopic'
		),
		'limit' => 0
			));

	/**
	 * Upgrade :
	 * 1. Convert segmented hjForumTopic objects to hjForum objects
	 * 2. Remove segments
	 * 3. Convert widgets to categories
	 */
	foreach ($segments as $segment) {

		$forum = get_entity($segment->container_guid);
		$query = "UPDATE {$dbprefix}entities SET subtype = $subtypeIdForum WHERE subtype = $subtypeIdForumTopic AND guid = $forum->guid";
		update_data($query);

		$widgets = elgg_get_entities(array(
			'types' => 'object',
			'subtypes' => 'widget',
			'container_guids' => array($segment->guid, $forum->guid),
			'limit' => 0
				));

		if ($widgets) {
			$forum->enable_subcategories = true;
			foreach ($widgets as $widget) {

				$threads = elgg_get_entities_from_metadata(array(
					'types' => 'object',
					'subtypes' => 'hjforumtopic',
					'metadata_name_value_pairs' => array(
						array('name' => 'widget', 'value' => $widget->guid)
					),
					'limit' => 0,
						));

				$cat = new ElggObject();
				$cat->subtype = 'hjforumcategory';
				$cat->owner_guid = elgg_get_logged_in_user_guid();
				$cat->container_guid = $forum->guid;
				$cat->title = $widget->title;
				$cat->description = '';
				$cat->access_id = ACCESS_PUBLIC;
				$cat->save();

				foreach ($threads as $thread) {
					$query = "UPDATE {$dbprefix}entities SET container_guid = $forum->guid WHERE guid = $thread->guid";
					update_data($query);
					unset($thread->widget);

					$thread->setCategory($cat->guid, true);
				}

				$widget->disable('plugin_version_upgrade');
			}
		}
		
		$segment->disable('plugin_version_upgrade');
	}
}

function hj_forum_1358285155() {

	$subtypeIdForumPost = get_subtype_id('object', 'hjforumpost');
	$subtypeIdAnnotation = get_subtype_id('object', 'hjannotation');

	$dbprefix = elgg_get_config('dbprefix');

	/**
	 * Upgrade :
	 * 1. Convert hjAnnotations objects for hjforumpost handlers to hjForumPost object
	 */
	$query = "	UPDATE {$dbprefix}entities e
				JOIN {$dbprefix}metadata md ON md.entity_guid = e.guid
				JOIN {$dbprefix}metastrings msn ON msn.id = md.name_id
				JOIN {$dbprefix}metastrings msv ON msv.id = md.value_id
				SET e.subtype = $subtypeIdForumPost
				WHERE e.subtype = $subtypeIdAnnotation AND msn.string = 'handler' AND msv.string = 'hjforumpost'	";

	update_data($query);
}

function hj_forum_1359738428() {

	$subtypes[] = get_subtype_id('object', 'hjforum');
	$subtypes[] = get_subtype_id('object', 'hjforumtopic');
	$subtypes[] = get_subtype_id('object', 'hjforumpost');

	$subtypes_in = implode(',', $subtypes);

	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT guid
				FROM {$dbprefix}entities e
				WHERE e.subtype IN ($subtypes_in)";

	$data = get_data($query);

	foreach ($data as $e) {
		hj_framework_set_ancestry($e->guid);
	}
}

function hj_forum_1360277917() {

	$dbprefix = elgg_get_config('dbprefix');

	$query = "	UPDATE {$dbprefix}metastrings msv
				JOIN {$dbprefix}metadata md ON md.value_id = msv.id
				JOIN {$dbprefix}metastrings msn ON msn.id = md.name_id
				SET msv.string = 1
				WHERE msn.string = 'sticky' AND msv.string = 'true'	";

	update_data($query);

	$query = "	UPDATE {$dbprefix}metastrings msv
				JOIN {$dbprefix}metadata md ON md.value_id = msv.id
				JOIN {$dbprefix}metastrings msn ON msn.id = md.name_id
				SET msv.string = 0
				WHERE msn.string = 'sticky' AND msv.string = 'false'	";

	update_data($query);
}

function hj_forum_1360948016() {

	$dbprefix = elgg_get_config('dbprefix');
	/**
	 * Upgrade :
	 * 1. Convert misclassified forum topics with posts as children back into topics
	 */
	$subtypeIdForum = get_subtype_id('object', 'hjforum');
	$subtypeIdForumTopic = get_subtype_id('object', 'hjforumtopic');

	$query = "	UPDATE {$dbprefix}entities e
				JOIN {$dbprefix}metadata md ON md.entity_guid = e.guid
				JOIN {$dbprefix}metastrings msn ON msn.id = md.name_id
				JOIN {$dbprefix}metastrings msv ON msv.id = md.value_id
				SET e.subtype = $subtypeIdForumTopic
				WHERE e.subtype = $subtypeIdForum AND msn.string = 'children' AND msv.string = 'forumpost'	";

	update_data($query);
}

function hj_forum_1360948621() {

	$dbprefix = elgg_get_config('dbprefix');
	/**
	 * Upgrade :
	 * 1. Former hjAnnotation's description is stored in annotation_value metadata. Needs updating
	 */
	$subtypeIdForumPost = get_subtype_id('object', 'hjforumpost');

	$query = "	UPDATE {$dbprefix}objects_entity oe
				JOIN {$dbprefix}metadata md ON md.entity_guid = oe.guid
				JOIN {$dbprefix}metastrings msn ON msn.id = md.name_id
				JOIN {$dbprefix}metastrings msv ON msv.id = md.value_id
				JOIN {$dbprefix}entities e on oe.guid = e.guid
				SET oe.description = msv.string
				WHERE e.subtype = $subtypeIdForumPost AND msn.string = 'annotation_value'";

	update_data($query);

	elgg_delete_metadata(array(
		'types' => 'object',
		'subtypes' => 'hjforumpost',
		'metadata_names' => array('annotation_name', 'annotation_value')
	));
}

function hj_forum_1361379905() {

	// set priority metadata on forum categories
	$subtype = get_subtype_id('object', 'hjforumcategory');

	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT guid, owner_guid
				FROM {$dbprefix}entities e
				WHERE e.subtype IN ($subtype)";

	$data = get_data($query);

	foreach ($data as $e) {
		create_metadata($e->guid, 'priority', 0, '', $e->owner_guid, ACCESS_PUBLIC);
	}
}

function hj_forum_1372438394() {
	add_metastring('priority');
	add_metastring('sticky');
}