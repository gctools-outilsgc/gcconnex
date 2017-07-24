<?php

$type = get_input('type');
$key = get_input('key');
$province = get_input('province');

if( !empty($type) && !empty($key) ){
	if($type == 'federal'){
		$deptObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'federal_departments',
		));
		$departments = get_entity($deptObj[0]->guid);

		$depts_en = json_decode($departments->federal_departments_en, true);
		$depts_fr = json_decode($departments->federal_departments_fr, true);

		unset($depts_en[$key]);
		unset($depts_fr[$key]);

		$departments->set('federal_departments_en', json_encode($depts_en));
		$departments->set('federal_departments_fr', json_encode($depts_fr));
		$departments->save();

		echo true;
	} else if($type == 'ministries'){
		$minObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'ministries',
		));
		$ministries = get_entity($minObj[0]->guid);

		$mins_en = json_decode($ministries->ministries_en, true);
		$mins_fr = json_decode($ministries->ministries_fr, true);

		unset($mins_en[$province][$key]);
		unset($mins_fr[$province][$key]);

		$ministries->set('ministries_en', json_encode($mins_en));
		$ministries->set('ministries_fr', json_encode($mins_fr));
		$ministries->save();

		echo true;
	} else if($type == 'universities'){
		$uniObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'universities',
		));
		$universities = get_entity($uniObj[0]->guid);

		$unis_en = json_decode($universities->universities_en, true);
		$unis_fr = json_decode($universities->universities_fr, true);

		unset($unis_en[$key]);
		unset($unis_fr[$key]);

		$universities->set('universities_en', json_encode($unis_en));
		$universities->set('universities_fr', json_encode($unis_fr));
		$universities->save();

		echo true;
	} else if($type == 'colleges'){
		$colObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'colleges',
		));
		$colleges = get_entity($colObj[0]->guid);

		$cols_en = json_decode($colleges->colleges_en, true);
		$cols_fr = json_decode($colleges->colleges_fr, true);

		unset($cols_en[$key]);
		unset($cols_fr[$key]);

		$colleges->set('colleges_en', json_encode($cols_en));
		$colleges->set('colleges_fr', json_encode($cols_fr));
		$colleges->save();

		echo true;
	} else if($type == 'other'){
		$otherObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'other',
		));
		$others = get_entity($otherObj[0]->guid);

		$others_en = json_decode($others->other_en, true);
		$others_fr = json_decode($others->other_fr, true);

		unset($others_en[$key]);
		unset($others_fr[$key]);

		$others->set('other_en', json_encode($others_en));
		$others->set('other_fr', json_encode($others_fr));
		$others->save();

		echo true;
	}
} else {
	echo false;
}
