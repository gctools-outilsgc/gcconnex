<?php 
	global $CONFIG;
	
	admin_gatekeeper();
	
	$key = get_input("key");
	$translation = get_input("translation");
	
	if(!empty($key) && !empty($translation)){
		if(!is_numeric($key)){
			if(preg_match("/^[a-zA-Z0-9_:]{1,}$/", $key)){
				$exists = false;
				if(array_key_exists($key, $CONFIG->translations["en"])){
					$exists = true;
				}
					
				if(!$exists){
					// save
					
					$custom_translations = array();
					
					if($custom_translations = translation_editor_get_plugin("en", "custom_keys")){
						$custom_translations = $custom_translations["en"];
					}
					
					$custom_translations[$key] = $translation;					
					
					$base_dir = elgg_get_data_path() . "translation_editor" . DIRECTORY_SEPARATOR;
					if(!file_exists($base_dir)){
						mkdir($base_dir);
					}
					
					$location = $base_dir . "custom_keys" . DIRECTORY_SEPARATOR;
					if(!file_exists($location)){
						mkdir($location);
					}
					
					$file_contents = "<?php" . PHP_EOL;
					$file_contents .= '$language = ';
					$file_contents .= var_export($custom_translations, true);
					$file_contents .= ';' . PHP_EOL;
					$file_contents .= 'add_translation("en", $language);'  . PHP_EOL;
					$file_contents .= "?>";
					
					if(file_put_contents($location . "en.php", $file_contents)){
						
						system_message(elgg_echo("translation_editor:action:add_custom_key:success"));
					} else {
						register_error(elgg_echo("translation_editor:action:add_custom_key:file_error"));
					}	
				} else {
					register_error(elgg_echo("translation_editor:action:add_custom_key:exists"));
				}
			} else {
				register_error(elgg_echo("translation_editor:action:add_custom_key:invalid_chars"));
			}
		} else {
			register_error(elgg_echo("translation_editor:action:add_custom_key:key_numeric"));
		}
	} else {
		register_error(elgg_echo("translation_editor:action:add_custom_key:missing_input"));
	}
	
	forward(REFERER);