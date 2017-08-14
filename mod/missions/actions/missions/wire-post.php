<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
//Nick - Replaced the old action with the wire reshare action from wire_tools

$body = get_input("body", "", false);

$access_id = (int) get_input("access_id", ACCESS_PUBLIC);
$method = "site";
$parent_guid = (int) get_input("parent_guid");
$reshare_guid = (int) get_input("reshare_guid");

// make sure the post isn't blank
if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}

$guid = thewire_tools_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method, $reshare_guid);
if (!$guid) {
	register_error(elgg_echo("thewire:error"));
	forward(REFERER);
}

// if reply, forward to thread display page
if ($parent_guid) {
	$parent = get_entity($parent_guid);
	forward("thewire/thread/$parent->wire_thread");
}

// cyu - send notifications when a user shares your content on the wire
if ($reshare_guid || $reshare_guid > 0) {
	$content_owner = get_entity($reshare_guid)->getOwnerEntity();
	$entity = get_entity($reshare_guid);
	$wire_entity = get_entity($guid);

	if ($entity->getType() == 'group'){
		$entity->title = $entity->name;
	}

	// cyu - if cp notification plugin is active, use that for notifications
	if (elgg_is_active_plugin('cp_notifications')) {
		$message = array(
			'cp_msg_type' => 'cp_wire_share',
			'cp_recipient' => $entity->getOwnerEntity(),
			'cp_shared_by' => elgg_get_logged_in_user_entity(),
			'cp_content' => $entity,
			'cp_content_reshared' => $entity,
			'cp_wire_url' => $wire_entity->getURL(),
		);
		elgg_trigger_plugin_hook('cp_overwrite_notification','all',$message);
	}
}

//Take them back to the missions screen
system_message(elgg_echo('missions:posted_to_the_wire'));
forward(elgg_get_site_url() . 'missions/main');