<?php

namespace ColdTrick\WidgetManager;

class Menus {
	
	/**
	 * Hook to register menu items on the admin pages
	 *
	 * @param string $hook_name    name of the hook
	 * @param string $entity_type  type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       hook parameters
	 *
	 * @return boolean
	 */
	public static function registerAdminPageMenu($hook_name, $entity_type, $return_value, $params) {		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		foreach ($return_value as $menu_item) {
			if ($menu_item->getName() == 'appearance:default_widgets') {
				// move defaultwidgets menu item
				$menu_item->setParentName('widgets');
			}
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'widgets',
			'text' => elgg_echo('admin:widgets'),
			'section' => 'configure',
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'widgets:manage',
			'href' => 'admin/widgets/manage',
			'text' => elgg_echo('admin:widgets:manage'),
			'parent_name' => 'widgets',
			'section' => 'configure',
		]);
		
		if (elgg_get_plugin_setting('custom_index', 'widget_manager') == '1|0') {
			// a special link to manage homepages that are only available if logged out
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'admin:widgets:manage:index',
				'href' => elgg_get_site_url() . '?override=true',
				'text' => elgg_echo('admin:widgets:manage:index'),
				'parent_name' => 'widgets',
				'section' => 'configure',
			]);
		}
		
		return $return_value;
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
	public static function addFixDefaultWidgetMenuItem($hook_name, $entity_type, $return_value, $params) {
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		if (!elgg_in_context('default_widgets')) {
			return;
		}
		
		$widget = elgg_extract('entity', $params);	
		if (!in_array($widget->context, ['profile', 'dashboard'])) {
			return;
		}
		
		if(empty($widget->fixed_parent_guid)) {
			return;
		}
		
		$class = [];
		if ($widget->fixed) {
			$class[] = 'elgg-icon-hover';
		}
			
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'fix',
			'text' => elgg_view_icon('thumb-tack', ['class' => $class]),
			'title' => elgg_echo('widget_manager:widgets:fix'),
			'href' => "#{$widget->guid}",
			'link_class' => 'widget-manager-fix',
		]);
	
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
	public static function prepareWidgetEditDeleteMenuItems($hook_name, $entity_type, $return_value, $params) {
		if (!is_array($return_value)) {
			return;
		}
	
		$widget = elgg_extract('entity', $params);
		if ($widget->fixed && !elgg_in_context('default_widgets') && !elgg_is_admin_logged_in()) {
			foreach ($return_value as $section_key => $section) {
				foreach ($section as $item_key => $item) {
					if (in_array($item->getName(), ['delete', 'settings'])) {
						unset($return_value[$section_key][$item_key]);
					}
				}
			}
		}
	
		foreach ($return_value as $section_key => $section) {
			foreach ($section as $item_key => $item) {
				if ($item->getName() == 'settings') {
					$show_access = elgg_get_config('widget_show_access');
					$item->setHref('ajax/view/widget_manager/widgets/settings?guid=' . $widget->getGUID() . '&show_access=' . $show_access);
					unset($item->rel);
					$item->{"data-colorbox-opts"} = '{"width": 750, "height": 500, "trapFocus": false}';
					$item->addLinkClass('elgg-lightbox');
				}
					
				if ($item->getName() == 'collapse') {
					if ($widget->widget_manager_collapse_disable === 'yes' && $widget->widget_manager_collapse_state !== 'closed') {
						unset($return_value[$section_key][$item_key]);
					} elseif ($widget->widget_manager_collapse_disable !== 'yes') {
						$widget_is_collapsed = false;
						$widget_is_open = true;
							
						if (elgg_is_logged_in()) {
							$widget_is_collapsed = widget_manager_check_collapsed_state($widget->guid, 'widget_state_collapsed');
							$widget_is_open = widget_manager_check_collapsed_state($widget->guid, 'widget_state_open');
						}
							
						if (($widget->widget_manager_collapse_state === 'closed' || $widget_is_collapsed) && !$widget_is_open) {
							$item->addLinkClass('elgg-widget-collapsed');
						}
					}
				}
					
				if ($item->getName() == 'delete') {
					// dirty fix to prevent incorrect reregistration of add widget js action (see js/lib/ui.widgets.js line 120)
					$item->addLinkClass('elgg-widget-multiple');
				}
			}
		}
	
		return $return_value;
	}
}