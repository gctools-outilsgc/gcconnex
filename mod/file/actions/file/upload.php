<?php
/**
 * Elgg file uploader/edit action
 *
 * @package ElggFile
 */

// Get variables
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$title2 = htmlspecialchars(get_input('title2', '', false), ENT_QUOTES, 'UTF-8');
$title3 = gc_implode_translation($title,$title2);
$desc = get_input("description");
$desc2 = get_input("description2");
$desc3 = gc_implode_translation($desc,$desc2);
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$guid = (int) get_input('file_guid');
$tags = get_input("tags");

/// retrieve information whether this was marked as minor edit or not
$file_edit = get_input('minor_edit');

if ($container_guid == 0) {
	$container_guid = elgg_get_logged_in_user_guid();
}

elgg_make_sticky_form('file');

// check if upload attempted and failed
if (!empty($_FILES['upload']['name']) && $_FILES['upload']['error'] != 0) {
	$error = elgg_get_friendly_upload_error($_FILES['upload']['error']);

	register_error($error);
	forward(REFERER);
}

// check whether this is a new file or an edit
$new_file = true;
if ($guid > 0) {
	$new_file = false;
}

if ($new_file) {
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
		$title = htmlspecialchars($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8');
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

$file->title = $title3;
//$file->title2 = $title2;
$file->description = $desc3;
//$file->description2 = $desc2;
$file->access_id = $access_id;
$file->container_guid = $container_guid;
$file->tags = string_to_tag_array($tags);

// we have a file upload, so process it
if (isset($_FILES['upload']['name']) && !empty($_FILES['upload']['name'])) {

	$prefix = "file/";

	// if previous file, delete it
	if (!$new_file) {
		$filename = $file->getFilenameOnFilestore();
		if (file_exists($filename)) {
			unlink($filename);
		}
	}

	$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);

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

	/// execute this line of code only if cp_notifications is active and that file is not minor edit
	if (elgg_is_active_plugin('cp_notifications') && $file_edit != 1)
		elgg_trigger_event('single_file_upload', $file->getType(), $file);
	else
		elgg_unregister_event_handler('create','object','cp_create_notification');
	
	$thumb = new ElggFile();
	$thumb->owner_guid = $file->owner_guid;

	$sizes = [
		'small' => [
			'w' => 60,
			'h' => 60,
			'square' => true,
			'metadata_name' => 'thumbnail',
			'filename_prefix' => 'thumb',
		],
		'medium' => [
			'w' => 153,
			'h' => 153,
			'square' => true,
			'metadata_name' => 'smallthumb',
			'filename_prefix' => 'smallthumb',
		],
		'large' => [
			'w' => 600,
			'h' => 600,
			'square' => false,
			'metadata_name' => 'largethumb',
			'filename_prefix' => 'largethumb',
		],
	];

	$remove_thumbs = function () use ($file, $sizes, $thumb) {
		if (!$file->guid) {
			return;
		}

		unset($file->icontime);

		foreach ($sizes as $size => $data) {
			$filename = $file->{$data['metadata_name']};
			if ($filename !== null) {
				$thumb->setFilename($filename);
				$thumb->delete();
				unset($file->{$data['metadata_name']});
			}
		}
	};

	$remove_thumbs();

	$jpg_filename = pathinfo($filestorename, PATHINFO_FILENAME) . '.jpg';

	if ($guid && $file->simpletype == "image") {
		$file->icontime = time();

		foreach ($sizes as $size => $data) {
			$image_bytes = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), $data['w'], $data['h'], $data['square']);
			if (!$image_bytes) {
				// bail and remove any thumbs
				$remove_thumbs();
				break;
			}

			$filename = "{$prefix}{$data['filename_prefix']}{$jpg_filename}";
			$thumb->setFilename($filename);
			$thumb->open("write");
			$thumb->write($image_bytes);
			$thumb->close();
			unset($image_bytes);

			$file->{$data['metadata_name']} = $filename;
		}
	}

} else {
	// not saving a file but still need to save the entity to push attributes to database
	$file->save();
}

// file saved so clear sticky form
elgg_clear_sticky_form('file');


// handle results differently for new files and file updates
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
