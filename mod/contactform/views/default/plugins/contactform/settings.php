<?php 
$email = $vars['entity']->email;
$list1 = $vars['entity']->list1;
$loginreq = $vars['entity']->loginreq;
if (!$loginreq) { $loginreq = 'yes'; }		
?>

<p>
<?php
echo elgg_echo('contactform:enteremail');
echo elgg_view('input/text', array(
    'name'  => 'params[email]',
    'value' => $email,
));
echo "<div>";
	echo elgg_echo('contactform:loginreqmsg') . ' ';
	echo elgg_view('input/dropdown', array(
		'name' => 'params[loginreq]',
		'options_values' => array(
			'no' => elgg_echo('contactform:no'),
			'yes' => elgg_echo('contactform:yes'),
		),
		'value' => $loginreq,
	));
echo "</div>";
?>
<style type="text/css">
	table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
	table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>


<div>


<?php



// elgg_log('cyu - add ext:'.$vars['entity']->db_add_eng, 'NOTICE');
// elgg_log('cyu - add dept:'.$vars['entity']->db_add_fr, 'NOTICE');

if (($vars['entity']->db_add_eng === '' || !isset($vars['entity']->db_add_eng)) 
	&& ($vars['entity']->db_add_fr === '' || !isset($vars['entity']->db_add_fr)))
{
	//system_message('c_ext:missing_param');
} else {
	addExtension2($vars['entity']->db_add_eng, $vars['entity']->db_add_fr);
	//system_message('c_ext:successfully_added');
}


$vars['entity']->db_add_eng = '';
$vars['entity']->db_add_fr = '';


elgg_load_library('contact_lib');

$delete_from_db = "action/c_email_extensions/delete";
$delete_btn = elgg_view('output/confirmlink', array(
	'name' => 'c_delete_from_db',
	'text' => elgg_echo('setting:delete'),
	'href' => $delete_from_db));

$result = getExtension2();
if (count($result) > 0)
{
	echo "<table name='display_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
	echo '<tr> <th></th> <th>'.elgg_echo('setting:eng').'</th> <th>'.elgg_echo('setting:fr').'</th></tr>';
	while ($row = mysqli_fetch_array($result))
	{
		$delete_from_db = "action/contactform/delete?id=".$row['id'];
		$delete_btn = elgg_view('output/confirmlink', array(
			'name' => 'c_delete_from_db',
			'text' => elgg_echo('setting:delete'),
			'href' => $delete_from_db));

		echo '<tr>'; 
		echo '<td> '.''.$delete_btn.' </td>';
		
		echo '<td> '.$row['english'].' </td>';
		echo '<td> '.$row['francais'].' </td>';
		echo '</tr>';
	}
	echo "</table>";
}

echo '<br/>';

	
$add_to_db = "action/contactform/add";
$add_btn = elgg_view('output/confirmlink', array(
	'name' => 'c_add_to_db',
	'text' => elgg_echo('setting:add'),
	'href' => $add_to_db,
	'class' => 'elgg-button'));

$add_ext_field = elgg_view('input/text', array(
	'name' => 'params[db_add_eng]',
    'id' => 'eng',
	'value' => $vars['entity']->db_add_eng));

$add_dept_field = elgg_view('input/text', array(
	'name' => 'params[db_add_fr]',
    'id' => 'fr',
	'value' => $vars['entity']->db_add_fr));
    

echo "<table name='add_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
echo '<tr> <th>'.elgg_echo('setting:field').'</th> </tr>';
echo '<tr><td>';
echo '<label for="eng">'.elgg_echo('setting:eng').'</label>:'.$add_ext_field.'<br/>';
echo '<label for="fr">'.elgg_echo('setting:fr').'</label>:'.$add_dept_field.'<br/>';
//echo $add_btn.'<br/>';
echo '</td></tr>';
echo '<br/>';
echo "</table>";

?>

</div>

