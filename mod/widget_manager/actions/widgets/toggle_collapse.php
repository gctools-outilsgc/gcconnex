<?php

$guid = (int) get_input("guid");
$collapsed = (boolean) get_input("collapsed");

$user = elgg_get_logged_in_user_entity();

$widget = get_entity($guid);

if ($user && elgg_instanceof($widget, "object", "widget")) {
	if ($collapsed) {
		$user->addRelationship($guid, "widget_state_collapsed");
		$user->removeRelationship($guid, "widget_state_open");
	} else {
		$user->addRelationship($guid, "widget_state_open");
		$user->removeRelationship($guid, "widget_state_collapsed");
	}
}