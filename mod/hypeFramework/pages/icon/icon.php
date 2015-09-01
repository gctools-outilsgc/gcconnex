<?php

$ha = access_get_show_hidden_status();
access_show_hidden_entities(true);

$entity_guid = get_input('guid');
$entity = get_entity($entity_guid);

$size = strtolower(get_input('size'));

if (!array_key_exists($size, hj_framework_get_thumb_sizes($entity->getSubtype()))) {
	$size = 'medium';
}

$success = false;

$filename = "icons/" . $entity->getGUID() . $size . ".jpg";

$filehandler = new ElggFile();
$filehandler->owner_guid = $entity->owner_guid;
$filehandler->setFilename($filename);

if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->size())) {
		$success = true;
	}
}

//if (!$success) {
//	$filehandler->setFilename("hjfile/" . $entity->guid . $size . ".jpg"); // hack for older version of hypeframework (<1.9)
//	if ($filehandler->open("read")) {
//		if ($contents = $filehandler->read($filehandler->size())) {
//			$success = true;
//		}
//	}
//}


access_show_hidden_entities($ha);

header("Content-type: image/jpeg");
header('Expires: ' . date('r', time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));
echo $contents;
