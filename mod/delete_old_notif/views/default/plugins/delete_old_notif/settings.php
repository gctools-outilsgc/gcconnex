<?php

$setting_delete_title =  elgg_echo('delete_old_notif:delete_button:description');

$setting_delete_button = elgg_view("input/button", array(
	"value" => elgg_echo("delete_old_notif:delete"), 
	"class" => "elgg-button elgg-button-action"
));

echo elgg_view_module("inline", $setting_delete_title, $setting_delete_button);

$setting_time_title =  elgg_echo('delete_old_notif:time_input:description');

$setting_time_input = elgg_view('input/text', array(
	'name' => 'params[delete_notif_time_input]',
	'value' => $vars['entity']->delete_notif_time_input,
));

echo elgg_view_module("inline", $setting_time_title, $setting_time_input);