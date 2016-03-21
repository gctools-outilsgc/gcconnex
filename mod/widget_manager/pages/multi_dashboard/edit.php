<?php

gatekeeper();

$guid = (int) get_input("guid");
$entity = null;

if (!empty($guid)) {
	if ($entity = get_entity($guid)) {
		if (!elgg_instanceof($entity, "object", MultiDashboard::SUBTYPE) || !$entity->canEdit()) {
			unset($entity);
		}
	} else {
		unset($entity);
	}
}

if (!empty($entity)) {
	$title_text = elgg_echo("widget_manager:multi_dashboard:edit", array($entity->title));
} else {
	$title_text = elgg_echo("widget_manager:multi_dashboard:new");
}

$form_vars = array(
	"id" => "widget_manager_multi_dashboard_edit",
	"class" => "elgg-form-alt"
);

$body_vars = array(
	"entity" => $entity
);

$form = elgg_view_form("multi_dashboard/edit", $form_vars, $body_vars);

echo elgg_view_module("info", $title_text, $form);
