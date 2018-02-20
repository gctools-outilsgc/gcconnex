<style type="text/css">
	table.depts     				{ width: 100%; border-right:1px solid #ccc; border-bottom:1px solid #ccc; margin-top: 10px; }
	table.depts th 					{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.depts td 					{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	.save-button					{ margin-top: 10px; }
	.dept_en, .dept_fr 				{ font-size: 14px; width: 100%; }
	select 							{ width: 98%; margin-bottom: 5px; }
	input:disabled 					{ background: #ddd; }
	.edit-message 					{ font-weight: bold; }
	.elgg-tabs ul 					{ display: inline-block; }
	.elgg-foot input[type=submit] 	{ display: none; }
</style>

<script type="text/javascript">
	$(function() {
		function toggleButtons(key, province){
			if(province){
				$('input[data-id="' + key + '"][data-province="' + province + '"]').prop("disabled", function(i, v){ return !v; });
			    $('a.save[data-id="' + key + '"][data-province="' + province + '"]').toggleClass('hidden');
			    $('a.cancel[data-id="' + key + '"][data-province="' + province + '"]').toggleClass('hidden');
			} else {
				$('input[data-id="' + key + '"]').prop("disabled", function(i, v){ return !v; });
			    $('a.save[data-id="' + key + '"]').toggleClass('hidden');
			    $('a.cancel[data-id="' + key + '"]').toggleClass('hidden');
			}
		}

		function showMessage(key, msg){
			$('span.edit-message[data-id="' + key + '"]').show().text(msg).delay(2000).fadeOut();
		}

		$("a.add").click(function(e){
			e.preventDefault();
		    var type = $(this).data('type');
		    var province = (type == 'ministries' || type == 'municipal') ? $("select[name=provincial]").val() : "";

		    var dept_en = $("#add-" + type + "-en").val();
		    var dept_fr = $("#add-" + type + "-fr").val();

		    if(dept_en !== "" && dept_fr !== ""){
			    elgg.action('gcRegistration_collab/save', {
				 	data: {
				    	type: type,
				    	province: province,
				    	dept_en: dept_en,
				    	dept_fr: dept_fr,
					},
				  	success: function (wrapper) {
					    if (wrapper.output == 1) {
					    	console.log("Saved!");
					    	elgg.system_message('Saved!');
					    	location.reload(true);
					    } else {
					    	console.log("Error!");
					    }
				  	},
				    error: function (jqXHR, textStatus, errorThrown) {
				        console.log("Error: " + errorThrown);
				    }
				});
		    }
		});

		$("a.edit, a.cancel").click(function(e){
			e.preventDefault();
		    var id = $(this).data('id');
		    var province = $(this).data('province');
		    toggleButtons(id, province);
		    if($(this).hasClass("edit")){ $('input.dept_en[data-id="' + id + '"][data-province="' + province + '"]').focus(); }
		});

		$("a.save").click(function(e){
			e.preventDefault();
		    var type = $(this).data('type');
		    var id = $(this).data('id');
		    var province = (type == 'ministries' || type == 'municipal') ? $(this).data('province') : "";

		    var dept_en = $('input.dept_en[data-id="' + id + '"]').val();
		    var dept_fr = $('input.dept_fr[data-id="' + id + '"]').val();

		    if(dept_en !== "" && dept_fr !== ""){
			 	elgg.action('gcRegistration_collab/save', {
				 	data: {
					    type: type,
					    id: id,
					    province: province,
				    	dept_en: dept_en,
				    	dept_fr: dept_fr,
					},
				  	success: function (wrapper) {
					    if (wrapper.output == 1) {
					    	showMessage(id, "Saved!");
					    	toggleButtons(id, province);
					    } else {
					    	showMessage(id, "Error!");
					    }
				  	},
				    error: function (jqXHR, textStatus, errorThrown) {
				        console.log("Error: " + errorThrown);
					    showMessage(id, "Error!");
				    }
				});
			}
		});

		$("#tabs").tabs({ active: 0 });
		$(".elgg-tabs li").first().addClass('elgg-state-selected');

		$(".elgg-tabs li a").click(function() {
			var parent = $(this).parent();
			parent.addClass('elgg-state-selected').siblings().removeClass('elgg-state-selected');
		});
	});
</script>

<div>

<?php

function deptSort($a, $b){
    return ($a[0] < $b[0]) ? -1 : 1;
}

echo '<br />';
echo '<div id="tabs"><ul class="elgg-tabs">
	<li><a href="#federal">Federal</a></li>
	<li><a href="#universities">Universities</a></li>
	<li><a href="#colleges">Colleges</a></li>
	<li><a href="#provincial">Provincial/Territorial</a></li>
	<li><a href="#municipal">Municipal</a></li>
	<li><a href="#other">Other</a></li></ul>';

// Start Federal Departments tab
echo '<div id="federal">';

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:department').' (EN): '.elgg_view('input/text', array('id' => 'add-federal-en')).'<br/>';
echo elgg_echo('gcRegister:department').' (FR): '.elgg_view('input/text', array('id' => 'add-federal-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="federal" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$deptObj = elgg_get_entities(array(
   	'type' => 'object',
   	'subtype' => 'federal_departments',
));
$departments = get_entity($deptObj[0]->guid);
$depts_en = json_decode($departments->federal_departments_en, true);
$depts_fr = json_decode($departments->federal_departments_fr, true);
ksort($depts_en);

if (count($depts_en) > 0) {
	echo '<table class="depts">';
	echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:department').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:department').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
	foreach ($depts_en as $key => $dept) {
		$delete_btn = elgg_view('output/confirmlink',
			array(
				'text' => elgg_echo('delete'),
				'href' => "action/gcRegistration_collab/delete?type=federal&key=" . $key
			)
		);

		echo '<tr>'; 
		echo '<td>'.$delete_btn.'</td>';
		echo '<td> <input class="dept_en" data-id="'.$key.'" type="text" value="'.$dept.'" disabled /> </td>';
		echo '<td> <input class="dept_fr" data-id="'.$key.'" type="text" value="'.$depts_fr[$key].'" disabled /> </td>';
		echo '<td> <a class="edit" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="federal" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

echo '</div>';
// End Federal Departments tab

// Start Universities tab
echo '<div id="universities">';

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:university').' (EN): '.elgg_view('input/text', array('id' => 'add-universities-en')).'<br/>';
echo elgg_echo('gcRegister:university').' (FR): '.elgg_view('input/text', array('id' => 'add-universities-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="universities" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$uniObj = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'universities',
));
$unis = get_entity($uniObj[0]->guid);
$unis_en = json_decode($unis->universities_en, true);
$unis_fr = json_decode($unis->universities_fr, true);
ksort($unis_en);

if (count($unis_en) > 0) {
	echo '<table class="depts">';
	echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:university').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:university').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
	foreach ($unis_en as $key => $uni) {
		$delete_btn = elgg_view('output/confirmlink',
			array(
				'text' => elgg_echo('delete'),
				'href' => "action/gcRegistration_collab/delete?type=universities&key=" . $key
			)
		);

		echo '<tr>'; 
		echo '<td>'.$delete_btn.'</td>';
		echo '<td> <input class="dept_en" data-id="'.$key.'" type="text" value="'.$uni.'" disabled /> </td>';
		echo '<td> <input class="dept_fr" data-id="'.$key.'" type="text" value="'.$unis_fr[$key].'" disabled /> </td>';
		echo '<td> <a class="edit" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="universities" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

echo '</div>';
// End Universities tab

// Start Colleges tab
echo '<div id="colleges">';

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:college').' (EN): '.elgg_view('input/text', array('id' => 'add-colleges-en')).'<br/>';
echo elgg_echo('gcRegister:college').' (FR): '.elgg_view('input/text', array('id' => 'add-colleges-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="colleges" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$colObj = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'colleges',
));
$cols = get_entity($colObj[0]->guid);
$cols_en = json_decode($cols->colleges_en, true);
$cols_fr = json_decode($cols->colleges_fr, true);
ksort($cols_en);

if (count($cols_en) > 0) {
	echo '<table class="depts">';
	echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:college').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:college').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
	foreach ($cols_en as $key => $col) {
		$delete_btn = elgg_view('output/confirmlink',
			array(
				'text' => elgg_echo('delete'),
				'href' => "action/gcRegistration_collab/delete?type=colleges&key=" . $key
			)
		);

		echo '<tr>'; 
		echo '<td>'.$delete_btn.'</td>';
		echo '<td> <input class="dept_en" data-id="'.$key.'" type="text" value="'.$col.'" disabled /> </td>';
		echo '<td> <input class="dept_fr" data-id="'.$key.'" type="text" value="'.$cols_fr[$key].'" disabled /> </td>';
		echo '<td> <a class="edit" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="colleges" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

echo '</div>';
// End Colleges tab

// Start Provincial/Territorial Departments tab
echo '<div id="provincial">';

$provObj = elgg_get_entities(array(
   	'type' => 'object',
   	'subtype' => 'provinces',
));
$provs = get_entity($provObj[0]->guid);
$provincial_departments = json_decode($provs->provinces_en, true);

// default to invalid value, so it encourages users to select
$provincial_choices = elgg_view('input/select', array(
	'name' => 'provincial',
	'options_values' => $provincial_departments,
));

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:province').': '.$provincial_choices.'<br/>';
echo elgg_echo('gcRegister:ministry').' (EN): '.elgg_view('input/text', array('id' => 'add-ministries-en')).'<br/>';
echo elgg_echo('gcRegister:ministry').' (FR): '.elgg_view('input/text', array('id' => 'add-ministries-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="ministries" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$minObj = elgg_get_entities(array(
   	'type' => 'object',
   	'subtype' => 'ministries',
));
$mins = get_entity($minObj[0]->guid);
$mins_en = json_decode($mins->ministries_en, true);
$mins_fr = json_decode($mins->ministries_fr, true);
ksort($mins_en);

if (count($mins_en) > 0) {
	echo '<table class="depts">';
	echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:ministry').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:ministry').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
	foreach($mins_en as $prov => $ministries){
		echo '<tr><th colspan="4">'.$prov.'</th></tr>'; 
		if (count($ministries) > 0) {
			foreach($ministries as $key => $min){
				$delete_btn = elgg_view('output/confirmlink',
					array(
						'text' => elgg_echo('delete'),
						'href' => "action/gcRegistration_collab/delete?type=ministries&province=".$prov."&key=" . $key
					)
				);

				echo '<tr>'; 
				echo '<td>'.$delete_btn.'</td>';
				echo '<td> <input class="dept_en" data-province="'.$prov.'" data-id="'.$key.'" type="text" value="'.$min.'" disabled /> </td>';
				echo '<td> <input class="dept_fr" data-province="'.$prov.'" data-id="'.$key.'" type="text" value="'.$mins_fr[$prov][$key].'" disabled /> </td>';
				echo '<td> <a class="edit" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="ministries" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
				echo '</tr>';
			}
		}
	}
	echo '</tbody></table>';
}

echo '</div>';
// End Provincial/Territorial Departments tab

// Start Municipal tab
echo '<div id="municipal">';

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:province').': '.$provincial_choices.'<br/>';
echo elgg_echo('gcRegister:occupation:municipal').' (EN): '.elgg_view('input/text', array('id' => 'add-municipal-en')).'<br/>';
echo elgg_echo('gcRegister:occupation:municipal').' (FR): '.elgg_view('input/text', array('id' => 'add-municipal-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="municipal" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$munObj = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'municipal',
));
$municipals = get_entity($munObj[0]->guid);

echo '<table class="depts">';
echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:occupation:municipal').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:occupation:municipal').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
foreach($provincial_departments as $prov){
	$province_holder = json_decode($municipals->$prov, true);
	if (count($province_holder) > 0) {
		echo '<tr><th colspan="4">'.$prov.'</th></tr>'; 
		foreach($province_holder as $key => $mun){
			$delete_btn = elgg_view('output/confirmlink',
				array(
					'text' => elgg_echo('delete'),
					'href' => "action/gcRegistration_collab/delete?type=municipal&province=".$prov."&key=" . $key
				)
			);

			echo '<tr>'; 
			echo '<td>'.$delete_btn.'</td>';
			echo '<td> <input class="dept_en" data-province="'.$prov.'" data-id="'.$key.'" type="text" value="'.$mun.'" disabled /> </td>';
			echo '<td> <input class="dept_fr" data-province="'.$prov.'" data-id="'.$key.'" type="text" value="'.$mun.'" disabled /> </td>';
			echo '<td> <a class="edit" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="municipal" data-province="'.$prov.'" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
			echo '</tr>';
		}
	}
}
echo '</tbody></table>';

echo '</div>';
// End Municipal tab

// Start Other tab
echo '<div id="other">';

echo '<table class="depts">';
echo '<tr> <th>'.elgg_echo('add').'</th> </tr>';
echo '<tr><td>';
echo elgg_echo('gcRegister:occupation:other').' (EN): '.elgg_view('input/text', array('id' => 'add-other-en')).'<br/>';
echo elgg_echo('gcRegister:occupation:other').' (FR): '.elgg_view('input/text', array('id' => 'add-other-fr')).'<br/>';
echo '<a class="add elgg-button elgg-button-submit btn btn-primary mtm" data-type="other" href="#">'.elgg_echo('add').'</a></td></tr>';
echo '</table>';

$otherObj = elgg_get_entities(array(
    'type' => 'object',
    'subtype' => 'other',
));
$others = get_entity($otherObj[0]->guid);
$others_en = json_decode($others->other_en, true);
$others_fr = json_decode($others->other_fr, true);
ksort($others_en);

if (count($others_en) > 0) {
	echo '<table class="depts">';
	echo '<thead><tr> <th width="10%"></th> <th width="40%">'.elgg_echo('gcRegister:occupation:other').' (EN)</th> <th width="40%">'.elgg_echo('gcRegister:occupation:other').' (FR)</th> <th width="10%"></th> </tr></thead><tbody>';
	foreach ($others_en as $key => $other) {
		$delete_btn = elgg_view('output/confirmlink',
			array(
				'text' => elgg_echo('delete'),
				'href' => "action/gcRegistration_collab/delete?type=other&key=" . $key
			)
		);

		echo '<tr>'; 
		echo '<td>'.$delete_btn.'</td>';
		echo '<td> <input class="dept_en" data-id="'.$key.'" type="text" value="'.$other.'" disabled /> </td>';
		echo '<td> <input class="dept_fr" data-id="'.$key.'" type="text" value="'.$others_fr[$key].'" disabled /> </td>';
		echo '<td> <a class="edit" data-id="'.$key.'" href="#">'.elgg_echo('edit').'</a> <a class="cancel hidden elgg-button only-one-click elgg-button-cancel btn btn-default" data-id="'.$key.'" href="#">'.elgg_echo('cancel').'</a> <a class="save hidden elgg-button only-one-click elgg-button-submit btn btn-primary" data-type="other" data-id="'.$key.'" href="#">'.elgg_echo('save').'</a> <br> <span class="edit-message" data-id="'.$key.'"></span> </td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

echo '</div>';
// End Other tab

echo '</div>';

?>

</div>