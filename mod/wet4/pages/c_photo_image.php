<?php

/**
 * This is a page used to display the cover photo for a group
 *
 * c_photo_image description.
 *
 * @version 1.0
 * @author Nick
 */
// Get engine
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
 //get the file guid
$file_guid = (int) get_input('file_guid');
//get it's entity
$file = get_entity($file_guid);
$thumbfile = $file->large;
$readfile = new ElggFile();
$readfile->owner_guid = $file->owner_guid;
$readfile->setFilename("groups_c_photo/" . $file_guid. '.jpg');
//$mime = $file->getMimeType();
$contents = $readfile->grabFile();

//$contents = $file->grabFile();
// caching images for 10 days

header("Content-type: image/jpeg");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+10 days")), true);
//header('Expires: ' . date('r',time() + 1)); //cache expires in 1 second
header("Pragma: public", true);
header("Cache-Control: public", true);
header("Content-Length: " . strlen($contents));

echo $contents;