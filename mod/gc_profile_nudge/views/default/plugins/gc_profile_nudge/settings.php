<?php
/*
 * Profile Nudge settings.php
 */

$reminder_time = $vars['entity']->reminder_time;

echo "<label class='mtm' for='reminder_time' style='display: block;'>" . elgg_echo('gc_profile_nudge:timelength') . "</label>";
echo elgg_view('input/select', array(
    'name' => 'params[reminder_time]',
    'id' => 'reminder_time',
    'class' => 'mts mbm',
    'value' => $reminder_time,
    'options_values' => array(
    	'1' => "1 " . elgg_echo('gc_profile_nudge:days'),
    	'2' => "2 " . elgg_echo('gc_profile_nudge:days'),
    	'3' => "3 " . elgg_echo('gc_profile_nudge:days'),
    	'4' => "4 " . elgg_echo('gc_profile_nudge:days'),
    	'5' => "5 " . elgg_echo('gc_profile_nudge:days'),
    	'10' => "10 " . elgg_echo('gc_profile_nudge:days'),
    	'20' => "20 " . elgg_echo('gc_profile_nudge:days'),
    	'30' => "30 " . elgg_echo('gc_profile_nudge:days'),
    	'60' => "60 " . elgg_echo('gc_profile_nudge:days'),
    	'90' => "90 " . elgg_echo('gc_profile_nudge:days'),
    	'120' => "120 " . elgg_echo('gc_profile_nudge:days'),
    	'150' => "150 " . elgg_echo('gc_profile_nudge:days'),
    	'180' => "180 " . elgg_echo('gc_profile_nudge:days'),
    	'210' => "210 " . elgg_echo('gc_profile_nudge:days'),
    	'240' => "240 " . elgg_echo('gc_profile_nudge:days'),
    	'270' => "270 " . elgg_echo('gc_profile_nudge:days'),
    	'300' => "300 " . elgg_echo('gc_profile_nudge:days'),
    	'330' => "330 " . elgg_echo('gc_profile_nudge:days'),
    	'360' => "360 " . elgg_echo('gc_profile_nudge:days')
    )
));
