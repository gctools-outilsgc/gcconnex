<?php
/**
 * Form to add a custom language key
 */

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('translation_editor:custom_keys:key'),
	'name' => 'key',
]);

echo elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('translation_editor:custom_keys:translation'),
	'#help' => elgg_echo('translation_editor:custom_keys:translation_info'),
	'name' => 'translation',
	'rows' => 3,
]);

// form footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
