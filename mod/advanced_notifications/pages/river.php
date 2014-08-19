<?php
/**
 * special river page only for notifications and my groups
 */
gatekeeper();

$options = array();

$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

$dbprefix = elgg_get_config("dbprefix");
$activity = false;

switch ($page_type) {
	case 'groups':
		$title = elgg_echo('advanced_notifications:activity:groups:title');
		$page_filter = $page_type;
		
		$groups_options = array(
			"type" => "group",
			"limit" => false,
			"relationship" => "member",
			"relationship_guid" => elgg_get_logged_in_user_guid(),
			"callback" => "advanced_notifications_row_to_guid"
		);
		
		if($groups = elgg_get_entities_from_relationship($groups_options)){
			$options['joins'] = array("JOIN " . $dbprefix . "entities e ON rv.object_guid = e.guid");
			$options['wheres'] = array("(rv.object_guid IN (" . implode(",", $groups) . ") OR e.container_guid IN (" . implode(",", $groups) . "))");
			
			$activity = elgg_list_river($options);
		}
		break;
	case 'notifications':
		$title = elgg_echo('advanced_notifications:activity:notifications:title');
		$page_filter = $page_type;

		$notifications_options = array(
			"relationship" => "notifysite",
			"limit" => false,
			"relationship_guid" => elgg_get_logged_in_user_guid(),
			"callback" => "advanced_notifications_row_to_guid"
		);
		
		if($notifications = elgg_get_entities_from_relationship($notifications_options)){
			$options['joins'] = array("JOIN " . $dbprefix . "entities e ON rv.object_guid = e.guid");
			$options['wheres'] = array("e.container_guid IN (" . implode(",", $notifications) . ")");
			
			$activity = elgg_list_river($options);
		}
		break;
	default:
		forward();
}


if (!$activity) {
	$activity = elgg_echo('river:none');
}

$content = elgg_view('core/river/filter', array('selector' => $selector));

$sidebar = elgg_view('core/river/sidebar');

$params = array(
	'title' => $title,
	'content' =>  $content . $activity,
	'sidebar' => $sidebar,
	'filter_context' => $page_filter,
	'class' => 'elgg-river-layout',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
