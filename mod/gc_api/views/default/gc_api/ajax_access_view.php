<?php
/*
 * filename: ajax_access_view.php
 * author: Troy T. Lawson
 * purpose: gets group guid from share form and re-builds access drop down list 
 */

//if (elgg_is_xhr()) {
	$guid = $_GET["guid"];
	//get default options
	$defaultAccess = get_write_access_array();
	//if group is selected
	if ($guid != 'NA'){
		//get access collection object belonging to guid
		$groupAC = get_user_access_collections($guid);
		//add group access level to array containing default options
		$defaultAccess[$groupAC[0]->id] = $groupAC[0]->name;
	
	}
	//build dropdown
	echo elgg_view('input/access', array(
			'name' => 'access_id',
			'value' => 2,
    	   	'id' => 'access_id',
			'entity_type' => 'object',
			'entity_subtype' => 'bookmarks',
			'options_values' => $defaultAccess //custom options
		)); 
		
//}
?>