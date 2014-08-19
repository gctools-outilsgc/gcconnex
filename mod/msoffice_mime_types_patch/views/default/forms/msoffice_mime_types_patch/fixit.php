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
$content .= '<p style="margin: 1em 0;">Here is a list of all files and their associated mime types.</p>';
$cnt = 0;
foreach($files as $file){
	$extension = pathinfo($file->originalfilename, PATHINFO_EXTENSION);
	if ($mapping[$extension]) {
		if ($file->getMimeType() != $mapping[$extension]) {
			$content .= '<li style="color: red;">' . $file->originalfilename . ' => ' . $file->getMimeType() . '</li>';
			$cnt += 1;
		}
		else {
			$content .= '<li>' . $file->originalfilename . ' => ' . $file->getMimeType() . '</li>';
		}
	}
	else {
		$content .= '<li>' . $file->originalfilename . ' => ' . $file->getMimeType() . '</li>';
	}
}
$content .= '<br/>';
if ($cnt > 0) {
	$content .= '<p>Files that do not have the correct mime type are listed in red.</p>';
	$content .= elgg_view('input/submit', array('value' => elgg_echo('Fix Incorrect Mime Types')));;
}
else {
	$content .= '<p>Congratulations. You do not have any incorrect mime types.</p>';
}
echo $content;
?>