<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$search_limit = $vars['entity']->search_limit;
if (empty($search_limit)) {
    $search_limit = '100';
}

$river_message_limit = $vars['entity']->river_message_limit;
if (empty($river_message_limit)) {
    $river_message_limit = '100';
}

$advanced_element_limit = $vars['entity']->advanced_element_limit;
if (empty($advanced_element_limit)) {
    $advanced_element_limit = 4;
}

$river_element_limit = $vars['entity']->river_element_limit;
if (empty($river_element_limit)) {
    $river_element_limit = 10;
}

$search_result_per_page = $vars['entity']->search_result_per_page;
if (empty($search_result_per_page)) {
    $search_result_per_page = 4;
}

$mission_developer_tools_on = $vars['entity']->mission_developer_tools_on;
if (empty($mission_developer_tools_on)) {
    $mission_developer_tools_on = 'YES';
}

$mission_front_page_limit = $vars['entity']->mission_front_page_limit;
if (empty($mission_front_page_limit)) {
	$mission_developer_tools_on = 3;
}

/*$hour_string = ' ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23';
elgg_set_plugin_setting('hour_string', $hour_string, 'missions');

// $minute_string = ' ,00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,31,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59';
$minute_string = ' ,00,15,30,45';
elgg_set_plugin_setting('minute_string', $minute_string, 'missions');

$language_string = ' ,A,B,C';
elgg_set_plugin_setting('language_string', $language_string, 'missions');

$day_string = elgg_echo('missions:mon') . ',' . elgg_echo('missions:tue') . ',' . elgg_echo('missions:wed') . ',' . elgg_echo('missions:thu') . ',' . elgg_echo('missions:fri') . ',' . elgg_echo('missions:sat') . ',' . elgg_echo('missions:sun');
elgg_set_plugin_setting('day_string', $day_string, 'missions');

$security_string = ' ,' . elgg_echo('missions:enhanced_reliability') . ',' . elgg_echo('missions:secret') . ',' . elgg_echo('missions:top_secret');
elgg_set_plugin_setting('security_string', $security_string, 'missions');

$timezone_string = ' ,Canada/Pacific (-8),Canada/Mountain (-7),Canada/Central (-6),Canada/Eastern (-5),Canada/Atlantic (-4),Canada/Newfoundland (-3.5)';
elgg_set_plugin_setting('timezone_string', $timezone_string, 'missions');

$duration_string = ' ,1,2,3,4,5,6,7,8';
elgg_set_plugin_setting('duration_string', $duration_string, 'missions');*/
?>

<div>
	<?php echo elgg_echo('missions:settings:developer_tools'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[mission_developer_tools_on]',
    			'options' => array('YES','NO'),
    			'value' => $mission_developer_tools_on
		));
	?>
<div>
	<?php echo elgg_echo('missions:settings:search_limit'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[search_limit]',
    			'options' => array('20','40','60','80','100','120','140','160','180','200'),
    			'value' => $search_limit
		));
	?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:message_limit'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[river_message_limit]',
    			'options' => array('50','100','150','200','250','300'),
    			'value' => $river_message_limit
		));
	?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:river_element_limit'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[river_element_limit]',
    			'options' => array(5,10,15,20,25),
    			'value' => $river_element_limit
		));
	?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:advanced_element_limit'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    		'name' => 'params[advanced_element_limit]',
    		'options' => array(4,6,8,10),
    		'value' => $advanced_element_limit
		));
	?>
</div>

<div>
	<?php echo elgg_echo('missions:settings:search_result_per_page'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[search_result_per_page]',
    			'options' => array(6,9,12,15),
    			'value' => $search_result_per_page
		));
	?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:mission_front_page_limit'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
    			'name' => 'params[mission_front_page_limit]',
    			'options' => array(3,6,9),
    			'value' => $mission_front_page_limit
		));
	?>
</div>
<!--</br>
<p>
	<?php echo elgg_echo('missions:settings:array_string_paragraph'); ?>
</p>
<div>
	<?php echo elgg_echo('missions:settings:hour_array_string') . "\n"; ?>
	<?php

echo elgg_view('input/text', array(
    'name' => 'params[hour_string]',
    'value' => $hour_string
));
?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:min_array_string') . "\n"; ?>
	<?php

echo elgg_view('input/text', array(
    'name' => 'params[minute_string]',
    'value' => $minute_string
));
?>
</div>
<div>
	<?php echo elgg_echo('missions:settings:lang_array_string') . "\n"; ?>
	<?php

echo elgg_view('input/text', array(
    'name' => 'params[language_string]',
    'value' => $language_string
));
?>
</div>-->