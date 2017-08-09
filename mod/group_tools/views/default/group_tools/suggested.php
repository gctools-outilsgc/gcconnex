<?php

/**
 * Group Tools
 *
 * List all suggested groups
 *
 * @author ColdTrick IT Solutions
 * 
 */

$groups = elgg_extract('groups', $vars);

if (empty($groups)) {
	return;
}

$lis = [];
foreach ($groups as $group) {
	
	$group_url = $group->getURL();
	
	$join_url = "action/groups/join?group_guid={$group->getGUID()}";
	
	if ($group->isPublicMembership() || $group->canEdit()) {
		$join_text = elgg_echo('groups:join');
	} else {
		// request membership
		$join_text = elgg_echo('groups:joinrequest');
	}
	
	$group_title = elgg_format_element('h3', [], elgg_view('output/url', [
		'text' => $group->name,
		'href' => $group_url,
		'is_trusted' => true,
	]));
	$icon = elgg_view_entity_icon($group, 'large');
	$description = '';
	if (!empty($group->briefdescription)) {
		$description = elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_view('output/text', [
			'value' => $group->briefdescription,
		]));
	}
	$join_link = elgg_format_element('div', [], elgg_view('output/url', [
		'text' => $join_text,
		'href' => $join_url,
		'is_action' => true,
		'class' => 'elgg-button elgg-button-action',
	]));
	
	$content = elgg_format_element('div', [], $group_title . $icon . $description . $join_link);
	
	$lis[] = elgg_format_element('li', ['class' => 'elgg-item'], $content);
}

echo elgg_format_element('ul', ['class' => 'elgg-gallery group-tools-suggested-groups'], implode('', $lis));

elgg_require_js('group_tools/suggested');
