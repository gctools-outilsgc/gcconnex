<?php
/**
 * Provide a way of setting your full name.
 *
 * @package Elgg
 * @subpackage Core
 *
 * GC_MODIFICATION
 * Description: Added wet styling and classes / Adding form label
 * Author: GCTools Team
 */

$user = elgg_get_page_owner_entity();
if ($user) {
	$title = elgg_echo('user:name:label');
	$content ='<label for="name">' . elgg_echo('name') . ': </label>';
	$content .= elgg_view('input/text', array(
		'name' => 'name',
        'id' => 'name',
		'value' => $user->name,
	));
	echo elgg_view_module('info', $title, $content);

	// need the user's guid to make sure the correct user gets updated
	// TODO: remove the hidden input in 2.0. See #8001
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
}
