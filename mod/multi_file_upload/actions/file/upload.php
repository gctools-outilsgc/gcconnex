<?php
/**
 * upload.php
 *
 * Manage uploading of files through bootstrap drag and drop upload
 *
 * @package multi_file_upload
 * @author GCTools
 */

//require_once('/var/www/html/gcconnex/engine/start.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/engine/start.php');


$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
//$guid = (int) get_input('file_guid');
$folder_guid = (int) get_input("folder_guid", 0);

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

$successMessage = '';
$failedMessage = '';

$new_file = true;
if ($guid > 0) {
	$new_file = false;
}


elgg_unregister_event_handler('single_file_upload', 'object', 'cp_create_notification');
elgg_unregister_event_handler('single_zip_file_upload', 'object', 'cp_create_notification');
$number_of_files_uploaded = 0;
$files_uploaded = array();

/// loop through files uploaded
for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {

	// check if upload attempted and failed
	if (!empty($_FILES['upload']['name'][$i]) && $_FILES['upload']['error'][$i] != 0) {
		$error = elgg_get_friendly_upload_error($_FILES['upload']['error'][$i]);
		register_error($error);
		continue;
	}

	// must have a file if a new file upload
	if (empty($_FILES['upload']['name'][$i])) {
		$error = elgg_echo('file:nofile');
		register_error($error);
		continue;
	}

	$file = new FilePluginFile();
	$file->subtype = "file";

	// if no title on new upload, grab filename
	$title = htmlspecialchars($_FILES['upload']['name'][$i], ENT_QUOTES, 'UTF-8');
	$title2 = $title;

	$file->title = $title;
	$file->title2 = $title2;
	$file->title3 = gc_implode_translation($title,$title2);
	$file->description = $desc;
	$file->description2 = $desc2;
	$file->description3 = gc_implode_translation($desc,$desc2);
	$file->access_id = $access_id;
	$file->container_guid = $container_guid;
	//$file->tags = string_to_tag_array($tags);

	if (isset($_FILES['upload']['name'][$i]) && !empty($_FILES['upload']['name'][$i])) {

		$prefix = "file/";


		$filestorename = elgg_strtolower(time().$_FILES['upload']['name'][$i]);


		$file->setFilename($prefix . $filestorename);
		$file->originalfilename = $_FILES['upload']['name'][$i];
		$mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'][$i], $_FILES['upload']['type'][$i]);

		$file->setMimeType($mime_type);
		$file->simpletype = elgg_get_file_simple_type($mime_type);

		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		move_uploaded_file($_FILES['upload']['tmp_name'][$i], $file->getFilenameOnFilestore());


		$guid = $file->save();

		// keep track of the files that are uploaded successfully
		$files_uploaded[$number_of_files_uploaded] = $file->getGUID();
		$number_of_files_uploaded++;



		// if image, we need to create thumbnails (this should be moved into a function)
		if ($guid && $file->simpletype == "image") {
			$file->icontime = time();

			$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
			if ($thumbnail) {
				$thumb = new ElggFile();
				$thumb->setMimeType($_FILES['upload']['type'][$i]);

				$thumb->setFilename($prefix."thumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbnail);
				$thumb->close();

				$file->thumbnail = $prefix."thumb".$filestorename;
				unset($thumbnail);
			}

			$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
			if ($thumbsmall) {
				$thumb->setFilename($prefix."smallthumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbsmall);
				$thumb->close();
				$file->smallthumb = $prefix."smallthumb".$filestorename;
				unset($thumbsmall);
			}

			$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
			if ($thumblarge) {
				$thumb->setFilename($prefix."largethumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumblarge);
				$thumb->close();
				$file->largethumb = $prefix."largethumb".$filestorename;
				unset($thumblarge);
			}
		} elseif ($file->icontime) {
			// if it is not an image, we do not need thumbnails
			unset($file->icontime);

			$thumb = new ElggFile();

			$thumb->setFilename($prefix . "thumb" . $filestorename);
			$thumb->delete();
			unset($file->thumbnail);

			$thumb->setFilename($prefix . "smallthumb" . $filestorename);
			$thumb->delete();
			unset($file->smallthumb);

			$thumb->setFilename($prefix . "largethumb" . $filestorename);
			$thumb->delete();
			unset($file->largethumb);
		}

	} else {
		// not saving a file but still need to save the entity to push attributes to database
		$file->save();
	}


	// file saved so clear sticky form
	elgg_clear_sticky_form('file');

	if ($guid) {
		$message = elgg_echo("file:saved");
		system_message($message);

		// log success messages into session variable to display
		$successMessage .= '<li>-'.$_FILES['upload']['name'][$i].'</li>';
		$_SESSION['multi_file_upload_success'] = elgg_echo('multi_upload:success', array($successMessage));

		elgg_create_river_item(array(
			'view' => 'river/object/file/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $file->guid,
		));

	} else {
		// failed to save file object - nothing we can do about this
		$error = elgg_echo("file:uploadfailed");
		register_error($error);

		// log errors into session variable to display
		$failedMessage .= '<li>-'.$_FILES['upload']['name'][$i].'</li>';
		$_SESSION['multi_file_upload_fail'] = elgg_echo('multi_upload:failed', array($failedMessage));
		continue;
	}
}


/// check if the new notifications plugin is active, then trigger the plugin hook, otherwise, trigger event hook
/// if cp notification plugin is active, use that for notifications
if (elgg_is_active_plugin('cp_notifications')) {
	if ($folder_guid === 0) {
		$forward_guid = $container_guid;
		$group_guid = $container_guid;
	} else {
		$forward_guid = $folder_guid;
		$group_guid = get_entity($file->container_guid)->getGUID();

	}

	$files_information = array(
		'number_files_uploaded' => $number_of_files_uploaded,
		'forward_guid' 			=> $forward_guid,
		'group_guid' 			=> $group_guid,
		'files_uploaded' 		=> $files_uploaded,
		'subtype'				=> 'file',
	);

	elgg_trigger_event('multi_file_upload', 'object', $files_information);
	elgg_register_event_handler('single_file_upload', 'object', 'cp_create_notification');
	elgg_register_event_handler('single_zip_file_upload', 'object', 'cp_create_notification');
}


$container = get_entity($container_guid);
if (elgg_instanceof($container, 'group')) {

	/*error_log(json_encode([ 'forwardURL' => [ "file/group/$container->guid/all" ], ]));*/

	echo json_encode([
		'forwardURL' => [
			"file/group/$container->guid/all"
		],
		'count' => [
			$container_guid
		],
		'name' => [
			$_FILES['upload']['name'][0]
		]
	]);
	forward("file/group/$container->guid/all");

} else {

	/*error_log(json_encode([ 'forwardURL' => [ "file/owner/$container->username" ], ]));*/

	echo json_encode([
		'forwardURL' => [
			"file/owner/$container->username"
		],
		'count' => [
			$container_guid
		],
		'name' => [
			$_FILES['upload']['name'][0]
		]
	]);

	forward("file/owner/$container->username");
}


