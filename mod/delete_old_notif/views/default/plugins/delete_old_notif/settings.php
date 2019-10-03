<?php

$setting_time_title =  elgg_echo('delete_old_notif:time_input:description');

$setting_time_input = elgg_view('input/text', array(
	'name' => 'params[delete_notif_time_input]',
	'value' => $vars['entity']->delete_notif_time_input,
));

echo elgg_view_module("inline", $setting_time_title, $setting_time_input);