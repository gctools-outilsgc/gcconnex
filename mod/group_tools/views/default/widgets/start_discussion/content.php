<?php
/**
 * quickly start a discussion
 */

$widget = elgg_extract("entity", $vars);
$embed = elgg_extract("embed", $vars, false);

// check if logged if
$user = elgg_get_logged_in_user_entity();
if (!empty($user)) {
	$owner = $widget->getOwnerEntity();

	$group_membership = $user->getGroups(array("limit" => false));
	if (!empty($group_membership)) {
		$selected_group = ELGG_ENTITIES_ANY_VALUE;
		if (elgg_instanceof($owner, "group")) {
			// preselect the current group
			$selected_group = $owner->getGUID();
		}

		$group_selection_options = array();
		$group_access_options = array();

		if (!$selected_group) {
			// no group container, so add empty record, so a user is required to select a group (instead of defaulting to the first option)
			$group_selection_options[] = "";
			$group_access_options["-1"] = "";
		}

		foreach ($group_membership as $group) {
			$group_selection_options[$group->getGUID()] = $group->name;
			$group_access_options[$group->group_acl] = $group->getGUID();
		}

		// sort the groups by name
		natcasesort($group_selection_options);

		$form_vars = array(
			"id" => "group-tools-start-discussion-widget-form",
			"action" => "action/discussion/save"
		);
		$body_vars = array(
			"groups" => $group_selection_options,
			"access" => $group_access_options,
			"container_guid" => $selected_group
		);

		echo elgg_view_form("discussion/quick_start",  $form_vars, $body_vars);
	} elseif (!$embed) {
		// you must join a group in order to use this widget
		$link_start = "<a href='" . elgg_get_site_url() . "/groups/all'>";
		$link_end = "</a>";

		$text = elgg_echo("group_tools:widgets:start_discussion:membership_required", array($link_start, $link_end));
		echo elgg_view("output/longtext", array("value" => $text));
	}
} elseif (!$embed) {
	// you have to be logged in in order to use this widget
	echo elgg_view("output/longtext", array("value" => elgg_echo("group_tools:widgets:start_discussion:login_required")));
}
