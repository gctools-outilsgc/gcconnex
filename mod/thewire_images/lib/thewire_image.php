<?php
/**
 * Procedural code for The Wire Image
 */

/**
 * Returns attachments for $post_guid
 *
 * @param int $post_guid The GUID of The Wire post to get image for.
 * @return TheWireImage|false
 */
function thewire_image_get_attachments($post_guid) {
	$post_guid = sanitise_int($post_guid);
	if (!$post_guid) {
		return false;
	}

	$attachments = elgg_get_entities_from_relationship(array(
		'relationship' => 'is_attachment',
		'relationship_guid' => $post_guid,
		'inverse_relationship' => true,
		'limit' => 1
	));

	if ($attachments) {
		return $attachments[0];
	}

	return false;
}