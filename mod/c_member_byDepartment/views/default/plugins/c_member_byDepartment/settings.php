<?php 

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;

$information_array = json_decode(file_get_contents($data_directory.'department_directory.json'));
$information_array = get_object_vars($information_array);

$last_member = elgg_get_entities(array('types' => 'user', 'limit' => '1'));
$last_member_saved = $information_array['members'];

if ($last_member[0]->getGUID() != $last_member_saved)
{
	echo 'there are some inconsistencies.. please update - $last_member='.$last_member[0]->getGUID().' $last_member_saved='.$last_member_saved.'<br/><br/>';
} else 
	echo 'everything seems to be in order :-)<br/><br/>';


$generate = "action/c_member_byDepartment/generate_report";
echo elgg_view('output/confirmlink', array(
	'name' => 'generate',
	'text' => elgg_echo('c_bin:regenerate_notice'),
	'href' => $generate,
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


echo '<br/><br/>';
	