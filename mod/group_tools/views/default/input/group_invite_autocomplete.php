<?php
/**
 * special autocomplete input
 */
$name = elgg_extract('name', $vars); // input name of the selected user
$id = elgg_extract('id', $vars);
$relationship = elgg_extract('relationship', $vars);

$destination = "{$id}_autocomplete_results";

$minChars = (int) elgg_extract('minChars', $vars, 3);
if ($minChars < 1) {
	$minChars = 3;
}

echo elgg_view('input/text', [
	'id' => $id . '_autocomplete',
	'class' => 'elgg-input-autocomplete',
	'data-group-guid' => elgg_extract('group_guid', $vars),
	'data-name' => $name,
	'data-relationship' => $relationship,
	'data-min-chars' => $minChars,
	'data-destination' => $destination,
]);

echo elgg_format_element('div', ['id' => $destination, 'class' => 'mtm clearfloat']);
?>
<script type="text/javascript">
	require(['group_tools/group_invite_autocomplete'], function (autoc) {
		autoc.init('<?php echo $id; ?>');
	});
</script>
