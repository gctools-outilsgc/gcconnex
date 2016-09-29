<?php
/**
 * View a file
 *
 * @package ElggFile
 */

$guid = get_input('guid');

elgg_entity_gatekeeper($guid, 'object', 'file');

$file = get_entity($guid);

$owner = elgg_get_page_owner_entity();

elgg_group_gatekeeper();

elgg_push_breadcrumb(elgg_echo('file'), 'file/all');

$lang = get_current_language();


if ($owner->title3){
	$crumbs_title = gc_explode_translation($owner->title3,$lang);	
}else{
	$crumbs_title = $owner->name;	
}
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "file/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "file/owner/$owner->username");
}

if($file->title3){
	$title = gc_explode_translation($file->title3, $lang);
	$file->title = gc_explode_translation($file->title3, $lang);
}else{
	$title = $file->title;
}
elgg_push_breadcrumb($crumbs_title);

$content = elgg_view_entity($file, array('full_view' => true));
$content .= elgg_view_comments($file);
elgg_register_menu_item('title', array(
	'name' => 'download',
	'text' => elgg_echo('download'),
	'href' => "file/download/$file->guid",
	'link_class' => 'elgg-button elgg-button-action',
));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
