<?php

namespace Beck24\MemberSelfDelete;

?>

<div style="margin: 20px;">
	<?php echo elgg_echo('member_selfdelete:options:explanation:prefix'); ?><br><br>
	<b><?php echo elgg_echo('member_selfdelete:option:delete'); ?>:</b><br>
	<?php echo elgg_echo('member_selfdelete:options:explanation:delete'); ?><br><br>

	<b><?php echo elgg_echo('member_selfdelete:option:ban'); ?>:</b><br>
	<?php echo elgg_echo('member_selfdelete:options:explanation:ban'); ?><br><br>

	<b><?php echo elgg_echo('member_selfdelete:option:anonymize'); ?>:</b><br>
	<?php echo elgg_echo('member_selfdelete:options:explanation:anonymize'); ?><br><br>

	<b><?php echo elgg_echo('member_selfdelete:option:choose') ?>:</b><br>
	<?php echo elgg_echo('member_selfdelete:options:explanation:choose') ?><br><br> 

	<label><?php echo elgg_echo('member_selfdelete:select:method'); ?></label><br><br>

	<?php
	$options = array(
		'name' => 'params[method]',
		'value' => $vars['entity']->method ? $vars['entity']->method : "delete",
		'options' => array(
			elgg_echo('member_selfdelete:option:delete') => 'delete',
			elgg_echo('member_selfdelete:option:ban') => 'ban',
			elgg_echo('member_selfdelete:option:anonymize') => 'anonymize',
			elgg_echo('member_selfdelete:option:choose') => 'choose'
		),
	);

	echo elgg_view('input/radio', $options);
	?>

	<br><br>

	<label><?php echo elgg_echo('member_selfdelete:select:feedback'); ?></label><br>
	<?php
	$options = array(
		'name' => 'params[feedback]',
		'value' => $vars['entity']->feedback ? $vars['entity']->feedback : "yes",
		'options' => array(
			elgg_echo('option:yes') => "yes",
			elgg_echo('option:no') => "no"
		),
	);

	echo elgg_view('input/radio', $options);
	?>
</div>