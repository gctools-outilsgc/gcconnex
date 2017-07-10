<style type="text/css">
	table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
	table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	.save-button		{ margin-top: 10px; }
	.active 			{ font-weight: bold; text-decoration: underline; }
	.ext, .dept 		{ font-size: 14px; width: 100%; }
	input:disabled 		{ background: #ddd; }
	.edit-message 		{ font-weight: bold; }
	.elgg-form-settings	{ max-width: none; }
</style>

<script type="text/javascript">
	$(function() {
		function toggleButtons(key){
			$('input[data-id=' + key + ']').prop("disabled", function(i, v){ return !v; });
		    $('a.edit-extension[data-id=' + key + ']').toggleClass('hidden');
		    $('a.cancel-extension[data-id=' + key + ']').toggleClass('hidden');
		    $('a.save-extension[data-id=' + key + ']').toggleClass('hidden');
		}

		function showMessage(key, msg){
			$('span.edit-message[data-id=' + key + ']').show().text(msg).delay(2000).fadeOut();
		}

		$("a.edit-extension, a.cancel-extension").click(function(e){
			e.preventDefault();
		    var id = $(this).data('id');
		    toggleButtons(id);
		    if($(this).hasClass("edit-extension")){ $('input.ext[data-id=' + id + ']').focus(); }
		});

		$("a.save-extension").click(function(e){
			e.preventDefault();
		    var id = $(this).data('id');
		    var ext = $('input.ext[data-id=' + id + ']').val();
		    var dept = $('input.dept[data-id=' + id + ']').val();

		    elgg.action('c_email_extensions/edit', {
			 	data: {
			    	id: id,
			    	ext: ext,
			    	dept: dept
				},
			  	success: function (wrapper) {
				    if (wrapper.output == 1) {
				    	showMessage(id, "Saved!");
				    	toggleButtons(id);
				    } else {
				    	showMessage(id, "Error!");
				    }
			  	},
			    error: function (jqXHR, textStatus, errorThrown) {
			        console.log("Error: " + errorThrown);
				    showMessage(id, "Error!");
			    }
			});
		});
	});
</script>

<div>

<?php

elgg_load_library('c_ext_lib');


if (($vars['entity']->db_add_ext === '' || !isset($vars['entity']->db_add_ext)) && ($vars['entity']->db_add_dept === '' || !isset($vars['entity']->db_add_dept)))
{
	// nothing here
} else
	addExtension($vars['entity']->db_add_ext, $vars['entity']->db_add_dept);

function getActiveClass($type, $value){
	return ($_GET[$type] == $value) ? " class='active'" : "";
}

$vars['entity']->db_add_ext = '';
$vars['entity']->db_add_dept = '';


elgg_load_library('c_ext_lib');

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

echo '<br/>';
echo "<table name='add_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
echo '<tr> <th>'.elgg_echo('c_ext:add_new_ext').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('c_ext:ext').':'.$add_ext_field.'<br/>';
echo elgg_echo('c_ext:dept').':'.$add_dept_field.'<br/>';
//echo $add_btn.'<br/>';
echo '</td></tr>';
echo "</table>";

$plugin = $vars['entity'];
$plugin_id = $plugin->getID();
$user_guid = elgg_extract('user_guid', $vars, elgg_get_logged_in_user_guid());

echo '<div class="save-button">';
echo elgg_view('input/hidden', array('name' => 'plugin_id', 'value' => $plugin_id));
echo elgg_view('input/hidden', array('name' => 'user_guid', 'value' => $user_guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save')));
echo '</div>';

echo '<br/>';

$delete_from_db = "action/c_email_extensions/delete";
$delete_btn = elgg_view('output/confirmlink', array(
	'name' => 'c_delete_from_db',
	'text' => elgg_echo('c_ext:delete'),
	'href' => $delete_from_db));

$domains = getExtension();

if (count($domains) > 0) {

	echo "<table name='display_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
	echo '<thead><tr> <th></th> <th width="10%">'.elgg_echo('c_ext:id').'</th> <th>'.elgg_echo('c_ext:ext').'</th> <th>'.elgg_echo('c_ext:dept').'</th> <th width="10%"></th> </tr></thead>';
	while( $domain = $domains->fetch_assoc() ){
		$delete_from_db = "action/c_email_extensions/delete?id=" . $domain['id'];
		$delete_btn = elgg_view('output/confirmlink', array(
			'name' => 'c_delete_from_db',
			'text' => elgg_echo('c_ext:delete'),
			'href' => $delete_from_db));

		echo "<tbody><tr>"; 
		echo "<td>{$delete_btn}</td>";
		echo "<td>" . $domain['id'] . "</td>";
		echo "<td><input class='ext' data-id='" . $domain['id'] . "' type='text' value='" . $domain['ext'] . "' disabled /></td>";
		echo "<td><input class='dept' data-id='" . $domain['id'] . "' type='text' value='" . $domain['dept'] . "' disabled /></td>";
		echo "<td><a class='edit-extension' data-id='" . $domain['id'] . "' href='#'>".elgg_echo('edit')."</a> <a class='cancel-extension hidden elgg-button only-one-click elgg-button-cancel btn btn-default' data-id='" . $domain['id'] . "' href='#'>".elgg_echo('cancel')."</a> <a class='save-extension hidden elgg-button only-one-click elgg-button-submit btn btn-primary' data-id='" . $domain['id'] . "' href='#'>".elgg_echo('save')."</a> <br> <span class='edit-message' data-id='" . $domain['id'] . "'></span></td>";
		echo "</tr></tbody>";
	}
	echo "</table>";
}

?>

</div>