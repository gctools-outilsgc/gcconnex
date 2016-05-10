<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Displays all completed and cancelled missions.
 */
if($_SESSION['mission_entities_per_page']) {
	$entities_per_page = $_SESSION['mission_entities_per_page'];
}

$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['metadata_name_value_pairs'] = array(array(
		'name' => 'state',
		'value' => 'completed'
), array(
		'name' => 'state',
		'value' => 'cancelled'
));
$options['metadata_name_value_pairs_operator'] = 'OR';
$options['limit'] = 0;
$entity_list = elgg_get_entities_from_metadata($options);

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
if($entities_per_page) {
	$max = $entities_per_page;
}
else {
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
}

$archive_list = elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'mission_full_view' => false
), $offset, $max);

$change_entities_per_page_form = elgg_view_form('missions/change-entities-per-page', array(
		'class' => 'form-horizontal'
), array(
		'entity_type' => 'mission',
		'number_per' => $entities_per_page
));
?>

<div class="col-sm-12">
	<?php echo $archive_list; ?>
</div>
<div class="col-sm-12">
	<?php echo $change_entities_per_page_form; ?>
</div>
