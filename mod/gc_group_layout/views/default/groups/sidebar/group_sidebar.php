<?php
$lang = get_current_language();
$group = elgg_get_page_owner_entity();

$description = gc_explode_translation($group->description,$lang);
$format_description = elgg_get_excerpt($description, 250);
$link_to_about = elgg_view('output/url', array(
	'text' => 'More about this group',
	'href' => '/groups/about/' .$group->guid, 
));
$access_list = elgg_format_element('li', ['class' => 'd-flex brdr-bttm'], '<div class="info-title">Access: </div><div>'. get_readable_access_level($group->access_id).'</div>');
$message_list = elgg_format_element('li', ['class' => 'd-flex'], '<div class="info-title">GCMessage Channel: </div><div><a href="#">#todoaddthisfeature</a></div>');
$info_list = elgg_format_element('ul', ['class'=> 'mrgn-tp-md mrgn-bttm-0 list-unstyled group-info-list'], $access_list . $message_list);
$content = elgg_format_element('div', [], $format_description . '<div>' .$link_to_about. '</div>' . $info_list);

echo elgg_view('page/components/module', array(
	'title' => 'Group Info',
	'body' => $content,
));