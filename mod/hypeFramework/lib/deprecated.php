<?php

/*
 * Deprecated / Legacy Functions
 */

/**
 * Register hypeJunction Framework Libraries
 *
 * @return void
 */
function hj_framework_register_libraries() {

	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

	return true;
}

/**
 * Register hypeJunction Javascript Libraries
 *
 * @return void
 */
function hj_framework_register_js() {

	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

	elgg_extend_view('js/hj/framework/ajax', 'js/lightbox');
	elgg_extend_view('js/hj/framework/ajax', 'js/hj/framework/fieldcheck');
	elgg_extend_view('js/hj/framework/ajax', 'js/vendors/slider/bxslider');

	$hj_js_ajax = elgg_get_simplecache_url('js', 'hj/framework/ajax');
	elgg_register_js('hj.framework.ajax', $hj_js_ajax);
	elgg_load_js('hj.framework.ajax');
	elgg_register_simplecache_view('js/hj/framework/ajax');

	$hj_js_tabs = elgg_get_simplecache_url('js', 'hj/framework/tabs');
	elgg_register_js('hj.framework.tabs', $hj_js_tabs);
	elgg_register_simplecache_view('js/hj/framework/tabs');

	$hj_js_sortable_tabs = elgg_get_simplecache_url('js', 'hj/framework/tabs.sortable');
	elgg_register_js('hj.framework.tabs.sortable', $hj_js_sortable_tabs);
	elgg_register_simplecache_view('js/hj/framework/tabs/sortable');

	$hj_js_sortable_list = elgg_get_simplecache_url('js', 'hj/framework/list.sortable');
	elgg_register_js('hj.framework.list.sortable', $hj_js_sortable_list);
	elgg_register_simplecache_view('js/hj/framework/list.sortable');

	// JS to check mandatory fields
	$hj_js_relationshiptags = elgg_get_simplecache_url('js', 'hj/framework/relationshiptags');
	elgg_register_js('hj.framework.relationshiptags', $hj_js_relationshiptags);
	elgg_register_simplecache_view('js/hj/framework/relationshiptags');

//	// JS for colorpicker
//	$hj_js_colorpicker = elgg_get_simplecache_url('js', 'vendors/colorpicker/colorpicker');
//	elgg_register_js('hj.framework.colorpicker', $hj_js_colorpicker);
//	elgg_register_simplecache_view('js/vendors/colorpicker/colorpicker');
	// JS for filetree
	$hj_js_tree = elgg_get_simplecache_url('js', 'vendors/jstree/tree');
	elgg_register_js('hj.framework.tree', $hj_js_tree);
	elgg_register_simplecache_view('js/vendors/jstree/tree');

	// JS for CLEditor
//	$hj_js_editor = elgg_get_simplecache_url('js', 'vendors/editor/editor');
//	elgg_register_js('hj.framework.editor', $hj_js_editor);
//	elgg_register_simplecache_view('js/vendors/editor/editor');
//    if (elgg_get_plugin_setting('cleditor', 'hypeFramework') == 'on') {
//        elgg_load_js('hj.framework.editor');
//    }
//
//	$hj_js_uploadify = elgg_get_simplecache_url('js', 'vendors/uploadify/jquery.uploadify');
//	elgg_register_js('hj.framework.uploadify', $hj_js_uploadify);
//	elgg_register_simplecache_view('js/vendors/uploadify/jquery.uploadify');
//
//	$hj_js_uploadify_init = elgg_get_simplecache_url('js', 'vendors/uploadify/multifile.init');
//	elgg_register_js('hj.framework.multifile', $hj_js_uploadify_init);
//	elgg_register_simplecache_view('js/vendors/uploadify/multifile.init');

	elgg_load_js('jquery.form');

	return true;
}

/**
 * Register hypeJunction CSS Libraries
 *
 * @return void
 */
function hj_framework_register_css() {

	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

	// Load the CSS Framework
	elgg_extend_view('css/elgg', 'css/hj/framework/base');
	elgg_extend_view('css/admin', 'css/hj/framework/base');

	// Load the 960 Grid
	elgg_extend_view('css/elgg', 'css/hj/framework/grid');
	elgg_extend_view('css/admin', 'css/hj/framework/grid');

	// Profile CSS
	if (!elgg_is_active_plugin('profile')) {
		$hj_css_profile = elgg_get_simplecache_url('css', 'hj/framework/profile');
		elgg_register_css('hj.framework.profile', $hj_css_profile);
		elgg_register_simplecache_view('css/hj/framework/profile');
	}
//	// CSS for colorpicker
//	$hj_css_colorpicker = elgg_get_simplecache_url('css', 'vendors/colorpicker/colorpicker.css');
//	elgg_register_css('hj.framework.colorpicker', $hj_css_colorpicker);
//	elgg_register_simplecache_view('css/vendors/colorpicker/colorpicker.css');
//	// jQuery UI
//	$hj_css_jq = elgg_get_simplecache_url('css', 'vendors/jquery/ui/theme');
//	elgg_register_css('hj.framework.jquitheme', $hj_css_jq);
//	elgg_register_simplecache_view('css/vendors/jquery/ui/theme');
	// Carousel
	$hj_css_carousel = elgg_get_simplecache_url('css', 'vendors/carousel/rcarousel.css');
	elgg_register_css('hj.framework.carousel', $hj_css_carousel);
	elgg_register_simplecache_view('css/vendors/carousel/rcarousel.css');

//	// PL Upload
//	$hj_css_uploadify = elgg_get_simplecache_url('css', 'vendors/uploadify/uploadify.css');
//	elgg_register_css('hj.framework.uploadify', $hj_css_uploadify);
//	elgg_register_simplecache_view('css/vendors/uploadify/uploadify.css');

	return true;
}

/**
 * Register entity URL and page_handlers
 * @return void
 */
function hj_framework_register_page_handlers() {

	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

	/**
	 * URL handlers
	 */
	// we need to protect certain entities from being viewed, as they do not have page handlers yet
	// these will be overriden within individual plugins
	elgg_register_entity_url_handler('object', 'hjform', 'hj_framework_entity_url_forwarder');
	elgg_register_entity_url_handler('object', 'hjfield', 'hj_framework_entity_url_forwarder');
	elgg_register_entity_url_handler('object', 'hjfilefolder', 'hj_framework_entity_url_forwarder');

	elgg_register_entity_url_handler('object', 'hjannotation', 'hj_framework_annotation_url_forwarder');

	elgg_register_entity_url_handler('object', 'hjsegment', 'hj_framework_segment_url_forwarder');

	elgg_register_page_handler('hj', 'hj_framework_legacy_page_handlers');
}

/**
 *  Register plugin and even hooks
 *
 * @return void
 */
function hj_framework_register_hooks() {
	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

// Create new AJAXed menus
//	elgg_register_plugin_hook_handler('register', 'menu:hjentityhead', 'hj_framework_entity_head_menu');
	elgg_register_plugin_hook_handler('register', 'menu:hjentityfoot', 'hj_framework_entity_foot_menu');
	elgg_register_plugin_hook_handler('register', 'menu:hjsegmenthead', 'hj_framework_segment_head_menu');
	elgg_register_plugin_hook_handler('register', 'menu:hjsectionfoot', 'hj_framework_section_foot_menu');

	// hjFile Icons
//	elgg_register_plugin_hook_handler('entity:icon:url', 'all', 'hj_framework_entity_icons');
	// Add Widgets
	elgg_register_plugin_hook_handler('hj:framework:form:process', 'all', 'hj_framework_setup_segment_widgets');

//	if (elgg_get_plugin_setting('cleditor', 'hypeFramework') == 'on') {
//		if (elgg_is_active_plugin('tinymce'))
//			elgg_unregister_plugin_hook_handler('register', 'menu:longtext', 'tinymce_longtext_menu');
//		if (elgg_is_active_plugin('embed'))
//			elgg_unregister_plugin_hook_handler('register', 'menu:longtext', 'embed_longtext_menu');
//		elgg_unregister_js('elgg.tinymce');
//	}
	// Allow writing to hjsegment containers
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', 'hj_framework_container_permissions_check');
	elgg_register_plugin_hook_handler('permissions_check:annotate', 'object', 'hj_framework_canannotate_check');

	// Process Input Types
	elgg_register_plugin_hook_handler('hj:formbuilder:fieldtypes', 'all', 'hj_framework_inputs');
	elgg_register_plugin_hook_handler('hj:framework:field:process', 'all', 'hj_framework_process_inputs');

	elgg_register_event_handler('create', 'object', 'hj_framework_widget_entity_list_update');
	elgg_register_event_handler('update', 'object', 'hj_framework_widget_entity_list_update');

	elgg_register_plugin_hook_handler('output', 'page', 'hj_framework_ajax_pageshell');
}

/**
 * Register necessary actions
 *
 * @return void
 */
function hj_framework_register_actions() {
	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

	$shortcuts = hj_framework_path_shortcuts('hypeFrameworkLegacy');

	// View an entity (by its GUID) or render a view
	elgg_register_action('framework/entities/view', $shortcuts['actions'] . 'hj/framework/view.php', 'public');

	// Edit an entity
	elgg_register_action('framework/entities/edit', $shortcuts['actions'] . 'hj/framework/edit.php');
	// Process an hjForm on submit
	elgg_register_action('framework/entities/save', $shortcuts['actions'] . 'hj/framework/submit.php', 'public');
	// Delete an entity by guid
	elgg_register_action('framework/entities/delete', $shortcuts['actions'] . 'hj/framework/delete.php', 'public');
	// Reset priority attribute of an object
	elgg_register_action('framework/entities/move', $shortcuts['actions'] . 'hj/framework/move.php');
	// E-mail form details
	elgg_register_action('framework/form/email', $shortcuts['actions'] . 'hj/framework/email.php');
	// Add widget
	elgg_register_action('framework/widget/add', $shortcuts['actions'] . 'hj/framework/addwidget.php');
	// Add widget
	elgg_register_action('framework/widget/load', $shortcuts['actions'] . 'hj/framework/loadwidget.php');
	// Download file
	elgg_register_action('framework/file/download', $shortcuts['actions'] . 'hj/framework/download.php', 'public');
}

function hj_framework_register_view_extentions() {

	if (!elgg_is_active_plugin('hypeFrameworkLegacy')) {
		return false;
	}

//	if (elgg_get_plugin_setting('cleditor', 'hypeFramework') == 'on') {
//		elgg_extend_view('input/longtext', 'js/vendors/editor/metatags');
//
//		//elgg_extend_view('page/elements/head', 'js/vendors/editor/metatags');
//	}
}

function hj_framework_decode_options_array(&$item, $key) {
	$item = htmlspecialchars_decode($item, ENT_QUOTES);
	if ($item == 'null') {
		$item = null;
	}
	if ($item == 'false') {
		$item = false;
	}
	if ($item == 'true') {
		$item = true;
	}
}

/**
 * Helper functions to manipulate entities
 *
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category Framework Entities Library
 */

/**
 * Get a an hjForm (data pattern) associated with this entity
 *
 * @param string $type
 * @param string $subtype
 * @param string $handler
 *
 * @return hjForm
 */
function hj_framework_get_data_pattern($type, $subtype, $handler = null) {
	$forms = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'hjform',
		'metadata_name_value_pairs' => array(
			array(
				'name' => 'subject_entity_type',
				'value' => $type
			),
			array(
				'name' => 'subject_entity_subtype',
				'value' => $subtype
			),
			array(
				'name' => 'handler',
				'value' => $handler
			)
			)));
	return $forms[0];
}

/**
 * Extract commonly used parameters from an entity metadata
 *
 * @param ElggEntity $entity
 * @param mixed $params
 * @param string $context
 * @return array
 */
function hj_framework_extract_params_from_entity(ElggEntity $entity, $params = array(), $context = null) {
	$return = array();

	if ($context) {
		elgg_push_context($context);
	} else {
		$context = elgg_get_context();
	}

	if (elgg_instanceof($entity)) {
		$container = $entity->getContainerEntity();
		$owner = $entity->getOwnerEntity();
		$form_guid = $entity->data_pattern;
		$form = get_entity($form_guid);
		if (elgg_instanceof($form)) {
			$handler = $form->handler;
		}

		$widget = get_entity($entity->widget);

		$entity_params = array(
			'entity_guid' => $entity->guid,
			'subject_guid' => $entity->guid,
			'container_guid' => $container->guid,
			'owner_guid' => $owner->guid,
			'form_guid' => $form->guid,
			'widget_guid' => $widget->guid,
			'type' => $entity->getType(),
			'subtype' => $entity->getSubtype(),
			'context' => $context,
			'handler' => $handler,
			'event' => 'update'
		);

		$params = array_merge($entity_params, $params);
	}
	return $params;
}

/**
 * Extract GET query params
 *
 * @return array
 */
function hj_framework_extract_params_from_url() {

	if ($params = get_input('params')) {
		return hj_framework_extract_params_from_params($params);
	}

	$context = get_input('context');
	if (!empty($context)) {
		elgg_push_context($context);
	} else {
		$context = elgg_get_context();
	}

	$section = get_input('subtype');
	if (empty($section)) {
		$section = "hj{$context}";
	}

	$handler = get_input('handler');
	if (empty($handler)) {
		$handler = '';
	}

	$subject_guid = get_input('subject_guid');
	$subject = get_entity($subject_guid);

	if ($entity_guid = get_input('entity_guid')) {
		$entity = get_entity($entity_guid);
		return hj_framework_extract_params_from_entity($entity, $params, $context);
	}

	$container_guid = get_input('container_guid');
	$container = get_entity($container_guid);
	if (!elgg_instanceof($container)) {
		$container = elgg_get_page_owner_entity();
	}

	$owner_guid = get_input('owner_guid');
	if (!empty($owner_guid)) {
		$owner = get_entity($owner_guid);
	} else if (elgg_instanceof($container)) {
		$owner = $container->getOwnerEntity();
	} else if (elgg_is_logged_in()) {
		$owner = elgg_get_logged_in_user_entity();
	} else {
		$owner = elgg_get_site_entity();
	}

	$form_guid = get_input('form_guid');
	$form = get_entity($form_guid);

	if (!elgg_instanceof($form)) {
		$form = hj_framework_get_data_pattern('object', $section, $handler);
	}

	$widget_guid = get_input('widget_guid');
	$widget = get_entity($widget_guid);

	$url_params = array(
		'subject_guid' => $subject->guid,
		'container_guid' => $container->guid,
		'owner_guid' => $owner->guid,
		'form_guid' => $form->guid,
		'widget_guid' => $widget->guid,
		'subtype' => $section,
		'context' => $context,
		'handler' => $handler,
		'event' => 'create'
	);

	return $params;
}

/**
 * Extract parameters from a given array
 *
 * @param array $params
 * @return type
 */
function hj_framework_extract_params_from_params($params = array()) {

	$context = $params['context'];
	if (!empty($context)) {
		elgg_push_context($context);
	} else {
		$context = elgg_get_context();
	}

	$section = $params['subtype'];
	if (empty($section)) {
		$section = "hj{$context}";
	}

	$handler = $params['handler'];
	if (empty($handler)) {
		$handler = '';
	}

	if (!$subject_guid = $params['subject_guid']) {
		$subject_guid = $params['entity_guid'];
	}
	$subject = get_entity($subject_guid);

	$container_guid = $params['container_guid'];
	$container = get_entity($container_guid);
	if (!elgg_instanceof($container)) {
		$container = elgg_get_page_owner_entity();
	}

	$owner_guid = $params['owner_guid'];
	if (!empty($owner_guid)) {
		$owner = get_entity($owner_guid);
	} else if (elgg_instanceof($container)) {
		$owner = $container->getOwnerEntity();
	} else if (elgg_is_logged_in()) {
		$owner = elgg_get_logged_in_user_entity();
	} else {
		$owner = elgg_get_site_entity();
	}

	$form_guid = $params['form_guid'];
	$form = get_entity($form_guid);
	if (!elgg_instanceof($form)) {
		$form = hj_framework_get_data_pattern('object', $section, $handler);
	}

	$widget_guid = $params['widget_type'];
	$widget = get_entity($widget_guid);

	$new_params = array(
		'subject_guid' => $subject->guid,
		'container_guid' => $container->guid,
		'owner_guid' => $owner->guid,
		'form_guid' => $form->guid,
		'widget_guid' => $widget->guid,
		'subtype' => $section,
		'context' => $context,
		'handler' => $handler,
		'event' => 'create'
	);

	$params = array_merge($new_params, $params);
	return $params;
}

function hj_framework_http_build_query($params) {
	if (isset($params['params'])) {
		$params = $params['params'];
	}
	foreach ($params as $key => $param) {
		if (isset($params[$key]) && !elgg_instanceof($param)) {
			$url_params['params'][$key] = $param;
		}
	}
	return http_build_query($url_params);
}

function hj_framework_json_query($params) {
	if (isset($params['params'])) {
		$params = $params['params'];
	}
	foreach ($params as $key => $param) {
		if (isset($params[$key]) && !elgg_instanceof($param)) {
			$url_params['params'][$key] = $param;
		}
	}
	return json_encode($url_params);
}

function hj_framework_decode_params_array($params) {
	foreach ($params as $key => $param) {
		if ($param == 'false') {
			$params[$key] = false;
		} else if ($params == 'true') {
			$params[$key] = true;
		}
	}
	return $params;
}

function hj_framework_get_email_url() {
	$extract = hj_framework_extract_params_from_url();
	$subject = elgg_extract('subject', $extract);

	if (elgg_instanceof($subject)) {
		return $subject->getURL();
	} else {
		return elgg_get_site_url();
	}
}

/**
 * hjFile helper functions
 */

/**
 * Get an array of hjFileFolder for a particular user in a given container
 *
 * @param ElggUser $user
 * @param ElggEntity $container_guid
 * @return type
 */
function hj_framework_get_user_file_folders($format = 'options_array', $owner_guid = NULL, $container_guid = NULL, $limit = 0) {
	if (!$owner_guid && elgg_is_logged_in()) {
		$owner_guid = elgg_get_logged_in_user_entity()->guid;
	} else {
		return true;
	}

	$filefolders = hj_framework_get_entities_by_priority('object', 'hjfilefolder', $owner_guid, $container_guid, $limit);
	switch ($format) {
		case 'options_array' :
			if (is_array($filefolders)) {
				$result[] = elgg_echo("hj:framework:newfolder");
				foreach ($filefolders as $filefolder) {
					$result[$filefolder->getGUID()] = $filefolder->title;
				}
			}
			break;

		case 'entities_array' :
			$result = $filefolders;
			break;
	}
	return $result;
}

function hj_framework_allow_file_download($file_guid) {
	return elgg_trigger_plugin_hook('hj:framework:allowdownload', 'all', array('file_guid' => $file_guid), true);
}

function hj_framework_process_filefolder_input($entity) {
	$newfilefolder = get_input('newfilefolder');
	$filefolder = get_input('filefolder');

	$form = get_entity($entity->data_pattern);
	if ($form->subject_entity_subtype != 'hjfile') {
		$entity->filefolder = null;
		$entity->newfilefolder = null;
	}
	if ((int) $filefolder > 0) {
		$filefolder = get_entity(get_input('filefolder'));
	} else if ($newfilefolder) {
		$filefolder = new ElggObject();
		$filefolder->title = $newfilefolder;
		$filefolder->subtype = 'hjfilefolder';
		$filefolder->datatype = 'default';
		$filefolder->data_pattern = hj_framework_get_data_pattern('object', 'hjfilefolder');
		$filefolder->owner_guid = $entity->owner_guid;
		$filefolder->container_guid = $entity->getGUID();
		$filefolder->access_id = $entity->access_id;
		$filefolder->save();

		hj_framework_set_entity_priority($filefolder);
	} else {
		$filefolder = $entity;
	}
	return $filefolder;
}

function hj_framework_handle_multifile_upload($user_guid) {

	if (!empty($_FILES)) {
		$access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);

		$file = $_FILES['Filedata'];

		$filehandler = new hjFile();
		$filehandler->owner_guid = (int) $user_guid;
		$filehandler->container_guid = (int) $user_guid;
		$filehandler->access_id = ACCESS_DEFAULT;
		$filehandler->data_pattern = hj_framework_get_data_pattern('object', 'hjfile');
		$filehandler->title = $file['name'];
		$filehandler->description = '';

		$prefix = "hjfile/";

		$filestorename = elgg_strtolower($file['name']);

		$mime = hj_framework_get_mime_type($file['name']);

		$filehandler->setFilename($prefix . $filestorename);
		$filehandler->setMimeType($mime);
		$filehandler->originalfilename = $file['name'];
		$filehandler->simpletype = hj_framework_get_simple_type($mime);
		$filehandler->filesize = round($file['size'] / (1024 * 1024), 2) . "Mb";

		$filehandler->open("write");
		$filehandler->close();
		move_uploaded_file($file['tmp_name'], $filehandler->getFilenameOnFilestore());

		$file_guid = $filehandler->save();

		hj_framework_set_entity_priority($filehandler);
		elgg_trigger_plugin_hook('hj:framework:file:process', 'object', array('entity' => $filehandler));

		if ($file_guid) {
			$meta_value = $filehandler->getGUID();
		} else {
			$meta_value = $filehandler->getFilenameOnFilestore();
		}

		if ($file_guid && $filehandler->simpletype == "image") {

			$thumb_sizes = hj_framework_get_thumb_sizes();

			foreach ($thumb_sizes as $thumb_type => $thumb_size) {
				$thumbnail = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $thumb_size['w'], $thumb_size['h'], $thumb_size['square'], 0, 0, 0, 0, true);
				if ($thumbnail) {
					$thumb = new ElggFile();
					$thumb->setMimeType($file['type']);
					$thumb->owner_guid = $user_guid;
					$thumb->setFilename("{$prefix}{$filehandler->getGUID()}{$thumb_type}.jpg");
					$thumb->open("write");
					$thumb->write($thumbnail);
					$thumb->close();

					$thumb_meta = "{$thumb_type}thumb";
					$filehandler->$thumb_meta = $thumb->getFilename();
					unset($thumbnail);
				}
			}
		}
		$response = array(
			'status' => 'OK',
			'value' => $meta_value
		);
	} else {
		$response = array(
			'status' => 'FAIL'
		);
	}

	echo json_encode($response);
	elgg_set_ignore_access($access);
	return;
}

function hj_framework_get_mime_type($filename) {

	// our list of mime types
	$mime_types = array(
		"pdf" => "application/pdf"
		, "exe" => "application/octet-stream"
		, "zip" => "application/zip"
		, "docx" => "application/msword"
		, "doc" => "application/msword"
		, "xls" => "application/vnd.ms-excel"
		, "ppt" => "application/vnd.ms-powerpoint"
		, "gif" => "image/gif"
		, "png" => "image/png"
		, "jpeg" => "image/jpg"
		, "jpg" => "image/jpg"
		, "mp3" => "audio/mpeg"
		, "wav" => "audio/x-wav"
		, "mpeg" => "video/mpeg"
		, "mpg" => "video/mpeg"
		, "mpe" => "video/mpeg"
		, "mov" => "video/quicktime"
		, "avi" => "video/x-msvideo"
		, "3gp" => "video/3gpp"
		, "css" => "text/css"
		, "jsc" => "application/javascript"
		, "js" => "application/javascript"
		, "php" => "text/html"
		, "htm" => "text/html"
		, "html" => "text/html"
	);

	$extension = strtolower(end(explode('.', $filename)));

	return $mime_types[$extension];
}

/**
 * Obtain an array of input types
 *
 * @return array
 */
function hj_formbuilder_get_input_types_array() {
	$types = array(
		'text',
		'plaintext',
		'longtext',
		'url',
		'email',
		'date',
		'dropdown',
		'tags',
		'checkboxes',
		'file',
		'hidden',
		'radio',
		'access',
	);
	$types = elgg_trigger_plugin_hook('hj:formbuilder:fieldtypes', 'all', array('types' => $types), $types);

	return $types;
}

function hj_formbuilder_get_filefolder_types() {
	$types = array('default', 'audio', 'video', 'photo', 'design', 'docs', 'powerpoint');
	$types = elgg_trigger_plugin_hook('hj:formbuilder:foldertypes', 'all', array('types' => $types), $types);
	return $types;
}

/**
 * Create an options_values array for a dropdown of available hjForms
 *
 * @return array
 */
function hj_formbuilder_get_forms_as_dropdown() {
	$forms = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'hjform',
		'limit' => 0
			));

	$options = array();
	//$options[] = 'select...';
	$options[] = elgg_echo('hj:formbuilder:formsdropdown:new');
	if (is_array($forms)) {
		foreach ($forms as $form) {
			//$form->delete();
			$options[$form->guid] = "$form->title";
		}
	}
	return $options;
}

function hj_formbuilder_get_forms_as_sections() {
	$forms = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'hjform',
		'limit' => 0
			));

	$core_subtypes = array('hjsegment', 'hjfile', 'hjfilefolder', 'hjcustommodule');

	$options = array();
	//$options[] = 'select...';
	if (is_array($forms)) {
		foreach ($forms as $form) {
			//$form->delete();
			if (!in_array($form->subject_entity_subtype, $core_subtypes)) {
				$options[$form->subject_entity_subtype] = "$form->subject_entity_subtype";
			}
		}
	}
	return $options;
}

/**
 *  Generic handler of entity icons
 */
function hj_framework_entity_icons($hook, $type, $return, $params) {
	$entity = $params['entity'];
	$size = $params['size'];

	if (!elgg_instanceof($entity)) {
		return $return;
	}

	switch ($entity->getSubtype()) {
		case 'hjfile' :
			if ($entity->simpletype == 'image') {
				return "mod/hypeFramework/pages/file/icon.php?guid={$entity->guid}&size={$size}";
			}

			$mapping = hj_framework_mime_mapping();

			$mime = $entity->mimetype;
			if ($mime) {
				$base_type = substr($mime, 0, strpos($mime, '/'));
			} else {
				$mime = 'none';
				$base_type = 'none';
			}

			if (isset($mapping[$mime])) {
				$type = $mapping[$mime];
			} elseif (isset($mapping[$base_type])) {
				$type = $mapping[$base_type];
			} else {
				$type = 'general';
			}

			$url = "mod/hypeFramework/graphics/mime/{$size}/{$type}.png";
			return $url;

			break;

		case 'hjfilefolder' :

			$type = $folder->datatype;
			if (!$type)
				$type = "default";

			$url = "mod/hypeFramework/graphics/folder/{$size}/{$type}.png";
			return $url;

			break;

		default :
			break;
	}
	$form = hj_framework_get_data_pattern($entity->getType(), $entity->getSubtype());
	if (elgg_instanceof($form, 'object', 'hjform') && $entity->icontime) {
		return elgg_get_config('url') . "hj/icon/$entity->guid/$size/$entity->icontime.jpg";
	}

	return $return;
}

function hj_framework_setup_segment_widgets($hook, $type, $return, $params) {

	$entity_guid = elgg_extract('guid', $params, 0);
	$entity = get_entity($entity_guid);
	$context = elgg_extract('context', $params, 'framework');
	$event = elgg_extract('event', $params, 'update');

	if ($entity->getSubtype() == 'hjsegment' && $event == 'create') {
		$sections = elgg_trigger_plugin_hook('hj:framework:widget:types', 'all', array('context' => $context), array());

		if (is_array($sections)) {
			foreach ($sections as $section => $name) {
				$entity->addWidget($section, null, $context);
			}
		}
	}

	return $return;
}

function hj_framework_container_permissions_check($hook, $type, $return, $params) {
	$container = elgg_extract('container', $params, false);
	$subtype = elgg_extract('subtype', $params, false);

	if ($subtype == 'hjforumsubmission') {
		return true;
	}
	if (elgg_instanceof($container, 'object', 'hjsegment') || $subtype == 'hjsegment') {
		return true;
	}
	if (elgg_instanceof($container, 'user') && $subtype == 'widget') {
		return true;
	}
	if (elgg_instanceof($container, 'object', 'hjannotation')) {
		return true;
	}
	if (elgg_instanceof($container) && $subtype == 'hjannotation') {
		return $container->canAnnotate();
	}

	if (elgg_instanceof($container, 'object', 'hjfilefolder')) {
		return true;
	}
	$container = get_entity($container->container_guid);
	if (elgg_instanceof($container, 'group') && $subtype == 'hjannotation') {
		return $container->canWriteToContainer();
	}

	return $return;
}

function hj_framework_canannotate_check($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params, false);

	if (elgg_instanceof($entity, 'object', 'hjannotation')) {
		$container = $entity->findOriginalContainer();
		if ($container->getType() == 'river') {
			return true;
		}
		if (elgg_instanceof($container_top, 'group')) {
			return $container_top->canWriteToContainer();
		} else {
			return $container->canAnnotate();
		}
	}
	return $return;
}

function hj_framework_inputs($hook, $type, $return, $params) {
	$return[] = 'entity_icon';
	$return[] = 'relationship_tags';
	$return[] = 'multifile';
	return $return;
}

function hj_framework_process_inputs($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params, false);
	$field = elgg_extract('field', $params, false);
	if (!$entity || !$field || !elgg_instanceof($entity)) {
		return true;
	}
	$type = $entity->getType();
	$subtype = $entity->getSubtype();

	switch ($field->input_type) {

		case 'file' :
			if (elgg_is_logged_in()) {
				global $_FILES;
				$field_name = $field->name;
				$file = $_FILES[$field_name];

				// Maybe someone doesn't want us to save the file in this particular way
				if (!empty($file['name']) && !elgg_trigger_plugin_hook('hj:framework:form:fileupload', 'all', array('entity' => $entity, 'file' => $file, 'field_name' => $field_name), false)) {
					hj_framework_process_file_upload($file, $entity, $field_name);
				}
			}
			break;

		case 'entity_icon' :
			$field_name = $field->name;

			global $_FILES;
			if ((isset($_FILES[$field_name])) && (substr_count($_FILES[$field_name]['type'], 'image/'))) {
				hj_framework_generate_entity_icons($entity, $field_name);
				$entity->$field_name = null;
			}
			break;

		case 'relationship_tags' :
			$field_name = $field->name;
			$tags = get_input('relationship_tag_guids');
			$relationship_name = get_input('relationship_tags_name', 'tagged_in');

			$current_tags = elgg_get_entities_from_relationship(array(
				'relationship' => $relationship_name,
				'relationship_guid' => $entity->guid,
				'inverse_relationship' => true
					));
			if (is_array($current_tags)) {
				foreach ($current_tags as $current_tag) {
					if (!in_array($current_tag->guid, $tags)) {
						remove_entity_relationship($current_tag->guid, $relationship_name, $entity->guid);
					}
				}
			}
			if (is_array($tags)) {
				foreach ($tags as $tag_guid) {
					add_entity_relationship($tag_guid, $relationship_name, $entity->guid);
				}
				$tags = implode(',', $tags);
			}

			$entity->$field_name = $tags;

			break;

		case 'multifile' :

			if (elgg_is_logged_in()) {
				$values = get_input($field->name);
				if (is_array($values)) {
					foreach ($values as $value) {
						create_metadata($entity->guid, $field->name, $value, '', $entity->owner_guid, $entity->access_id, true);
						if (!elgg_trigger_plugin_hook('hj:framework:form:multifile', 'all', array('entity' => $entity, 'file_guid' => $value, 'field_name' => $field_name), false)) {
							make_attachment($entity->guid, $value);
						}
					}
				}
			}

			break;
	}

	return true;
}

function hj_framework_ajax_pageshell($hook, $type, $return, $params) {

	if (elgg_is_xhr()) {
		$params['page_shell'] = 'ajax';
		return elgg_view('page/ajax', $params);
	}

	return $return;
}

function hj_framework_industry_list() {
	return $industries = array(
		"industry:47" => elgg_echo("Accounting"),
		"industry:94" => elgg_echo("Airlines/Aviation"),
		"industry:120" => elgg_echo("AlternativeDisputeResolution"),
		"industry:125" => elgg_echo("AlternativeMedicine"),
		"industry:127" => elgg_echo("Animation"),
		"industry:19" => elgg_echo("Apparel&Fashion"),
		"industry:50" => elgg_echo("Architecture&Planning"),
		"industry:111" => elgg_echo("ArtsandCrafts"),
		"industry:53" => elgg_echo("Automotive"),
		"industry:52" => elgg_echo("Aviation&Aerospace"),
		"industry:41" => elgg_echo("Banking"),
		"industry:12" => elgg_echo("Biotechnology"),
		"industry:36" => elgg_echo("BroadcastMedia"),
		"industry:49" => elgg_echo("BuildingMaterials"),
		"industry:138" => elgg_echo("BusinessSuppliesandEquipment"),
		"industry:129" => elgg_echo("CapitalMarkets"),
		"industry:54" => elgg_echo("Chemicals"),
		"industry:90" => elgg_echo("Civic&SocialOrganization"),
		"industry:51" => elgg_echo("CivilEngineering"),
		"industry:128" => elgg_echo("CommercialRealEstate"),
		"industry:118" => elgg_echo("Computer&NetworkSecurity"),
		"industry:109" => elgg_echo("ComputerGames"),
		"industry:3" => elgg_echo("ComputerHardware"),
		"industry:5" => elgg_echo("ComputerNetworking"),
		"industry:4" => elgg_echo("ComputerSoftware"),
		"industry:48" => elgg_echo("Construction"),
		"industry:24" => elgg_echo("ConsumerElectronics"),
		"industry:25" => elgg_echo("ConsumerGoods"),
		"industry:91" => elgg_echo("ConsumerServices"),
		"industry:18" => elgg_echo("Cosmetics"),
		"industry:65" => elgg_echo("Dairy"),
		"industry:1" => elgg_echo("Defense&Space"),
		"industry:99" => elgg_echo("Design"),
		"industry:69" => elgg_echo("EducationManagement"),
		"industry:132" => elgg_echo("E-Learning"),
		"industry:112" => elgg_echo("Electrical/ElectronicManufacturing"),
		"industry:28" => elgg_echo("Entertainment"),
		"industry:86" => elgg_echo("EnvironmentalServices"),
		"industry:110" => elgg_echo("EventsServices"),
		"industry:76" => elgg_echo("ExecutiveOffice"),
		"industry:122" => elgg_echo("FacilitiesServices"),
		"industry:63" => elgg_echo("Farming"),
		"industry:43" => elgg_echo("FinancialServices"),
		"industry:38" => elgg_echo("FineArt"),
		"industry:66" => elgg_echo("Fishery"),
		"industry:34" => elgg_echo("Food&Beverages"),
		"industry:23" => elgg_echo("FoodProduction"),
		"industry:101" => elgg_echo("Fund-Raising"),
		"industry:26" => elgg_echo("Furniture"),
		"industry:29" => elgg_echo("Gambling&Casinos"),
		"industry:145" => elgg_echo("Glass,Ceramics&Concrete"),
		"industry:75" => elgg_echo("GovernmentAdministration"),
		"industry:148" => elgg_echo("GovernmentRelations"),
		"industry:140" => elgg_echo("GraphicDesign"),
		"industry:124" => elgg_echo("Health,WellnessandFitness"),
		"industry:68" => elgg_echo("HigherEducation"),
		"industry:14" => elgg_echo("Hospital&HealthCare"),
		"industry:31" => elgg_echo("Hospitality"),
		"industry:137" => elgg_echo("HumanResources"),
		"industry:134" => elgg_echo("ImportandExport"),
		"industry:88" => elgg_echo("Individual&FamilyServices"),
		"industry:147" => elgg_echo("IndustrialAutomation"),
		"industry:84" => elgg_echo("InformationServices"),
		"industry:96" => elgg_echo("InformationTechnologyandServices"),
		"industry:42" => elgg_echo("Insurance"),
		"industry:74" => elgg_echo("InternationalAffairs"),
		"industry:141" => elgg_echo("InternationalTradeandDevelopment"),
		"industry:6" => elgg_echo("Internet"),
		"industry:45" => elgg_echo("InvestmentBanking"),
		"industry:46" => elgg_echo("InvestmentManagement"),
		"industry:73" => elgg_echo("Judiciary"),
		"industry:77" => elgg_echo("LawEnforcement"),
		"industry:9" => elgg_echo("LawPractice"),
		"industry:10" => elgg_echo("LegalServices"),
		"industry:72" => elgg_echo("LegislativeOffice"),
		"industry:30" => elgg_echo("Leisure,Travel&Tourism"),
		"industry:85" => elgg_echo("Libraries"),
		"industry:116" => elgg_echo("LogisticsandSupplyChain"),
		"industry:143" => elgg_echo("LuxuryGoods&Jewelry"),
		"industry:55" => elgg_echo("Machinery"),
		"industry:11" => elgg_echo("ManagementConsulting"),
		"industry:95" => elgg_echo("Maritime"),
		"industry:97" => elgg_echo("MarketResearch"),
		"industry:80" => elgg_echo("MarketingandAdvertising"),
		"industry:135" => elgg_echo("MechanicalorIndustrialEngineering"),
		"industry:126" => elgg_echo("MediaProduction"),
		"industry:17" => elgg_echo("MedicalDevices"),
		"industry:13" => elgg_echo("MedicalPractice"),
		"industry:139" => elgg_echo("MentalHealthCare"),
		"industry:71" => elgg_echo("Military"),
		"industry:56" => elgg_echo("Mining&Metals"),
		"industry:35" => elgg_echo("MotionPicturesandFilm"),
		"industry:37" => elgg_echo("MuseumsandInstitutions"),
		"industry:115" => elgg_echo("Music"),
		"industry:114" => elgg_echo("Nanotechnology"),
		"industry:81" => elgg_echo("Newspapers"),
		"industry:100" => elgg_echo("Non-ProfitOrganizationManagement"),
		"industry:57" => elgg_echo("Oil&Energy"),
		"industry:113" => elgg_echo("OnlineMedia"),
		"industry:123" => elgg_echo("Outsourcing/Offshoring"),
		"industry:87" => elgg_echo("Package/FreightDelivery"),
		"industry:146" => elgg_echo("PackagingandContainers"),
		"industry:61" => elgg_echo("Paper&ForestProducts"),
		"industry:39" => elgg_echo("PerformingArts"),
		"industry:15" => elgg_echo("Pharmaceuticals"),
		"industry:131" => elgg_echo("Philanthropy"),
		"industry:136" => elgg_echo("Photography"),
		"industry:117" => elgg_echo("Plastics"),
		"industry:107" => elgg_echo("PoliticalOrganization"),
		"industry:67" => elgg_echo("Primary/SecondaryEducation"),
		"industry:83" => elgg_echo("Printing"),
		"industry:105" => elgg_echo("ProfessionalTraining&Coaching"),
		"industry:102" => elgg_echo("ProgramDevelopment"),
		"industry:79" => elgg_echo("PublicPolicy"),
		"industry:98" => elgg_echo("PublicRelationsandCommunications"),
		"industry:78" => elgg_echo("PublicSafety"),
		"industry:82" => elgg_echo("Publishing"),
		"industry:62" => elgg_echo("RailroadManufacture"),
		"industry:64" => elgg_echo("Ranching"),
		"industry:44" => elgg_echo("RealEstate"),
		"industry:40" => elgg_echo("RecreationalFacilitiesandServices"),
		"industry:89" => elgg_echo("ReligiousInstitutions"),
		"industry:144" => elgg_echo("Renewables&Environment"),
		"industry:70" => elgg_echo("Research"),
		"industry:32" => elgg_echo("Restaurants"),
		"industry:27" => elgg_echo("Retail"),
		"industry:121" => elgg_echo("SecurityandInvestigations"),
		"industry:7" => elgg_echo("Semiconductors"),
		"industry:58" => elgg_echo("Shipbuilding"),
		"industry:20" => elgg_echo("SportingGoods"),
		"industry:33" => elgg_echo("Sports"),
		"industry:104" => elgg_echo("StaffingandRecruiting"),
		"industry:22" => elgg_echo("Supermarkets"),
		"industry:8" => elgg_echo("Telecommunications"),
		"industry:60" => elgg_echo("Textiles"),
		"industry:130" => elgg_echo("ThinkTanks"),
		"industry:21" => elgg_echo("Tobacco"),
		"industry:108" => elgg_echo("TranslationandLocalization"),
		"industry:92" => elgg_echo("Transportation/Trucking/Railroad"),
		"industry:59" => elgg_echo("Utilities"),
		"industry:106" => elgg_echo("VentureCapital&PrivateEquity"),
		"industry:16" => elgg_echo("Veterinary"),
		"industry:93" => elgg_echo("Warehousing"),
		"industry:133" => elgg_echo("Wholesale"),
		"industry:142" => elgg_echo("WineandSpirits"),
		"industry:119" => elgg_echo("Wireless"),
		"industry:103" => elgg_echo("WritingandEditing")
	);
}

function hj_framework_mime_mapping() {
	return $mapping = array(
		'application/excel' => 'xls',
		'application/msword' => 'doc',
		'application/pdf' => 'pdf',
		'application/powerpoint' => 'ppt',
		'application/vnd.ms-excel' => 'xls',
		'application/vnd.ms-powerpoint' => 'ppt',
		'application/vnd.oasis.opendocument.text' => 'doc',
		'application/x-gzip' => 'gzip',
		'application/x-rar-compressed' => 'rar',
		'application/zip' => 'zip',
		'text/directory' => 'vcard',
		'text/v-card' => 'vcard',
		'application/octet-stream' => 'exe',
		'application' => 'application',
		'audio' => 'music',
		'text' => 'text',
		'video' => 'video',
		'image' => 'image'
	);
}

/**
 * Various Menu Hook Handlers
 *
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category AJAX
 * @category Menu
 * @category Object
 *
 */

/**
 * Hook handler for menu:hjentityhead
 * Header menu of an entity
 * By default, contains Edit and Delete buttons
 *      Edit button loads ajax and replaces entity content in <div id="elgg-object-{$guid}">
 *      Delete button sends an ajax request and on success removes <div id="elgg_object_{$guid}">
 *
 *
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 *
 */
function hj_framework_entity_head_menu($hook, $type, $return, $params) {

//	if (elgg_in_context('print') || elgg_in_context('activity') || !elgg_is_logged_in()) {
//		return $return;
//	}
	// Extract available parameters
	$entity = elgg_extract('entity', $params);
	$handler = elgg_extract('handler', $params);

	//$handler = elgg_extract('handler', $params);

	$current_view = elgg_extract('current_view', $params);

	if (!$current_view) {
		$params['short_view'] = true;
	}
	$params = hj_framework_extract_params_from_params($params);
	$data = hj_framework_json_query($params);

	if (!$current_view || (elgg_is_xhr() && !elgg_in_context('fancybox'))) {
		if (!isset($params['has_full_view']) || $params['has_full_view'] === true) {
			$params['params']['full_view'] = true;
			$params['params']['push_context'] = 'fancybox';
			$data = hj_framework_json_query($params);
			$fullview = array(
				'name' => 'fullview',
				'title' => elgg_echo('hj:framework:gallerytitle', array($entity->title)),
				'text' => elgg_echo('hj:framework:gallerytitle', array($entity->title)),
				'href' => "action/framework/entities/view?e=$entity->guid",
				'data-options' => htmlentities($data, ENT_QUOTES, 'UTF-8'),
				'rel' => 'fancybox',
				'class' => 'hj-ajaxed-view',
				'priority' => 300,
				'section' => 'dropdown'
			);
			$return[] = ElggMenuItem::factory($fullview);
		}
	}

	if ($handler == 'hjfile') {
		$file_guid = elgg_extract('file_guid', $params);

		if (hj_framework_allow_file_download($file_guid)) {
			$download = array(
				'name' => 'download',
				'title' => elgg_echo('hj:framework:download'),
				'text' => elgg_echo('hj:framework:download'),
				'id' => "hj-ajaxed-download-{$file_guid}",
				'href' => "hj/file/download/{$file_guid}/",
				'target' => '_blank',
				'priority' => 500,
				'section' => 'dropdown'
			);
			$return[] = ElggMenuItem::factory($download);
		}
	}

	if ($entity && elgg_instanceof($entity) && $entity->canEdit()) {
		$edit = array(
			'name' => 'edit',
			'title' => elgg_echo('hj:framework:edit'),
			'text' => elgg_echo('hj:framework:edit'),
			'rel' => 'fancybox',
			'href' => "action/framework/entities/edit",
			'data-options' => htmlentities($data, ENT_QUOTES, 'UTF-8'),
			'class' => "hj-ajaxed-edit",
			'priority' => 800,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($edit);

		// AJAXed Delete Button
		$delete = array(
			'name' => 'delete',
			'title' => elgg_echo('hj:framework:delete'),
			'text' => elgg_echo('hj:framework:delete'),
			'href' => "action/framework/entities/delete?e=$entity->guid",
			'data-options' => htmlentities($data, ENT_QUOTES, 'UTF-8'),
			'class' => 'hj-ajaxed-remove',
			'id' => "hj-ajaxed-remove-{$entity->guid}",
			'priority' => 900,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($delete);
	}

	// access
	$access = elgg_view('output/access', array('entity' => $entity));
	$options = array(
		'name' => 'access',
		'text' => $access,
		'href' => false,
		'priority' => 100,
	);
	$return[] = ElggMenuItem::factory($options);

	return $return;
}

/**
 * Hook handler for menu:hjentityfoot
 * Footer menu of an entity
 * By default, contains a full_view of an element in a hidden div
 * @return array
 */
function hj_framework_entity_foot_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);
	$handler = elgg_extract('handler', $params);

	if (elgg_in_context('print') || elgg_in_context('activity')) {
		return $return;
	}

	return $return;
}

/**
 * Hook handler for menu:hjsegmenthead
 * Contains a sectional menu
 * By default, contains Add and Refresh
 *      Add button - loads a form to add a new element
 *      Refresh button - reloads section content
 *
 */
function hj_framework_segment_head_menu($hook, $type, $return, $params) {

	// Extract available parameters
	$entity = elgg_extract('entity', $params);

	$container_guid = elgg_extract('container_guid', $params['params']);
	$container = get_entity($container_guid);

	$section = elgg_extract('subtype', $params['params']);
	$handler = elgg_extract('handler', $params['params']);

	$data = hj_framework_json_query($params);
	$url = hj_framework_http_build_query($params);

	if (elgg_instanceof($entity, 'object', 'hjsegment') && elgg_instanceof($container) && $container->canEdit()) {

		// Add widget
		$widget = array(
			'name' => 'widget',
			'title' => elgg_echo('hj:framework:addwidget'),
			'text' => elgg_echo('hj:framework:addwidget'),
			'href' => "action/framework/widget/add",
			'data-options' => $data,
			'id' => "hj-ajaxed-addwidget-{$entity->guid}",
			'class' => "hj-ajaxed-addwidget",
			'target' => "elgg-object-{$entity->guid}",
			'priority' => 100,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($widget);

		// AJAXed Edit Button
		$edit = array(
			'name' => 'edit',
			'title' => elgg_echo('hj:framework:edit'),
			'text' => elgg_echo('hj:framework:edit'),
			'href' => "action/framework/entities/edit",
			'data-options' => $data,
			'id' => "hj-ajaxed-edit-{$entity->guid}",
			'class' => "hj-ajaxed-edit",
			'target' => "elgg-object-{$entity->guid}",
			'priority' => 800,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($edit);

		// AJAXed Delete Button
		$delete = array(
			'name' => 'delete',
			'title' => elgg_echo('hj:framework:delete'),
			'text' => elgg_echo('hj:framework:delete'),
			'href' => "action/framework/entities/delete?e=$entity->guid",
			'data-options' => $data,
			'id' => "hj-ajaxed-remove-{$entity->guid}",
			'class' => 'hj-ajaxed-remove',
			'priority' => 900,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($delete);
	}

	$print = array(
		'name' => 'print',
		'title' => elgg_echo('hj:framework:print'),
		'text' => elgg_echo('hj:framework:print'),
		'href' => "hj/print?{$url}",
		'target' => "_blank",
		'priority' => 200,
		'section' => 'dropdown'
	);
	$return[] = ElggMenuItem::factory($print);

	if (file_exists(elgg_get_plugins_path() . 'hypeFramework/lib/dompdf/dompdf_config.inc.php')) {
		$pdf = array(
			'name' => 'pdf',
			'title' => elgg_echo('hj:framework:pdf'),
			'text' => elgg_echo('hj:framework:pdf'),
			'href' => "hj/pdf?{$url}",
			//'is_action' => false,
			'target' => "_blank",
			'priority' => 300,
			'section' => 'dropdown'
		);
		$return[] = ElggMenuItem::factory($pdf);
	}
//        $email_form = hj_framework_get_data_pattern('object', 'hjemail');
//        $email_f = $email_form->guid;
//
//        $email = array(
//            'name' => 'email',
//            'title' => elgg_echo('hj:framework:email'),
//            'text' => elgg_view_icon('hj hj-icon-email'),
//            'href' => "action/framework/entities/edit?f={$email_f}&s={$entity->guid}",
//            //'is_action' => true,
//            'rel' => 'fancybox',
//            'id' => "hj-ajaxed-email-{$entity->guid}",
//            'class' => "hj-ajaxed-edit",
//            'target' => "#elgg-object-{$entity->guid}",
//            'priority' => 300
//        );
//	$return[] = ElggMenuItem::factory($email);

	return $return;
}

/**
 * Hook handler for menu:hjsectionfoot
 * Contains a sectional menu
 * By default, contains Add and Refresh
 *      Add button - loads a form to add a new element
 *      Refresh button - reloads section content
 *
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array
 *
 * - $c - container entity
 * - $o - owner entity
 * - $f - form entity
 * - $context - context
 * - $sn - section name
 *
 */
function hj_framework_section_foot_menu($hook, $type, $return, $params) {

	$container_guid = elgg_extract('container_guid', $params['params']);
	$container = get_entity($container_guid);

	$widget_guid = elgg_extract('widget_guid', $params['params']);
	$widget = get_entity($widget_guid);

	$segment_guid = elgg_extract('segment_guid', $params['params']);
	$segment = get_entity($segment_guid);

	$section = elgg_extract('subtype', $params['params']);

	$data = hj_framework_json_query($params);

	if (elgg_instanceof($container) && $container->canEdit()) {
		// AJAXed Add Button
		$add = array(
			'name' => 'add',
			'title' => elgg_echo('hj:framework:addnew'),
			'text' => elgg_view_icon('hj hj-icon-add') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:addnew') . '</span>',
			'href' => "action/framework/entities/edit",
			'data-options' => $data,
			'is_action' => true,
			'rel' => 'fancybox',
			'class' => "hj-ajaxed-add",
			'priority' => 200
		);
		$return[] = ElggMenuItem::factory($add);

//        // AJAXed Refresh Button
//        $refresh = array(
//            'name' => 'refresh',
//            'title' => elgg_echo('hj:framework:refresh'),
//            'text' => elgg_view_icon('hj hj-icon-refresh') . '<span class="hj-icon-text">' . elgg_echo('hj:framework:refresh') . '</span>',
//            'href' => "action/framework/entities/view?e=$entity->guid",
//            'data-options' => $data,
//            'is_action' => true,
//            'id' => "hj-ajaxed-refresh-{$entity->guid}",
//            'class' => "hj-ajaxed-refresh",
//            'target' => "#elgg-widget-{$widget->guid} #hj-section-{$section}",
//            'priority' => 300
//        );
//        $return[] = ElggMenuItem::factory($refresh);
	}

	return $return;
}

function hj_framework_entity_url_forwarder($entity) {
	return 'hj/';
}

function hj_framework_segment_url_forwarder($entity) {
	if (elgg_instanceof($entity, 'object', 'hjsegment')) {
		$container = $entity->getContainerEntity();
		return $container->getURL();
	}
	return 'hj/';
}

/**
 * Forward hjAnnotation to its container handler
 */
function hj_framework_annotation_url_forwarder($entity) {
	$container = $entity->getContainerEntity();
	if (elgg_instanceof($container)) {
		return $container->getURL();
	} else {
		return '';
	}
}

function hj_framework_legacy_page_handlers($page) {
	$plugin = 'hypeFrameworkLegacy';
	$shortcuts = hj_framework_path_shortcuts($plugin);
	$pages = dirname(dirname(dirname(__FILE__))) . '/pages/';

	if (!isset($page[0])) {
		forward();
	}

	switch ($page[0]) {
		case 'file' :
			if (!isset($page[1]))
				forward();


			switch ($page[1]) {
				case 'download':
					set_input('e', $page[2]);
					include $pages . 'file/download.php';
					break;

				default :
					forward();
					break;
			}

		case 'print' :
			include $pages . 'print/print.php';
			break;

		case 'pdf' :
			include $pages . 'print/pdf.php';
			break;

		case 'icon':
			set_input('guid', $page[1]);
			set_input('size', $page[2]);
			include "{$pages}icon/icon.php";
			break;

		case 'sync':
			switch ($page[1]) {
				default :
					include "{$pages}sync/sync.php";
					break;

				case 'priority' :
					include "{$pages}sync/sync_priority.php";
					break;

				case 'metadata' :
					include "{$pages}sync/sync_metadata.php";
					break;

				case 'relationship' :
					include "{$pages}sync/sync_relationship.php";
					break;
			}
			break;

		case 'multifile' :
			session_id(get_input('Elgg'));
			global $_SESSION;
			$_SESSION = json_decode(get_input('SESSION'), true);
			hj_framework_handle_multifile_upload(get_input('userid'));
			break;

		default :
			return false;
			break;
	}
	return true;
}

function hj_framework_setup() {
	if (elgg_is_logged_in()) {
		hj_framework_setup_filefolder_form();
		hj_framework_setup_file_form();
		elgg_set_plugin_setting('hj:framework:setup', true, 'hypeFramework');
		return true;
	}
	return false;
}

function hj_framework_setup_filefolder_form() {
//Setup Filefolder Form
	$form = new hjForm();
	$form->title = 'hypeFramework:filefolder';
	$form->label = 'File Folder Creation Form';
	$form->description = 'hypeFramework File Folder Creation Form';
	$form->subject_entity_subtype = 'hjfilefolder';
	$form->notify_admins = false;
	$form->add_to_river = false;
	$form->comments_on = false;
	$form->ajaxify = true;

	if ($form->save()) {
		$form->addField(array(
			'title' => 'Name of the folder',
			'name' => 'title',
			'mandatory' => true
		));
		$form->addField(array(
			'title' => 'Description',
			'name' => 'description',
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext'
		));
		$form->addField(array(
			'title' => 'Tags',
			'name' => 'tags',
			'input_type' => 'tags'
		));
		$form->addField(array(
			'title' => 'Folder Type',
			'name' => 'datatype',
			'input_type' => 'dropdown',
			'options_values' => "hj_framework_get_filefolder_types();"
		));
		$form->addField(array(
			'title' => 'Access Level',
			'name' => 'access_id',
			'input_type' => 'access'
		));
		return true;
	}
	return false;
}

function hj_framework_setup_file_form() {
	//Setup Files Form
	$form = new hjForm();
	$form->title = 'hypeFramework:fileupload';
	$form->label = 'File Upload Form';
	$form->description = 'hypeFramework File Upload Form';
	$form->subject_entity_subtype = 'hjfile';
	$form->notify_admins = false;
	$form->add_to_river = true;
	$form->comments_on = true;

	if ($form->save()) {
		$form->addField(array(
			'title' => 'Name of the File',
			'name' => 'title',
			'mandatory' => true
		));
		$form->addField(array(
			'title' => 'Description',
			'name' => 'description',
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext'
		));
		$form->addField(array(
			'title' => 'Tags',
			'name' => 'tags',
			'input_type' => 'tags'
		));
		$form->addField(array(
			'title' => 'Folder Name',
			'tooltip' => 'elgg_echo("if empty, create one below")',
			'name' => 'filefolder',
			'input_type' => 'dropdown',
			'options_values' => 'hj_framework_get_user_file_folders();'
		));
		$form->addField(array(
			'title' => 'Create new folder',
			'name' => 'newfilefolder'
		));
		$form->addField(array(
			'title' => 'Upload',
			'name' => 'fileupload',
			'input_type' => 'file',
			'mandatory' => true
		));
		$form->addField(array(
			'title' => 'Access Level',
			'name' => 'access_id',
			'input_type' => 'access'
		));
		return true;
	}
	return false;
}