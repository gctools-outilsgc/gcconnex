<?php

	// this could take a while ;)
	set_time_limit(0);
	
	$group_guid = (int) get_input("group_guid");
	
	if(!empty($group_guid)){
		if(($group = get_entity($group_guid)) && ($group instanceof ElggGroup)){
			// set counters
			$already = 0;
			$new = 0;
			$failure = 0;
			
			$options = array(
				"type" => "user",
				"relationship" => "member_of_site",
				"relationship_guid" => elgg_get_site_entity()->getGUID(),
				"inverse_relationship" => true,
				"limit" => false,
				"callback" => "group_tools_guid_only_callback"
			);
			
			if($user_guids = elgg_get_entities_from_relationship($options)){
				
				foreach($user_guids as $user_guid){
					if(!is_group_member($group->getGUID(), $user_guid)){
						if(join_group($group->getGUID(), $user_guid)){
							$new++;
						} else {
							$failure++;
						}
					} else {
						$already++;
					}
					
					// cleanup cache, to be sure
					_elgg_invalidate_cache_for_entity($user_guid);
				}
			}
			
			system_message(elgg_echo("group_tools:action:fix_auto_join:success", array($new, $already, $failure)));
		} else {
			register_error(elgg_echo("group_tools:action:error:entity"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:input"));
	}
	
	forward(REFERER);