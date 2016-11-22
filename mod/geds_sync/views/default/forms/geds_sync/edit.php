<?php
/*
* This is the edit access form for location and org metadata
* This form is an element of the edit page '../geds_sync/edit'
*
*  Hitting save will trigger the edit action (../actions/geds_sync/edit_access.php)
*/
echo elgg_echo('geds:org:access:label');

// we get the current access id and use it to set the value of the drop down. 
//This way the page will load with the current access rights already set in the drop down
$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0, 
		// we only grab the english value as the english and french access should always be the same
		'metadata_names' => array('orgStruct')
	);
$metadata = elgg_get_metadata($options);
echo elgg_view('input/access', array(
	'name' => 'org_access_id',
	'value' => $metadata[0]->access_id //elgg_get_metadata returns an array, just use element 0
));


echo "</br></br>";
echo elgg_echo('geds:loc:access:label');

// grab current value of address metadata to set value of dropdown
$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0,
		'metadata_names' => array('addressString')
	);

$metadata = elgg_get_metadata($options);

echo elgg_view('input/access', array(
	'name' => 'loc_access_id',
	'value' => $metadata[0]->access_id
));

echo "</br>";
//submit triggers edit_access.php action
echo elgg_view('input/submit', array(
	'value' => elgg_echo('geds:save'),
	'name' => 'save',
));