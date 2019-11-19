<?php
$lang = get_current_language();
$group = elgg_get_page_owner_entity();
//TODO: Add link to GCmessage
$description = gc_explode_translation($group->description,$lang);
if($description != ""){
	$format_description = '<div><b>'. elgg_echo('description').'</b></div>' . elgg_get_excerpt($description, 300);
}
$link_to_about = elgg_view('output/url', array(
	'text' => elgg_echo('group:more_button'),
	'href' => '/groups/about/' .$group->guid,
	'class' => 'btn btn-default',
));
$mem = ($group->isPublicMembership()) ? elgg_echo('groups:open') : elgg_echo('groups:closed');
$access_list = elgg_format_element('li', ['class' => 'd-flex'], '<div class="info-title">'.elgg_echo('access').': </div><div>'. $mem.'</div>');
$info_list = elgg_format_element('ul', ['class'=> 'mrgn-tp-md mrgn-bttm-0 list-unstyled group-info-list'], $access_list);
$content = elgg_format_element('div', [], $info_list . $format_description . '<div class="mrgn-tp-md">' .$link_to_about. '</div>');

echo elgg_view('page/components/module', array(
	'title' => elgg_echo('group:info'),
	'body' => $content,
));