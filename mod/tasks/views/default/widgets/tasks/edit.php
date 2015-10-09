<?php
/**
 * Elgg tasks widget edit
 *
 * @package ElggTasks
 */

// set default value
if (!isset($vars['entity']->tasks_num)) {
	$vars['entity']->tasks_num = 4;
}

$params = array(
	'name' => 'params[tasks_num]',
	'value' => $vars['entity']->tasks_num,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<div>
	<?php echo elgg_echo('tasks:num'); ?>:
	<?php echo $dropdown; ?>
</div>
