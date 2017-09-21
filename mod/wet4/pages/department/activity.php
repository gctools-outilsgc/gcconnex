<?php

if(elgg_is_active_plugin('gc_streaming_content')){
  elgg_require_js("stream_dept_activity");
}

elgg_set_context('dept_activity');

$title = elgg_echo('new:dept:activity:title');

if(!isset(elgg_get_logged_in_user_entity()->DAconnections) || elgg_get_logged_in_user_entity()->DAconnections == ''){
  $filter_link = elgg_view('output/url', array(
    'text' => elgg_echo('dept:activity:hide'),
    'href' => elgg_add_action_tokens_to_url(elgg_get_site_url().'action/deptactivity/filter')
  ));
} else {
  $filter_link = elgg_view('output/url', array(
    'text' => elgg_echo('dept:activity:show'),
    'href' => elgg_add_action_tokens_to_url(elgg_get_site_url().'action/deptactivity/filter')
  ));
}

$tabs = elgg_view('dept_activity/tabs');

$filter_form = '<a href="#" style="position:absolute; top:10px; right:20px;" title="'.elgg_echo('dept:activity:filter:title').'" class="dropdown  pull-right mrgn-rght-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v fa-2x icon-unsel"><span class="wb-inv">'.elgg_echo('dept:activity:filter:title').'</span></i></a><ul style="top:45px; right: 8px;" class="dropdown-menu pull-right act-filter" aria-labelledby="dropdownMenu2"><li id="filter_form">'.$filter_link.'</li></ul>';

//get the department we are working with
$dept = elgg_get_logged_in_user_entity()->department;

//main content of page
$db_prefix = elgg_get_config('dbprefix');
$options['joins'] = array("INNER JOIN {$db_prefix}metadata md ON md.entity_guid = rv.subject_guid LEFT JOIN {$db_prefix}metastrings msn ON md.name_id = msn.id LEFT JOIN {$db_prefix}metastrings msv ON md.value_id = msv.id");	// we need this to filter by metadata
$options['wheres'] = array("msn.string = \"department\" AND msv.string LIKE \"{$dept}\"");

//remove friend connections from action types
$actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
//load user's preference
$filteredItems = array(elgg_get_logged_in_user_entity()->DAconnections);

//filter out preference
$options['action_types'] = array_diff($actionTypes, $filteredItems);

$options['no_results'] = elgg_echo('river:none');
$activity = elgg_list_river($options);

//sidebar
$deptSeperate = explode(' / ', $dept);

$depart1 = $deptSeperate[0]  . ' / ' . $deptSeperate[1];
$depart2 = $deptSeperate[1]  . ' / ' . $deptSeperate[0];

$deptCount = elgg_get_entities_from_metadata(array(
    'types' => 'user',
    'metadata_names' => array('department'),
    'metadata_values' => array($depart1, $depart2),
    'limit' => 0,
    ));

$deptUsers = array();
foreach($deptCount as $k => $user){
  $deptUsers[] = $user->guid;
}

$wire_post = elgg_list_entities(array(
  'type' => 'object',
  'subtypes' => 'thewire',
  'owner_guids' => $deptUsers,
  'pagination' => false,
  'limit' => 15,
));

$sidebar = elgg_view_module('sidebar', elgg_echo('item:object:thewire'), $wire_post);

$content = '<div class="panel-body">'.$tabs.$filter_form.'<div class="new-newsfeed-holder"><div class="newsfeed-posts-holder"></div></div>'.$activity.'</div>';

//put it all together
$params = array(
  'content' => $content,
  'title' => $title,
  "sidebar" => $sidebar,
  'filter' => false
);

$body = elgg_view_layout('one_sidebar',  $params);

echo elgg_view_page($title, $body);

elgg_pop_context();
