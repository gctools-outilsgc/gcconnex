<style type="text/css">
	table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
	table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>


<div>

<?php

elgg_load_library('c_ext_lib');

// elgg_log('cyu - add ext:'.$vars['entity']->db_add_ext, 'NOTICE');
// elgg_log('cyu - add dept:'.$vars['entity']->db_add_dept, 'NOTICE');

if (($vars['entity']->db_add_ext === '' || !isset($vars['entity']->db_add_ext)) 
	&& ($vars['entity']->db_add_dept === '' || !isset($vars['entity']->db_add_dept)))
{
	//system_message('c_ext:missing_param');
} else {
	addExtension($vars['entity']->db_add_ext, $vars['entity']->db_add_dept);
	//system_message('c_ext:successfully_added');
}


$vars['entity']->db_add_ext = '';
$vars['entity']->db_add_dept = '';


elgg_load_library('c_ext_lib');

$delete_from_db = "action/c_email_extensions/delete";
$delete_btn = elgg_view('output/confirmlink', array(
	'name' => 'c_delete_from_db',
	'text' => elgg_echo('c_ext:delete'),
	'href' => $delete_from_db));

$result = getExtension();
if (count($result) > 0)
{
	echo "<table name='display_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
	echo '<tr> <th></th> <th width="16%">'.elgg_echo('c_ext:id').'</th> <th>'.elgg_echo('c_ext:ext').'</th> <th>'.elgg_echo('c_ext:dept').'</th></tr>';
	while ($row = mysqli_fetch_array($result))
	{
		$delete_from_db = "action/c_email_extensions/delete?id=".$row['id'];
		$delete_btn = elgg_view('output/confirmlink', array(
			'name' => 'c_delete_from_db',
			'text' => elgg_echo('c_ext:delete'),
			'href' => $delete_from_db));

		echo '<tr>'; 
		echo '<td> '.''.$delete_btn.' </td>';
		echo '<td> '.$row['id'].' </td>';
		echo '<td> '.$row['ext'].' </td>';
		echo '<td> '.$row['dept'].' </td>';
		echo '</tr>';
	}
	echo "</table>";
}

echo '<br/>';

	
$add_to_db = "action/c_email_extensions/add";
$add_btn = elgg_view('output/confirmlink', array(
	'name' => 'c_add_to_db',
	'text' => elgg_echo('c_ext:add'),
	'href' => $add_to_db,
	'class' => 'elgg-button'));

$add_ext_field = elgg_view('input/text', array(
	'name' => 'params[db_add_ext]',
	'value' => $vars['entity']->db_add_ext));

$add_dept_field = elgg_view('input/text', array(
	'name' => 'params[db_add_dept]',
	'value' => $vars['entity']->db_add_dept));

echo "<table name='add_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
echo '<tr> <th>'.elgg_echo('c_ext:add_new_ext').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('c_ext:ext').':'.$add_ext_field.'<br/>';
echo elgg_echo('c_ext:dept').':'.$add_dept_field.'<br/>';
//echo $add_btn.'<br/>';
echo '</td></tr>';
echo '<br/>';
echo "</table>";

?>

</div>