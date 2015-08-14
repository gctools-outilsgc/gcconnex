<?php
// note: need to record load time for page (performance)
// note: initial load on the page will take longer because it checks and renders files that are needed for this
// 1. initial startup to set up files (.json files with departments and members) & tagging members
// 2. post startup: check if database and .json files are in sync (check if num members are same)

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;	// /www/elggdata/gc_dept
//$start_timer = microtime(true);										// record the initial time

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

//$end_timer = microtime(true);										// record the end time
//$time = number_format($end_timer - $start_timer, 2);				// difference the two recorded time
//$body .= '<br/>'.elgg_echo('c_bin:estimated_loaded',array($time));

echo elgg_view_page($title, $body);


/* *************** PAGE FUNCTIONS *************** */

// use this function for only when department tab is selected (reduce performance load)
function render_department_tab($data_directory) {
	gatekeeper();	// logged in users only
	$display = '';
	//$display .= create_files($data_directory);	// creates the necessary files..

	if (file_exists($data_directory.'department_listing.json') && file_exists($data_directory.'department_directory.json') && file_exists($data_directory.'department-listing.csv'))
	{
		// NOW DISPLAY THE INFORMATION ON THE PAGE
		$department_listing = json_decode(file_get_contents($data_directory.'department_listing.json'), true);
		$department_directory = json_decode(file_get_contents($data_directory.'department_directory.json'), true);

		$master_array = array();
		$save_department_name = '';
		foreach ($department_listing as $department_name => $department_domains_array)
		{
			if (is_array($department_domains_array) && $department_name) {
				$usercount = 0;
				foreach ($department_domains_array as $key => $value) {
				 	//error_log('++ cyu - key:'.$key.' // value:'.$value)
				 	if ($department_directory[$key]['members'] > 0) {
				 		if (!$master_array[$department_name]) $master_array[$department_name] = array();

				 		$usercount += $department_directory[$key]['members'];
				 		$master_array[$department_name]['members'] = $usercount;

				 		$save_department_name = $department_name;
				 	}
				}
			}
		}

		foreach ($department_listing as $department_domain => $department_name) {
			if (!is_array($department_name)) {
				$department_info = explode('|',$department_name);
				if ($master_array[$department_info[0]] > 0)
				$master_array[$department_info[0]]['abbreviation'] = $department_info[1];
			}
		}

		if (!isset($_COOKIE['connex_lang']))
		 	$master_array = department_language($master_array, true);
		else {
			if ($_COOKIE["connex_lang"] === 'en')
		 		$master_array = department_language($master_array,true);
		 	else
		 		$master_array = department_language($master_array,false);
		}

		if (get_input('sort') === 'alpha')
		{
			ksort($master_array);
		} else {
			arsort($master_array);
		}

		$display = '';
		$display .= "<table width='100%' cellpadding='0' cellspacing='0' style='border-right:1px solid #ccc; border-bottom:1px solid #ccc;'>";
		$display .= '<tr> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:department_name').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:department_abbreviations').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:total_user').'</th></tr>';
		foreach ($master_array as $department_name => $department_info) {	
			$display .= '<tr><td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"><a href="'.elgg_get_site_url().'members/gc_dept?dept='.$department_info['abbreviation'].'">'.$department_name.'</a></td>';

			// joy: nitpicky
			$acronym = explode('/',$department_info['abbreviation']);
			if (count($acronym) == 2) {
				if (!isset($_COOKIE['connex_lang']))
				 	$selected_acronym = $acronym[0];
				else {
					if ($_COOKIE["connex_lang"] === 'en')
				 		$selected_acronym = $acronym[0];
				 	else
				 		$selected_acronym = $acronym[1];
				}
			} else {
				$selected_acronym = $department_info['abbreviation'];
			}

			$display .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$department_info['abbreviation'].'">'.$selected_acronym.'</a></td>';
		 	$display .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> '.$department_info['members'].' </td></tr>';
		}
		$display .= '</table>';
	} else {
		$display = elgg_echo('c_bin:missing_requirements');
	}
	return $display;
}