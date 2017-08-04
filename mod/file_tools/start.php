<?php

define('FILE_TOOLS_SUBTYPE', 'folder');
define('FILE_TOOLS_RELATIONSHIP', 'folder_of');

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'file_tools_init');

/**
 * Called during system initialization
 *
 * @return void
 */
function file_tools_init() {
	// extend CSS
	elgg_extend_view('css/elgg', 'css/file_tools/site.css');
	
	// register CSS libraries
	elgg_register_css('jstree', elgg_get_simplecache_url('js/jstree/themes/default/style.min.css'));
	
	// extend views
	elgg_extend_view('groups/edit', 'file_tools/group_settings');
	
	//ajax views
	elgg_register_ajax_view('object/folder/file_tree_content');
	
	// register page handler for nice URL's
	elgg_register_page_handler('file_tools', '\ColdTrick\FileTools\PageHandler::fileTools');
	
	// make our own URLs for folder icons
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', '\ColdTrick\FileTools\Folder::getIconURL');
	
	// register events
	elgg_register_event_handler('create', 'object', '\ColdTrick\FileTools\ElggFile::create');
	elgg_register_event_handler('update', 'object', '\ColdTrick\FileTools\ElggFile::update');
	elgg_register_event_handler('delete', 'object', '\ColdTrick\FileTools\Folder::delete');
	
	// register hooks
	elgg_register_plugin_hook_handler('permissions_check:metadata', 'object', '\ColdTrick\FileTools\Folder::canEditMetadata');
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', '\ColdTrick\FileTools\Folder::canWriteToContainer');
	elgg_register_plugin_hook_handler('route', 'file', '\ColdTrick\FileTools\Router::file');
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\FileTools\Folder::getURL');
	
	elgg_register_plugin_hook_handler('entity:url', 'object', '\ColdTrick\FileTools\Widgets::wigetGetURL');
	elgg_register_plugin_hook_handler('handlers', 'widgets', '\ColdTrick\FileTools\Widgets::getHandlers');
	
	elgg_register_plugin_hook_handler('register', 'menu:entity', '\ColdTrick\FileTools\Menus\Entity::registerFile');
	elgg_register_plugin_hook_handler('register', 'menu:file_tools_folder_breadcrumb', '\ColdTrick\FileTools\Menus\FolderBreadcrumb::register');
	elgg_register_plugin_hook_handler('register', 'menu:file_tools_folder_sidebar_tree', '\ColdTrick\FileTools\Menus\FolderSidebarTree::register');
	
	elgg_register_plugin_hook_handler('tool_options', 'group', '\ColdTrick\FileTools\Groups::tools');
	
	// register actions
	elgg_register_action('file_tools/groups/save_sort', dirname(__FILE__) . '/actions/groups/save_sort.php');
	elgg_register_action('file_tools/folder/edit', dirname(__FILE__) . '/actions/folder/edit.php');
	elgg_register_action('file_tools/folder/delete', dirname(__FILE__) . '/actions/folder/delete.php');
	elgg_register_action('file_tools/folder/reorder', dirname(__FILE__) . '/actions/folder/reorder.php');
	elgg_register_action('file_tools/upload/zip', dirname(__FILE__) . '/actions/upload/zip.php');
	elgg_register_action('file_tools/folder/delete', dirname(__FILE__) . '/actions/folder/delete.php');
	elgg_register_action('file_tools/file/hide', dirname(__FILE__) . '/actions/file/hide.php');
	
	elgg_register_action('file/move', dirname(__FILE__) . '/actions/file/move.php');
	elgg_register_action('file/bulk_delete', dirname(__FILE__) . '/actions/file/bulk_delete.php');
	
}
