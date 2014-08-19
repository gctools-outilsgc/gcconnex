<?php 

	function widget_manager_get_widget_setting($widget_handler, $setting, $context = null){
		$result = false;
		
		if(is_null($context)){
			$context = elgg_get_context();
		}
		
		static $widget_settings;
		if(!isset($widget_settings)){
			$widget_settings = array();
		}
		if(!isset($widget_settings[$context])){
			$widget_settings[$context] = array();
		}
		if(!isset($widget_settings[$context][$widget_handler])){
			$widget_settings[$context][$widget_handler] = array();
		}
		
		if(isset($widget_settings[$context][$widget_handler][$setting])){
			return $widget_settings[$context][$widget_handler][$setting];
		}
		
		if(!empty($widget_handler) && !empty($setting)){
			if($plugin_setting = elgg_get_plugin_setting($context . "_" . $widget_handler . "_" . $setting, "widget_manager")){
				if($plugin_setting == "yes"){
					$result = true;
				}
			} elseif($setting == "can_add" || $setting == "can_remove"){
				$result = true;
			}
			
			$widget_settings[$context][$widget_handler][$setting] = $result;
		}
		
		return $result;
	}
	
	function widget_manager_set_widget_setting($widget_handler, $setting, $context, $value){
		$result = false;
		
		if(!empty($widget_handler) && !empty($setting)){
			$widget_setting = $context . "_" . $widget_handler . "_" . $setting;
			
			if(elgg_set_plugin_setting($widget_setting, $value, "widget_manager")){
				$result = true;
			}
		}
		
		return $result;
	}
	
	/* sorts a given array of widgets alphabetically based on the widget name */
	function widget_manager_sort_widgets(&$widgets){
		if(!empty($widgets)){
			foreach($widgets as $key => $row){
				$name[$key] = $row->name; 
			}
			$name = array_map('strtolower', $name); 
			
			array_multisort($name, SORT_STRING, $widgets);
		}
	}

	/* returns a given array of widgets with the guids as key*/
	function widget_manager_sort_widgets_guid(&$widgets){
		if(!empty($widgets)){
			$new_widgets = array();
			
			foreach($widgets as $row){
				$new_widgets[$row->guid] = $row; 
			}
			
			$widgets = $new_widgets;
		}
	}
	
	function widget_manager_set_configured_widgets($context, $column, $value){
		$result = false;
		
		if(!empty($context) && !empty($column)){
			if(elgg_set_plugin_setting($context . "_" . $column, $value, "widget_manager")){
				$result = true;
			}
		}
		
		return $result;
	}
	
	/* handles widget title urls */
	function widget_manager_widget_url_handler($widget){
		$result = false;
		
		if($widget instanceof ElggWidget){
			/* plugins should use the following hook for setting the correct widget title */
			$result = elgg_trigger_plugin_hook("widget_url", "widget_manager", array("entity" => $widget), false);
			
			if(empty($result)){
				$handler = $widget->handler;
				
				$widgettypes = elgg_get_config("widgets");
				if(isset($widgettypes->handlers[$handler]->link)) {
					$link = $widgettypes->handlers[$handler]->link;
				}
				
				if (!empty($link)) {
					/* this substitution loop will be deprecated in a future version */
					
					$owner = $widget->getOwnerEntity();
					if($owner instanceof ElggSite){
						if(elgg_is_logged_in()){
							// index widgets sometimes use usernames in widget titles
							$owner = elgg_get_logged_in_user_entity();
						}
					}
					/* Let's do some basic substitutions to the link */
					 	
					/* [USERNAME] */
					$link = preg_replace('#\[USERNAME\]#', $owner->username, $link);
						
					/* [GUID] */
					$link = preg_replace('#\[GUID\]#', $owner->getGUID(), $link);
						
					/* [BASEURL] */
					$link = preg_replace('#\[BASEURL\]#', elgg_get_site_url(), $link);
				
					$result = $link;
				}
			}
		}
			
		return $result;
	}
	
	/* load widget manager widgets */
	function widget_manager_load_widgets(){
		$widgets_folder = elgg_get_plugins_path() . "widget_manager/widgets";
		$widgets_folder_contents = scandir($widgets_folder);
		 
		foreach($widgets_folder_contents as $widget){
			if(is_dir($widgets_folder . "/" . $widget) && $widget !== "." && $widget !== ".."){
				if(file_exists($widgets_folder . "/" . $widget . "/start.php")){
					$widget_folder = $widgets_folder . "/" . $widget; 
					
					// include start.php
 					include($widget_folder . "/start.php");
				} else {
 					elgg_log(elgg_echo("widgetmanager:load_widgets:missing_start"), "WARNING");
 				}	
			}
		}
	}
	
	/* 
	 * Updates the fixed widgets for a given context and user
	 */
	function widget_manager_update_fixed_widgets($context, $user_guid){
		// need to be able to access everything
		$old_ia = elgg_set_ignore_access(true);
		elgg_push_context('create_default_widgets');
		
		$options = array(
				'type' => 'object',
				'subtype' => 'widget',
				'owner_guid' => elgg_get_site_entity()->guid,
				'private_setting_name_value_pairs' => array(
					'context' => $context,
					'fixed' => 1
					),
				'limit' => false
			);
		
		// see if there are configured fixed widgets
		$configured_fixed_widgets = elgg_get_entities_from_private_settings($options);
		widget_manager_sort_widgets_guid($configured_fixed_widgets);
		
		// fetch all currently configured widgets fixed AND not fixed
		$options["private_setting_name_value_pairs"] = array('context' => $context);
		$options["owner_guid"] = $user_guid;
		
		$user_widgets = elgg_get_entities_from_private_settings($options);
		widget_manager_sort_widgets_guid($user_widgets);
		
		$default_widget_guids = array();
		
		// update current widgets
		if($user_widgets){
			foreach($user_widgets as $guid => $widget){
				$widget_fixed = $widget->fixed;
				$default_widget_guid = $widget->fixed_parent_guid;
				$default_widget_guids[] = $default_widget_guid;
				
				if(!empty($default_widget_guid)){
					if($widget_fixed && !array_key_exists($default_widget_guid, $configured_fixed_widgets)){
						// remove fixed status
						$widget->fixed = false;
					} elseif(!$widget_fixed && array_key_exists($default_widget_guid, $configured_fixed_widgets)) {
						// add fixed status
						$widget->fixed = true;					
					}
					
					// need to recheck the fixed status as it could have been changed
					if($widget->fixed && array_key_exists($default_widget_guid, $configured_fixed_widgets)){
						// update settings for currently configured widgets
						
						// pull in settings
						$settings = get_all_private_settings($configured_fixed_widgets[$default_widget_guid]->guid);
						foreach ($settings as $name => $value) {
							$widget->$name = $value;
						}
						
						// access is no setting, but could also be controlled from the default widget
						$widget->access = $configured_fixed_widgets[$default_widget_guid]->access;
						
						// save the widget (needed for access update)
						$widget->save();
					}
				}
			}
		}
		
		// add new fixed widgets
		if($configured_fixed_widgets){
			foreach($configured_fixed_widgets as $guid => $widget){
				if(!in_array($guid, $default_widget_guids)){
					// if no widget is found which is already linked to this default widget, clone the widget to the user
					$new_widget = clone $widget;
					$new_widget->container_guid = $user_guid;
					$new_widget->owner_guid = $user_guid;
					
					// pull in settings
					$settings = get_all_private_settings($guid);
					
					foreach ($settings as $name => $value) {
						$new_widget->$name = $value;
					}
					
					$new_widget->save();
				}
			}
		}
		
		// fixing order on all columns for this context, fixed widgets should always stay on top of other 'free' widgets
		foreach(array(1,2,3) as $column){
			// reuse previous declared options with a minor adjustment
			$options["private_setting_name_value_pairs"] = array(
				'context' => $context,
				'column' => $column
			);
			
			$column_widgets = elgg_get_entities_from_private_settings($options);
			
			$free_widgets = array();
			$max_fixed_order = 0;
			
			if($column_widgets){
				foreach($column_widgets as $widget){
					if($widget->fixed){
						if($widget->order > $max_fixed_order){
							$max_fixed_order = $widget->order;
						}
					} else {
						$free_widgets[] = $widget; 
					}
				}
				if(!empty($max_fixed_order) && !empty($free_widgets)){
					foreach($free_widgets as $widget){
						$widget->order += $max_fixed_order;
					}
				}
			}
		}
		
		// revert access
		elgg_set_ignore_access($old_ia);
		elgg_pop_context();
		
		// set the user timestamp
		elgg_set_plugin_user_setting($context . "_fixed_ts", time(), $user_guid, "widget_manager");
	}
	
	function widget_manager_multi_dashboard_enabled(){
		static $result;
		
		if(!isset($result)){
			$result = false;
			
			if(elgg_is_active_plugin("dashboard") && (elgg_get_plugin_setting("multi_dashboard_enabled", "widget_manager") == "yes")){
				$result = true;
			}
		}
		
		return $result;
	}

	/*
	 * This function replaces default Elgg function elgg_widgets
	 * Default dashboard tab widgets have no relationship with a custom dashboard
	 */
	function widget_manager_get_widgets($user_guid, $context) {
		global $CONFIG;
		
		$options = array(
			'type' => 'object',
			'subtype' => 'widget',
			'owner_guid' => $user_guid,
			'private_setting_name' => 'context',
			'private_setting_value' => $context,
			'wheres' => array(
						"NOT EXISTS (
							SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r
							WHERE r.guid_one = e.guid
								AND r.relationship = '" . MultiDashboard::WIDGET_RELATIONSHIP . "')"
					),
			'limit' => 0
		);
		
		$widgets = elgg_get_entities_from_private_settings($options);
		if (!$widgets) {
			return array();
		}
	
		$sorted_widgets = array();
		foreach ($widgets as $widget) {
			if (!isset($sorted_widgets[(int)$widget->column])) {
				$sorted_widgets[(int)$widget->column] = array();
			}
			$sorted_widgets[(int)$widget->column][$widget->order] = $widget;
		}
	
		foreach ($sorted_widgets as $col => $widgets) {
			ksort($sorted_widgets[$col]);
		}
	
		return $sorted_widgets;
	}