<?php

namespace AU\SubGroups;

$group = elgg_get_page_owner_entity();

$parent = get_parent_group($group);

// radio buttons use label => value
$options_values = array(
	elgg_echo('au_subgroups:deleteoption:delete') => 'delete',
	elgg_echo('au_subgroups:deleteoption:owner') => 'owner',
);

if ($parent) {
	$options_values[elgg_echo('au_subgroups:deleteoption:parent')] = 'parent';
}

echo "<label>" . elgg_echo('au_subgroups:delete:label') . "</label><br><br>";
echo elgg_view('input/radio', array(
	'name' => 'au_subgroups_content_policy',
	'value' => 'delete',
	'options' => $options_values
));

echo "<br><br>";

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $group->guid));

echo elgg_view('input/submit', array('value' => elgg_echo('submit')));
