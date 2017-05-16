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
$user = elgg_get_logged_in_user_entity();
if($_SESSION['mission_entities_per_page']) {
	$entities_per_page = $_SESSION['mission_entities_per_page'];
}

// List of all accepted and posted relationships the mission has.
$temp_array_one = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_posted',
		'relationship_guid' => elgg_get_logged_in_user_guid(),
		'limit' => 0
));
$temp_array_two = elgg_get_entities_from_relationship(array(
		'relationship' => 'mission_accepted',
		'relationship_guid' => elgg_get_logged_in_user_guid(),
		'inverse_relationship' => true,
		'limit' => 0
));
$entity_list = array_merge($temp_array_one, $temp_array_two);
$entity_list_original = $entity_list;

if(!$user->show_closed_missions) {
	foreach($entity_list as $key => $entity) {
		if($entity->state == 'completed' || $entity->state == 'cancelled') {
			unset($entity_list[$key]);
		}
	}
}

usort($entity_list, 'mm_cmp_by_updated');

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
if($entities_per_page) {
	$max = $entities_per_page;
}
else {
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
}

// Displays the list of mission entities.
$missions_list = '<div style="display:block;">' . elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
				'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
        'gallery_class'=>'wb-eqht',
        'item_class'=>'col-sm-6 col-md-4 ',

		'mission_full_view' => false
), $offset, $max) . '</div>';

// Form which gives options to refine or unrefine the missions displayed.
$refine_missions_form = elgg_view_form('missions/refine-my-missions-form', array(
		'class' => 'form-horizontal'
));

// Element which displays links to unfinished feedback.
$unfinished_feedback = elgg_view('page/elements/unfinished-feedback', array(
		'entity_list' => $entity_list_original
));

$change_entities_per_page_form = elgg_view_form('missions/change-entities-per-page', array(
		'class' => 'form-horizontal'
), array(
		'entity_type' => 'mission',
		'number_per' => $entities_per_page
));
?>

<div>
	<?php echo $unfinished_feedback; ?>
</div>
<div>
	<h2 class='h4'><?php echo elgg_echo('missions:my_opportunities'); ?></h2>
	<div class="col-sm-12">
		<?php echo $missions_list; ?>
	</div>
</div>
<div class="col-sm-12">
	<?php echo $refine_missions_form; ?>
</div>
<div hidden name="mission-total-count"><?php echo $count; ?></div>
<div class="col-sm-12">
	<?php echo $change_entities_per_page_form; ?>
</div>