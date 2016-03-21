<?php
/**
 * Task summary
 *
 */
	$entity = $vars['entity'];
	$worker=get_entity($entity->assigned_to);
	$owner = $entity->getOwnerEntity();
	$container = get_entity($entity->getContainerGUID());
	$friendlytime = elgg_view_friendly_time($entity->time_created);
	$metadata = elgg_extract('metadata', $vars, '');
	$urlTaskOwner = elgg_get_site_url()."tasks/owner/".$container->username;
?>
<!--
	<table width="100%" class="tasks" >
		<tr>
			<td width="33%">
				<h3><a href="<?php echo $entity->getURL(); ?>"><?php echo $entity->title; ?></a></h3>
			</td>
			<td width="33%">
				<a href="<?php echo $urlTaskOwner; ?>"><?php echo $container->name; ?></a>&nbsp;<?php echo $friendlytime; ?>
			</td width="33%">
			<td width="33%" style="text-align: right;">
				<?php if ($metadata) {	echo $metadata; } ?>
			</td>
		</tr>
	</table>
-->
	<hr>
	<table width="100%" class="tasks" >
		<tr>
			<td width="50%">
			<label><?php 	echo elgg_echo('tasks:start_date'); ?></label>
			<?php   echo elgg_view('output/text',array('value' => $entity->start_date)); ?>
			</td>
			<td width="50%">
			<label><?php 	echo elgg_echo('tasks:end_date'); ?></label>
			<?php   echo elgg_view('output/text',array('value' => $entity->end_date)); ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
			<label><?php echo elgg_echo('tasks:task_type'); ?></label>
			<?php echo elgg_view('output/text',array('value' => elgg_echo("tasks:task_type_{$entity->task_type}"))); ?>
			</td>
			<td width="50%">
			<label><?php echo elgg_echo('tasks:status'); ?></label>
			<?php echo elgg_view('output/text',array('value' => elgg_echo("tasks:task_status_{$entity->status}"))); ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
			<label><?php 	echo elgg_echo('tasks:percent_done'); ?></label>
			<?php echo elgg_view('output/text',array('value' => elgg_echo("tasks:task_percent_done_{$entity->percent_done}"))); ?>
			</td>
			<td width="50%">
			<label><?php 	echo elgg_echo('tasks:work_remaining'); ?></label>
			<?php echo elgg_view('output/text',array('value' => $entity->work_remaining)); ?>
			</td>
		</tr>
		<tr>
			<td width="50%">
			<label><?php echo $worker ? elgg_echo('tasks:assigned_to') :""; ?></label>
			<?php if ($worker) { ?>
			<a href="<?php echo elgg_get_site_url(); ?>profile/<?php echo $worker->username; ?>"><?php echo $worker->name; ?></a>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td width="100%" colspan="2">
			<hr>
			<label><?php 	echo elgg_echo('tasks:description'); ?></label>
				<?php   echo elgg_view('output/longtext',array('value' => $entity->description)); ?>
			</td>
		</tr>
	</table>
	<hr>


