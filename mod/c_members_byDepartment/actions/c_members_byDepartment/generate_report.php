<?php

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;
$dbprefix = elgg_get_config("dbprefix");


if (file_exists($data_directory.'department_directory.json')) {
	$information_array = json_decode(file_get_contents($data_directory.'department_directory.json'));
	$information_array = get_object_vars($information_array);
	$last_guid_onFile = $information_array['members'];
} else {
	$last_guid_onFile = 0;
}

$last_guid_db = elgg_get_entities(array('types' => 'user', 'limit' => '1'));

if ($last_guid_db[0]->getGUID() != $last_guid_onFile) {

	if ($last_guid_onFile != 0) {
		// backup the files then remove
		rename($data_directory.'department_directory.json',$data_directory.'department_directory_'.date("Y-m-d-h-i-s").'.json');
		unlink($data_directory.'department_listing.json');
	}
	// create the files
	$result = create_files($data_directory);
}

forward(REFERER);