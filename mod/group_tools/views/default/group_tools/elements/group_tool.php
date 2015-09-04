<?php
/**
 * Display one group tool option
 *
 * @uses $vars['group_tool'] the group tool options
 * @uses $vars['value']      the current value of this option
 * @uses $vars['name']       (optional) the name of the input
 * @uses $vars['class']      (optional) class to be put on the wrapper div
 */

$group_tool = elgg_extract("group_tool", $vars);
$value = elgg_extract("value", $vars);

$group_tool_toggle_name = elgg_extract("name", $vars, $group_tool->name . "_enable");

$attr = array(
	'class' => elgg_extract("class", $vars)
);

$content = elgg_view('input/checkbox', array(
	'name' => $group_tool_toggle_name,
	'value' => 'yes',
	'default' => 'no',
	'checked' => ($value === 'yes') ? true : false,
	'label' => $group_tool->label,
	'class' => 'mrs'
));

// optional description
$lan_key = $group_tool->name . ":group_tool_option:description";
if (elgg_language_key_exists($lan_key)) {
	$content .= elgg_view("output/longtext", array("value" => elgg_echo($lan_key), "class" => "elgg-quiet mtn"));
}

echo elgg_format_element('div', $attr, $content);
