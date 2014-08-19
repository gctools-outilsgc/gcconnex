<?php 

	admin_gatekeeper();
	
	$code = get_input("code");
	if(!empty($code)){
		if($custom_languages = elgg_get_plugin_setting("custom_languages", "translation_editor")){
			$custom_languages = explode(",", $custom_languages);
			$custom_languages[] = $code;
			
			$code = implode(",", array_unique($custom_languages));
			
		} 
		
		elgg_set_plugin_setting("custom_languages", $code, "translation_editor");
		system_message(elgg_echo("translation_editor:action:add_language:success"));
	}
	
	forward(REFERER);