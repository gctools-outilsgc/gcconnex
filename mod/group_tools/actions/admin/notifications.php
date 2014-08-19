<?php
	
	global $NOTIFICATION_HANDLERS;

	$toggle = get_input("toggle");
	$guid = (int) get_input("guid");
	
	$forward_url = REFERER;
	
	if(!empty($guid) && !empty($toggle)){
		if(($group = get_entity($guid)) && elgg_instanceof($group, "group")){
			// get group members
			if($members = $group->getMembers(false)){
				if($toggle == "enable"){
					// fix notifications settings for site amd email
					$auto_notification_handlers = array(
						"site",
						"email"
					);
					
					// enable notification for everyone
					foreach($members as $member){
						foreach($NOTIFICATION_HANDLERS as $method => $dummy){
							if(in_array($method, $auto_notification_handlers)){
								add_entity_relationship($member->getGUID(), "notify" . $method, $group->getGUID());
							}
						}
					}
					
					system_message(elgg_echo("group_tools:action:notifications:success:enable"));
					$forward_url = $group->getURL();
				} elseif($toggle == "disable"){
					// disable notification for everyone
					foreach($members as $member){
						foreach($NOTIFICATION_HANDLERS as $method => $dummy){
							remove_entity_relationship($member->getGUID(), "notify" . $method, $group->getGUID());
						}
					}
					
					system_message(elgg_echo("group_tools:action:notifications:success:disable"));
					$forward_url = $group->getURL();
				} else {
					register_error(elgg_echo("group_tools:action:notifications:error:toggle"));
				}
			}
		} else {
			register_error(elgg_echo("group_tools:action:error:entity"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:input"));
	}
	
	forward($forward_url);