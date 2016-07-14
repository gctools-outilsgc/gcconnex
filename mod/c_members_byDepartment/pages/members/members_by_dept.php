<?php
gatekeeper();	// logged in user can only see this section
global $CONFIG;
$get_department = get_input('dept');	// get the department name

//exceptions to normal format of department array key

//pov-[key]
$provList = array('pov-alb', 'pov-bc', 'pov-man', 'pov-nb', 'pov-nfl', 'pov-ns', 'pov-nwt', 'pov-nun', 'pov-ont', 'pov-pei', 'pov-que', 'pov-sask', 'pov-yuk');
//'OU=[key],O=GC,C=CA'
$diffdept = array('AAFC-AAC', 'CED-DEC', 'CRCC-CCETP', 'FDO-FDO', 'LOP-BDP', 'DND-MDN', 'POLAR-POLAIRE', 'PSLREB-CRTEFP', 'PSPC-SPAC', 'PC-PC', 'CMH-MCH', 'STATCAN-STATCAN');
//'ou=[key],o=GC,c=CA'
$spaceDept = array('ATSSC-SCDATA', 'CCPERB-CCEEBC', 'CMIP-MCIQ', 'DI-ID', 'IRSAS-SAPI', 'SST-TSS',);
//'ou=[key],O=GC,C=CA'
$mixDept = array('GAC-AMC' );

$obj = elgg_get_entities(array(
              'type' => 'object',
              'subtype' => 'dept_list',
              'owner_guid' => 0
       ));

//$metaname = "deptsEn";

$departmentsEn = json_decode($obj[0]->deptsEn, true);
$provinces['pov-alb'] = 'Government of Alberta';
$provinces['pov-bc'] = 'Government of British Columbia';
$provinces['pov-man'] = 'Government of Manitoba';
$provinces['pov-nb'] = 'Government of New Brunswick';
$provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
$provinces['pov-ns'] = 'Government of Nova Scotia';
$provinces['pov-nwt'] = 'Government of Northwest Territories';
$provinces['pov-nun'] = 'Government of Nunavut';
$provinces['pov-ont'] = 'Government of Ontario';
$provinces['pov-pei'] = 'Government of Prince Edward Island';
$provinces['pov-que'] = 'Government of Quebec';
$provinces['pov-sask'] = 'Government of Saskatchewan';
$provinces['pov-yuk'] = 'Government of Yukon';
$departmentsEn = array_merge($departmentsEn,$provinces);

//$metaname = "deptsFr";

$departmentsFr = json_decode($obj[0]->deptsFr, true);
$provinces['pov-alb'] = "Gouvernement de l'Alberta";
$provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
$provinces['pov-man'] = 'Gouvernement du Manitoba';
$provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
$provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
$provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
$provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
$provinces['pov-nun'] = 'Gouvernement du Nunavut';
$provinces['pov-ont'] = "Gouvernement de l'Ontario";
$provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
$provinces['pov-que'] = 'Gouvernement du Québec';
$provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
$provinces['pov-yuk'] = 'Gouvernement du Yukon';
$departmentsFr = array_merge($departmentsFr,$provinces);

//find correct department array based o language
if (get_current_language()=='en'){
    $displayDept = $departmentsEn;
} else {
    $displayDept = $departmentsFr;
}

//check if part of exception arrays to fix odd keys
if(in_array($get_department, $provList)){
    $key = $get_department;
} else if(in_array($get_department, $diffdept)){
    $key = 'OU='.$get_department.',O=GC,C=CA';
} else if(in_array($get_department, $spaceDept)){
    $key = 'ou='.$get_department.',o=GC,c=CA';
} else if(in_array($get_department, $mixDept)){
    $key = 'ou='.$get_department.',O=GC,C=CA';
} else {
    $key = 'ou='.$get_department.', o=GC, c=CA';
}


$title = elgg_echo('c_bin:member_in', array($displayDept[$key]));

//get user count
$total_users = elgg_get_entities_from_metadata(array(
        'types' => 'user', 
        'metadata_names' => array('department'), 
        'metadata_values' => array($departmentsEn[$key]." / ".$departmentsFr[$key], $departmentsFr[$key]." / ".$departmentsEn[$key]), 
        'count' => true
    ));
elgg_push_context('member_by_dept');


//order of list and arrow display
$currentOrder = get_input('order');
if(!$currentOrder){
    $order = 'ASC';
    $arrows = '<span style="margin-left:3px"><i class="fa fa-lg fa-caret-down icon-sel" aria-hidden="true"></i><i class="fa fa-lg fa-caret-up icon-unsel" aria-hidden="true"></i></span>';
} else if($currentOrder == 'ASC') {
    $order = 'DESC';
    $arrows = '<span style="margin-left:3px"><i class="fa fa-lg fa-caret-down icon-unsel" aria-hidden="true"></i><i class="fa fa-lg fa-caret-up icon-sel" aria-hidden="true"></i></span>';
} else {
    $order = 'ASC';
    $arrows = '<span style="margin-left:3px"><i class="fa fa-lg fa-caret-down icon-sel" aria-hidden="true"></i><i class="fa fa-lg fa-caret-up icon-unsel" aria-hidden="true"></i></span>';
}


//filter links
$alphaLink = elgg_echo('c_bin:sort_by').'<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=alpha&order='.$order.'">'.elgg_echo('c_bin:sort_alpha').$arrows.'</a>';
$timeLink = '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=validate&order='.$order.'">'.elgg_echo('c_bin:sort_guid').$arrows.'</a>';



//which way we are sorting the list (alphabetical or date joined)
$sort = get_input('sort');

//set arrows to display correctly
if($sort){
    if($sort == 'alpha'){
        $sort_by = 'o.name';
        $timeLink = '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=validate&order=DESC">'.elgg_echo('c_bin:sort_guid').'</a>';
    } else if($sort == 'validate'){
        $sort_by = 'e.time_created';
        $alphaLink = elgg_echo('c_bin:sort_by').'<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=alpha&order=DESC">'.elgg_echo('c_bin:sort_alpha').'</a>';
    }
} else {
    $sort_by = 'o.name';
    $timeLink = '<a href="'.elgg_get_site_url().'members/gc_dept?dept='.$get_department.'&sort=validate&order=DESC">'.elgg_echo('c_bin:sort_guid').'</a>';
}

//place everything in content
$content = '<p>'. $alphaLink .' | '. $timeLink .'</p>';

$content .= elgg_list_entities_from_metadata(array(
        'types' => 'user', 
        'metadata_names' => array('department'), 
        'metadata_values' => array($departmentsEn[$key]." / ".$departmentsFr[$key], $departmentsFr[$key]." / ".$departmentsEn[$key]), 
        'pagination' => true,
        'limit' => 50,
        'context' => 'member_by_dept',
        'joins' => array("INNER JOIN {$CONFIG->dbprefix}users_entity o ON (e.guid = o.guid)"),
        'order_by' => $sort_by . ' ' . $order
    ));


$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title.' ('.$total_users.')',
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page']))
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

elgg_pop_context();