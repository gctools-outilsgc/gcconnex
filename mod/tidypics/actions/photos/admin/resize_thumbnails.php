<?php
/**
 * Tidypics Batch Thumbnail Re-Sizing
 *
 * Called through ajax, but registered as an Elgg action.
 *
 */

elgg_load_library('tidypics:resize');

global $START_MICROTIME;
$batch_run_time_in_secs = 5;

// Offset is the total amount of images processed so far.
$offset = (int) get_input("offset", 0);
$limit = 5;

$image_lib = elgg_get_plugin_setting('image_lib', 'tidypics');
if (!$image_lib) {
	$image_lib = "GD";
}

$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

_elgg_services()->db->disableQueryCache();

$success_count = 0;
$error_count_invalid_image = 0;
$error_count_recreate_failed = 0;

while ((microtime(true) - $START_MICROTIME) < $batch_run_time_in_secs) {

	$batch = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'image',
		'limit' => $limit,
		'offset' => $offset,
	));

	foreach($batch as $image) {
		$filename = $image->getFilename();
		$container_guid = $image->container_guid;

		if (!$filename || !$container_guid) {
			$error_count_invalid_image++;
		} else {
			$prefix = "image/$container_guid/";
			$filestorename = substr($filename, strlen($prefix));

			switch ($image_lib) {
				case "ImageMagick":
					if (!tp_create_im_cmdline_thumbnails($image, $prefix, $filestorename)) {
						$error_count_recreate_failed++;
					} else {
						$success_count++;
					}
					break;
				case "ImageMagickPHP":
					if (!tp_create_imagick_thumbnails($image, $prefix, $filestorename)) {
						$error_count_recreate_failed++;
					} else {
						$success_count++;
					}
					break;
				default:
					if (!tp_create_gd_thumbnails($image, $prefix, $filestorename)) {
						$error_count_recreate_failed++;
					} else {
						$success_count++;
					}
					break;
			}
		}
	}
	$offset += $limit;
}

access_show_hidden_entities($access_status);

_elgg_services()->db->enableQueryCache();

// Give some feedback for the UI
echo json_encode(array(
	"numSuccess" => $success_count,
	"numErrorsInvalidImage" => $error_count_invalid_image,
	"numErrorsRecreateFailed" => $error_count_recreate_failed
));
