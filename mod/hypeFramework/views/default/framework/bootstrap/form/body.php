<?php

$form_name = elgg_extract('form_name', $vars);

$form = elgg_extract('form', $vars);
$fields = elgg_extract('fields', $form, array());

$entity = elgg_extract('entity', $vars, false);

$event = ($entity) ? 'edit' : 'create';

// Get form title
if (isset($form['title'][$event])) {
	$title = $form['title'][$event];
}

// Get form description
if (isset($form['description'][$event])) {
	$content = elgg_view('output/longtext', array(
		'value' => $form['description'][$event],
		'class' => 'elgg-form-description'
			));
}

if ($fields && count($fields)) {
	foreach ($fields as $name => $options) {
		if (!$options)
			continue;

		$options['form_name'] = $form_name;
		$options['name'] = $name;
		$params['field'] = $options;
		$content .= elgg_view('framework/bootstrap/form/elements/field', $params);
	}
}

$footer .= elgg_view('input/hidden', array(
	'name' => 'form_name',
	'value' => $form_name
		));

if ($form['buttons']) {
	$footer .= $vars['buttons'];
} else if ($form['buttons'] !== false) {

	$footer .= elgg_view('input/submit', array(
		'value' => elgg_echo('submit'),
		'class' => 'elgg-button-submit'
	));

	// cyu - 01-21-2015: fixed the cancel button

	// $footer .= elgg_view('input/button', array(
	// 	'value' => elgg_echo('cancel'),
	// 	'class' => 'elgg-button-cancel elgg-button-cancel-trigger',
	// ));

	// cyu - 01-22-2015: alternative (fix)
	// 	$footer .= elgg_view('output/confirmlink', array(
	// 		'name' => 'Cancel',
	// 		'text' => elgg_echo('cancel'),
	// 		'href' => 'action/dosomething',
	// 		'confirm' => 'Are you sure?',
	// 		'class' => 'elgg-button elgg-button-cancel'
	// 	));
}

echo elgg_view_module('form', $title, $content, array(
	'footer' => $footer
));
