<?php
$files = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'file',
	'limit' => 0,
));
$mapping = array(
	'docx' => 'application/msword',
	'doc' => 'application/msword',
	'pptx' => 'application/powerpoint',
	'ppt' => 'application/powerpoint',
	'xlsx' => 'application/excel',
	'xls' => 'application/excel',
);
foreach($files as $file){
	$extension = pathinfo($file->originalfilename, PATHINFO_EXTENSION);
	if ($mapping[$extension]) {
		if ($file->getMimeType() != $mapping[$extension]) {
			$file->setMimeType($mapping[$extension]);
		}
	}
}
system_message("MS Office files with incorrect mime types have been fixed.");
forward(REFERER);
?>