<?php
/**
 * ideas group sidebar
 */
$page_owner = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_guid();

if ($page_owner->canWriteToContainer($user)) {
    echo elgg_view('ideas/sidebar-ideas');

	/* echo elgg_view('ideas/sidebar-points'); */
	/*
	$body = elgg_view('ideas/sidebar-idea');
	echo elgg_view_module('aside', '', $body);
	*/
	
	/*
	echo elgg_view('page/elements/tagcloud_block', array(
		'subtypes' => array('idea')
	));
    */
}