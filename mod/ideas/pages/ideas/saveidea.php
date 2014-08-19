<?php
/**
 * Add idea page
 *
 * @package ideas
 *
 * input search come from search.php
 */

elgg_push_breadcrumb(elgg_echo('ideas:idea:add'));

if ($idea && !$idea->canWritetoContainer()) {
	register_error(elgg_echo('ideas:idea:save:failed'));
	forward(REFERRER);
}

$vars = ideas_prepare_form_vars();

$content = elgg_view_form('ideas/saveidea', array(), $vars);

$title = elgg_echo('ideas:idea:add');

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);