<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @package Elgg
 * @subpackage Core
 *
 */

elgg_push_context('owner_block');

// groups and other users get owner block 
$owner = elgg_get_page_owner_entity();
if ($owner instanceof ElggGroup ||
	($owner instanceof ElggUser && $owner->getGUID() != elgg_get_logged_in_user_guid())) {
	$body = elgg_view_menu('owner_block', array('entity' => $owner));
	echo elgg_view('page/components/module', array(
		'body' => $body,
		'class' => 'elgg-owner-block',
	));
}
elgg_pop_context();