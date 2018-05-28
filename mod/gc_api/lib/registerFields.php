<?php
elgg_ws_expose_function(
	"get.fields",
	"get_register_fields",
	array("id" => array('type' => 'string')),
	'return occupation fields data to populate dropdowns',
	'GET',
	false,
	false
);

function get_register_fields() {

	//university
	$uniObj = elgg_get_entities(array(
						'type' => 'object',
						'subtype' => 'universities',
					));
	$unis = get_entity($uniObj[0]->guid);

	$fields['academic']['university']['en'] = $unis->universities_en;
	$fields['academic']['university']['fr'] = $unis->universities_fr;

	$fields['student']['university']['en'] = $unis->universities_en;
	$fields['student']['university']['fr'] = $unis->universities_fr;

	//college
	$colObj = elgg_get_entities(array(
						'type' => 'object',
						'subtype' => 'colleges',
					));
	$cols = get_entity($colObj[0]->guid);

	$fields['academic']['college']['en'] = $cols->colleges_en;
	$fields['academic']['college']['fr'] = $cols->colleges_fr;

	$fields['student']['college']['en'] = $cols->colleges_en;
	$fields['student']['college']['fr'] = $cols->colleges_fr;

	//federal departments
	$deptObj = elgg_get_entities(array(
						'type' => 'object',
						'subtype' => 'federal_departments',
					));
	$depts = get_entity($deptObj[0]->guid);

	$fields['federal']['en'] = $depts->federal_departments_en;
	$fields['federal']['fr'] = $depts->federal_departments_fr;

	$fields['retired']['en'] = $depts->federal_departments_en;
	$fields['retired']['fr'] = $depts->federal_departments_fr;

	//provincial
	$provObj = elgg_get_entities(array(
						'type' => 'object',
						'subtype' => 'provinces',
					));
	$provs = get_entity($provObj[0]->guid);

	$fields['provincial']['en'] = $provs->provinces_en;
	$fields['provincial']['fr'] = $provs->provinces_fr;

	$minObj = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'ministries',
		));
	$mins = get_entity($minObj[0]->guid);

	//create more usable keys
	$enMin = json_decode($mins->ministries_en, true);
	foreach($enMin as $province => $ministry){
		$enMin[str_replace(" ", "", strtolower($province))] = $ministry;
		 unset($enMin[$province]);
	}
	$frMin = json_decode($mins->ministries_fr, true);
	foreach($frMin as $province => $ministry){
		$frMin[str_replace(" ", "", strtolower($province))] = $ministry;
		 unset($frMin[$province]);
	}

	$fields['provincial']['ministry']['en'] = json_encode($enMin);
	$fields['provincial']['ministry']['fr'] = json_encode($frMin);
	
	//municipal
	$fields['municipal']['en'] = $provs->provinces_en;
	$fields['municipal']['fr'] = $provs->provinces_fr;

	//municipal
	$fields['municipal']['en'] = $provs->provinces_en;
	$fields['municipal']['fr'] = $provs->provinces_fr;

	//other
	$otherObj = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'other',
	));
	$others = get_entity($otherObj[0]->guid);

	$fields['other']['en'] = $others->other_en;
	$fields['other']['fr'] = $others->other_fr;

	return $fields;

}
?>
