<?php
gatekeeper();	// logged in user can only see this section
global $CONFIG;
$get_department = get_input('dept');	// get the department name
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;	// www/elggdata/gc_dept

// NOW DISPLAY THE INFORMATION ON THE PAGE
$department_listing = json_decode(file_get_contents($data_directory.'department_listing.json'), true);
$department_directory = json_decode(file_get_contents($data_directory.'department_directory.json'), true);

// filter out the departments we dont need
foreach ($department_listing as $email => $department_name) {
	if (is_string($department_name)) {
		if (!strpos($department_name, $get_department))
			unset($department_listing[$email]);
	}
}

$master_array = array();
$usercount = 0;
$user_array = array();
$selected_department_name;
foreach ($department_listing as $department_email => $department_name)
{
	if (is_string($department_name)) {
		$name_bits = explode('|',$department_name);
		$department_name = $name_bits[0];
		if (is_array($department_directory[$department_email]) && $department_directory[$department_email]['members'] > 0)
		{
			if (!is_array($master_array[$department_name])) $master_array[$department_name] = array();	// if not an array, allocate
			$usercount = $usercount + $department_directory[$department_email]['members'];
			foreach ($department_directory[$department_email] as $user_index => $user_info) {
				$selected_department_name = $department_name;
				if ($user_index !== 'members') {
					$master_array[$department_name]['members'] = $usercount;
					$user_bits = explode('|',$user_info);
					$master_array[$department_name][$user_bits[3]] = $user_bits[4].'|'.$user_info;
					//error_log('cyu - user index:'.$user_index.' / user info:'.$user_info);
				}
			}
		}
	}
}

$selected_department = $master_array;
$total_users = $selected_department[$selected_department_name]['members'];	// save the total users before we erase it
unset($selected_department[$selected_department_name]['members']);	// remove the members element before we display it on screen
$selected_department = $selected_department[$selected_department_name];	// we can remove the department name.. no need for it

// toggle between english and french
if (!isset($_COOKIE['connex_lang']))
	$selected_department = department_language($selected_department, true);
else {
	if ($_COOKIE["connex_lang"] === 'en')
 		$selected_department = department_language($selected_department,true);
 	else
 		$selected_department = department_language($selected_department,false);
}


// if no sort was selected, sort by alphabet
$sort_type = get_input('sort');
if (!$sort_type) $sort_type = 'alpha';

// if no page was selected, default to 0th page
$curr_page = get_input('current_page');
if (!$curr_page) $curr_page = 0;

$owner_guid = get_loggedin_userid();
$owner = get_user($owner_guid);

$title = elgg_echo('c_bin:member_in', array($get_department));
$content = '<p>'.elgg_echo('c_bin:sort_by').'<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=alpha&current_page='.$curr_page.'">'.elgg_echo('c_bin:sort_alpha').'</a> | <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=validate&current_page='.$curr_page.'">'.elgg_echo('c_bin:sort_guid').'</a></p>'; 

// separating the views per page
$divide_pages = count($selected_department);
$divide_pages = $divide_pages/200;	// display at max of 200 users

$selected_department = array_chunk($selected_department, 200, true);	// chunk it to 200 at a time

// what did the user select as sort option?
if ($sort_type === 'alpha')
{
	asort($selected_department[$curr_page]);	// sort by value
} else {
	ksort($selected_department[$curr_page]);	// sort by key
}

$content .= "<table style='border-right:1px solid #ccc; border-bottom:1px solid #ccc;' cellpadding='0' cellspacing='0'>";
$content .= '<tr> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:user_icon').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:display_name').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:email_address').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:date_joined').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:colleague').'</th></tr>';
foreach ($selected_department[$curr_page] as $user_index => $user_information_block)
{
	//error_log('cyu - info:'.$user_information[3]);
	$user_information = explode('|',$user_information_block);
	$user_obj = get_user($user_information[3]);

	
	if (is_object($user_obj)) { 
		$user_icon = $user_obj->getIconURL(); 
		//error_log('cyu - icon:'.$user_icon); 
	} else {
		$user_icon = elgg_get_site_url().'_graphics/icons/user/defaultmedium.gif';
	}
	//error_log('cyu - the thing:'.$user_obj);

	
	$content .= '<tr><td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <img src="'./*$user_information[6]*/$user_icon.'"> </td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'profile/'.$user_information[2].'">'.$user_information[5].'</a></td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'profile/'.$user_information[2].'">'.$user_information[1].'</a></td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> '.date('Y-m-d H:i:s', $user_information[4]).' </td>';

	if ($user_information[2] == $owner->guid)
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> - </td></tr>';
	elseif (!$owner->isFriendsWith($user_information[3]))
	{
		$__elgg_ts = time();
		$__elgg_token = generate_action_token($__elgg_ts);
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'action/friends/add?friend='.$user_information[3].'&__elgg_ts='.$__elgg_ts.'&__elgg_token='.$__elgg_token.'">'.elgg_echo('c_bin:add_colleague').'</a> </td></tr>';
	}
	else
	{
		$__elgg_ts = time();
		$__elgg_token = generate_action_token($__elgg_ts);
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'action/friends/remove?friend='.$user_information[3].'&__elgg_ts='.$__elgg_ts.'&__elgg_token='.$__elgg_token.'">'.elgg_echo('c_bin:remove_colleague').'</a> </td></tr>';
	}
}
$content .= '</table>';
$content .= '<br/>';


// this creates: << page numbers >>
//error_log('cyu - current page:'.$curr_page);
if ($curr_page == 0)
	$content .= ' ';
else {
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page=0" title="'.elgg_echo('c_bin:first_page').'"> << </a>| ';
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page='.($curr_page-1).'" title="'.elgg_echo('c_bin:previous').'"> < </a>| ';
}

for( $i=1; $i<$divide_pages+1; $i++ )
{
	if ($curr_page+1 == $i)
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page='.($i-1).'"><b><u>'.$i.'</u></b></a> ';
	else
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page='.($i-1).'">'.$i.'</a> ';
}

if ($curr_page == floor($divide_pages))
	$content .= ' ';
else {
		$content .= '| <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page='.($curr_page+1).'" title="'.elgg_echo('c_bin:next').'"> > </a>| ';
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort='.$sort_type.'&current_page='.floor($divide_pages).'" title="'.elgg_echo('c_bin:last_page').'"> >> </a>';
	}

$content .= '<br/>';
$content .= '<br/><a href="'.elgg_get_site_url().'members/department'.'">'.elgg_echo('c_bin:returnToMenu').'</a>';

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title.' ('.$total_users.')',
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page']))
);
$body = elgg_view_layout('content', $params);
echo elgg_view_page($title, $body);