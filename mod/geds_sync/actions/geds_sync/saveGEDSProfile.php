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
		//turn JSON string to object
		$data = json_decode($data);

		$user = get_user($uid);

		//loop through all the data passed from table
		foreach ($data as $dataItem) {
			if ($dataItem->geds) {
				$user->set($dataItem->property, $dataItem->geds);
			}
		}
		if ($depAcc) {
			$user->set('depAcc', $depAcc);
		}
		if ($org) {
			$user->set('orgStruct', $org);
		}
		if ($orgFr) {
			$user->set('orgStructFr', $orgFr);
		}
		if ($loc) {
			$user->set('addressString', $loc);
			//add plain text version to location if field already filled out
			if ($user->location) {
				$locString = json_decode($loc);
				$user->set('location', $locString->street .','. $locString->city.' '. $locString->province);
			}
		}
		if ($locFr) {
			$user->set('addressStringFr', $locFr);
			//add plain text version to location if field already filled out
			if ($user->location) {
				$locString = json_decode($locFr);
				$user->set('location', $locString->street .','. $locString->city.' '. $locString->province);
			}
		}
		if ($gedsDN) {
			if ($gedsDN == 'DELETE_ME') {
				$user->set('gedsDN', '');
			} else {
				$user->set('gedsDN', $gedsDN);
			}
		}
		//save changes.
		$user->save();
		system_message(elgg_echo('geds:success'));
	}
