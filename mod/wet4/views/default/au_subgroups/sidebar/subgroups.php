<?php
/*
* GC_MODIFICATION
* Description: Added view all link with footer style. Added support for content translation.
* Author: GCTools Team
*/
namespace AU\SubGroups;
$lang = get_current_language();
if ($vars['entity']->subgroups_enable == 'no') {
	// no subgroups allowed
	return;
}

$sgCount = '';

$subgroups = get_subgroups($vars['entity'], 3);
$body = '';

if (!$subgroups) {
	$body = '<div class="elgg-subtext">' . elgg_echo('au_subgroups:nogroups') . '</div>';
} else {
	foreach ($subgroups as $subgroup) {

		$subgroup_name = gc_explode_translation( $subgroup->name, $lang);

		$body .= elgg_view_image_block(
				elgg_view_entity_icon($subgroup, 'tiny'), elgg_view('output/url', array(
			'href' => $subgroup->getURL(),
			'text' => $subgroup_name,
			'is_trusted' => true))
		);
	}

    //count total number of subgroups and add it to view all link
    $subgroupsTotalCount = get_subgroups($vars['entity']);
    $sgCount = '(' . count($subgroupsTotalCount) . ')';
}

$title = elgg_echo('au_subgroups:subgroups');

$all_link = elgg_view('output/url', array(
	'href' => 'groups/subgroups/list/' . $vars['entity']->guid,
	'text' => elgg_echo('au_subgroups:subgroups:more') . $sgCount,
	'is_trusted' => true,
		));

$footer = "<div class='text-right'>$all_link</div>";

//only show subgroups widget if the group has subgroups
if($sgCount){
    echo elgg_view_module('aside', $title, $body, array('footer' => $footer,));
}
