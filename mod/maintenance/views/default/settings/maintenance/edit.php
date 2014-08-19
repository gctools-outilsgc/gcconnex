<?php
	$active = $vars['entity']->maintenance_active;
	if (!$active) $active = 'no';
		
	$text = $vars['entity']->maintenance_text;
	
?>
<p>
	<?php echo elgg_echo('maintenance:settings:activate'); ?>
	
	<?php
		echo elgg_view('input/pulldown', array(
			'internalname' => 'params[maintenance_active]',
			'options_values' => array(
				'yes' => elgg_echo('option:yes'),
				'no' => elgg_echo('option:no')
			),
			'value' => $active
		));
	?>
	<br />
	<?php echo elgg_echo('maintenance:settings:text'); ?>
	
	<?php echo elgg_view('input/longtext', array('internalname'=>'params[maintenance_text]', 'value'=>$text));?>
</p>
