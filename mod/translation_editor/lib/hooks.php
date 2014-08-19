<?php

	function translation_editor_user_hover_menu($hook, $type, $return, $params) {
		$user = $params['entity'];
	
		if (elgg_is_admin_logged_in() && !($user->isAdmin())){
			// TODO: replace with a single toggle editor action?
			if(translation_editor_is_translation_editor($user->getGUID())){
				$url = "action/translation_editor/unmake_translation_editor?user=" . $user->getGUID();
				$title = elgg_echo("translation_editor:action:unmake_translation_editor");
			} else {
				$url = "action/translation_editor/make_translation_editor?user=" . $user->getGUID();
				$title = elgg_echo("translation_editor:action:make_translation_editor");
			}
				
			$item = new ElggMenuItem('translation_editor', $title, $url);
			$item->setSection('admin');
			$item->setConfirmText(elgg_echo("question:areyousure"));
			$return[] = $item;
	
			return $return;
		}
	}

	function translation_editor_actions_hook($hook, $type, $return, $params){
		$allowed_actions = array(
			"admin/plugins/activate",
			"admin/plugins/deactivate",
			"admin/plugins/activate_all",
			"admin/plugins/deactivate_all",
			"admin/plugins/set_priority",
			"upgrading" // not actualy an action but comes from events.php
		);
		
		if(!empty($type) && in_array($type, $allowed_actions)){
			// make sure we have all translations
			translation_editor_reload_all_translations();
			
			if($languages = get_installed_translations()){
				foreach($languages as $key => $desc){
					remove_private_setting(elgg_get_site_entity()->getGUID(), "te_last_update_" . $key);
				}
			}
		}
	}