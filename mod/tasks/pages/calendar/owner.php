<?php
/**
 * Calendar for all Tasks
 *
 * @package ElggPages
 */


$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('tasks/all');
}

// access check for closed groups
group_gatekeeper();

$title = elgg_echo('tasks:owner', array($owner->name));
$filter_context ='mine';

include elgg_get_plugins_path() . 'tasks/pages/calendar/common.php';

