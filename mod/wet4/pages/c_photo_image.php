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


echo $contents;
