<?php
/**
 * Elgg ideas widget edit view
 *
 * @package ideas
 */

// set default value
if (!isset($vars['entity']->max_display)) {
	$vars['entity']->max_display = 4;
}
if (!isset($vars['entity']->type_display)) {
	$vars['entity']->type_display = 'top';
}

$params = array(
	'name' => 'params[max_display]',
	'value' => $vars['entity']->max_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$dropdown = elgg_view('input/dropdown', $params);

$params = array(
	'name' => 'params[type_display]',
	'value' => $vars['entity']->type_display,
	'options_values' => array(
		'top' => elgg_echo('ideas:filter:top'),
		'new' => elgg_echo('ideas:filter:new'),
	),
);
$dropdownType = elgg_view('input/dropdown', $params);

?>
<div>
	<?php echo elgg_echo('ideas:numbertodisplay'); ?>:
	<?php echo $dropdown; ?>
	<?php echo '<br/>' . elgg_echo('ideas:typetodisplay'); ?>:
	<?php echo $dropdownType; ?>
</div>
