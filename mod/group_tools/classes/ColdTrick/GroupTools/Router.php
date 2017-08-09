<?php

namespace ColdTrick\GroupTools;

class Router {
	
	/**
	 * Take over the groups page handler in some cases
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param null   $params       supplied params
	 *
	 * @return void|false
	 */
	public static function groups($hook, $type, $return_value, $params) {
		
		if (empty($return_value) || !is_array($return_value)) {
			return;
		}
		
		$resource_loaded = false;
		
		$page = elgg_extract('segments', $return_value);
		switch (elgg_extract(0, $page, 'all')) {
			case 'all':
				// prepare tab listing settings
				group_tools_prepare_listing_settings();
				break;
			case 'suggested':
				echo elgg_view_resource('group_tools/groups/suggested');
				$resource_loaded = true;
				break;
			case 'requests':
				$subpage = elgg_extract('2', $page);
				if (empty($subpage)) {
					break;
				}
				$guid = elgg_extract('1', $page);
				if (elgg_view_exists("resources/groups/requests/{$subpage}")) {
					
					elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");
					
					echo elgg_view_resource("groups/requests/{$subpage}", [
						'guid' => $guid,
					]);
					$resource_loaded = true;
				}
				break;
			case 'mail':
				
				echo elgg_view_resource('group_tools/groups/mail', [
					'group_guid' => (int) elgg_extract('1', $page),
				]);
				$resource_loaded = true;
				break;
			case 'group_invite_autocomplete':
				
				echo elgg_view_resource('group_tools/groups/group_invite_autocomplete');
				$resource_loaded = true;
				break;
			case 'add':
				if (group_tools_is_group_creation_limited()) {
					elgg_admin_gatekeeper();
				}
				break;
			case 'related':
				$guid = elgg_extract('1', $page);
				
				echo elgg_view_resource('group_tools/groups/related', [
					'guid' => $guid,
				]);
				$resource_loaded = true;
				break;
			default:
				// check if we have an old group profile link
				if (isset($page[0]) && is_numeric($page[0])) {
					$group = get_entity($page[0]);
					if ($group instanceof ElggGroup) {
						register_error(elgg_echo('changebookmark'));
						forward($group->getURL());
					}
				}
				break;
		}
		
		// did we want this page?
		if ($resource_loaded) {
			// done by resource view
			return false;
		}
	}
	
	/**
	 * Allow registration with a valid group invite code
	 *
	 * Both access to the registration page and the registration action
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param null   $params       supplied params
	 *
	 * @return void
	 */
	public static function allowRegistration($hook, $type, $return_value, $params) {
		
		// enable registration if disabled
		group_tools_enable_registration();
	}
	
	/**
	 * Take over the livesearch when searching for groups
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param null   $params       supplied params
	 *
	 * @see input_livesearch_page_handler()
	 *
	 * @return void|false
	 */
	public static function livesearch($hook, $type, $return_value, $params) {
		
		// only return results to logged in users.
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			exit;
		}
		
		$q = get_input('term', get_input('q'));
		if (empty($q)) {
			exit;
		}
		
		// sanitise search query
		$q = sanitise_string($q);
		
		// replace mysql vars with escaped strings
		$q = str_replace(['_', '%'], ['\_', '\%'], $q);
		
		$match_on = get_input('match_on', 'all');
		if (!is_array($match_on)) {
			$match_on = [$match_on];
		}
		
		// only take over groups search
		if (count($match_on) > 1 || !in_array('groups', $match_on)) {
			return;
		}
		
		$owner_guid = ELGG_ENTITIES_ANY_VALUE;
		if (get_input('match_owner', false)) {
			$owner_guid = $user->getGUID();
		}
		
		$input_name = get_input('name', 'groups');
		$limit = sanitise_int(get_input('limit', elgg_get_config('default_limit')));
		
		// fetch groups
		$results = [];
		$dbprefix = elgg_get_config('dbprefix');
		$options = [
			'type' => 'group',
			'limit' => $limit,
			'owner_guid' => $owner_guid,
			'joins' => [
				"JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid",
			],
			'wheres' => [
				"(ge.name LIKE '%{$q}%' OR ge.description LIKE '%{$q}%')",
			],
		];
		
		$entities = elgg_get_entities($options);
		if (!empty($entities)) {
			foreach ($entities as $entity) {
				$output = elgg_view_list_item($entity, [
					'use_hover' => false,
					'class' => 'elgg-autocomplete-item',
					'full_view' => false,
					'href' => false,
					'title' => $entity->name, // Default title would be a link
				]);
				
				$icon = elgg_view_entity_icon($entity, 'tiny', [
					'use_hover' => false,
				]);
				
				$result = [
					'type' => 'group',
					'name' => $entity->name,
					'desc' => strip_tags($entity->description),
					'guid' => $entity->getGUID(),
					'label' => $output,
					'value' => $entity->getGUID(),
					'icon' => $icon,
					'url' => $entity->getURL(),
					'html' => elgg_view('input/grouppicker/item', [
						'entity' => $entity,
						'input_name' => $input_name,
					]),
				];
				
				$results[$entity->name . rand(1, 100)] = $result;
			}
		}
		
		ksort($results);
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode(array_values($results));
		exit;
	}
}
