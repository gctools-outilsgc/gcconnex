<?php

namespace AU\SubGroups;

if ($vars['entity']->subgroups_enable == 'no') {
	// no subgroups allowed
	return;
}

$all_link = elgg_view('output/url', array(
	'href' => 'groups/subgroups/list/' . $vars['entity']->guid,
	'text' => elgg_echo('au_subgroups:subgroups:more'),
	'is_trusted' => true,
		));

$subgroups = get_subgroups($vars['entity'], 5);
$body = '';

if (!$subgroups) {
	$body = '<div class="elgg-subtext">' . elgg_echo('au_subgroups:nogroups') . '</div>';
} else {
	foreach ($subgroups as $subgroup) {

		$body .= elgg_view_image_block(
				elgg_view_entity_icon($subgroup, 'tiny'), elgg_view('output/url', array(
			'href' => $subgroup->getURL(),
			'text' => $subgroup->name,
			'is_trusted' => true))
		);
	}
}

$title = elgg_echo('au_subgroups:subgroups');


$body .= "<div class='center mts'>$all_link</div>";

echo elgg_view_module('aside', $title, $body);
