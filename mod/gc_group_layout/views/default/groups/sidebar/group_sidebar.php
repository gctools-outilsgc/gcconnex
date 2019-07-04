<?php
$lang = get_current_language();
$group = elgg_get_page_owner_entity();

$description = gc_explode_translation($group->description,$lang);
$link_to_about = elgg_view('output/url', array(
	'text' => 'About this group',
	'href' => '/groups/about/' .$group->guid, 
));
$info_list = elgg_format_element('ul', ['array' => 'list-group'], '<li class="list-group-item">Members: X</li><li class="list-group-item">GCMessage: LINK</li>');
$content = elgg_format_element('div', [], $description . $link_to_about . $info_list);

echo elgg_view('page/components/module', array(
	'title' => 'Group Info',
	'body' => $content,
	'footer' => $all_link,
));