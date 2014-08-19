<?php 

	admin_gatekeeper();
	
	$result = false;
	
	$user = get_input("user");
	$user = get_entity($user);
	
	if($user instanceof ElggUser){
		unset($user->translation_editor);
		$result = true;	
	}

	if(!$result){
		register_error(elgg_echo("translation_editor:action:unmake_translation_editor:error"));
	} else {
		system_message(elgg_echo("translation_editor:action:unmake_translation_editor:success"));
	}
	forward(REFERER);
