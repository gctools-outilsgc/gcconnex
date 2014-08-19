<?php 

	$invitecode = get_input("invitecode");
	
	$user = elgg_get_logged_in_user_entity();
	$forward_url = REFERER;
	
	if(!empty($invitecode)){
		$forward_url = elgg_get_site_url() . "groups/invitations/" . $user->username;
		
		if($group = group_tools_check_group_email_invitation($invitecode)){
			if(groups_join_group($group, $user)){
				$options = array(
					"guid" => $group->getGUID(),
					"annotation_name" => "email_invitation",
					"annotation_value" => $invitecode,
					"annotation_owner_guid" => $group->getGUID(),
					"limit" => 1
				);
				
				if($annotations = elgg_get_annotations($options)){
					$annotations[0]->delete();
				}
				
				$forward_url = $group->getURL();
				system_message(elgg_echo("group_tools:action:groups:email_invitation:success"));
			} else {
				register_error(elgg_echo("group_tools:action:groups:email_invitation:error:join", array($group->name)));
			}
		} else {
			register_error(elgg_echo("group_tools:action:groups:email_invitation:error:code"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:groups:email_invitation:error:input"));
	}

	forward($forward_url);
