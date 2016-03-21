<?php

$group = elgg_extract("entity", $vars);
if (!empty($group) && elgg_instanceof($group, "group") && group_tools_domain_based_groups_enabled()) {
	$title = elgg_echo("group_tools:domain_based:title");
	
	$form_body = "<div class='mbm'>" . elgg_echo("group_tools:domain_based:description") . "</div>";
	
	$domains = $group->getPrivateSetting("domain_based");
	if (!empty($domains)) {
		$domains = explode("|", trim($domains, "|"));
	}
	
	$form_body .= "<div>";
	$form_body .= elgg_view("input/tags", array("name" => "domains", "value" => $domains));
	$form_body .= "</div>";
	
	$form_body .= "<div class='elgg-foot mtm'>";
	$form_body .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	$form_body .= "</div>";
	
	$content = elgg_view("input/form", array("action" => "action/group_tools/domain_based", "body" => $form_body));
	
	echo elgg_view_module("info", $title, $content);
}