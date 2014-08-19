<?php 

	gatekeeper();
	
	$group_guid = (int) get_input("group_guid", 0);

	if(($group = get_entity($group_guid)) && ($group instanceof ElggGroup) && ($group->canEdit())){
		// set page owner
		elgg_set_page_owner_guid($group->getGUID());
		elgg_set_context("groups");
		
		// set breadcrumb
		elgg_push_breadcrumb(elgg_echo("groups"), "groups/all");
		elgg_push_breadcrumb($group->name, $group->getURL());
		elgg_push_breadcrumb(elgg_echo("group_tools:menu:mail"));
		
		// get members
		$members = $group->getMembers(false);
		
		// build page elements
		$title_text = elgg_echo("group_tools:mail:title");
		$title = elgg_view_title($title_text);
		
		$form = elgg_view("group_tools/forms/mail", array("entity" => $group, "members" => $members));
		
		$body = elgg_view_layout("content", array(
			"entity" => $group,
			"title" => $title_text,
			"content" => $form,
			"filter" => false
		));
		echo elgg_view_page($title_text, $body);
	} else {
		forward(REFERER);
	}
	