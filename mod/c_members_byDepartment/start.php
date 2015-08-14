<?php

elgg_register_event_handler('init', 'system', 'c_member_byDepartment_init');

// cyu - modified 02-13-2015: issues with table naming convention resolved
function c_member_byDepartment_init() {
	elgg_register_library('c_department_bin', elgg_get_plugins_path().'c_members_byDepartment/lib/functions.php');
	elgg_load_library('c_department_bin');

	// slightly modify the tabs under the members menu
	elgg_unregister_page_handler('members', 'members_page_handler');
	elgg_register_page_handler('members', 'members_page_handler_2');
	
	// register the generate report action
	$action_path = elgg_get_plugins_path().'c_members_byDepartment/actions/c_members_byDepartment';
	elgg_register_action('c_members_byDepartment/generate_report', "$action_path/generate_report.php");
	elgg_register_action('c_members_byDepartment/generate_users', "$action_path/generate_users.php");
}


function members_page_handler_2($page) {
	$base = elgg_get_plugins_path() . 'members/pages/members';
	$base2 = elgg_get_plugins_path() . 'c_members_byDepartment/pages/members';

	if (!isset($page[0])) {
		$page[0] = 'newest';
	}

	$vars = array();
	$vars['page'] = $page[0];

	switch ($page[0])
	{
		case 'gc_dept':
			require_once "$base2/members_by_dept.php";
			break;
		case 'search':
			require_once "$base/search.php";
			break;
		default:
			require_once "$base2/index.php";
			break;
	}
	return true;
}