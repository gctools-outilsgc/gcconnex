<?php
/**
 * Cleanup the group profile sidebar
 */

$group = elgg_extract("entity", $vars);

if (!empty($group) && ($group instanceof ElggGroup) && $group->canEdit()) {
	elgg_require_js("group_tools/group_edit");
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	$featured_options = array(
		"no" => elgg_echo("option:no"),
		1 => 1,
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		15 => 15,
		20 => 20,
		25 => 25
	);
	
	$featured_sorting = array(
		"time_created" => elgg_echo("group_tools:cleanup:featured_sorting:time_created"),
		"alphabetical" => elgg_echo("group_tools:cleanup:featured_sorting:alphabetical"),
	);
	
	$prefix = "group_tools:cleanup:";
	
	$form_body = "<div class='elgg-quiet'>" . elgg_echo("group_tools:cleanup:description") . "</div>";
	
	// cleanup owner block
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:owner_block");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "owner_block", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "owner_block"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:owner_block:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"owner_block\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"owner_block\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// hide group actions
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:actions");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "actions", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "actions"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:actions:explain") . "' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// hide group menu items
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:menu");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "menu", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "menu"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:menu:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"menu\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"menu\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// hide group search
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:search");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "search", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "search"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:search:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"search\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"search\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// hide group members
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:members");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "members", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "members"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:members:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"members\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"members\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// show featured groups
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:featured");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "featured", 
		"options_values" => $featured_options, 
		"value" => $group->getPrivateSetting($prefix . "featured"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:featured:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"featured\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"featured\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:featured_sorting");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "featured_sorting", 
		"options_values" => $featured_sorting, 
		"value" => $group->getPrivateSetting($prefix . "featured_sorting"),
		"class" => "mls"
	));
	$form_body .= "</div>";
	
	// hide my status
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_tools:cleanup:my_status");
	$form_body .= ":" . elgg_view("input/dropdown", array(
		"name" => "my_status", 
		"options_values" => $noyes_options, 
		"value" => $group->getPrivateSetting($prefix . "my_status"),
		"class" => "mls"
	));
	$form_body .= "<span alt='" . elgg_echo("group_tools:explain") . "' title='" . elgg_echo("group_tools:cleanup:my_status:explain") . "' onmouseover='elgg.group_tools.cleanup_highlight(\"my_status\");' onmouseout='elgg.group_tools.cleanup_unhighlight(\"my_status\");' class='float-alt'>";
	$form_body .= elgg_view_icon("info");
	$form_body .= "</span>";
	$form_body .= "</div>";
	
	// buttons
	$form_body .= "<div>";
	$form_body .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	$form_body .= "</div>";
	
	// make body
	$title = elgg_echo("group_tools:cleanup:title");
	$body = elgg_view("input/form", array("action" => "action/group_tools/cleanup",
											"body" => $form_body));
	
	// show body
	echo elgg_view_module("info", $title, $body);
}
