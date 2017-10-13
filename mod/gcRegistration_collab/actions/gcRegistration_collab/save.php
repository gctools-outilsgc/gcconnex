<?php

$type = get_input('type');
$id = get_input('id');
$province = get_input('province');
$key = $dept_en = get_input('dept_en');
$dept_fr = get_input('dept_fr');

if( !empty($type) && !empty($key) && !empty($dept_en) && !empty($dept_fr) ){
	if($type == 'federal'){
		$deptObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'federal_departments',
		));
		$departments = get_entity($deptObj[0]->guid);

		$depts_en = json_decode($departments->federal_departments_en, true);
		$depts_fr = json_decode($departments->federal_departments_fr, true);

		if( isset($id) ){
			$depts_en[$id] = $dept_en;
			$depts_fr[$id] = $dept_fr;
		} else {
			$depts_en[$key] = $dept_en;
			$depts_fr[$key] = $dept_fr;
		}

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

		if( isset($id) ){
			$mins_en[$province][$id] = $dept_en;
			$mins_fr[$province][$id] = $dept_fr;
		} else {
			$mins_en[$province][$key] = $dept_en;
			$mins_fr[$province][$key] = $dept_fr;
		}

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

		if( isset($id) ){
			$unis_en[$id] = $dept_en;
			$unis_fr[$id] = $dept_fr;
		} else {
			$unis_en[$key] = $dept_en;
			$unis_fr[$key] = $dept_fr;
		}

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

		if( isset($id) ){
			$cols_en[$id] = $dept_en;
			$cols_fr[$id] = $dept_fr;
		} else {
			$cols_en[$key] = $dept_en;
			$cols_fr[$key] = $dept_fr;
		}

		$colleges->set('colleges_en', json_encode($cols_en));
		$colleges->set('colleges_fr', json_encode($cols_fr));
		$colleges->save();

		echo true;
	} else if($type == 'municipal'){
		$munObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'municipal',
		));
		$municipals = get_entity($munObj[0]->guid);
		$municipals_province = json_decode($municipals->get($province), true);

		if( isset($id) ){
			$municipals_province[$id] = $dept_en;
		} else {
			$municipals_province[$key] = $dept_en;
		}

		$municipals->set($province, json_encode($municipals_province));
		$municipals->save();

		echo true;
	} else if($type == 'other'){
		$otherObj = elgg_get_entities(array(
		   	'type' => 'object',
		   	'subtype' => 'other',
		));
		$others = get_entity($otherObj[0]->guid);

		$others_en = json_decode($others->other_en, true);
		$others_fr = json_decode($others->other_fr, true);

		if( isset($id) ){
			$others_en[$id] = $dept_en;
			$others_fr[$id] = $dept_fr;
		} else {
			$others_en[$key] = $dept_en;
			$others_fr[$key] = $dept_fr;
		}

		$others->set('other_en', json_encode($others_en));
		$others->set('other_fr', json_encode($others_fr));
		$others->save();

		echo true;
	}
} else {
	echo false;
}
