<?php
/**
 * Elgg tasks widget
 *
 * @package ElggPages
 */

$num = (int) $vars['entity']->tasks_num;

$options = array(
	'type' => 'object',
	'subtype' => 'task_top',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$url = "tasks/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('tasks:more'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('tasks:none');
}
