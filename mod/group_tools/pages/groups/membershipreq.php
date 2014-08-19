<?php
	/**
	 * Manage group invite requests.
	 * 
	 * @package ElggGroups
	 */

	gatekeeper();
	
	$guid = (int) get_input("group_guid");
	
	elgg_set_page_owner_guid($guid);
	
	$group = get_entity($guid);
	
	$title = elgg_echo('groups:membershiprequests');
	
	if ($group && $group->canEdit()) {
		elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");
		elgg_push_breadcrumb($group->name, $group->getURL());
		elgg_push_breadcrumb($title);
	
		// membership requests
		$requests = elgg_get_entities_from_relationship(array(
				'type' => 'user',
				'relationship' => 'membership_request',
				'relationship_guid' => $guid,
				'inverse_relationship' => true,
				'limit' => 0,
		));
		
		// invited users
		$invitations = elgg_get_entities_from_relationship(array(
			"type" => "user",
			"relationship" => "invited", 
			"relationship_guid" => $guid, 
			"limit" => false
		));
		
		$content = elgg_view('groups/membershiprequests', array(
			'requests' => $requests,
			'invitations' => $invitations,
			'entity' => $group,
		));
	
	} else {
		$content = elgg_echo("groups:noaccess");
	}
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);
	
	echo elgg_view_page($title, $body);
