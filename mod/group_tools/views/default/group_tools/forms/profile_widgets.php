<?php

	$group = $vars["entity"];
	
	if(!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()){
		if(!$group->isPublicMembership()){
			// closed membership, so extend options
			$noyes_options = array(
				"no" => elgg_echo("option:no"),
				"yes" => elgg_echo("option:yes")
			);
			
			// build form
			$title = elgg_echo("group_tools:profile_widgets:title");
			$form_body = "<div>" . elgg_echo("group_tools:profile_widgets:description") . "</div>";
			
			$form_body .= "<div>";
			$form_body .= elgg_echo("group_tools:profile_widgets:option");
			$form_body .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "profile_widgets", "options_values" => $noyes_options, "value" => $group->profile_widgets));
			$form_body .= "</div>";
			
			$form_body .= "<div>";
			$form_body .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
			$form_body .= elgg_view("input/submit", array("value" => elgg_echo("submit")));
			$form_body .= "</div>";
			
			$form = elgg_view("input/form", array("body" => $form_body,
													"action" => $vars["url"] . "action/group_tools/profile_widgets"));
			
			echo elgg_view_module("info", $title, $form);
		}
	}