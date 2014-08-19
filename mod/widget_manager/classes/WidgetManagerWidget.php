<?php

class WidgetManagerWidget extends ElggWidget {
	protected $settings_cache = array();
	protected $settings_defaults = array(
 		"fixed" => NULL,
		"widget_manager_hide_header" => NULL,
		"widget_manager_show_toggle" => NULL,
		"widget_manager_show_edit" => NULL,
		"widget_manager_custom_title" => NULL,
		"widget_manager_custom_url" => NULL,
		"widget_manager_disable_widget_content_style" => NULL,
		"widget_manager_custom_class" => NULL
	);
	
	protected function load($guid) {
		// Load data from entity table if needed
		if (!parent::load($guid)) {
			return false;
		}
		
		// Only work with GUID from here
		if ($guid instanceof stdClass) {
			$guid = $guid->guid;
		}
		
		$query = "SELECT * from " . elgg_get_config("dbprefix"). "private_settings where entity_guid = {$guid}";
		$result = get_data($query);
		if ($result) {
			foreach ($result as $r) {
				$this->settings_cache[$r->name] = $r->value;
			}
		}
		
		return true;
	}

	public function get($name) {
		if(is_array($this->settings_cache) && array_key_exists($name, $this->settings_cache)){
			$result = $this->settings_cache[$name];
		} elseif (array_key_exists($name, $this->settings_defaults)){
			$result = $this->settings_defaults[$name];
		}
		
		if(!isset($result)){
			$result = parent::get($name);
		}
		// check if it should be an array
		$decoded_result = json_decode($result, true);
		if(is_array($decoded_result)){
			$result = $decoded_result;
		}
		
		return $result;		
	}

	public function set($name, $value){
		if(is_array($value)){
			if(empty($value)){
				$value = null;
			} else {
				$value = json_encode($value);
			}
			
		}
		
		if(parent::set($name, $value)){
			$this->settings_cache[$name] = $value;
		}
	}
	
	public function getTitle(){
		if($custom_title = $this->widget_manager_custom_title){
			return $custom_title;
		} else {
			return parent::getTitle();
		}
	}
	
	public function getURL(){
		if($custom_url = $this->widget_manager_custom_url){
			return $custom_url;
		} else {
			return parent::getURL();
		}
	}
	
	public function canEdit($user_guid = 0){
		$result = parent::canEdit($user_guid);
		
		if($result && ($this->fixed && !elgg_is_admin_logged_in())){
			$result = false;
		}
		return $result;
	}
	
	/* need to take over from ElggWidget to allow saving arrays */
	public function saveSettings($params) {
		if (!$this->canEdit()) {
			return false;
		}
	
		// plugin hook handlers should return true to indicate the settings have
		// been saved so that default code does not run
		$hook_params = array(
				'widget' => $this,
				'params' => $params
		);
		if (elgg_trigger_plugin_hook('widget_settings', $this->handler, $hook_params, false) == true) {
			return true;
		}
	
		if (is_array($params) && count($params) > 0) {
			foreach ($params as $name => $value) {
				$this->$name = $value;
			}
			$this->save();
		}
	
		return true;
	}
}