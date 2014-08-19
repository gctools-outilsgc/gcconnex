<?php
elgg_register_event_handler('init', 'system', 'msoffice_mimetypes_patch_init');
function msoffice_mimetypes_patch_init(){
	elgg_register_page_handler('msoffice_mime_types_patch', 'msoffice_mime_types_patch_handler');
	elgg_register_action('msoffice_mime_types_patch/fixit', elgg_get_plugins_path() . 'msoffice_mime_types_patch/actions/msoffice_mime_types_patch/fixit.php', 'admin');
	elgg_register_menu_item('page', array(
		'name' => 'MS Office Mime Types Patch',
		'href' => 'admin/msoffice_mime_types_patch',
		'text' => elgg_echo('admin:msoffice_mime_types_patch'),
		'context' => 'admin',
		'priority' => 1000,
		'section' => 'administer'
	));
}
function msoffice_mime_types_patch_handler($page){
	include elgg_get_plugins_path() . 'msoffice_mime_types_patch/index.php';
}
?>