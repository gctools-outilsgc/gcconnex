<?php
/**
 * Elgg group operators manage form
 *
 * @package ElggGroupOperators
 */

$group_guid = elgg_extract('entity', $vars)->guid;
$candidates = elgg_extract('candidates', $vars);

if(!empty($candidates)){ 
	$body .= '<label for="who">'.elgg_echo('group_operators:new').'</label><br />';
	$body .= elgg_view('input/combobox', array('name'=>'who','id'=>'who', 'options_values'=>group_operators_prepare_combo_vars($candidates),
							'style'=>'display:inline', 'title'=>elgg_echo('group_operators:new:instructions')));
	$body .= elgg_view('input/submit',array('value'=>elgg_echo('group_operators:new:button'), 'class' => 'btn btn-primary'));
	$body .= '<div class="elgg-footer">'.elgg_view('input/hidden', array('name'=>'mygroup', 'value'=>$group_guid)).'</div>';
	echo $body;
}
?>
