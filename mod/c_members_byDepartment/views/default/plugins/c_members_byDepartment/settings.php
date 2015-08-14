<?php 

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;

if (file_exists($data_directory.'department_directory.json')) {
	$information_array = json_decode(file_get_contents($data_directory.'department_directory.json'));
	$information_array = get_object_vars($information_array);
	$last_guid_onFile = $information_array['members'];
} else {
	$last_guid_onFile = 0;
}

$last_guid_db = elgg_get_entities(array('types' => 'user', 'limit' => '1'));

echo 'Last member in <b>Database</b>: '.$last_guid_db[0]->getGUID().' | Last member on <b>File</b>: '.$last_guid_onFile.'<br/>';

if ($last_guid_db[0]->getGUID() != $last_guid_onFile)
	echo 'The files need to be updated, there are either new members or files are missing <br/><br/>';
else 
	echo 'Everything is up to date, need not do anything :-) <br/><br/>';


$generate_link = "action/c_members_byDepartment/generate_users";
echo elgg_view('output/confirmlink', array(
	'name' => 'generate1',
	'text' => elgg_echo('generate user'),
	'href' => $generate_link,
	'class' => 'elgg-button'
));
echo '<br/><br/>';

$generate_link = "action/c_members_byDepartment/generate_report";
echo elgg_view('output/confirmlink', array(
	'name' => 'generate',
	'text' => elgg_echo('c_bin:regenerate_notice'),
	'href' => $generate_link,
	'class' => 'elgg-button'
));
echo '<br/><br/>';

//$tagging = "action/c_member_byDepartment/tag_users";
//echo elgg_view('output/confirmlink', array(
//	'name' => 'tagging',
//	'text' => elgg_echo('c_bin:tag_notice'),
//	'href' => $tagging,
//	'class' => 'elgg-button'
//));

echo '<br/><br/>';
