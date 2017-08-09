<?php
/**
 * ColdTrick:
 * - added filter tabs support
 * - added sorting options
 */

// all groups doesn't get link to self
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('groups'));

if (elgg_get_plugin_setting('limited_groups', 'groups') != 'yes' || elgg_is_admin_logged_in()) {
	elgg_register_title_button();
}

$selected_tab = get_input('filter', 'all');

$content = '';

$dbprefix = elgg_get_config('dbprefix');
$getter = 'elgg_get_entities_from_relationship';
$group_options = [
	'type' => 'group',
	'full_view' => false,
	'no_results' => elgg_echo('groups:none'),
];

switch ($selected_tab) {
	case 'discussion':
		$getter = false;
		
		// Get only the discussions that have been created inside a group
		$content = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'discussion',
			'order_by' => 'e.last_action desc',
			'limit' => 40,
			'full_view' => false,
			'no_results' => elgg_echo('discussion:none'),
			'joins' => array("JOIN {$dbprefix}entities ce ON ce.guid = e.container_guid"),
			'wheres' => array('ce.type = "group"'),
			'distinct' => false,
			'preload_containers' => true,
		));
		break;
	case 'featured':
		$group_options['metadata_name_value_pairs'] = [
			'name' => 'featured_group',
			'value' => 'yes',
		];
		$group_options['no_results'] = elgg_echo('groups:nofeatured');
		break;
	case 'yours':
		elgg_gatekeeper();
		
		$group_options['relationship'] = 'member';
		$group_options['relationship_guid'] = elgg_get_logged_in_user_guid();
		$group_options['inverse_relationship'] = false;

		break;
	case 'open':
		$group_options['metadata_name_value_pairs'] = [
			'name' => 'membership',
			'value' => ACCESS_PUBLIC,
		];
		
		break;
	case 'closed':
		$group_options['metadata_name_value_pairs'] = [
			'name' => 'membership',
			'value' => ACCESS_PUBLIC,
			'operand' => '<>',
		];
		
		break;
	case 'ordered':
		// @todo drop this?
		$order_id = elgg_get_metastring_id('order');
		
		$group_options['limit'] = false;
		$group_options['pagination'] = false;
		$group_options['selects'] = [
			"IFNULL((SELECT order_ms.string as order_val
			FROM {$dbprefix}metadata mo
			JOIN {$dbprefix}metastrings order_ms ON mo.value_id = order_ms.id
			WHERE e.guid = mo.entity_guid
			AND mo.name_id = {$order_id}), 99999) AS order_val",
		];
		
		$group_options['order_by'] = 'CAST(order_val AS SIGNED) ASC, e.time_created DESC';
		
		if (elgg_is_admin_logged_in()) {
			elgg_require_js('group_tools/ordered_list');
			$group_options['list_class'] = 'group-tools-list-ordered';
		}
		
		break;
	case 'all':
	default:
		
		break;
}

// sorting options
$sorting = get_input('sort');
switch ($sorting) {
	case 'popular':
		$getter = 'elgg_get_entities_from_relationship_count';
		
		$group_options['relationship'] = 'member';
		$group_options['inverse_relationship'] = false;
		break;
	case 'alpha':
		$group_options['joins'][] = "JOIN {$dbprefix}groups_entity ges ON e.guid = ges.guid";
		
		$order = strtoupper(get_input('order'));
		if (!in_array($order, ['ASC', 'DESC'])) {
			$order = 'ASC';
		}
		
		$group_options['order_by'] = "ges.name {$order}";
		break;
	case 'newest':
	default:
		// nothing, as Elgg default sorting is by time_created desc (eg newest)
		break;
}

if (!empty($getter)) {
	$content = elgg_list_entities($group_options, $getter);
}

$filter = elgg_view('groups/group_sort_menu', array('selected' => $selected_tab));

$sidebar = elgg_view('groups/sidebar/find');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'filter' => $filter,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page(elgg_echo('groups:all'), $body);
