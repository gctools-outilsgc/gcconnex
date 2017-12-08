<?php
/**
 * Download an attachment to a wire plugin
 */

$attachment_guid = get_input('guid');
$attachment = get_entity($attachment_guid);

if (!elgg_instanceof($attachment, 'object', 'thewire_image')) {
	register_error(elgg_echo('thewire_image:invalid_image'));
	forward(REFERER);
}

// make sure we have access to the wire object.
$post = elgg_get_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'relationship' => 'is_attachment',
	'relationship_guid' => $attachment->getGUID(),
	'inverse_relationship' => false
));

if (!$post || !(elgg_instanceof($post[0], 'object', 'thewire'))) {
	register_error(elgg_echo('thewire_image:invalid_image'));
	forward(REFERER);
}

$mime = $attachment->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$filename = $attachment->originalfilename;

// fix for IE https issue
header("Pragma: public");
header("Content-type: $mime");

// show images in the browser
if (strpos($mime, "image/") !== false) {
	header("Content-Disposition: inline; filename=\"$filename\"");
} else {
	header("Content-Disposition: attachment; filename=\"$filename\"");
}

$contents = $attachment->grabFile();
$splitString = str_split($contents, 8192);
foreach ($splitString as $chunk) {
	echo $chunk;
}
