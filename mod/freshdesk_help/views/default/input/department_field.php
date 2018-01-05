<?php

//get department list
$obj = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'dept_list',
    'owner_guid' => 0
));

$provincesEn = array();

$departmentsEn = $obj[0]->deptsEn;
$provincesEn['pov-alb'] = 'Government of Alberta';
$provincesEn['pov-bc'] = 'Government of British Columbia';
$provincesEn['pov-man'] = 'Government of Manitoba';
$provincesEn['pov-nb'] = 'Government of New Brunswick';
$provincesEn['pov-nfl'] = 'Government of Newfoundland and Labrador';
$provincesEn['pov-ns'] = 'Government of Nova Scotia';
$provincesEn['pov-nwt'] = 'Government of Northwest Territories';
$provincesEn['pov-nun'] = 'Government of Nunavut';
$provincesEn['pov-ont'] = 'Government of Ontario';
$provincesEn['pov-pei'] = 'Government of Prince Edward Island';
$provincesEn['pov-que'] = 'Government of Quebec';
$provincesEn['pov-sask'] = 'Government of Saskatchewan';
$provincesEn['pov-yuk'] = 'Government of Yukon';

$departmentsEn = json_decode($departmentsEn, true);
array_merge($departmentsEn, $provincesEn);

$provincesFr = array();

$departmentsFr = $obj[0]->deptsFr;
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

$departmentsFr = json_decode($departmentsFr, true);
array_merge($departmentsFr, $provincesFr);

//create better options_values
$options = array();
$lang = get_input('lang');
if(!$lang){ $lang = get_current_language();}
if($lang == 'en'){
  foreach($departmentsEn as $k => $v){
    $options[$departmentsEn[$k].' / '.$departmentsFr[$k]] = $departmentsEn[$k];
  }
} else {
  foreach($departmentsFr as $k => $v){
    $options[$departmentsEn[$k].' / '.$departmentsFr[$k]] = $departmentsFr[$k];
  }
}

if(elgg_is_logged_in()){
  $value = elgg_get_logged_in_user_entity()->department;

  $value = explode(" / ", $value);

  $key = array_search($value[0], $options);
  if ($key === false){
      $key = array_search($value[1], $options);
  }
}

$none = array();
$none['None'] = '...';

echo elgg_view('input/select', array(
  'name' => 'department',
  'id' => 'department',
  'required' => 'required',
  'class' => 'form-control',
  'value' => $key,
  'options_values' => array_merge($none, $options),
));
?>
