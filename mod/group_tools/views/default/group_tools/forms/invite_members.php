<?php
/**
 * who can invite group members
 */

$group = elgg_extract("entity", $vars);

if (!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()) {
	$setting = elgg_get_plugin_setting("invite_members", "group_tools");
	if (!empty($setting) && in_array($setting, array("yes_off", "yes_on"))) {
		$noyes_options = array(
			"no" => elgg_echo("option:no"),
			"yes" => elgg_echo("option:yes")
		);
		
		$invite_members = $group->invite_members;
		if (empty($invite_members)) {
			$invite_members = "no";
			
			if ($setting == "yes_on") {
				$invite_members = "yes";
			}
		}
		
		$title = elgg_echo("group_tools:invite_members:title");
		
		$content = elgg_echo("group_tools:invite_members:description");
		$content .= elgg_view("input/dropdown", array(
			"name" => "invite_members", 
			"value" => $invite_members, 
			"options_values" => $noyes_options, 
			"class" => "mls"
		));
		
		$content .= "<div class='mtm'>";
		$content .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
		$content .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		$content .= "</div>";
		
		$form = elgg_view("input/form", array(
			"action" => "action/group_tools/invite_members",
			"body" => $content
		));
		
		echo elgg_view_module("info", $title, $form);
	}
}
