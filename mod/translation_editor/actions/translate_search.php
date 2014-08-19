<?php 
	global $CONFIG;
	
	//action_gatekeeper();
	gatekeeper();
	
	// Fixes for KSES filtering
	// fix to allow javascript in href
	$CONFIG->allowedprotocols[] = "javascript";
	
	// fix allowed tags
	$CONFIG->allowedtags["a"]["onclick"] = array();
	$CONFIG->allowedtags["span"]["id"] = array();
	
	// get inputs
	$current_language = get_input("current_language");
	$translation = get_input("translation");
	$jquery = get_input("jquery", false);
	
	// Preparing jQuery result
	$json_result = array();
	$json_result["result"] = false;
	
	if(translation_editor_is_translation_editor()){
		$trans = get_installed_translations();
		
		if(!empty($current_language) && !empty($translation) && array_key_exists($current_language, $trans)){
			foreach($translation as $plugin => $translate_input){
				// merge with existing custom translations
				if($custom_translation = translation_editor_read_translation($current_language, $plugin)){
					$translate_input = array_merge($custom_translation, $translate_input);
				}
				
				$translated = translation_editor_compare_translations($current_language, $translate_input);
				
				if(!empty($translated)){
					if(translation_editor_write_translation($current_language, $plugin, $translated)){
						if(!$jquery){
							system_message(elgg_echo("translation_editor:action:translate:success"));
						} else {
							$json_result["result"] = true;
						}
					} else {
						if(!$jquery){
							register_error(elgg_echo("translation_editor:action:translate:error:write"));
						}
					}
				} else {
					translation_editor_delete_translation($current_language, $plugin);
					if(!$jquery){
						system_message(elgg_echo("translation_editor:action:translate:no_changed_values"));
					} else {
						$json_result["result"] = true;
					}
				}
			}
			
			// merge translations
			translation_editor_merge_translations($current_language, true);
		} else {
			if(!$jquery){
				register_error(elgg_echo("translation_editor:action:translate:error:input"));
			}
		}
	} else {
		if(!$jquery){
			register_error(elgg_echo("translation_editor:action:translate:error:not_authorized"));
		}
	}
	
	if(!$jquery){
		forward(REFERER);
	} else {
		// Send JSON data
		$json_string = json_encode($json_result);
		
		header("Content-Type: application/json; charset=UTF-8");
		header("Content-Length: " . strlen($json_string));
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		
		echo $json_string;
		exit();
	}
