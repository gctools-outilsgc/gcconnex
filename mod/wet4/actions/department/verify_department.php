<?php

//get input value
$department = get_input('department');



//save department
$obj = elgg_get_entities(array(
   							'type' => 'object',
   							'subtype' => 'dept_list',
   							'owner_guid' => 0
						));
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

$departmentsFr = json_decode($obj[0]->deptsFr, true);
$provincesFr['pov-alb'] = "Gouvernement de l'Alberta";
$provincesFr['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
$provincesFr['pov-man'] = 'Gouvernement du Manitoba';
$provincesFr['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
$provincesFr['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
$provincesFr['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
$provincesFr['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
$provincesFr['pov-nun'] = 'Gouvernement du Nunavut';
$provincesFr['pov-ont'] = "Gouvernement de l'Ontario";
$provincesFr['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
$provincesFr['pov-que'] = 'Gouvernement du Québec';
$provincesFr['pov-sask'] = 'Gouvernement de Saskatchewan';
$provincesFr['pov-yuk'] = 'Gouvernement du Yukon';
$departmentsFr = array_merge($departmentsFr,$provincesFr);

if (get_current_language()=='en'){
    $deptString = $departmentsEn[$department]." / ".$departmentsFr[$department];
}else{
    $deptString = $departmentsFr[$department]." / ".$departmentsEn[$department];
}

//save dept
elgg_get_logged_in_user_entity()->department = $deptString;
//save time
elgg_get_logged_in_user_entity()->last_department_verify = time();

system_message($deptString );
    ?>