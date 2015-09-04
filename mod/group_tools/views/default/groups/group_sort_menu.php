<?php
/**
 * All groups listing page navigation
 *
 */

$tabs = array(
	"newest" => array(
		"text" => elgg_echo("sort:newest"),
		"href" => "groups/all?filter=newest",
		"priority" => 200,
	),
	"yours" => array(
		"text" => elgg_echo("groups:yours"),
		"href" => "groups/all?filter=yours",
		"priority" => 250,
	),
	"popular" => array(
		"text" => elgg_echo("sort:popular"),
		"href" => "groups/all?filter=popular",
		"priority" => 300,
	),
	"discussion" => array(
		"text" => elgg_echo("groups:latestdiscussion"),
		"href" => "groups/all?filter=discussion",
		"priority" => 400,
	),
	"open" => array(
		"text" => elgg_echo("group_tools:groups:sorting:open"),
		"href" => "groups/all?filter=open",
		"priority" => 500,
	),
	"closed" => array(
		"text" => elgg_echo("group_tools:groups:sorting:closed"),
		"href" => "groups/all?filter=closed",
		"priority" => 600,
	),
	"alpha" => array(
		"text" => elgg_echo("group_tools:groups:sorting:alphabetical"),
		"href" => "groups/all?filter=alpha",
		"priority" => 700,
	),
	"ordered" => array(
		"text" => elgg_echo("group_tools:groups:sorting:ordered"),
		"href" => "groups/all?filter=ordered",
		"priority" => 800,
	),
	"suggested" => array(
		"text" => elgg_echo("group_tools:groups:sorting:suggested"),
		"href" => "groups/suggested",
		"priority" => 900,
	),
);

foreach ($tabs as $name => $tab) {
	$show_tab = false;
	$show_tab_setting = elgg_get_plugin_setting("group_listing_" . $name . "_available", "group_tools");
	if ($name == "ordered") {
		if ($show_tab_setting == "1") {
			$show_tab = true;
		}
	} elseif ($show_tab_setting !== "0") {
		$show_tab = true;
	}
	
	if ($show_tab && in_array($name, array("yours", "suggested")) && !elgg_is_logged_in()) {
		$show_tab = false;
	}
	
	if ($show_tab) {
		$tab["name"] = $name;
		
		if ($vars["selected"] == $name) {
			$tab["selected"] = true;
		}
	
		elgg_register_menu_item("filter", $tab);
	}
}

echo elgg_view_menu("filter", array("sort_by" => "priority", "class" => "elgg-menu-hz"));
