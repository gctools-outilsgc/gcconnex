<?php

/**
 * Hooks for widget manager
 */

/**
 * Returns a ACL for use in widgets
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_write_access_hook($hook_name, $entity_type, $return_value, $params) {
	
	if (!elgg_in_context("widget_access")) {
		return $return_value;
	}
	$widget = elgg_extract('entity', $params['input_params']);
	if ($widget instanceof ElggWidget) {
		$widget_context = $widget->context;
		if ((elgg_in_context("index") || elgg_can_edit_widget_layout($widget_context)) && elgg_is_admin_logged_in()) {
			// admins only have the following options for index widgets
			$return_value = array(
				ACCESS_PRIVATE => elgg_echo("access:admin_only"),
				ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
				ACCESS_LOGGED_OUT => elgg_echo("LOGGED_OUT"),
				ACCESS_PUBLIC => elgg_echo("PUBLIC")
			);
		} elseif (elgg_can_edit_widget_layout($widget_context)) {
			// for non admins that can manage this widget context
			$return_value = array(
				ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
				ACCESS_PUBLIC => elgg_echo("PUBLIC")
			);
		}
	} elseif (elgg_in_context("index") && elgg_is_admin_logged_in()) {
		// admins only have the following options for index widgets
		$return_value = array(
			ACCESS_PRIVATE => elgg_echo("access:admin_only"),
			ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
			ACCESS_LOGGED_OUT => elgg_echo("LOGGED_OUT"),
			ACCESS_PUBLIC => elgg_echo("PUBLIC")
		);
		
	} elseif (elgg_in_context("groups")) {
		$group = elgg_get_page_owner_entity();
		if (!empty($group->group_acl)) {
			$return_value = array(
				$group->group_acl => elgg_echo("groups:group") . ": " . $group->name,
				ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
				ACCESS_PUBLIC => elgg_echo("PUBLIC")
			);
		}
	}

	return $return_value;
}
	
/**
 * Creates the ability to see content only for logged_out users
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_read_access_hook($hook_name, $entity_type, $return_value, $params) {
	$result = $return_value;

	if (!elgg_is_logged_in() || elgg_is_admin_logged_in()) {
		if (!empty($result) && !is_array($result)) {
			$result = array($result);
		} elseif (empty($result)) {
			$result = array();
		}
			
		if (is_array($result)) {
			$result[] = ACCESS_LOGGED_OUT;
		}
	}

	return $result;
}
	
/**
 * Function that unregisters html validation for admins to be able to save freehtml widgets with special html
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return void
 */
function widget_manager_widgets_save_hook($hook_name, $entity_type, $return_value, $params) {
	if (elgg_is_admin_logged_in() && elgg_get_plugin_setting("disable_free_html_filter", "widget_manager") == "yes") {
		$guid = get_input("guid");
		$widget = get_entity($guid);
		
		if ($widget instanceof ElggWidget) {
			if ($widget->handler == "free_html") {
				$advanced_context = elgg_trigger_plugin_hook("advanced_context", "widget_manager", array("entity" => $widget), array("index"));
				
				if (is_array($advanced_context) && in_array($widget->context, $advanced_context)) {
					elgg_unregister_plugin_hook_handler("validate", "input", "htmlawed_filter_tags");
				}
			}
		}
	}
}
	
/**
 * Hook to take over the index page
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return boolean
 */
function widget_manager_route_index_handler($hook_name, $entity_type, $return_value, $params) {
	
	if (empty($return_value) || !is_array($return_value)) {
		return $return_value;
	}
	
	// identifier will be empty for the index page
	$identifier = elgg_extract("identifier", $return_value);
	if (!empty($identifier)) {
		return $return_value;
	}
	
	$setting = elgg_get_plugin_setting("custom_index", "widget_manager");
	if (empty($setting)) {
		return $return_value;
	}
	
	list($non_loggedin, $loggedin) = explode("|", $setting);
		
	if ((!elgg_is_logged_in() && !empty($non_loggedin)) || (elgg_is_logged_in() && !empty($loggedin)) || (elgg_is_admin_logged_in() && (get_input("override") == true))) {
		elgg_register_page_handler("", "widget_manager_index_page_handler");
	}
}
	
/**
 * Adds an optional fix link to the menu
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_register_widget_menu($hook_name, $entity_type, $return_value, $params) {
	$widget = $params['entity'];
	
	if (elgg_is_admin_logged_in() && elgg_in_context("default_widgets") && in_array($widget->context, array("profile", "dashboard")) && $widget->fixed_parent_guid) {
		$class = "widget-manager-fix";
		if ($widget->fixed) {
			$class .= " fixed";
		}
		
		$params = array(
			'name' => "fix",
			'text' => elgg_view_icon('widget-manager-push-pin'),
			'title' => elgg_echo('widget_manager:widgets:fix'),
			'href' => "#$widget->guid",
			'link_class' => $class
		);
			
		$item = ElggMenuItem::factory($params);
		$return_value[] = $item;
	}

	return $return_value;
}

/**
 * Optionally removes the edit and delete links from the menu
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_prepare_widget_menu($hook_name, $entity_type, $return_value, $params) {
	if (is_array($return_value)) {
		$widget = $params["entity"];
		if ($widget->fixed && !elgg_in_context("default_widgets") && !elgg_is_admin_logged_in()) {
			foreach ($return_value as $section_key => $section) {
				foreach ($section as $item_key => $item) {
					if (in_array($item->getName(), array("delete", "settings"))) {
						unset($return_value[$section_key][$item_key]);
					}
				}
			}
		}
		
		foreach ($return_value as $section_key => $section) {
			foreach ($section as $item_key => $item) {
				if ($item->getName() == "settings") {
					$show_access = elgg_get_config("widget_show_access");
					$item->setHref("ajax/view/widget_manager/widgets/settings?guid=" . $widget->getGUID() . "&show_access=" . $show_access);
					unset($item->rel);
					$item->{"data-colorbox-opts"} = '{"width": 750, "height": 500, "trapFocus": false}';
					$item->addLinkClass("elgg-lightbox");
				}
				
				if ($item->getName() == "collapse") {
					if ($widget->widget_manager_collapse_disable === "yes" && $widget->widget_manager_collapse_state !== "closed") {
						unset($return_value[$section_key][$item_key]);
					} elseif ($widget->widget_manager_collapse_disable !== "yes") {
						$widget_is_collapsed = false;
						$widget_is_open = true;
						
						if (elgg_is_logged_in()) {
							$widget_is_collapsed = widget_manager_check_collapsed_state($widget->guid, "widget_state_collapsed");
							$widget_is_open = widget_manager_check_collapsed_state($widget->guid, "widget_state_open");
						}
												
						if (($widget->widget_manager_collapse_state === "closed" || $widget_is_collapsed) && !$widget_is_open) {
							$item->addLinkClass("elgg-widget-collapsed");
						}
					}
				}
			}
		}
	}
	
	return $return_value;
}

/**
 * Adds an 'add as dashboard tab' menu item to the extras menu
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_register_extras_menu($hook_name, $entity_type, $return_value, $params) {
	if (!elgg_is_logged_in()) {
		// can only add to dashboard if logged in
		return $return_value;
	}
	
	if (elgg_get_viewtype() === "internal_dashboard") {
		// do not show the menu item if already in internal dashboard
		return $return_value;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => MultiDashboard::SUBTYPE,
		"owner_guid" => elgg_get_logged_in_user_guid(),
		"count" => true
	);
	$tab_count = elgg_get_entities($options);
	
	if ($tab_count < MULTI_DASHBOARD_MAX_TABS) {

		$params = array(
			"name" => "multi_dashboard",
			"text" => elgg_view_icon("home"),
			"href" => "multi_dashboard/edit/?internal_url=" . urlencode(current_page_url()),
			"title" => elgg_echo("widget_manager:multi_dashboard:extras"),
			"rel" => "nofollow",
			"id" => "widget-manager-multi_dashboard-extras"
		);
		$item = ElggMenuItem::factory($params);
		
		$return_value[] = $item;
	}
	
	return $return_value;
}

/**
 * Routes the multidashboard pages
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return void
 */
function widget_manager_dashboard_route_handler($hook_name, $entity_type, $return_value, $params) {
	if ($page = elgg_extract("segments", $return_value)) {
		if (!empty($page[0])) {
			if (get_entity($page[0])) {
				set_input("multi_dashboard_guid", $page[0]);
			} else {
				register_error(elgg_echo("changebookmark"));
			}
		}
	}
}

/**
 * Adds special data to widgets that are added on multidashboards
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return void
 */
function widget_manager_widgets_add_action_handler($hook_name, $entity_type, $return_value, $params) {
	$widget_context = get_input("context"); // dashboard_<guid>;
	if ($widget_context) {
		if (stristr($widget_context, "dashboard_") !== false) {
			list($context, $guid) = explode("_", $widget_context);
			
			set_input("context", $context);
			set_input("multi_dashboard_guid", $guid);
		}
	}
}

/**
 * Checks if a user can manage current widget layout
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return boolean
 */
function widget_manager_widget_layout_permissions_check($hook_name, $entity_type, $return_value, $params) {
	$page_owner = elgg_extract("page_owner", $params);
	$user = elgg_extract("user", $params);
	$context = elgg_extract("context", $params);
			
	if (!$return_value && ($user instanceof ElggUser)) {
		if (($page_owner instanceof ElggGroup) && $page_owner->canEdit($user->getGUID())) {
			// group widget layout
			$return_value = true;
		} elseif (!in_array($context, array("index", "dashboard", "profile", "groups"))) {
			// extra widget contexts
			$contexts_config = json_decode(elgg_get_plugin_setting("extra_contexts_config", "widget_manager"), true);
			if (!is_array($contexts_config)) {
				$contexts_config = array();
			}
			$context_config = elgg_extract($context, $contexts_config, array());
			$context_managers = string_to_tag_array(elgg_extract("manager", $context_config, ""));
			if (!empty($context_managers)) {
				foreach ($context_managers as $manager) {
					if ($manager == $user->username) {
						$return_value = true;
						break;
					}
				}
			}
		}
	}
	
	return $return_value;
}
	
/**
 * Fallback widget title urls for non widget manager widgets
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return string
 */
function widget_manager_widgets_url($hook_name, $entity_type, $return_value, $params) {
	$result = $return_value;
	$widget = $params["entity"];
	
	if ($widget instanceof ElggWidget) {
		$deprecated_result = elgg_trigger_plugin_hook("widget_url", "widget_manager", array("entity" => $widget), false);
		if ($deprecated_result) {
			elgg_deprecated_notice("The widget_url hook is deprecated (used for widget '" . $widget->handler . "') and not functional. Use the plugin hook in ElggEntity::getURL()", "1.9");
		}
		
		if (empty($result)) {
			$owner = $widget->getOwnerEntity();
			switch ($widget->handler) {
				case "friends":
					$result = "/friends/" . $owner->username;
					break;
				case "messageboard":
					$result = "/messageboard/" . $owner->username;
					break;
				case "river_widget":
					$result = "/activity";
					break;
				case "bookmarks":
					if ($owner instanceof ElggGroup) {
						$result = "/bookmarks/group/" . $owner->getGUID() . "/all";
					} else {
						$result = "/bookmarks/owner/" . $owner->username;
					}
					break;
			}
		}
	}
	return $result;
}
	
/**
 * Allow for group default widgets
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return string
 */
function widget_manager_group_widgets_default_list($hook_name, $entity_type, $return_value, $params) {
	if (!is_array($return_value)) {
		$return_value = array();
	}

	$return_value[] = array(
		'name' => elgg_echo('groups'),
		'widget_context' => 'groups',
		'widget_columns' => 2,
		'event' => 'create',
		'entity_type' => 'group',
		'entity_subtype' => NULL
	);

	return $return_value;
}
	
/**
 * Add extra widget contexts that have advanced widget options available
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return array
 */
function widget_manager_advanced_context($hook_name, $entity_type, $return_value, $params) {
	if (!is_array($return_value)) {
		$return_value = array();
	}
	
	$setting = strtolower(elgg_get_plugin_setting("extra_contexts", "widget_manager"));
	if ($setting && isset($params["entity"])) {
		$widget = $params["entity"];
		$widget_context = $widget->context;
		
		$contexts = string_to_tag_array($setting);
		if ($contexts) {
			if (in_array($widget_context, $contexts)) {
				$return_value[] = $widget_context;
			}
		}
	}

	return $return_value;
}

/**
 * Register new widget contexts for use on custom widget pages
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return string
 */
function widget_manager_available_widgets_context($hook_name, $entity_type, $return_value, $params) {
	if (!empty($return_value)) {
		$setting = strtolower(elgg_get_plugin_setting("extra_contexts", "widget_manager"));
		if ($setting) {
			$contexts = string_to_tag_array($setting);
			
			if ($contexts && in_array($return_value, $contexts)) {
				$return_value = "index";
			}
		}
	}
	
	return $return_value;
}
	
/**
 * Updates the pluginsettings for the contexts
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return void
 */
function widget_manager_plugins_settings_save_hook_handler($hook_name, $entity_type, $return_value, $params) {
	$plugin_id = get_input("plugin_id");
	
	if ($plugin_id == "widget_manager") {
		$contexts = get_input("contexts", array());
		$extra_contexts = array();
		$extra_contexts_config = array();
		
		foreach ($contexts["page"] as $key => $page) {
			$page = trim($page);
			
			if (!empty($page)) {
				$extra_contexts[] = $page;
				$extra_contexts_config[$page]["layout"] = $contexts["layout"][$key];
				$extra_contexts_config[$page]["top_row"] = $contexts["top_row"][$key];
				$extra_contexts_config[$page]["manager"] = $contexts["manager"][$key];
			}
		}
		$extra_contexts = implode(",", $extra_contexts);
		
		$extra_contexts_config = json_encode($extra_contexts_config);
					
		elgg_set_plugin_setting("extra_contexts", $extra_contexts, "widget_manager");
		elgg_set_plugin_setting("extra_contexts_config", $extra_contexts_config, "widget_manager");
	}
}
	
/**
 * Registers the extra context permissions check hook
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return void
 */
function widget_manager_widgets_action_hook_handler($hook_name, $entity_type, $return_value, $params) {
	if ($entity_type == "widgets/move") {
		$widget_guid = get_input("widget_guid");
		if ($widget_guid) {
			$widget = get_entity($widget_guid);
			if ($widget && ($widget instanceof ElggWidget)) {
				$widget_context = $widget->context;
				
				$index_widgets = elgg_get_widget_types("index");
				
				foreach ($index_widgets as $handler => $index_widget) {
					$contexts = $index_widget->context;
					$contexts[] = $widget_context;
					elgg_register_widget_type($handler, $index_widget->name, $index_widget->description, $contexts, $index_widget->multiple);
				}
			}
		}
	} elseif ($entity_type == "widgets/add") {
		elgg_register_plugin_hook_handler("permissions_check", "site", "widget_manager_permissions_check_site_hook_handler");
	}
}
	
/**
 * Checks if current user can edit a given widget context. Hook gets registered by widget_manager_widgets_action_hook_handler
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return boolean
 */
function widget_manager_permissions_check_site_hook_handler($hook_name, $entity_type, $return_value, $params) {
	$user = elgg_extract("user", $params);
	
	if ($return_value || !$user) {
		return $return_value;
	}
	
	$context = get_input("context");
	if ($context) {
		$return_value = elgg_can_edit_widget_layout($context, $user->getGUID());
	}
	
	return $return_value;
}

/**
 * Checks if current user can edit a widget if it is in a context he/she can manage
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return boolean
 */
function widget_manager_permissions_check_object_hook_handler($hook_name, $entity_type, $return_value, $params) {
	$user = elgg_extract("user", $params);
	$entity = elgg_extract("entity", $params);
	
	if ($return_value || !$user) {
		return $return_value;
	}
	
	if (!($entity instanceof ElggWidget)) {
		return $return_value;
	}
	
	$site = $entity->getOwnerEntity();
	if (!($site instanceof ElggSite)) {
		// special permission is only for widget owned by site
		return $return_value;
	}
	
	$context = $entity->context;
	if ($context) {
		$return_value = elgg_can_edit_widget_layout($context, $user->getGUID());
	}
			
	return $return_value;
}

/**
 * Returns a rss widget specific date_time notation
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param string $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return string
 */
function widget_manager_friendly_time_hook($hook_name, $entity_type, $return_value, $params) {
	if (empty($params['time'])) {
		return $return_value;
	}

	if (!elgg_in_context("rss_date")) {
		return $return_value;
	}
	
	$date_info = getdate($params['time']);

	$date_array = array(
		elgg_echo("date:weekday:" . $date_info["wday"]),
		elgg_echo("date:month:" . str_pad($date_info["mon"], 2, "0", STR_PAD_LEFT), array($date_info["mday"])),
		$date_info["year"]
	);

	return implode(" ", $date_array);
}

/**
 * Listen to the widget settings save of the RSS server widget
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param bool   $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return bool
 */
function widget_manager_rss_server_widget_settings_hook_handler($hook_name, $entity_type, $return_value, $params) {

	if (empty($params) || !is_array($params)) {
		return $return_value;
	}

	$widget = elgg_extract("widget", $params);
	if (empty($widget) || !elgg_instanceof($widget, "object", "widget")) {
		return $return_value;
	}

	if ($widget->handler != "rss_server") {
		return $return_value;
	}

	$cache_file = elgg_get_config("dataroot") . "widgets/rss/" . $widget->getGUID() . ".json";
	if (file_exists($cache_file)) {
		unlink($cache_file);
	}

	return $return_value;
}

/**
 * Returns an array of cacheable widget handlers
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param bool   $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return bool
 */
function widget_manager_cacheable_handlers_hook_handler($hook_name, $entity_type, $return_value, $params) {

	if (!is_array($return_value)) {
		return $return_value;
	}
	
	$return_value[] = 'iframe';
	$return_value[] = 'free_html';
	$return_value[] = 'image_slider';
	$return_value[] = 'twitter_search';

	return $return_value;
}

/**
 * Unsets the cached data for cacheable widgets
 *
 * @param string $hook_name    name of the hook
 * @param string $entity_type  type of the hook
 * @param bool   $return_value current return value
 * @param array  $params       hook parameters
 *
 * @return bool
 */
function widget_manager_all_widget_settings_hook_handler($hook_name, $entity_type, $return_value, $params) {
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}

	$widget = elgg_extract("widget", $params);
	if (empty($widget) || !elgg_instanceof($widget, "object", "widget")) {
		return $return_value;
	}

	if (widget_manager_is_cacheable_widget($widget)) {
		$widget->widget_manager_cached_data = null;
	}
}
