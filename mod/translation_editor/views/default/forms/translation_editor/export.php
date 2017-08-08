<?php

echo elgg_view_field([
	'#type' => 'checkboxes',
	'#label' => elgg_echo('translation_editor:export:plugins'),
	'name' => 'plugins',
	'options' => elgg_extract('exportable_plugins', $vars),
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'language',
	'value' => elgg_extract('current_language', $vars),
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('export'),
]);

elgg_set_form_footer($footer);
