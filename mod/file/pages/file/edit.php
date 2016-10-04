<?php
/**
 * Edit a file
 *
 * @package ElggFile
 */

elgg_load_library('elgg:file');
$lang = get_current_language();
elgg_gatekeeper();

$file_guid = (int) get_input('guid');
$file = new FilePluginFile($file_guid);
if (!$file) {
	forward();
}
if (!$file->canEdit()) {
	forward();
}

$title = elgg_echo('file:edit');

elgg_push_breadcrumb(elgg_echo('file'), "file/all");
if($file->title3){
	elgg_push_breadcrumb(gc_explode_translation($file->title3,$lang), $file->getURL());
}else{
	elgg_push_breadcrumb($file->title3, $file->getURL());
}

elgg_push_breadcrumb($title);

elgg_set_page_owner_guid($file->getContainerGUID());

$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = file_prepare_form_vars($file);

$content = elgg_view_form('file/upload', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
