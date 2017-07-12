<?php

elgg_register_event_handler('init','system','gc_elgg_sitemap_init');


function gc_elgg_sitemap_init() {
//elgg_register_plugin_hook_handler('register','menu:owner_block','gcforums_owner_block_menu');
	// display text only if user agent string is gsa-crawler (or whatever is set)
	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false) {

	    elgg_register_plugin_hook_handler('register', 'menu:site', 'elgg_site_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:user_menu', 'elgg_user_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:title', 'elgg_user_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:filter', 'elgg_entity_menu_handler');
	    elgg_register_plugin_hook_handler('prepare', 'breadcrumbs', 'elgg_breadcrumb_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:title2', 'elgg_site_menu_handler');

	
	    /// remove all the sidebars across the site
	    elgg_register_plugin_hook_handler('view', 'bookmarks/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'blog/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'event_calendar/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'file/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'groups/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'members/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'missiona/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'thewire/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'photos/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'file/sidebar', 'elgg_sidebar_handler');
		elgg_register_plugin_hook_handler('view', 'input/longtext', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'input/submit', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'ouptput/url', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'event_calendar/show_events', 'elgg_event_calendar_list_handler');

		elgg_register_plugin_hook_handler('view', 'groups/profile/widget_area', 'elgg_generic_view_handler');

		elgg_register_plugin_hook_handler('view', 'page/elements/comments', 'elgg_comment_view_handler');

	    /// renmove these pages so that it doesn't get crawled
		elgg_unregister_page_handler('activity');
		elgg_unregister_page_handler('dashboard');
		elgg_unregister_menu_item('topbar', 'dashboard');
		elgg_unregister_menu_item('site', 'activity');
		elgg_unregister_menu_item('site', 'career');
		elgg_unregister_menu_item('site', 'Help');
		elgg_unregister_menu_item('site', 'newsfeed');
		elgg_unregister_menu_item('site', 'communities');
		elgg_unregister_menu_item('title2', 'new_folder');

		/// list all entities
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/summary', 'elgg_entities_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/full', 'elgg_full_entities_view_handler');
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/thewire_summary', 'elgg_thewire_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'group/elements/summary', 'elgg_entities_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'page/components/image_block', 'elgg_sidebar_handler');

		elgg_register_plugin_hook_handler('view', 'members/nav', 'elgg_members_menu_handler');
		elgg_register_plugin_hook_handler('view', 'event_calendar/filter_menu', 'elgg_members_menu_handler');


	    elgg_register_plugin_hook_handler('register','menu:owner_block','group_navigation_handler');
		elgg_extend_view('groups/profile/summary', 'group_tabs', 600);

		elgg_register_plugin_hook_handler('entity:url', 'group', 'redirect_group_url');

	}
}


function redirect_group_url($hook, $type, $url, $params) {
	// from: 192.168.xx.xx/gcconnex/groups/profile/1111/group-name
	// to: 192.168.xx.xx/gcconnex/groups/profile/1111/
	$base_url = elgg_get_site_entity()->getURL();
	$stripped_url = str_replace($base_url, "", $_SERVER['REQUEST_URI']);
	$url = explode('/', $stripped_url);

	if (strpos($_SERVER['REQUEST_URI'],"/groups/profile/") !== false)
	{
		if (sizeof($url) > 5)
			forward("groups/profile/{$params['entity']->guid}");
	}
}

function group_navigation_handler($hook, $type, $value, $params) {

	if (elgg_get_context() === 'group_profile' || elgg_get_context() === 'groupSubPage') {
	
		$base_url = elgg_get_site_entity()->getURL();
		$group_id = elgg_get_page_owner_entity()->guid;

		foreach ($value as $key => $item) {

			if ($item->getName() === 'activity' || $item->getName() === 'more' || $item->getName() === 'photo_albums' || $item->getName() === 'event_calendar') continue;

			if ($item->getName() === 'discussion') {
				$url = "{$base_url}{$item->getName()}/owner/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			} else if ($item->getName() === 'about') {
				$url = "{$base_url}groups/profile/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			} else {
				$url = "{$base_url}{$item->getName()}/group/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			}

		}
	}
	return "";
}


function elgg_members_menu_handler($hook, $type, $value, $params) {
	return "";
}

function elgg_generic_view_handler($hook, $type, $value, $params) {
	return "";
}



function elgg_comment_view_handler($hook, $type, $value, $params) {
	//echo "type: {$type} /// hook: {$hook} /// ".print_r($value,true);

	if ($type === 'page/elements/comments') {

		$comments = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'comment',
			'container_guid' => $params['vars']['entity']->guid,
			'reverse_order_by' => true,
			'full_view' => true,
			'limit' => 15,
			'preload_owners' => true,
			'distinct' => false,
			'url_fragment' => $attr['id'],
		));
	}

	return $comments;
}

function elgg_event_calendar_list_handler($hook, $type, $value, $params) {

	$event_list = elgg_list_entities([
	    'type' => 'object',
	    'subtype' => 'event_calendar',
	]);

	return $event_list;
}



function elgg_entity_menu_handler($hook, $type, $value, $params) {
	return "";
}

/**
 * checks if string input is json
 * @param string $string
 */
function isJsonString($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}


function elgg_full_entities_view_handler($hook, $type, $value, $params) {
//echo "full entities view thing // {$value['entity']->guid} /// ".print_r($value['entity']);

	$description = "";

	switch ($value['entity']->getSubtype()) {

		case 'event_calendar':
			if (isJsonString($value['entity']->long_description)) {
				$description_array = json_decode($value['entity']->long_description, true);
				$description .= "<p> {$description_array['en']} </p> <p> {$description_array['fr']} </p>";
			} else {
				$description .= "<p> {$value['entity']->long_description} </p> <p> {$value['entity']->long_description2} </p>";
			}
			break;

		default:
			if (isJsonString($value['entity']->description)) {
				$description_array = json_decode($value['entity']->description, true);
				$description .= "<p> {$description_array['en']} </p> <p> {$description_array['fr']} </p>";
			} else {
				$description .= "<p> {$value['entity']->description} </p> <p> {$value['entity']->description2} </p>";
			}
	}

	echo $description;

	return "";
}


function elgg_thewire_list_handler($hook, $type, $value, $params) {
	echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->description}</a>  <br/>";
	return "";
}

function elgg_entities_list_handler($hook, $type, $value, $params) {
	
//echo "context: ".get_context();
	// brief view: display content (excerpt)
	// full view: content does not exist (it will display the title link again)
	if (!$value['content'] && get_context() !== 'members' && get_context() !== 'polls' && get_context() !== 'event_calendar' && get_context() !== 'file' && get_context() !== 'groups') return;

	$context = get_context();
	switch ($context) {
		case 'file':
		case 'event_calendar':
			echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->title}</a>  <br/>";
			break;
		case 'groups':
			$group_url = elgg_get_site_url()."groups/profile/{$value['entity']->guid}/";
			echo "<a href='{$group_url}'>{$value['entity']->name}</a>  <br/>";
			break;

		case 'members':
			$member_url = elgg_get_site_url()."profile/{$value['entity']->username}/";
			echo "<a href='{$member_url}'>{$value['entity']->username}</a>  <br/>";
			break;

		default:
			echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->title}</a>  <br/>";
		
	}
	return "";
}

function elgg_sidebar_handler($hook, $type, $menu, $params) {
	echo $menu['body'];
	return "";
}

/**
 * hide the breadcrumbs
 */
function elgg_breadcrumb_handler($hook, $type, $menu, $params) {
	return "";
}



/**
 * hide the user menu bar
 */
function elgg_user_menu_handler($hook, $type, $menu, $params) {
	return "";
}


/**
 * xml the links for the site navigation
 */
function elgg_site_menu_handler($hook, $type, $menu, $params) {
	$menu_item = "";
	foreach ($menu as $key => $item) {

		if ($item->getName() === 'translation_editor' || $item->getName() === 'new_folder' || $item->getName() === 'questions')
			continue;

		if ($item->getName() === 'groups') {
			$group_url = elgg_get_site_url()."groups/";
			$menu_item .= " <a style='color:white;' href='{$group_url}'> {$item->getName()}</a> ";
		}
		else 
			$menu_item .= " <a style='color:white;' href='{$item->getHref()}'> {$item->getName()}</a> ";
	}
	echo $menu_item;

	return true;
}

