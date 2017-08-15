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
	
	if (!elgg_in_context('widget_access')) {
		return $return_value;
	}
	
	$widget = elgg_extract('entity', $params['input_params']);
	if ($widget instanceof ElggWidget) {
		$widget_context = $widget->context;
		
		if ($widget_context == 'groups') {
			$group = $widget->getContainerEntity();
			if (!empty($group->group_acl)) {
				$return_value = [
					$group->group_acl => elgg_echo('groups:group') . ': ' . $group->name,
					ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
					ACCESS_PUBLIC => elgg_echo('PUBLIC')
				];
			}
		} elseif ($widget->getContainerGUID() === elgg_get_site_entity()->getGUID()) {
			// admins only have the following options for index widgets
			if (elgg_is_admin_logged_in()) {
				$return_value = [
					ACCESS_PRIVATE => elgg_echo('access:admin_only'),
					ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
					ACCESS_LOGGED_OUT => elgg_echo('LOGGED_OUT'),
					ACCESS_PUBLIC => elgg_echo('PUBLIC')
				];
			} elseif(elgg_can_edit_widget_layout($widget_context)) {
				// for non admins that can manage this widget context
				$return_value = [
					ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
					ACCESS_PUBLIC => elgg_echo('PUBLIC')
				];
			}
		}
	} elseif (elgg_in_context('index') && elgg_is_admin_logged_in()) {
		// admins only have the following options for index widgets
		$return_value = [
			ACCESS_PRIVATE => elgg_echo('access:admin_only'),
			ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
			ACCESS_LOGGED_OUT => elgg_echo('LOGGED_OUT'),
			ACCESS_PUBLIC => elgg_echo('PUBLIC')
		];
		
	} elseif (elgg_in_context('groups')) {
		$group = elgg_get_page_owner_entity();
		if (!empty($group->group_acl)) {
			$return_value = [
				$group->group_acl => elgg_echo('groups:group') . ': ' . $group->name,
				ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'),
				ACCESS_PUBLIC => elgg_echo('PUBLIC')
			];
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
			$result = [$result];
		} elseif (empty($result)) {
			$result = [];
		}
			
		if (is_array($result)) {
			$result[] = ACCESS_LOGGED_OUT;
		}
	}

	return $result;
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
	$page_owner = elgg_extract('page_owner', $params);
	$user = elgg_extract('user', $params);
	$context = elgg_extract('context', $params);
			
	if (!$return_value && ($user instanceof ElggUser)) {
		if (($page_owner instanceof ElggGroup) && $page_owner->canEdit($user->getGUID())) {
			// group widget layout
			$return_value = true;
		} elseif (!in_array($context, ['index', 'dashboard', 'profile', 'groups'])) {
			// extra widget contexts
			$contexts_config = json_decode(elgg_get_plugin_setting('extra_contexts_config', 'widget_manager'), true);
			if (!is_array($contexts_config)) {
				$contexts_config = array();
			}
			$context_config = elgg_extract($context, $contexts_config, []);
			$context_managers = string_to_tag_array(elgg_extract('manager', $context_config, ''));
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
	$widget = elgg_extract('entity', $params);
	if (!elgg_instanceof($widget, 'object', 'widget')) {
		return $result;
	}
	
	if (!empty($result)) {
		return $result;
	}
	
	$owner = $widget->getOwnerEntity();
	switch ($widget->handler) {
		case 'friends':
			$result = "/friends/{$owner->username}";
			break;
		case 'messageboard':
			$result = "/messageboard/{$owner->username}";
			break;
		case 'river_widget':
			$result = '/activity';
			break;
		case 'bookmarks':
			if ($owner instanceof ElggGroup) {
				$result = "/bookmarks/group/{$owner->getGUID()}/all";
			} else {
				$result = "/bookmarks/owner/{$owner->username}";
			}
			break;
	}

	return $result;
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
	$plugin_id = get_input('plugin_id');
	
	if ($plugin_id !== 'widget_manager') {
		return;
	}
	
	$contexts = get_input('contexts', []);
	$extra_contexts = [];
	$extra_contexts_config = [];
	
	foreach ($contexts['page'] as $key => $page) {
		$page = trim($page);
		
		if (empty($page)) {
			continue;
		}
		
		$extra_contexts[] = $page;
		$extra_contexts_config[$page]['layout'] = $contexts['layout'][$key];
		$extra_contexts_config[$page]['top_row'] = $contexts['top_row'][$key];
		$extra_contexts_config[$page]['manager'] = $contexts['manager'][$key];
	}
	
	$extra_contexts = implode(',', $extra_contexts);
	
	$extra_contexts_config = json_encode($extra_contexts_config);
				
	elgg_set_plugin_setting('extra_contexts', $extra_contexts, 'widget_manager');
	elgg_set_plugin_setting('extra_contexts_config', $extra_contexts_config, 'widget_manager');
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
	if ($entity_type == 'widgets/move') {
		$widget_guid = (int) get_input('widget_guid');
		if (empty($widget_guid)) {
			return;
		}

		$widget = get_entity($widget_guid);
		if (!elgg_instanceof($widget, 'object', 'widget')) {
			return;
		}
		
		$widget_context = $widget->context;
		
		$index_widgets = elgg_get_widget_types('index');
		
		foreach ($index_widgets as $handler => $index_widget) {
			$contexts = $index_widget->context;
			$contexts[] = $widget_context;
			elgg_register_widget_type($handler, $index_widget->name, $index_widget->description, $contexts, $index_widget->multiple);
		}
	} elseif ($entity_type == 'widgets/add') {
		elgg_register_plugin_hook_handler('permissions_check', 'site', 'widget_manager_permissions_check_site_hook_handler');
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
	$user = elgg_extract('user', $params);
	
	if ($return_value || !$user) {
		return $return_value;
	}
	
	$context = get_input('context');
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
	$user = elgg_extract('user', $params);
	$entity = elgg_extract('entity', $params);
	
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
