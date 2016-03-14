<?php

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward();
}

$listEn = get_input('listEn');
$listFr = get_input('listFr');

$obj = elgg_get_entities(array(
   	'type' => 'object',
   	'subtype' => 'dept_list',
   	'owner_guid' => elgg_get_logged_in_user_guid()
));
if (!$obj){
	$depts = new ElggObject();
	$depts->subtype = "dept_list";
	$depts->title = "depts";
	$depts->access_id = ACCESS_PUBLIC;


	$depts->set('deptsEn',$listEn);
	
	$depts->set('deptsFr',$listFr);
	$depts_guid1 = $depts->save();

}else{
	if($obj[0]->title == 'deptsEn'){
		$en = 0;
		$fr = 1;
	}else{
		$en = 1;
		$fr = 0;
	}
	if ($obj[0]->deptsEn!=$listEn){
		$enList = get_entity($obj[0]->guid);
		$meta = elgg_get_metadata(array(
			'metadata_name' => 'deptsEn',
		));
		if($meta){
			foreach ($meta as $x){
				$x->delete();
			}
		}
		$enList->set('deptsEn',$listEn);// = "test";
		$enList->save();
		
	}
	if ($obj[0]->deptsFr!=$listFr){
		$frList = get_entity($obj[0]->guid);
		$meta = elgg_get_metadata(array(
			'metadata_name' => 'deptsFr',
		));
		if($meta){
			foreach ($meta as $x){
				$x->delete();
			}
		}
		$frList->set('deptsFr',$listFr);// = "test";
		$frList->save();
		
	}
}
//echo $obj[0]->description;


