<?php


if (!isset($vars['entity']->en_stats_instruction))
	$vars['entity']->en_stats_instruction = 'COMING SOON, NEAR <b>YOU!</b>';
if (!isset($vars['entity']->fr_stats_instruction))
	$vars['entity']->fr_stats_instruction = 'Bientôt, près de chez <b>VOUS</b>!';

?>
<div>
<?php
echo '<b>Instructions in English</b><br />';
echo elgg_view('input/longtext', array(
	'name' => 'params[en_stats_instruction]',
	'class' => 'instruction_txt_en',
	'id' => 'stats-textarea_en',
	'value' => $vars['entity']->en_stats_instruction
	));
echo '<br /><br/>';
echo '<b>Instructions in French</b><br />';
echo elgg_view('input/longtext', array(
	'name' => 'params[fr_stats_instruction]',
	'class' => 'instruction_txt_fr',
	'id' => 'stats-textarea_fr',
	'value' => $vars['entity']->fr_stats_instruction
	));

?>
</div>