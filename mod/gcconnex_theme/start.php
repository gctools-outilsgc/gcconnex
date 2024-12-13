<?php

/**
 * start.php
 *
 * GCconnex theme - includes all GCTools branding, links and language.
 *
 * @author Government of Canada
 */

elgg_register_event_handler('init', 'system', 'gcconnex_theme_init');

function gcconnex_theme_init()
{
    elgg_register_page_handler('gcconnex_is_moving', 'expages_page_handler');
    elgg_register_page_handler('gcconnex_demenage', 'expages_page_handler');

	elgg_register_page_handler('hello', 'gcconnex_theme_page_handler');
	elgg_register_plugin_hook_handler('register', 'menu:site', 'career_menu_hander');

	//jobs.gc.ca menu link
	elgg_register_menu_item('subSite', array(
		'name' => 'jobs',
		'text' => elgg_echo('wet:jobs:link'),
		'href' => elgg_echo('wet:jobs:href'),
		'target' => '_blank',
	));

	//menu item for career dropdown
	elgg_register_menu_item('site', array(
			'name' => 'career',
			'href' => '#career_menu',
			'text' => elgg_echo('career') . '<span class="expicon glyphicon glyphicon-chevron-down"></span>'
	));

	// this will take care of the redirect only for groups
	elgg_register_plugin_hook_handler('route', 'all', 'group_content_routing_handler', 10);
}

// function that handles moving jobs marketplace and micro missions into drop down menu
function career_menu_hander($hook, $type, $menu, $params)
{
	if (!is_array($menu)) {
		return;
	}

	foreach ($menu as $key => $item) {
		if ($item->getName() === 'career') {
			if (elgg_is_active_plugin('missions')) {
				$item->addChild(elgg_get_menu_item('site', 'mission_main'));
			}

			//if (elgg_is_active_plugin('gcforums')) {
				//$item->addChild(elgg_get_menu_item('subSite', 'Forum'));
			//}

			$item->addChild(elgg_get_menu_item('subSite', 'jobs'));
			$item->setLinkClass('item');
		}
	}
}

/**
 * handler that takes care of the page routes (#1195)
 * redirects user (who do not have access to group content) to the group profile
 * @param string $hook
 * @param string $type
 * @param array $info
 */
function group_content_routing_handler($hook, $type, $info)
{
	global $CONFIG;
	$dbprefix = elgg_get_config('dbprefix');
	$entity_guid = (int)$info['segments'][1];

	$query = "SELECT guid, container_guid FROM {$dbprefix}entities WHERE guid = {$entity_guid} LIMIT 1";
	$entity_information = get_data($query);

	$group_guid = $entity_information[0]->container_guid;
	$group_entity = get_entity($group_guid);

	if ($group_entity instanceof ElggGroup && !(get_entity($entity_guid))) {
		register_error(elgg_echo('limited_access'));
		forward("groups/profile/{$group_guid}");
	}
}
