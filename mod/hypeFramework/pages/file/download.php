<?php
$file_guid = (int)get_input("guid");
$file = get_entity($file_guid);

if (!$file || !$file instanceof ElggFile) {
    exit;
}

$mime = $file->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}
$filename = $file->originalfilename;

header("Pragma: public");
header("Content-type: $mime");
header("Content-Disposition: attachment; filename=\"$filename\"");

ob_clean();
flush();
readfile($file->getFilenameOnFilestore());
exit;