<?php

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

forward(REFERER);