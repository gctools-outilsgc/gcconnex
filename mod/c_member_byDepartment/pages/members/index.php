<?php
// note: need to record load time for page (performance)
// note: initial load on the page will take longer because it checks and renders files that are needed for this
// 1. initial startup to set up files (.json files with departments and members) & tagging members
// 2. post startup: check if database and .json files are in sync (check if num members are same)

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;	// /www/elggdata/gc_dept
$start_timer = microtime(true);										// record the initial time

$num_members = get_number_users();
$title = elgg_echo('members');


// determine how to render the page depending on which tab the user selects
$options = array('type' => 'user', 'full_view' => false);
switch ($vars['page'])
{
	case 'popular':
		$options['relationship'] = 'friend';
		$options['inverse_relationship'] = false;
		$content = elgg_list_entities_from_relationship_count($options);
		break;
	case 'online':
		$content = get_online_users();
		break;
	case 'department':
		$content = '<p>'.elgg_echo('c_bin:sort_by').'<a href="'.elgg_get_site_url().'members/department?sort=alpha">'.elgg_echo('c_bin:sort_alpha').'</a> | <a href="'.elgg_get_site_url().'members/department?sort=total">'.elgg_echo('c_bin:sort_totalUsers').'</a></p>'; 
		$content .= render_department_tab($data_directory);
		break;
	case 'newest':
	default:
		$content = elgg_list_entities($options);
		break;
}

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);


$body = elgg_view_layout('content', $params);

$end_timer = microtime(true);										// record the end time
$time = number_format($end_timer - $start_timer, 2);				// difference the two recorded time
$body .= '<br/>'.elgg_echo('c_bin:estimated_loaded',array($time));
echo elgg_view_page($title, $body);


/* *************** PAGE FUNCTIONS *************** */

// use this function for only when department tab is selected (reduce performance load)
function render_department_tab($data_directory) {
	gatekeeper();
	// check necessary files in elggdata-prod2/gc_dept: department-listing.csv, department_listing.json, department_directory.json, all_departments.json

	if (!file_exists($data_directory.'department_listing.json'))
	{
		if (!file_exists($data_directory.'department-listing.csv'))
		{
			//error_log('cyu - missing department-listing.csv');
		}
		//error_log('cyu - missing department_listing.json');

		$csvData = file_get_contents($data_directory.'department-listing.csv');
		$lines = explode(PHP_EOL, $csvData);
		$department_listing = array();
		foreach ($lines as $line) {
			$dept_info = explode(';', $line);
			$department_listing[] = $dept_info;
		}

		$department_name = array();

		foreach ($department_listing as $department)
			$department_name[$department[0]] = $department[2].'|'.$department[1];

		foreach ($department_listing as $abbrev)
		{
			if (!is_array($department_name[$abbrev[2]]))
				$department_name[$abbrev[2]] = array('abbreviation' => $abbrev[1]);

			$tmp_arr = array_merge($department_name[$abbrev[2]], array($abbrev[0] => $abbrev[2].'|'.$abbrev[1]));
			$department_name[$abbrev[2]] = $tmp_arr;
		}

		file_put_contents($data_directory.'department_listing.json', json_encode($department_name)); 
		foreach ($information_array as $key => $single_information)
		{
			if ($key !== 'members')
			{
				for ($i = 0; $i < count($single_information); $i++)
					$department_name[$key.'.gc.ca'] .= '|'.$single_information[$i];
			}
		}
		unset($information_array);
		unset($department_listing);

	}

	if (!file_exists($data_directory.'all_departments.json'))
	{
		//error_log('cyu - missing all_departments.json');
		foreach ($department_name as $dept => $abbreviate)
			$name_list[] = $abbreviate;
		$name_list = array_unique($name_list);
		file_put_contents($data_directory.'all_departments.json',json_encode($name_list));
	}


	if (!file_exists($data_directory.'department_directory.json'))
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
			//error_log('cyu - iconURL for:'.$user->name.' URL='.$user->getIconURL());
			$tmp_arr = array_merge($main_json_file[$value], array($key => strtolower($user->email).'|'.strtolower($user->username).'|'.$key.'|'.$user->time_created.'|'.$user->name.'|'.$user->getIconURL()));
			$main_json_file[$value] = $tmp_arr;
		}
		$write_to_json = file_put_contents($data_directory.'department_directory.json', json_encode($main_json_file));
	}
	unset($main_json_file);
	unset($count_members);


	$department_name = json_decode(file_get_contents($data_directory.'department_listing.json'), true);
	$information_array = json_decode(file_get_contents($data_directory.'department_directory.json'), true);
	$name_list = json_decode(file_get_contents($data_directory.'all_departments.json'), true);

	//  pack the necessary data into an array 
	$main_arr = array();
	$name_list = array();
	foreach ($department_name as $dept => $abbreviate) {
		$name_list[] = $abbreviate;
	}
	$name_list = array_unique($name_list);
	$some_array = array();

	foreach ($name_list as $each_dept)
	{
		$domain_names = array_keys($department_name, $each_dept);

		$used_domains = array();
		if ($domain_names) {
			$membercount = 0;
			foreach ($domain_names as $domain_keys)
			{
				// some keys are stored like this: tbs-sct and tbs-sct.gc.ca
				if (count($information_array[$domain_keys]) > 0)
				{
					if (!in_array($domain_keys,$used_domains))
					{
						if (!$information_array[$domain_keys]['members'])
							$membercount = $membercount + 0;
						else {
							$membercount = $membercount + $information_array[$domain_keys]['members'];
							$used_domains[] = $domain_keys;
						}

					}
				} else {
					$domain_keys = explode('.', $domain_keys);
					if (!in_array($domain_keys[0],$used_domains))
					{
						if (!$information_array[$domain_keys[0]]['members'])
							$membercount = $membercount + 0;
						else {
							$membercount = $membercount + $information_array[$domain_keys[0]]['members'];
							$used_domains[] = $domain_keys[0];
						}
					}
				}
			}
			$some_array[$each_dept] = $membercount;
		}
	}



	// sort the array depending on the option the user chose then display in the table
	$some_array = array_filter($some_array);
	if (get_input('sort') === 'alpha')
	{
		//elgg_log('cyu - sort:'.get_input('sort'), 'NOTICE');
		ksort($some_array);
	} else {
		arsort($some_array);
	}

	$display = '';
	$display .= "<table width='100%' cellpadding='0' cellspacing='0' style='border-right:1px solid #ccc; border-bottom:1px solid #ccc;'>";
	$display .= '<tr> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:department_name').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:department_abbreviations').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:total_user').'</th></tr>';
	foreach ($some_array as $theKey => $theElement)
	{
		$dpt_nfo = explode('|', $theKey);
		$display .= '<tr><td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"><a href="'.elgg_get_site_url().'members/gc_dept?dept='.$dpt_nfo[1].'">'.$dpt_nfo[0].'</a></td>';
		$display .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$dpt_nfo[1].'">'.$dpt_nfo[1].'</a></td>';
		$display .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> '.$theElement.' </td></tr>';
	}
	$display .= '</table>';
	
	return $display;
}


