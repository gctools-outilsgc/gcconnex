<?php
/**
 * Elgg group operators manage form
 *
 * @package ElggGroupOperators
 */
 /*
 * GC_MODIFICATION
 * Description: Changed styling of form
 * Author: GCTools Team
 */
$group_guid = elgg_extract('entity', $vars)->guid;
//$candidates = elgg_extract('candidates', $vars);

//if(!empty($candidates)){
	$body .= '<label for="who">'.elgg_echo('group_operators:new').'</label><br />';
	//$body .= elgg_view('input/combobox', array('name'=>'who','id'=>'who', 'options_values'=>group_operators_prepare_combo_vars($candidates),
	//						'style'=>'display:inline; width:80%', 'title'=>elgg_echo('group_operators:new:instructions')));
	$body .= elgg_view("input/text", array(
				"id" => "groups-owner-guid",
				"value" =>  '',
			));

	$body .= elgg_view("input/select", array(
				"name" => "who",
				"id" => "groups-owner-guid-select",
				"value" =>  '',
				"options_values" => '',
				"class" => "groups-owner-input hidden",
			));

			$vars = array(
				'class' => 'mentions-popup hidden',
				'id' => 'groupmems-popup',
			);

	$body .= elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);

	$body .= elgg_view('input/submit',array('value'=>elgg_echo('group_operators:new:button'), 'class' => 'btn btn-primary mrgn-tp-md'));
	$body .= '<div class="elgg-footer">'.elgg_view('input/hidden', array('name'=>'mygroup', 'value'=>$group_guid)).'</div>';
	echo $body;
//}


?>
