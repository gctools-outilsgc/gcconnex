<?php

echo elgg_view_field([
	'#type' => 'file',
	'#label' => elgg_echo('translation_editor:import:file'),
	'name' => 'import',
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'language',
	'value' => elgg_extract('current_language', $vars),
]);


$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('import'),
]);

elgg_set_form_footer($footer);
