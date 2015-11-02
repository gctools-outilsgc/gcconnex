<?php
/**
 * Display a form for quick blog adding
 */

$bubble_icon = elgg_view_icon('speech-bubble');
$add_string = elgg_echo('activity:blog:add');

// This automatically toggles the element with the same id as the href
$blog_link = elgg_view('output/url', array(
    'text' =>  "$bubble_icon $add_string",
    'href' => "#activity-blog-form",
    'rel' => 'toggle',
    'class' => 'blog-form-toggle elgg-button elgg-button-submit',
));

$module_vars = array('id' => 'activity-blog-form');

// Set default values
$body_vars = array('title' => '', 'description' => '', 'tags' => '');

// Get possible sticky values
if (elgg_is_sticky_form('blog')) {
	$sticky_values = elgg_get_sticky_values('blog');
	foreach ($sticky_values as $key => $value) {
		$body_vars[$key] = $value;
	}
} else {
	// There are no values so hide the form for now
	$module_vars['class'] = 'hidden';
}

elgg_clear_sticky_form('blog');

$form_vars = array('action' => 'action/activity/blog/save');

$blog_form = elgg_view_form('activity/blog/save', $form_vars, $body_vars);

echo $blog_link;
echo elgg_view_module('featured', '', $blog_form, $module_vars);
