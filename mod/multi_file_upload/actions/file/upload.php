<?php

//if (empty($_FILES)) {
//	error_log('no files');
    // No file was selected for upload, your (re)action goes here
//}
//error_log(json_encode($_FILES));
//error_log($_FILES['uploads']['name'][0]);
//$folder = $_POST['folder_guid'];
//$access = $_POST['access_id_file'];

//if(!empty($_FILES['uploads'])){
//  $body = 'its here: '. $_FILES['uploads']['name'][0] . ' size: '.$_FILES['uploads']['name'][1];
//} else {
//  $file = 'fuck no';
//}

//system_message($folder . ' ' . $access . ' file ->'. $file);
require_once('/var/www/elggGit/engine/start.php');
error_log('mulit action');


$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$title2 = htmlspecialchars(get_input('title2', '', false), ENT_QUOTES, 'UTF-8');
$desc = get_input("description");
$desc2 = get_input("description2");
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$folder_guid = (int) get_input("folder_guid", 0);
//error_log($_POST['folder_guid']);
//$tags = get_input("tags");

//error_log($title.' - '.$title2.' - '.$desc.' - '.$desc2.' - '.$access_id.' - '.$container_guid.' - '.$guid.' - '.$folder_guid);

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

// check if upload attempted and failed
if (!empty($_FILES['upload']['name'][0]) && $_FILES['upload']['error'][0] != 0) {
	$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);

	register_error($error);
	//error_log('empty');
	forward(REFERER);
}

$new_file = true;
if ($guid > 0) {
	$new_file = false;
}

if ($new_file) {
	//error_log('new file');
	// must have a file if a new file upload
	if (empty($_FILES['upload']['name'])) {
		$error = elgg_echo('file:nofile');
		register_error($error);

		forward(REFERER);
	}

	$file = new FilePluginFile();
	$file->subtype = "file";

	// if no title on new upload, grab filename
	if (empty($title)) {
		$title = htmlspecialchars($_FILES['upload']['name'][0], ENT_QUOTES, 'UTF-8');
		$title2 = $title;
	}
	
} else {
	// load original file object
	$file = new FilePluginFile($guid);
	if (!$file) {
		register_error(elgg_echo('file:cannotload'));
		forward(REFERER);
	}

	// user must be able to edit file
	if (!$file->canEdit()) {
		register_error(elgg_echo('file:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $file->title;
	}
}
$file->title = $title;
$file->title2 = $title2;
$file->title3 = gc_implode_translation($title,$title2);
$file->description = $desc;
$file->description2 = $desc2;
$file->description3 = gc_implode_translation($desc,$desc2);
$file->access_id = $access_id;
$file->container_guid = $container_guid;
//$file->tags = string_to_tag_array($tags);

if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "file/";

	// if previous file, delete it
	if ($new_file == false) {
		$filename = $file->getFilenameOnFilestore();
		if (file_exists($filename)) {
			unlink($filename);
		}

		// use same filename on the disk - ensures thumbnails are overwritten
		$filestorename = $file->getFilename();
		$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
	} else {
		$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
	}

	$file->setFilename($prefix . $filestorename);
	$file->originalfilename = $_FILES['upload']['name'];
	$mime_type = $file->detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);

	$file->setMimeType($mime_type);
	$file->simpletype = elgg_get_file_simple_type($mime_type);

	// Open the file to guarantee the directory exists
	$file->open("write");
	$file->close();
	move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());

	$guid = $file->save();

	// if image, we need to create thumbnails (this should be moved into a function)
	if ($guid && $file->simpletype == "image") {
		$file->icontime = time();
		
		$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->setMimeType($_FILES['upload']['type']);

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
if ($new_file) {
	if ($guid) {
		$message = elgg_echo("file:saved");
		system_message($message);
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
	}

	$container = get_entity($container_guid);
	if (elgg_instanceof($container, 'group')) {
		forward("file/group/$container->guid/all");
	} else {
		forward("file/owner/$container->username");
	}

} else {
	if ($guid) {
		system_message(elgg_echo("file:saved"));
	} else {
		register_error(elgg_echo("file:uploadfailed"));
	}

	forward($file->getURL());
}
 ?>
