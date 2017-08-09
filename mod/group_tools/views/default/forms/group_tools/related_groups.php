<?php

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
	return;
}

$content = elgg_view('input/autocomplete', [
	'name' => 'guid',
	'match_on' => 'groups',
	'placeholder' => elgg_echo('group_tools:related_groups:form:placeholder'),
]);
$content .= elgg_view('input/hidden', ['name' => 'group_guid', 'value' => $group->getGUID()]);
$content .= elgg_view('input/submit', ['value' => elgg_echo('add')]);
$content .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('group_tools:related_groups:form:description'));

echo elgg_format_element('div', ['id' => 'group-tools-related-groups-form'], $content);
