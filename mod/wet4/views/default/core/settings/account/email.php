<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 *
  * GC_MODIFICATION
 * Description: Added wet styling and classes / Adding form labels
 * Author: GCTools Team
 */

$user = elgg_get_page_owner_entity();

if ($user) {
	$title = elgg_echo('email:settings');
	$content = '<label for="email">'. elgg_echo('email:address:label') . ': </label>';
	$content .= elgg_view('input/email', array(
		'name' => 'email',
        'id' => 'email',
		'value' => $user->email,
	));
  
	echo elgg_view_module('info', $title, $content);
}
