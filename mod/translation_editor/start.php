<?php 

	define("TRANSLATION_EDITOR_DISABLED_LANGUAGE", "disabled_languages");

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/events.php");
	
	function translation_editor_init(){
		global $CONFIG;
		
		elgg_extend_view("css/elgg", "translation_editor/css/site");
		elgg_extend_view("js/elgg", "translation_editor/js/site");
		
		elgg_register_page_handler('translation_editor', 'translation_editor_page_handler');
		
		// add to site menu
		if(translation_editor_is_translation_editor(elgg_get_logged_in_user_guid())){
			$menu_item = new ElggMenuItem("translation_editor", elgg_echo('translation_editor:menu:title'), "translation_editor");
			elgg_register_menu_item("site", $menu_item);
		}
		
		if (elgg_is_admin_logged_in()){
			// Extend context menu with admin links
   			elgg_extend_view('profile/menu/adminlinks','translation_editor/adminlinks');

   			// add to admin menu
   			elgg_register_menu_item('page', array(
				'name' => "translation_editor",
				'href' => "translation_editor",
				'text' => elgg_echo("translation_editor:menu:title"),
				'context' => "admin",
				'parent_name' => "appearance",
				'section' => "configure"
			));
		}
		
		elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'translation_editor_user_hover_menu');
	
	}
	
	function translation_editor_page_handler($page){
		
		switch($page[0]){
			case "search":
				$q = get_input("translation_editor_search");
				if(!empty($q)){
					include(dirname(__FILE__) . "/pages/search.php");
					break;
				}
			default:
				if(!empty($page[0])){
					set_input("current_language", $page[0]);
					if(!empty($page[1])){
						set_input("plugin", $page[1]);
					}
					
					include(dirname(__FILE__) . "/pages/index.php");
				} else {
					$current_language = get_current_language();
					forward("translation_editor/" . $current_language);
				}
				break;
		}
		
		return true;
	}
	
	function translation_editor_plugins_boot_event(){
		global $CONFIG;
		
		run_function_once("translation_editor_version_053");
		
		// add the custom_keys_locations to language paths
		$custom_keys_path = $CONFIG->dataroot . "translation_editor" . DIRECTORY_SEPARATOR . "custom_keys" . DIRECTORY_SEPARATOR;
		if(is_dir($custom_keys_path)){
			$CONFIG->language_paths[$custom_keys_path] = true;
		}   
		
		// force creation of static to prevent reload of unwanted translations
		reload_all_translations(); 
		
		translation_editor_load_custom_languages();
		
		if(elgg_get_context() != "translation_editor"){
			// remove disabled languages
			translation_editor_unregister_translations(); 
		}
		
		// load custom translations
		$user_language = get_current_language();
		$elgg_default_language = "en";
		
		$load_languages = array($user_language, $elgg_default_language);
		$load_languages = array_unique($load_languages);
		
		$disabled_languages = translation_editor_get_disabled_languages();
		
		foreach($load_languages as $language){
			if(empty($disabled_languages) || !in_array($language, $disabled_languages)){
				// add custom translations
				translation_editor_load_translations($language);
			}
		}
	}
	
	function translation_editor_version_053(){
		if($languages = get_installed_translations()){
			foreach($languages as $lang => $name){
				translation_editor_merge_translations($lang);
			}
		}
	}
	
	// Plugin init
	elgg_register_event_handler('plugins_boot', 'system', 'translation_editor_plugins_boot_event', 50); // before normal execution to prevent conflicts with plugins like language_selector
	elgg_register_event_handler('init', 'system', 'translation_editor_init');
	
	// register hooks
	elgg_register_plugin_hook_handler("action", "admin/plugins/activate", "translation_editor_actions_hook");
	elgg_register_plugin_hook_handler("action", "admin/plugins/deactivate", "translation_editor_actions_hook");
	elgg_register_plugin_hook_handler("action", "admin/plugins/activate_all", "translation_editor_actions_hook");
	elgg_register_plugin_hook_handler("action", "admin/plugins/deactivate_all", "translation_editor_actions_hook");
	elgg_register_plugin_hook_handler("action", "admin/plugins/set_priority", "translation_editor_actions_hook");
	
	// register events
	elgg_register_event_handler("upgrade", "system", "translation_editor_upgrade_event");
	
	// Register actions
	elgg_register_action("translation_editor/translate", dirname(__FILE__) . "/actions/translate.php");
	elgg_register_action("translation_editor/translate_search", dirname(__FILE__) . "/actions/translate_search.php");
	elgg_register_action("translation_editor/merge", dirname(__FILE__) . "/actions/merge.php");
	
	// Admin only actions
	elgg_register_action("translation_editor/make_translation_editor", dirname(__FILE__) . "/actions/make_translation_editor.php", "admin");
	elgg_register_action("translation_editor/unmake_translation_editor", dirname(__FILE__) . "/actions/unmake_translation_editor.php", "admin");
	elgg_register_action("translation_editor/delete", dirname(__FILE__) . "/actions/delete.php", "admin");
	elgg_register_action("translation_editor/disable_languages", dirname(__FILE__) . "/actions/disable_languages.php", "admin");
	elgg_register_action("translation_editor/add_language", dirname(__FILE__) . "/actions/add_language.php", "admin");
	elgg_register_action("translation_editor/add_custom_key", dirname(__FILE__) . "/actions/add_custom_key.php", "admin");
	elgg_register_action("translation_editor/delete_language", dirname(__FILE__) . "/actions/delete_language.php", "admin");
	