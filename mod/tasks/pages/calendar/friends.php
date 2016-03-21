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

elgg_push_breadcrumb($owner->name, "tasks/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('tasks:friends');
$filter_context ='friends';

include elgg_get_plugins_path() . 'tasks/pages/calendar/common.php';

