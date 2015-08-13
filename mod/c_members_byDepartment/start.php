<?php

elgg_register_event_handler('init', 'system', 'c_member_byDepartment_init');


function c_member_byDepartment_init() {
	elgg_unregister_page_handler('members', 'members_page_handler');
	elgg_register_page_handler('members', 'members_page_handler_2');
	// manually re-generate the users
	$action_path = elgg_get_plugins_path().'c_member_byDepartment/actions/c_member_byDepartment';
	elgg_register_action('c_member_byDepartment/generate_report', "$action_path/generate_report.php");
	//elgg_register_action('c_member_byDepartment/tag_users', "$action_path/tag_users.php");
	// cron job configuration
	register_plugin_hook('cron', 'daily', 'regenerate_users');
}

function regenerate_users($hook, $entity_type, $returnvalue, $params) {

	error_log('cyu - cronjob has been invoked :O');

	global $CONFIG;
	$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;

	$information_array = json_decode(file_get_contents($data_directory.'department_directory.json'));
	$information_array = get_object_vars($information_array);

	$last_member = elgg_get_entities(array('types' => 'user', 'limit' => '1'));
	$last_member_saved = $information_array['members'];

	if ($last_member[0]->getGUID() != $last_member_saved)
	{

		global $CONFIG;
		$query = "SELECT ue.email, ue.name, e.time_created, e.guid FROM elggentities e, elggusers_entity ue WHERE e.type = 'user' AND e.guid = ue.guid AND e.enabled = 'yes'";

		$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
		if (mysqli_connect_errno($connection)) elgg_log("cyu - Failed to connect to MySQL: ".mysqli_connect_errno(), 'NOTICE');
		$result = mysqli_query($connection,$query);
		mysqli_close($connection);

		$array_of_users = array();
		while ($row = mysqli_fetch_array($result))
		{
			$domain = explode('@', strtolower($row['email']));
			$filter_domain = explode('.', $domain[1]);
			if ($filter_domain[count($filter_domain) - 2].'.'.$filter_domain[count($filter_domain) - 1] === 'gc.ca')
				$array_of_users[$row['guid']] = $filter_domain[0];
			else
				$array_of_users[$row['guid']] = $domain[1];
		}
		$main_json_file = array();
		$count_members = array();
		$main_json_file['members'] = max(array_keys($array_of_users));
		$count_members = array_count_values($array_of_users);
		$main_json_file = array_merge($main_json_file, $count_members);

		foreach ($array_of_users as $key => $value)
		{
			if (!is_array($main_json_file[$value]))
			{
				$num_members = $main_json_file[$value];
				$main_json_file[$value] = array('members' => $main_json_file[$value]);
			}
			$user = get_user($key);
			$tmp_arr = array_merge($main_json_file[$value], array($key => strtolower($user->email).'|'.strtolower($user->username).'|'.$key.'|'.$user->time_created.'|'.$user->name.'|'.$user->getIconURL()));
			$main_json_file[$value] = $tmp_arr;
		}
		$write_to_json = file_put_contents($data_directory.'department_directory.json', json_encode($main_json_file));
		$today = date("YmdHis");
		$write_as_backup = file_put_contents($data_directory.'department_directory_'.$today.'.json', json_encode($main_json_file));
	}
}

function members_page_handler_2($page) {
	$base = elgg_get_plugins_path() . 'members/pages/members';
	$base2 = elgg_get_plugins_path() . 'c_member_byDepartment/pages/members';

	if (!isset($page[0])) {
		$page[0] = 'newest';
	}

	$vars = array();
	$vars['page'] = $page[0];

	elgg_log('cyu - page:'.$page[0],'NOTICE');

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