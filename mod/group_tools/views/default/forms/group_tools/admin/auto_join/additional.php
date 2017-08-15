<?php

$id = elgg_extract('id', $vars);
$config = [];
if (empty($id)) {
	$id = 'additional-' . str_ireplace('.', '', microtime(true));
	$config['type'] = elgg_extract('type', $vars, 'additional');
} else {
	$config = group_tools_get_auto_join_configuration($id);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'id',
	'value' => $id,
]);
echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'type',
	'value' => elgg_extract('type', $config, 'additional'),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title',
	'value' => elgg_extract('title', $config),
	'required' => true,
]);

// matching patterns
$label = elgg_view('elements/forms/label', [
	'label' => elgg_echo('group_tools:form:admin:auto_join:additional:pattern'),
	'required' => true,
]);
$help = elgg_view('output/url', [
	'text' => elgg_echo('group_tools:form:admin:auto_join:additional:pattern:add'),
	'href' => '#',
	'id' => 'group-tools-auto-join-add-pattern',
]);
$help .= elgg_view('elements/forms/help', [
	'help' => elgg_echo('group_tools:form:admin:auto_join:additional:pattern:help'),
]);
$patterns = elgg_extract('patterns', $config);
if (!empty($patterns)) {
	$input = '';
	foreach ($patterns as $pattern) {
		$input .= elgg_view('group_tools/elements/auto_join_match_pattern', [
			'pattern' => $pattern,
		]);
	}
} else {
	$input = elgg_view('group_tools/elements/auto_join_match_pattern');
}

echo elgg_view('elements/forms/field', [
	'label' => $label,
	'help' => $help,
	'input' => $input,
	'class' => 'group-tools-auto-join-additional-pattern',
]);

echo elgg_view_field([
	'#type' => 'grouppicker',
	'#label' => elgg_echo('group_tools:form:admin:auto_join:additional:group'),
	'#help' => elgg_echo('group_tools:form:admin:auto_join:additional:group:help'),
	'name' => 'group_guids',
	'values' => elgg_extract('group_guids', $config, []),
]);

// make form footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
?>
<script>
	require(['group_tools/auto_join_additional']);
</script>