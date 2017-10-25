<?php
/**
 * Views attachments for a wire post
 */

// we want to use the thewire_image_get_attachments() function, so load the library.
elgg_load_library('thewire_image');

$post = elgg_extract('entity', $vars);
if (!elgg_instanceof($post, 'object', 'thewire')) {
	return true;
}

$attachment = thewire_image_get_attachments($post->getGUID());

if ($attachment) {
	echo "<div class='elgg-content mrgn-tp-sm mrgn-lft-sm mrgn-bttm-sm'>";
	echo "<a class='elgg-lightbox' href='" . elgg_get_site_url() . 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename . "'>";
	echo elgg_view('output/img', array(
		'src' => 'thewire_image/download/' . $attachment->getGUID() . '/' . $attachment->original_filename,
		'alt' => $attachment->original_filename,
		'class' => 'img-thumbnail',
		'style' => "height: 120px; width: auto;"
	));
	echo "</a>";
	echo "</div>";
}