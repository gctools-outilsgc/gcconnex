<?php
	/*
	* saveGEDSProfile.php
	* action file that saves metadata from geds sync to users profile
	*/

	//make sure this is an ajax call
	if (elgg_is_xhr()) {
		//get various inputs passed 
		$uid = get_input('guid');
		$data = get_input('data');
		$depAcc = get_input('depAcc');
		$org = get_input('orgStruct');
		$orgFr = get_input('orgStructFr');
		$loc = get_input('address');
		$locFr = get_input('addressFr');
		
		$gedsDN = get_input('gedsDN');
		//$data = utf8_encode($data);
		//turn JSON string to object
		$data = json_decode($data);
		
		$user = get_user($uid);
		
		//loop through all the data passed from table
		foreach($data as $dataItem){

			if($dataItem->geds){
				$user->set($dataItem->property, $dataItem->geds);
			}
			
			
		}
		if ($depAcc){
			$user->set('depAcc', $depAcc);
		}
		if ($org){
			$user->set('orgStruct', $org);
		}
		if ($orgFr){
			$user->set('orgStructFr', $orgFr);
		}
		if ($loc){
			$user->set('addressString', $loc);
		}
		if ($locFr){
			$user->set('addressStringFr', $locFr);
		}
		if ($gedsDN){
			if($gedsDN == 'DELETE_ME'){
				$user->set('gedsDN', '');
			}else{
				$user->set('gedsDN', $gedsDN);
			}
			
		}
		//save changes.
		$user->save();
		system_message(elgg_echo('geds:success'));
		
	}
