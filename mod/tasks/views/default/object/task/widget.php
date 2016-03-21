<?php
/**
 * Summary of an task for lists/galleries
 *
 * @uses $vars['entity'] TAsk
 *
 * @author Fx Nion
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */


	$entity = elgg_extract('entity', $vars);
	$worker=get_entity($entity->assigned_to);
	
	$container = $entity->getContainerEntity();
	$friendlytime = elgg_view_friendly_time($entity->time_updated);
	$metadata = elgg_extract('metadata', $vars, '');
	$urlTaskOwner = elgg_get_site_url()."tasks/owner/".$container->username;
	$categories = elgg_view('output/categories', $vars);
	
	$metadataMenu = elgg_view_menu('entity', array(
	'entity' => $entity,
	'handler' => 'tasks',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	));
	
	$owner = $entity->getOwnerEntity();
	$owner_link = elgg_view('output/url', array(
		'href' => "tasks/owner/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));


?>
<?php echo $metadataMenu; ?>
<h4><a href="<?php echo $entity->getURL(); ?>"><?php echo $entity->title; ?></a></h4>
<table class="task" style="color: #aaa; width: 100%; font-size: 85%">
	<tr>
		<td width="55%">
		<?php echo elgg_echo('tasks:percent_done'). " : " .elgg_view('output/text',array('value' => elgg_echo("tasks:task_percent_done_{$entity->percent_done}"))); ?>
		</td>
		<td width="45%">
		<?php echo elgg_echo('tasks:work_remaining'). " : " .elgg_view('output/text',array('value' => $entity->work_remaining)); ?>
		</td>
	</tr>
	<tr>
		<td width="55%">
		<?php echo elgg_echo('tasks:start_date'). " : " .elgg_view('output/text',array('value' => $entity->start_date, "css"=>"truc")); ?>
		</td>
		<td width="45%">
		<?php echo elgg_echo('tasks:end_date'). " : " .elgg_view('output/text',array('value' => $entity->end_date)); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="elgg-subtext" ><?php  echo elgg_echo('byline', array($owner_link)); ?> ,  <?php echo $friendlytime; ?></td>
	</tr>
</table>

