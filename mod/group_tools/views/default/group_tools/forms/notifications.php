<?php

	if(($user = elgg_get_logged_in_user_entity()) && $user->isAdmin()){
		$group = elgg_extract("entity", $vars);
		
		if(!empty($group) && elgg_instanceof($group, "group")){
			// count members
			if($group instanceof ElggGroup){
				
			}
			$member_count = $group->getMembers(0, 0, true);
			
			// count how manyu members are notified by email
			$notification_options = array(
				"type" => "user",
				"count" => true,
				"relationship" => "notifyemail",
				"relationship_guid" => $group->getGUID(),
				"inverse_relationship" => true
			);
			
			$notification_count = elgg_get_entities_from_relationship($notification_options);
			
			if(elgg_is_active_plugin("messages")){
				// maybe more members are being notified by site
				$notification_options["relationship"] = "notifysite";
				
				if($site_notification_count = elgg_get_entities_from_relationship($notification_options)){
					if($site_notification_count > $notification_count){
						$notification_count = $site_notification_count;
					}
				}
			}
			
			// start building content
			$title = elgg_echo("group_tools:notifications:title");
			
			$content = "<div class='mbm'>" . elgg_echo("group_tools:notifications:description", array($member_count, $notification_count)) . "</div>";
			
			// enable notification for everyone
			if($member_count > $notification_count){
				$content .= elgg_view("output/confirmlink", array(
					"href" => "action/group_tools/notifications?toggle=enable&guid=" . $group->getGUID(),
					"text" => elgg_echo("group_tools:notifications:enable"),
					"class" => "elgg-button elgg-button-submit mrm"));
			}
			
			// disable notification
			if($notification_count > 0){
				$content .= elgg_view("output/confirmlink", array(
					"href" => "action/group_tools/notifications?toggle=disable&guid=" . $group->getGUID(),
					"text" => elgg_echo("group_tools:notifications:disable"),
					"class" => "elgg-button elgg-button-submit"));
			}
			
			// disclaimer about timing
			$content .= "<div class='elgg-quiet mtm'>" . elgg_echo("group_tools:notifications:disclaimer") . "</div>";
			
			// echo content
			echo elgg_view_module("info", $title, $content);
		}
	}