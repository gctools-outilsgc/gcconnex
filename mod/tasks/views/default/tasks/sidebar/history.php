<?php
/**
 * History of this task
 *
 * @uses $vars['task']
 */

$title = elgg_echo('tasks:history');

if ($vars['task']) {
	$options = array(
		'guid' => $vars['task']->guid,
		'annotation_name' => 'task',
		'limit' => 20,
		'reverse_order_by' => true
	);
	$content = elgg_list_annotations($options);
}

echo elgg_view_module('aside', $title, $content);