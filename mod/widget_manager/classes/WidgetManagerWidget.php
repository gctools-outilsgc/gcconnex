<?php

/**
 * Extends the feature of default ElggWidgets
 *
 * @package WidgetManager
 */
class WidgetManagerWidget extends ElggWidget {
	protected $settings_cache = array();
	protected $settings_defaults = array(
		"fixed" => NULL,
		"widget_manager_hide_header" => NULL,
		"widget_manager_show_toggle" => NULL,
		"widget_manager_show_edit" => NULL,
		"widget_manager_custom_title" => NULL,
		"widget_manager_custom_url" => NULL,
		"widget_manager_custom_more_title" => NULL,
		"widget_manager_custom_more_url" => NULL,
		"widget_manager_disable_widget_content_style" => NULL,
		"widget_manager_custom_class" => NULL,
		"widget_manager_fixed_height" => NULL,
		"widget_manager_collapse_state" => NULL,
		"widget_manager_collapse_disable" => NULL,
		"widget_manager_cached_data" => NULL
	);

	/**
	 * Loads all settings into a settings cache when a widget gets loaded
	 *
	 * @param int $guid guid of the entity
	 *
	 * @return boolean
	 */
	protected function load($guid) {
		// Load data from entity table if needed
		if (!parent::load($guid)) {
			return false;
		}
		
		// Only work with GUID from here
		if ($guid instanceof stdClass) {
			$guid = $guid->guid;
		}
		
		$query = "SELECT * from " . elgg_get_config("dbprefix") . "private_settings where entity_guid = {$guid}";
		$result = get_data($query);
		if ($result) {
			foreach ($result as $r) {
				$this->settings_cache[$r->name] = $r->value;
			}
		}
		
		return true;
	}

	/**
	 * Tries to get data from settings cache first
	 *
	 * @param string $name name of the setting/metadata
	 *
	 * @return mixed
	 */
	public function __get($name) {
		if (is_array($this->settings_cache) && array_key_exists($name, $this->settings_cache)) {
			$result = $this->settings_cache[$name];
		} elseif (array_key_exists($name, $this->settings_defaults)) {
			return $this->settings_defaults[$name];
		}
		
		if (!isset($result)) {
			$result = parent::__get($name);
		}
		// check if it should be an array
		$decoded_result = json_decode($result, true);
		if (is_array($decoded_result)) {
			$result = $decoded_result;
		}
		return $result;
	}

	/**
	 * Updates setting cache when parent data is set
	 *
	 * @param string $name  setting/metadata being updated
	 * @param mixed  $value new value
	 *
	 * @return void
	 */
	public function __set($name, $value) {
		if (is_array($value)) {
			if (empty($value)) {
				$value = null;
			} else {
				$value = json_encode($value);
			}
		}
		
		parent::__set($name, $value);
		
		$this->settings_cache[$name] = $value;
		
		// If memcache is available then delete this entry from the cache
		static $newentity_cache;
		if ((!$newentity_cache) && (is_memcache_available())) {
			$newentity_cache = new ElggMemcache('new_entity_cache');
		}
		if ($newentity_cache) {
			$newentity_cache->delete($this->getGUID());
		}
	}
	
	/**
	 * Returns title of the widget
	 *
	 * @return string
	 */
	public function getTitle() {
		if ($custom_title = $this->widget_manager_custom_title) {
			return $custom_title;
		} else {
			return parent::getTitle();
		}
	}
	
	/**
	 * Returns url of the widget
	 *
	 * @return string
	 */
	public function getURL() {
		if ($custom_url = $this->widget_manager_custom_url) {
			return $custom_url;
		} else {
			return parent::getURL();
		}
	}
	
	/**
	 * Can someone edit this widget (normal users can not edit fixed widgets)
	 *
	 * @param int $user_guid optional user_guid to check
	 *
	 * @return boolean
	 */
	public function canEdit($user_guid = 0) {
		$result = parent::canEdit($user_guid);
		
		if ($result && ($this->fixed && !elgg_is_admin_logged_in())) {
			$result = false;
		}
		return $result;
	}
	
	/**
	 * need to take over from ElggWidget to allow saving arrays
	 *
	 * @param array $params new settings
	 *
	 * @return boolean
	 */
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
