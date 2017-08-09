<?php

namespace ColdTrick\GroupTools;

class GroupSortMenu {
	
	/**
	 * add group tools tabs
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function addTabs($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_sort_menu')) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('groups:all'),
			'href' => 'groups/all?filter=all',
			'priority' => 200,
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'yours',
			'text' => elgg_echo('groups:yours'),
			'href' => 'groups/all?filter=yours',
			'priority' => 250,
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'open',
			'text' => elgg_echo('group_tools:groups:sorting:open'),
			'href' => 'groups/all?filter=open',
			'priority' => 500,
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'closed',
			'text' => elgg_echo('group_tools:groups:sorting:closed'),
			'href' => 'groups/all?filter=closed',
			'priority' => 600,
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'ordered',
			'text' => elgg_echo('group_tools:groups:sorting:ordered'),
			'href' => 'groups/all?filter=ordered',
			'priority' => 800,
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'suggested',
			'text' => elgg_echo('group_tools:groups:sorting:suggested'),
			'href' => 'groups/suggested',
			'priority' => 900,
		]);
		
		return $return_value;
	}
	
	/**
	 * add sorting options to the menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function addSorting($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_sort_menu')) {
			return;
		}
		
		$allowed_sorting_tabs = [
			'all',
			'yours',
			'open',
			'closed',
			'featured',
		];
		$selected_tab = elgg_extract('selected', $params);
		if (!in_array($selected_tab, $allowed_sorting_tabs)) {
			return;
		}
		
		$base_url = current_page_url();
		// main sorting menu item
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'sorting',
			'text' => elgg_view_icon('sort'),
			'title' => elgg_echo('sort'),
			'href' => '#',
			'priority' => -1, // needs to be first
		]);
		
		// add sorting options
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'newest',
			'text' => elgg_view_icon('sort-amount-desc', ['class' => 'mrs']) . elgg_echo('sort:newest'),
			'title' => elgg_echo('sort:newest'),
			'href' => elgg_http_add_url_query_elements($base_url, [
				'sort' => 'newest',
			]),
			'priority' => 100,
			'parent_name' => 'sorting',
			'selected' => get_input('sort') === 'newest',
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'alpha',
			'text' => elgg_view_icon('sort-alpha-asc', ['class' => 'mrs']) . elgg_echo('sort:alpha'),
			'title' => elgg_echo('sort:alpha'),
			'href' => elgg_http_add_url_query_elements($base_url, [
				'sort' => 'alpha',
			]),
			'priority' => 200,
			'parent_name' => 'sorting',
			'selected' => get_input('sort') === 'alpha',
		]);
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'popular',
			'text' => elgg_view_icon('sort-numeric-desc', ['class' => 'mrs']) . elgg_echo('sort:popular'),
			'title' => elgg_echo('sort:popular'),
			'href' => elgg_http_add_url_query_elements($base_url, [
				'sort' => 'popular',
			]),
			'priority' => 300,
			'parent_name' => 'sorting',
			'selected' => get_input('sort') === 'popular',
		]);
		
		return $return_value;
	}
	
	/**
	 * Clean up the tabs on the group listing page
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function cleanupTabs($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_sort_menu')) {
			return;
		}
		
		/* @var $menu_item \ElggMenuItem */
		foreach ($return_value as $index => $menu_item) {
			$menu_name = $menu_item->getName();
			
			// check plugin settings for the tabs
			if (!self::showTab($menu_name)) {
				unset($return_value[$index]);
				continue;
			}
			
			// check if discussions is enabled
			if (($menu_name === 'discussion') && !elgg_is_active_plugin('discussions')) {
				unset($return_value[$index]);
				continue;
			}
		}
		
		return $return_value;
	}
	
	/**
	 * Check plugin settings if the tabs should be shown
	 *
	 * @param string $name the (internal) name of the tab
	 *
	 * @return bool
	 */
	protected static function showTab($name) {
		
		$show_tab_setting = elgg_get_plugin_setting("group_listing_{$name}_available", 'group_tools');
		
		$default_hidden_tabs = [
			'ordered',
			'featured',
		];
		if (in_array($name, $default_hidden_tabs)) {
			if ($show_tab_setting === '1') {
				return true;
			}
		} elseif ($show_tab_setting !== '0') {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Set the correct selected tab
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function setSelected($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('group_sort_menu')) {
			return;
		}
		
		$selected_tab = elgg_extract('selected', $params, 'all');
		if (empty($selected_tab)) {
			return;
		}
		
		foreach ($return_value as $section => $menu_items) {
			if (empty($menu_items) || !is_array($menu_items)) {
				continue;
			}
			
			/* @var $menu_item \ElggMenuItem */
			foreach ($menu_items as $menu_item) {
				if ($menu_item->getName() !== $selected_tab) {
					continue;
				}
				
				$menu_item->setSelected(true);
				break;
			}
		}
		
		return $return_value;
	}
}
