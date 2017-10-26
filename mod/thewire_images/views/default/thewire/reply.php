<?php
/**
 * Reply header
 */

elgg_load_library('thewire_image');

$post = $vars['post'];
$poster = $post->getOwnerEntity();
$poster_details = array(
	htmlspecialchars($poster->name,  ENT_QUOTES, 'UTF-8'),
	htmlspecialchars($poster->username,  ENT_QUOTES, 'UTF-8'),
);

echo "<strong>" . elgg_echo('thewire:replying', $poster_details) . "</strong>";

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

if( $post->description != "" ){
	echo "<blockquote>" . $post->description . "</blockquote>";
}