<?php
/**
 * All wire posts
 * 
 */

elgg_push_breadcrumb(elgg_echo('thewire'));

$title = elgg_echo('thewire:everyone');

$content = '';
if (elgg_is_logged_in()) {
	$form_vars = array('class' => 'thewire-form');
	$content .= elgg_view_form('thewire/add', $form_vars);
	$content .= elgg_view('input/urlshortener');
}
$new_post_holder = elgg_format_element('div', array('class'=>'posts-holder'),'');
$content .= elgg_format_element('div', array('class'=>'new-wire-holder'),$new_post_holder);

$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => get_input('limit', 15),
	'preload_owners' => true,
));

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('thewire/sidebar'),
));

echo elgg_view_page($title, $body);
