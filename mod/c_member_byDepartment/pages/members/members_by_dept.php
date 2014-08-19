<?php
gatekeeper();
global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;	// /www/elggdata/gc_dept
$start_timer = microtime(true);										// record the initial time

$get_dept = get_input('dept');
$get_data = json_decode(file_get_contents($data_directory.'department_directory.json'));

$department_listing = json_decode(file_get_contents($data_directory.'department_listing.json'));


$department_listing = get_object_vars($department_listing);
$get_data = get_object_vars($get_data);

// the string we are looking for contains a backslash.. need to escape it
$get_dept = str_replace('/', '\/', $get_dept);

// we need to get all the domains that are mapped to the department and then we process users4display
$stripped_department_listing = $department_listing;
$matches = array_filter($stripped_department_listing, function($var) use ($get_dept) { return preg_match("/\b$get_dept\b/i", $var); });

$main_arr = array();
$used_array = array();
foreach ($matches as $match_key => $match_value) {
	if (!in_array($match_key, $used_array)) {
		foreach ((array)$get_data[$match_key] as $user) 
		{
			if ($get_data[$match_key]) 
			{
				$inform = explode('|',$user);
				if ($inform[2] > 0 ) 
				{
					//$main_arr[$inform[2]] = $inform[0].'|'.$inform[1];
					$main_arr[$inform[2]] = $inform[4].'|'.$inform[1].'|'.$inform[3].'|'.$inform[5].'|'.$inform[0];
				}
			}
		}
		$used_array[] = $match_key;
	}
	$match_key = explode('.', $match_key);

	if (!in_array($match_key[0],$used_array))
	{
		//error_log('cyu - key:'.$match_key[0].' count (strip):'.count((array)$get_data[$match_key[0]]));
		foreach ((array)$get_data[$match_key[0]] as $user) {
			$inform = explode('|',$user);
			if ($inform[2] > 0 ) {
				//error_log('cyu - user email:'.$inform[0].' +++ GUID:'.$inform[2].' +++ time created:'.$inform[3].' +++ display name:'.$inform[4]);
				$main_arr[$inform[2]] = $inform[4].'|'.$inform[1].'|'.$inform[3].'|'.$inform[5].'|'.$inform[0]; 
			}
		}
		$used_array[] = $match_key[0];
	}
}


if (get_input('sort') === 'alpha')
{
	asort($main_arr);
} else {
	ksort($main_arr);
}

$sort_type = get_input('sort');
if (!$sort_type) $sort_type = 'alpha';

$curr_page = get_input('current_page');
if (!$curr_page) $curr_page = 0;

$get_dept = str_replace('\/', '/', $get_dept);

$title = elgg_echo('c_bin:member_in', array($get_dept));
$content = '<p>'.elgg_echo('c_bin:sort_by').'<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort=alpha&current_page='.$curr_page.'">'.elgg_echo('c_bin:sort_alpha').'</a> | <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort=validate&current_page='.$curr_page.'">'.elgg_echo('c_bin:sort_guid').'</a></p>'; 


$divide_into_pages = count($main_arr);
$population_of_people = count($main_arr);
$divide_into_pages = $divide_into_pages/200;


$main_arr = array_chunk($main_arr, 200, true);

$content .= "<table style='border-right:1px solid #ccc; border-bottom:1px solid #ccc;' cellpadding='0' cellspacing='0'>";
$content .= '<tr> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:user_icon').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:display_name').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:email_address').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:date_joined').'</th> <th style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;">'.elgg_echo('c_bin:colleague').'</th></tr>';

$owner_guid = get_loggedin_userid();
$owner = get_user($owner_guid);

$usercount = 0;
foreach ($main_arr[$curr_page] as $main_key => $main_value)
{
	$usercount++;
	$details = explode ('|', $main_value);
	$details[3] = str_replace('medium', 'small', $details[3]);
	$content .= '<tr><td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <img src="'.$details[3].'"> </td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'profile/'.$details[1].'">'.$details[0].'</a></td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'profile/'.$details[1].'">'.$details[4].'</a></td>';
	$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> '.date('Y-m-d H:i:s', $details[2]).' </td>';

	if ($owner->guid == $main_key)
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> - </td></tr>';
	elseif (!$owner->isFriendsWith($main_key))
	{
		$__elgg_ts = time();
		$__elgg_token = generate_action_token($__elgg_ts);
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'action/friends/add?friend='.$main_key.'&__elgg_ts='.$__elgg_ts.'&__elgg_token='.$__elgg_token.'">'.elgg_echo('c_bin:add_colleague').'</a> </td></tr>';
	}
	else
	{
		$__elgg_ts = time();
		$__elgg_token = generate_action_token($__elgg_ts);
		$content .= '<td style="padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc;"> <a href="'.elgg_get_site_url().'action/friends/remove?friend='.$main_key.'&__elgg_ts='.$__elgg_ts.'&__elgg_token='.$__elgg_token.'">'.elgg_echo('c_bin:remove_colleague').'</a> </td></tr>';
	}
}
$content .= '</table>';

$content .= '<br/><center>';
if ($curr_page == 0)
	$content .= ' ';
else 
	{
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page=0" title="'.elgg_echo('c_bin:first_page').'"> << </a>| ';
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page='.($curr_page-1).'" title="'.elgg_echo('c_bin:previous').'"> < </a>| ';
	}

for($i=1; $i<$divide_into_pages+1; $i++)
{
	if ($curr_page+1 == $i)
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page='.($i-1).'"><b>'.$i.'</b></a> ';
	else
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page='.($i-1).'">'.$i.'</a> ';
}

if ($curr_page == floor($divide_into_pages))
	$content .= ' ';
else 
	{
		$content .= '| <a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page='.($curr_page+1).'" title="'.elgg_echo('c_bin:next').'"> > </a>| ';
		$content .= '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_dept.'&sort='.$sort_type.'&current_page='.floor($divide_into_pages).'" title="'.elgg_echo('c_bin:last_page').'"> >> </a>';
	}
$content .= '</center><br/>';

$content .= '<br/><a href="'.elgg_get_site_url().'members/department'.'">'.elgg_echo('c_bin:returnToMenu').'</a>';
$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " (".$population_of_people.")",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

$end_timer = microtime(true);										// record the end time
$time = number_format($end_timer - $start_timer, 2);				// difference the two recorded time
$body .= '<br/>'.elgg_echo('c_bin:estimated_loaded',array($time));;
$modification_time = date("Y-m-d H:i:s", filemtime($data_directory.'department_directory.json'));
$body .= '<br/>'.elgg_echo('c_bin:report_generated',array($modification_time));
echo elgg_view_page($title, $body);


