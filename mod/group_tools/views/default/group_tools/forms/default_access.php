<?php

	$group = elgg_extract("entity", $vars);
	
	if(!empty($group) && elgg_instanceof($group, "group") && $group->canEdit()){
		$default_access = $group->getPrivateSetting("elgg_default_access");
		if($default_access === false){
			// no setting yet, input/access can't handle false
			$default_access = ACCESS_DEFAULT;
		}
		
		$title = elgg_echo("group_tools:default_access:title");
		
		$form_body = "<div>" . elgg_echo("group_tools:default_access:description") . "</div>";
		
		$form_body .= "<div>";
		$form_body .= elgg_echo("default_access:label");
		$form_body .= "&nbsp;" . elgg_view("input/access", array("name" => "group_default_access", "value" => $default_access));
		$form_body .= "</div>";
		
		$form_body .= "<div class='elgg_foot'>";
		$form_body .= elgg_view("input/hidden", array("name" => "guid", "value" => $group->getGUID()));
		$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		$form_body .= "</div>";
		
		$body = elgg_view("input/form", array(
			"body" => $form_body,
			"action" => $vars["url"] . "action/group_tools/default_access"));
		
		global $GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED;
		if(!empty($GROUP_TOOLS_GROUP_DEFAULT_ACCESS_ENABLED)){
			echo elgg_view_module("info", $title, $body);
		}
	}