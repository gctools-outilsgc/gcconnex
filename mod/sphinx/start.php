<?php

function sphinx_init() {
	elgg_register_class('SphinxClient', dirname(__FILE__) . '/vendors/sphinx/sphinxapi.php');
	elgg_register_viewtype('sphinx');

	elgg_unregister_plugin_hook_handler('search', 'object', 'search_objects_hook');
	elgg_unregister_plugin_hook_handler('search', 'group', 'search_groups_hook');
	elgg_unregister_plugin_hook_handler('search', 'user', 'search_users_hook');

	elgg_unregister_plugin_hook_handler('search', 'tags', 'search_tags_hook');
	
	elgg_register_plugin_hook_handler('search', 'object', 'sphinx_objects_hook');
	elgg_register_plugin_hook_handler('search', 'group', 'sphinx_groups_hook');
	elgg_register_plugin_hook_handler('search', 'user', 'sphinx_users_hook');

	elgg_register_plugin_hook_handler('search', 'tags', 'sphinx_tags_hook');
	
	elgg_register_admin_menu_item('configure', 'sphinx', 'settings');
	elgg_register_admin_menu_item('administer', 'sphinx', 'statistics');
	
	elgg_register_action('sphinx/configure', dirname(__FILE__) . '/actions/sphinx/configure.php', 'admin');
}

function sphinx_query($params, $index) {
	$cl = new SphinxClient();
	$cl->SetServer("localhost", 9312);
	$cl->SetMatchMode(SPH_MATCH_ALL);
	$cl->SetLimits($params['offset'], $params['limit']);
	
	if (isset($params['subtype'])) {
		$subtype_id = intval(get_subtype_id($params['type'], $params['subtype']));
		$cl->SetFilter('subtype', array($subtype_id));
	}
	
	if (isset($params['owner_guid'])) {
		$cl->SetFilter('owner_guid', array($params['owner_guid']));
	}
	
	if (isset($params['container_guid'])) {
		$cl->SetFilter('container_guid', array($params['container_guid']));
	}

	// get result set from the main table
	//$result = $cl->Query($params['query'], $index);


	switch($index)
	{
		case 'objects':
			$result = $cl->Query($params['query'], 'delta_obj objects');
			break;
		case 'users':
			$result = $cl->Query($params['query'], 'delta_usr users');
			//print_r($result);
			break;
		case 'groups':
			$result = $cl->Query($params['query'], 'delta_grp groups');
			//print_r($result);
			break;
		case 'tags':
			$result = $cl->Query($params['query'], 'delta_tag tags');
			//print_r($result);
			break;
		default:
			$result = false;
			break;
	}


	if ($result === false) {
		elgg_log($cl->GetLastError(), 'ERROR');
		return;
	} 
	
	if ($cl->GetLastWarning()) {
		elgg_log($cl->GetLastWarning(), 'WARNING');
	}
	
	//echo "<pre>", print_r($result['matches']), "</pre>";
	
	$entities = array();
	
	if (!empty($result['matches']))
	{
		foreach ($result['matches'] as $match) 
		{

			if (!get_entity($match['attrs']['guid']))
			{

			} else {

				$entities[] = entity_row_to_elggstar((object)$match['attrs']);
			}
		}
	}
		
	return array(
		'count' => $result['total_found'],
		'entities' => $entities,
	);
}

/**
 * Return default results for searches on objects.
 */
function sphinx_objects_hook($hook, $type, $value, $params) {
	$return = sphinx_query($params, 'objects');
	
	if (!isset($return)) {
		return NULL;
	}
	
	$objects = $return['entities'];
	
	// add the volatile data for why these entities have been returned.
	foreach ($objects as $object) {
		$title = search_get_highlighted_relevant_substrings($object->title, $params['query']);
		$object->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($object->description, $params['query']);
		$object->setVolatileData('search_matched_description', $desc);
	}
	
	return $return;
}

/**
 * Return default results for searches on groups.
 */
function sphinx_groups_hook($hook, $type, $value, $params) {
	$return = sphinx_query($params, 'groups');
	
	if (!isset($return)) {
		return NULL;
	}
	
	$groups = $return['entities'];
	
	// add the volatile data for why these entities have been returned.
	foreach ($groups as $group) {
		$title = search_get_highlighted_relevant_substrings($group->name, $params['query']);
		$group->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($group->description, $params['query']);
		$group->setVolatileData('search_matched_description', $desc);
	}
	
	return $return;
}

/**
 * Return default results for searches on users.
 *
 * @todo add profile field MD searching
 */
function sphinx_users_hook($hook, $type, $value, $params) {
	$return = sphinx_query($params, 'users');
	
	if (!isset($return)) {
		return NULL;
	}
	
	$users = $return['entities'];
	// add the volatile data for why these entities have been returned.
	foreach ($users as $user) {

		$title = search_get_highlighted_relevant_substrings($user->username, $params['query']);
		$user->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($user->name, $params['query']);
		$user->setVolatileData('search_matched_description', $desc);
	}
	
	return $return;
}

/**
 * Return default results for searches on tags.
 *
 * @todo add profile field MD searching
 */
function sphinx_tags_hook($hook, $type, $value, $params) {
	//echo "<script>console.log( 'params - start: ".implode("-",$params)."' );</script>";
	//echo "<script>console.log( 'params - start: ".print_r($params,true)."' );</script>";
	$return = sphinx_query($params, 'tags');
	//echo "<script>console.log( 'return - start: ".implode("-",$return)."' );</script>";
	if (!isset($return)) {
		return NULL;
	}
	
	$tags = $return['entities'];
	if (!is_array($tags)) error_log('cyu - this tag aint an array, yo!');
	//echo "<script>console.log( 'tags - start: ".implode("-",$tags)."' );</script>";

	if (!is_array($tags))
	{
		//error_log('cyu - tags is not an array');
	} else {
		//error_log('cyu - tags is an array and it contains...['.count($tags).']');
	}
	$valid_tag_names = elgg_get_registered_tag_metadata_names();

	// add the volatile data for why these entities have been returned.
	foreach ($tags as $tag) {
		$whole_tag = '';
		$sanitised_tags = array();

		foreach ($tag->tags as $list_tags)
		{
			$sanitised_tags[] = ' ' . sanitise_string($list_tags) . ' ';
		}

		$whole_tag = implode(', ', $sanitised_tags);
		$whole_tag = 'Tags: ' . $whole_tag;


		// different entities have different titles
		switch($tag->type) {
			case 'site':
			case 'user':
			case 'group':
				$title_tmp = $tag->name;
				break;
			case 'object':
				$title_tmp = $tag->title;
				break;
		}

		// Nick told me my idea was dirty, so I'm hard coding the numbers.
		$title_tmp = strip_tags($title_tmp);
		if (elgg_strlen($title_tmp) > 297) {
			$title_str = elgg_substr($title_tmp, 0, 297) . '...';
		} else {
			$title_str = $title_tmp;
		}

		$desc_tmp = strip_tags($tag->description);
		if (elgg_strlen($desc_tmp) > 297) {
			$desc_str = elgg_substr($desc_tmp, 0, 297) . '...';
		} else {
			$desc_str = $desc_tmp;
		}

		$title = search_get_highlighted_relevant_substrings($title_tmp, $params['query']);
		$tag->setVolatileData('search_matched_title', $title_tmp);
		
		$desc = search_get_highlighted_relevant_substrings($desc_str, $params['query']);
		$tag->setVolatileData('search_matched_description', $desc_str);

		$tag_list = search_get_highlighted_relevant_substrings($whole_tag, $params['query']);
		$tag->setVolatileData('search_matched_extra', $tag_list);
	}
	
	return $return;
}

function sphinx_write_conf() {
	$handle = fopen(elgg_get_data_path() . 'sphinx/sphinx.conf', 'w');
	fwrite($handle, elgg_view('sphinx/conf'));
	fclose($handle);
}

elgg_register_event_handler('init', 'system', 'sphinx_init');
