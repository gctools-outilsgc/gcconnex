<?php 
	
	admin_gatekeeper();
	
	$result = false;
	
	$user = get_input("user");
	$role = "translation_editor";
	
	$user = get_entity($user);
	if($user instanceof ElggUser){
		if(create_metadata($user->guid, $role, true, "integer", $user->guid, ACCESS_PUBLIC)){
			$result = true;	
		}
	}

	if(!$result){
		register_error(elgg_echo("translation_editor:action:make_translation_editor:error"));
	} else {
		system_message(elgg_echo("translation_editor:action:make_translation_editor:success"));
	}
	
	forward(REFERER);