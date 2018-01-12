<?php
/**
 * The Wire Attachment.
 *
 * Attach files to the wire!
 */

elgg_register_event_handler('init', 'system', 'thewire_image');

/**
 * Inits the plugin
 *
 * @return void
 */
function thewire_image() {
	$plugin_root = dirname(__FILE__);
	elgg_register_library('thewire_image', "$plugin_root/lib/thewire_image.php");
	elgg_register_js('dropzone', 'mod/thewire_images/js/dropzone.js');
	elgg_register_css('dropzone', 'mod/thewire_images/css/dropzone.css');
	
	elgg_extend_view('js/elgg', 'js/thewire_image');

	elgg_register_event_handler('create', 'object', 'thewire_image_check_attachments');
	elgg_register_event_handler('delete', 'object', 'thewire_image_delete_attached_files');

	// overrule default save action
	elgg_unregister_action("thewire/add");
	elgg_register_action("thewire/add", "$plugin_root/actions/thewire/add.php");

	// downloads are served through pages instead of actions so the download link can be shared.
	// action tokens prevent sharing action links.
	// this means we need to implement our own security in the page handler using gatekeeper().
	elgg_register_page_handler('thewire_image', 'thewire_image_page_handler');
}

/**
 * Check for attachments when wire posts are created.
 *
 * @param type $event
 * @param type $type
 * @param type $object
 * @return type mixed
 */
function thewire_image_check_attachments($event, $type, $object) {
	if (!elgg_instanceof($object, 'object', 'thewire')) {
		return null;
	}

	$file = elgg_extract('thewire_image_file', $_FILES, null);

	if ($file) {
		$file_obj = new TheWireImage();


		$file_obj->setFilename('thewire_image/' . rand().".jpg");

		$file_obj->setMimeType($file['type']);
		$file_obj->original_filename = $file['name'];
		$file_obj->simpletype = file_get_simple_type($file['type']);
		$file_obj->access_id = ACCESS_PUBLIC;

		$file_obj->open("write");
		$file_obj->write(get_uploaded_file('thewire_image_file'));
		$file_obj->close();

		if ($file_obj->save()) {

			$file_obj->addRelationship($object->getGUID(), 'is_attachment');

		} else {
			register_error(elgg_echo('thewire_image:could_not_save_image'));
		}
	}

	return null;
}

/**
 * The wire attachment page handler
 *
 * Supports:
 *	Download an attachment: thewire_image/download/<guid>/<title>
 *
 * @param array $page From the page_handler function
 * @return bool
 */
function thewire_image_page_handler($page) {
	gatekeeper();
	$pages = dirname(__FILE__) . '/pages/thewire_image';
	$section = elgg_extract(0, $page);

	switch($section) {
		case 'download':
			$guid = elgg_extract(1, $page);
			set_input('guid', $guid);
			require "$pages/download.php";
			break;

		default:
			// in the future we'll be able to register this as a 404
			// for now, act like an action and forward away.
			register_error(elgg_echo('thewire_image:invalid_section'));
			forward(REFERRER);
	}
}

/**
 * Deletes any attachments when wire posts are deleted.
 *
 * @param type $event
 * @param type $type
 * @param type $object
 * @return null
 */
function thewire_image_delete_attached_files($event, $type, $object) {

	if (!elgg_instanceof($object, 'object', 'thewire')) {
		return null;
	}
	
	// we want to use the thewire_image_get_attachments() function,
	// so load the library.
	elgg_load_library('thewire_image');

	$attachment = thewire_image_get_attachments($object->getGUID());

	if ($attachment && !$attachment->delete()) {
		register_error(elgg_echo('thewire_image:could_not_delete'));
	}
}