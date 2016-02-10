<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which displays all the missions related to the logged in user.
 */
gatekeeper();

// Selects the last section of the current URI.
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$last_segment = array_pop($exploded_uri);

$title = elgg_echo('missions:my_missions');
$content = elgg_view_title($title);

$highlight_all = false;
$highlight_manager = false;
$highlight_accepted = false;

// Decides on content based on the URI.
$entity_list = '';
switch($last_segment) {
    case 'manager':
        $entity_list = elgg_get_entities_from_relationship(array(
                'relationship' => 'mission_posted',
                'relationship_guid' => elgg_get_logged_in_user_guid()
        ));
        $highlight_manager = true;
        break;
    case 'accepted':
        $entity_list = elgg_get_entities_from_relationship(array(
            'relationship' => 'mission_accepted',
            'relationship_guid' => elgg_get_logged_in_user_guid(),
            'inverse_relationship' => true
        ));
        $highlight_accepted = true;
        break;
    default:
        $temp_array_one = elgg_get_entities_from_relationship(array(
                'relationship' => 'mission_posted',
                'relationship_guid' => elgg_get_logged_in_user_guid()
        ));
        $temp_array_two = elgg_get_entities_from_relationship(array(
            'relationship' => 'mission_accepted',
            'relationship_guid' => elgg_get_logged_in_user_guid(),
            'inverse_relationship' => true
        ));
        $entity_list = array_merge($temp_array_one, $temp_array_two);
        $highlight_all = true;
}

// A set of tabs which navigate to different variations of the My Missions page.
$navigation_tabs = array(
    array(
        'text' => elgg_echo('missions:all'),
        'href' => elgg_get_site_url() . 'missions/mission-mine/all',
        'selected' => $highlight_all
    ),
    array(
        'text' => elgg_echo('missions:manager'),
        'href' => elgg_get_site_url() . 'missions/mission-mine/manager',
        'selected' => $highlight_manager
    ),
    array(
        'text' => elgg_echo('missions:accepted'),
        'href' => elgg_get_site_url() . 'missions/mission-mine/accepted',
        'selected' => $highlight_accepted
    )
);
$content .= elgg_view('navigation/tabs', array(
		'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default',
		'tabs' => $navigation_tabs));

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

// Displays the list of mission entities.
$content .= elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
    'count' => $count,
    'offset' => $offset,
    'limit' => $max,
    'pagination' => true,
    'list_type' => 'gallery',
    'gallery_class' => 'mission-gallery'
    ), $offset, $max);

$sidebar = elgg_view_menu('mission_main', array(
    'sort_by' => 'priority'
));

$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

echo elgg_view_page($title, $body);