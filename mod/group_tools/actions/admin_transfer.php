<?php

	$group_guid = (int) get_input("group_guid", 0);
	$owner_guid = (int) get_input("owner_guid", 0);
	
	$loggedin_user = elgg_get_logged_in_user_entity();
	$forward_url = REFERER;
	
	if(!empty($group_guid) && !empty($owner_guid)){
		if(($group = get_entity($group_guid)) && ($group instanceof ElggGroup) && ($new_owner = get_user($owner_guid))){
			if(($group->getOwnerGUID() == $loggedin_user->getGUID()) || $loggedin_user->isAdmin()){
				if($group->getOwnerGUID() != $new_owner->getGUID()){
					// register plugin hook to make sure transfer can complete
					elgg_register_plugin_hook_handler("permissions_check", "group", "group_tools_admin_transfer_permissions_hook");
					
					$old_owner = $group->getOwnerEntity();
					
					// transfer ownership
					$group->owner_guid = $new_owner->getGUID();
					$group->container_guid = $new_owner->getGUID();
					
					// make sure user is added to the group
					$group->join($new_owner);
									
					if($group->save()){
						$forward_url = $group->getURL();
						
						// remove existing group administrator role for new owner
						remove_entity_relationship($new_owner->getGUID(), "group_admin", $group->getGUID());
						
						// check for group icon
						if(!empty($group->icontime)){
							$prefix = "groups/" . $group->getGUID();
							
							$sizes = array("tiny", "small", "medium", "large");
							
							$ofh = new ElggFile();
							$ofh->owner_guid = $old_owner->getGUID();
							
							$nfh = new ElggFile();
							$nfh->owner_guid = $group->getOwnerGUID();
							
							foreach($sizes as $size){
								// set correct file to handle
								$ofh->setFilename($prefix . $size . ".jpg");
								$nfh->setFilename($prefix . $size . ".jpg");
								
								// open files
								$ofh->open("read");
								$nfh->open("write");
								
								// copy file
								$nfh->write($ofh->grabFile());
								
								// close file
								$ofh->close();
								$nfh->close();
								
								// cleanup old file
								$ofh->delete();
							}
							
							$group->icontime = time();
						}
						
						// move metadata of the group to the new owner
						$options = array(
							"guid" => $group->getGUID(),
							"limit" => false
						);
						if($metadata = elgg_get_metadata($options)){
							foreach($metadata as $md){
								if($md->owner_guid == $old_owner->getGUID()){
									$md->owner_guid = $new_owner->getGUID();
									$md->save();
								}
							}
						}
						
						// notify new owner
						if($new_owner->getGUID() != $loggedin_user->getGUID()){
							$subject = elgg_echo("group_tools:notify:transfer:subject", array($group->name));
							$message = elgg_echo("group_tools:notify:transfer:message", array(
											$new_owner->name,
											$loggedin_user->name,
											$group->name,
											$group->getURL()));
							
							notify_user($new_owner->getGUID(), $group->getGUID(), $subject, $message);
						}
						
						// success message
						system_message(elgg_echo("group_tools:action:admin_transfer:success", array($new_owner->name)));
					} else {
						register_error(elgg_echo("group_tools:action:admin_transfer:error:save"));
					}
					
					// unregister plugin hook for permissions
					elgg_unregister_plugin_hook_handler("permissions_check", "group", "group_tools_admin_transfer_permissions_hook");
				} else {
					register_error(elgg_echo("group_tools:action:admin_transfer:error:self"));
				}
			} else {
				register_error(elgg_echo("group_tools:action:admin_transfer:error:access"));
			}
		} else {
			register_error(elgg_echo("group_tools:action:error:entities"));
		}
	} else {
		register_error(elgg_echo("group_tools:action:error:input"));
	}

	forward($forward_url);
	