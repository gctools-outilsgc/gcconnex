<?php
$settings = "";
$tabs = array();

$selected_context = get_input("widget_context", "profile");

foreach(array("profile", "dashboard", "groups") as $key => $context){
	$selected = false;
	if($selected_context === $context){
		$selected = true;
	}
	$tabs_options= array(
			"title" => elgg_echo($context),
			"selected" => $selected,
			"url" => "admin/widgets/manage?widget_context=" . $context
		);
	
	$tabs[] = $tabs_options;
	
}

$body = elgg_view("navigation/tabs", array("tabs" => $tabs));
$body .= elgg_view("widget_manager/forms/settings", array("widget_context" => $selected_context));

echo $body;