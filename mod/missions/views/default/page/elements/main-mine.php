<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page content related to the user's missions. 
 */

// List of all accepted and posted relationships the mission has.
$temp_array_one = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_posted',
		'relationship_guid' => elgg_get_logged_in_user_guid()
));
$temp_array_two = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_accepted',
		'relationship_guid' => elgg_get_logged_in_user_guid(),
		'inverse_relationship' => true
));
$entity_list = array_merge($temp_array_one, $temp_array_two);
$entity_list_original = $entity_list;

if($_SESSION['mission_refine_closed'] != 'SHOW_CLOSED') {
	foreach($entity_list as $key => $entity) {
		if($entity->state == 'completed' || $entity->state == 'cancelled') {
			unset($entity_list[$key]);
		}
	}
}

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

// Displays the list of mission entities.
$missions_list = elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'gallery_class' => 'mission-gallery',
		'mission_full_view' => false
), $offset, $max);

// Form which gives options to refine or unrefine the missions displayed.
$refine_missions_form .= elgg_view_form('missions/refine-my-missions-form', array(
		'class' => 'form-horizontal'
));

// Element which displays links to unfinished feedback.
$unfinished_feedback = elgg_view('page/elements/unfinished-feedback', array(
		'entity_list' => $entity_list_original
));
?>

<div>
	<?php echo $unfinished_feedback; ?>
</div>
</br>
<h4><?php echo elgg_echo('missions:my_opportunities'); ?></h4>
<div>
	<?php echo $missions_list; ?>
</div>
<div class="col-sm-offset-1">
	<?php echo $refine_missions_form; ?>
</div>
</br>