<?php

// toggle between english and french departments
function department_language($master_array, $is_english) {
	$temp_array = array();

	foreach ($master_array as $key => $value)
	{
		$name = explode('/',$key);
		if ($is_english) {
			$temp_array[$name[0]] = $value;
		} else {
			// department vs users array (due to french/english toggle)
			if (is_array($value))
				$temp_array[$name[1]] = $value;
			else 
				$temp_array[$name[0]] = $value;
		}
	}
	unset($master_array);	// de-allocate memory
	$master_array = $temp_array;
	//print_r($master_array);
	return $master_array;
}

function create_user_list_from_database() {
	global $CONFIG;
	$dbprefix = elgg_get_config("dbprefix");
	$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;
	$query = "SELECT ue.email, ue.name, e.time_created, e.guid, ue.username FROM ".$dbprefix."entities e, ".$dbprefix."users_entity ue WHERE e.type = 'user' AND e.guid = ue.guid AND e.enabled = 'yes'";
	
	// cyu - important note that doing it this way, we aren't using up all the PHP memory... (PHP Fatal error: Allowed memory size of xxxx bytes exhausted...)
	$conn = new mysqli($CONFIG->dbhost,$CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	$result = $conn->query($query);
	$conn->close();

	$binned_users = array();
	$extract_user_information = array();
	while ($row = $result->fetch_assoc()) {
		$domain = explode('@',strtolower($row['email']));
		$binned_users[$row['guid']] = $domain[1];
		
		$extract_user_information[$row['guid']] = utf8_encode($row['email'].'|'.$row['username'].'|'.$row['guid'].'|'.$row['time_created'].'|'.$row['name']);
		//error_log('cyu - guid:'.utf8_encode($row['email'].'|'.$row['username'].'|'.$row['guid'].'|'.$row['time_created'].'|'.$row['name']));
	}
	//error_log(print_r($extract_user_information,true));
	//error_log('cyu - json_encode:'.json_encode($extract_user_information));
	$result_binned = file_put_contents($data_directory.'create_user_list_from_database.json', json_encode($binned_users));
	$result_users = file_put_contents($data_directory.'database_pull.json', json_encode($extract_user_information));
	//error_log('cyu - results user:'.$result_users);
	unset($binned_users);


}


// creates the necessary files (json)
function create_files($data_directory) {
	$display = '';
	$dbprefix = elgg_get_config("dbprefix");

	// this is an important file, updates require this file
	if (!file_exists($data_directory.'department-listing.csv'))
	{
		if (elgg_is_admin_logged_in())
			$display .= "department-listing.csv cannot be found in the data folder";
		return $display;
	} // end if department-listing.csv


	// CREATE DEPARTMENT_LISTING.JSON IF FILE DOES NOT EXIST
	if (!file_exists($data_directory.'department_listing.json'))
	{
		$csvData = explode(PHP_EOL,file_get_contents($data_directory.'department-listing.csv'));	// get the contents of the csv file
		$department_listing = array();	// allocate memory for department_listing

		foreach ($csvData as $csvRow) {
			$dept_info = explode(';',$csvRow);
			$department_listing[] = $dept_info;
			//error_log('[error_log c_members_byDepartment] dept_info:'.$dept_info[0].' /// '.$dept_info[1]); // domain | abbreviation
		}
	
		$department_name = array();
		foreach ($department_listing as $department) {
			$department_name[$department[0]] = $department[2].'|'.$department[1];
			//error_log('[error_log c_members_byDepartment] department_name:'.$department[2].'|'.$department[1]);	// department_name | department abbrev
		}

		foreach ($department_listing as $dept_abbrev) {
			if (!is_array($department_name[$dept_abbrev[2]])) {
				$department_name[$dept_abbrev[2]] = array('abbreviation' => $dept_abbrev[1]);	// cyu - they're actually domains..
				//error_log('[error_log c_members_byDepartment] abbrev:'.$dept_abbrev[1]);
			}
			$temp_array = array_merge($department_name[$dept_abbrev[2]],array($dept_abbrev[0] => $dept_abbrev[2].'|'.$dept_abbrev[1]));
			//error_log('[error_log c_members_byDepartment] department abbrev:'.$dept_abbrev[2].'|'.$dept_abbrev[1]);
			//error_log('[error_log c_members_byDepartment] temp_array:'.print_r($temp_array,true));
			$department_name[$dept_abbrev[2]] = $temp_array;
		}
		$result = file_put_contents($data_directory.'department_listing.json', json_encode($department_name));
		//if (!$result) return FALSE;
		// ALL DEPARTMENT INFORMATION SAVED IN DEPARTMENT_LISTING.JSON
	} // end if department_listing.json (modified)
	unset($department_listing);	// deallocate memory
	unset($department_name);

	set_time_limit(600);	// need to temporarily lengthen the time for the script to run..



	// CREATE DEPARTMENT_DIRECTORY.JSON IF FILE DOES NOT EXIST
	if (!file_exists($data_directory.'department_directory.json'))
	{
		$binned_users = json_decode(file_get_contents($data_directory.'create_user_list_from_database.json'), true);
		
		$user_information_extract = json_decode(file_get_contents($data_directory.'database_pull.json'), true);


		//error_log(print_r($user_information_extract,true));
		//error_log('[error_log c_members_byDepartment] binned users:'.print_r($binned_users,true));
		$main_file = array();
		$main_file['members'] = max(array_keys($binned_users));
		$usercount = array();
		$usercount = array_count_values($binned_users);
		$main_file = array_merge($main_file,$usercount);
		unset($usercount);	// deallocate memory
		foreach ($binned_users as $key => $value) {
			if (!is_array($main_file[$value]))	// key: user guid | value: user email domain
			{
				//error_log('[error_log c_members_byDepartment] value:'.$value.' /// key:'.$key);
				$usercount = $main_file[$value];
				$main_file[$value] = array('members' => $main_file[$value]);
			}
			//$user = get_user($key);
			//$query = "SELECT e.guid, ue.email, ue.username, e.time_created, ue.name FROM elggentities e, elggusers_entity ue WHERE e.guid = ue.guid AND e.guid = ".$key;
			//$user = get_data($query);

			//$temp_array = array_merge($main_file[$value], array($key => strtolower($user->email).'|'.strtolower($user->username).'|'.$key.'|'.$user->time_created.'|'.$user->name/*.'|'.$user->getIconURL()*/));
			//$temp_array = array_merge($main_file[$value], array($key => strtolower($user[[0]->email).'|'.strtolower($user[0]->username).'|'.$key.'|'.$user[0]->time_created.'|'.$user[0]->name));
			//$temp_array = array_merge($main_file[$value], array($key => strtolower($user_information_extract[$key]->email).'|'.$user_information_extract[$key]->username.'|'.$user_information_extract[$key]->$key.'|'.$user_information_extract[$key]->time_created.'|'.$user_information_extract[$key]->name));
			
			$userinfo = explode('|',$user_information_extract[$key]);
			$temp_array = array_merge($main_file[$value], array($key => strtolower($userinfo[0]).'|'.$userinfo[1].'|'.$userinfo[2].'|'.$userinfo[3].'|'.$userinfo[4]));
			
			$main_file[$value] = $temp_array;
			unset($user);
		}
		file_put_contents($data_directory.'department_directory.json', json_encode($main_file));
	}
	unset($main_file);	// deallocate memory
	// DEPARTMENT DIRECTORY THAT CONTAINS ALL USERS ARE SAVED IN DEPARTMENT_DIRECTORY.JSON
	//error_log('cyu - department_directory file created');

	return TRUE;

}