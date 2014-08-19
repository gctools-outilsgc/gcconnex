<?php
/**
 * Avatar crop action
 *
 */

$guid = get_input('guid');
$owner = get_entity($guid);

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('avatar:crop:fail'));
	forward(REFERER);
}

$x1 = (int) get_input('x1', 0);
$y1 = (int) get_input('y1', 0);
$x2 = (int) get_input('x2', 0);
$y2 = (int) get_input('y2', 0);

$filehandler = new ElggFile();
$filehandler->owner_guid = $owner->getGUID();
$filehandler->setFilename("profile/" . $owner->guid . "master" . ".jpg");
$filename = $filehandler->getFilenameOnFilestore();

// ensuring the avatar image exists in the first place
if (!file_exists($filename)) {
	register_error(elgg_echo('avatar:crop:fail'));
	forward(REFERER);
}

/* START gcProfilePictureBadges addition: add badges to master image */
require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
global $badgemap;

$badge_d = get_input( 'badge', '' );
$badge = $badgemap[$badge_d]; 		// which badge

// update badge settings
$user = elgg_get_logged_in_user_entity();
$user->active_badge = $badge_d;

if ( $badge != '' ) {
	$dest_size = getimagesize($filename);
	$side_length = 150;
	$badge_file = elgg_get_plugins_path() . 'gcProfilePictureBadges/graphics/' . $badge;
	
	// load master avatar file (always a jpeg)
	$dest = imagecreatefromjpeg( $filename );
	
	// get badge file's type
	$badgesizearray = getimagesize($badge_file);
	
	$accepted_formats = array(
		'image/jpeg' => 'jpeg',
		'image/pjpeg' => 'jpeg',
		'image/png' => 'png',
		'image/x-png' => 'png',
		'image/gif' => 'gif'
	);
	$badge_load_function = "imagecreatefrom" . $accepted_formats[$badgesizearray['mime']];
	
	// load badge file
	$src = $badge_load_function( $badge_file );
	
	imagealphablending($src, false);
	imagesavealpha($src, true);

	// prepare resize parameters
	if ( $x1 == 0 && $x2 == 0 && $y1 == 0 && $y2 == 0){		// if no cropping parameters are passed
		$center_x = floor( $dest_size[0]/2 );
		$center_y = floor( $dest_size[1]/2 );
		$half_side_length = floor( min( $dest_size[0], $dest_size[1] ) / 2 );
		
		$d_x1 = $center_x - $half_side_length; 
		$d_x2 = $center_x + $half_side_length;
		
		$d_y1 = $center_y - $half_side_length; 
		$d_y2 = $center_y + $half_side_length;
	}
	else{
		$d_x1 = $x1; 
		$d_x2 = $x2;
		
		$d_y1 = $y1; 
		$d_y2 = $y2;
	}
	
	$dest_crop[0] = $d_x2 - $d_x1;
	$dest_crop[1] = $d_y2 - $d_y1;
	
	$badge_size = getimagesize($badge_file);
	$re_size = 1;			// resize parameter
	if ( $badge_size[0] / $dest_crop[0] > $badge_size[1] / $dest_crop[1] )	// the side length is 1/5 of the more constrained dimention
		$re_size = 0.25 * $dest_crop[0]; 
	else
		$re_size = 0.25 * $dest_crop[1]; 
	
	
//imagecopymerge($dest, $src, $x1 + 5, $y1 + 5, 0, 0, 32, 32, 100);
imagecopyresampled($dest, $src, $d_x1 + 3, $d_y1 + 3, 0, 0, $re_size, $re_size, $badge_size[0], $badge_size[1]);
	ob_start();
	imagejpeg($dest, NULL, 90);
	$new_master = ob_get_clean();

		$file = new ElggFile();
		$file->owner_guid = $guid;
		$file->setFilename("profile/" . $owner->guid . "master+badge" . ".jpg");
		$file->open('write');
		$file->write($new_master);
		$file->close();
		
		// use the master avatar with the badge from now on
	$filehandler->setFilename("profile/" . $owner->guid . "master+badge" . ".jpg");
	$filename = $filehandler->getFilenameOnFilestore();
}
/* END of gcProfilePictureBadges addition */

$icon_sizes = elgg_get_config('icon_sizes');
unset($icon_sizes['master']);

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();
foreach ($icon_sizes as $name => $size_info) {
	$resized = get_resized_image_from_existing_file($filename, $size_info['w'], $size_info['h'], $size_info['square'], $x1, $y1, $x2, $y2, $size_info['upscale']);

	if ($resized) {
		//@todo Make these actual entities.  See exts #348.
		$file = new ElggFile();
		$file->owner_guid = $guid;
		$file->setFilename("profile/{$guid}{$name}.jpg");
		$file->open('write');
		$file->write($resized);
		$file->close();
		$files[] = $file;
	} else {
		// cleanup on fail
		foreach ($files as $file) {
			$file->delete();
		}

		register_error(elgg_echo('avatar:resize:fail'));
		forward(REFERER);
	}
}

$owner->icontime = time();

$owner->x1 = $x1;
$owner->x2 = $x2;
$owner->y1 = $y1;
$owner->y2 = $y2;

system_message(elgg_echo('avatar:crop:success'));
$view = 'river/user/default/profileiconupdate';
elgg_delete_river(array('subject_guid' => $owner->guid, 'view' => $view));
add_to_river($view, 'update', $owner->guid, $owner->guid);

forward(REFERER);
