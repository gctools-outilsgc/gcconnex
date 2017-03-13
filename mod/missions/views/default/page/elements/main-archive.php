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

$_SESSION['mission_search_switch_subtype'] = 'archive';

// Simple search form.
$simple_search_form = elgg_view_form('missions/search-simple');

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
//Nick - Added the type filter session to the sort hook
$entity_list = mm_sort_mission_decider($_SESSION['missions_sort_field_value'], $_SESSION['missions_order_field_value'], $entity_list, $_SESSION['missions_type_field_value'], $_SESSION['missions_role_field_value']);
$count = count($entity_list);       // count the filtered list
if ( $offset >= $count )            // reset offset if it no longer makes sense after filtering
    $offset = 0;

$max_reached = '';
if(($offset + $max) >= elgg_get_plugin_setting('search_limit', 'missions') && $count >= elgg_get_plugin_setting('search_limit', 'missions')) {
    $max_reached = '<div class="col-sm-12" style="font-style:italic;">' . elgg_echo('missions:reached_maximum_entities') . '</div>';
}

$archive_list = elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
        'gallery_class'=>'wb-eqht clearfix',
        'item_class'=>'col-sm-6 col-md-4 ',
//		'gallery_class' => 'mission-gallery',
		'mission_full_view' => false
), $offset, $max);

$change_entities_per_page_form = elgg_view_form('missions/change-entities-per-page', array(
		'class' => 'form-horizontal'
), array(
		'entity_type' => 'mission',
		'number_per' => $entities_per_page
));

$sort_missions_form .= elgg_view_form('missions/sort-missions-form', array(
		'class' => 'form-horizontal'
), array(
		'mission_sort_archive' => true
));

//Nick - Checking to see if there are any sort filters so we can add a clear button
$opp_type_field = $_SESSION['missions_type_field_value'];
$role_type_field = $_SESSION['missions_role_field_value'];

if ($opp_type_field || $role_type_field) {
    $clear_link = elgg_view('output/url', array(
        'text' => elgg_echo('missions:clear_filter'),
        'href' => 'action/missions/sort-missions-form?opp_filter=&role_filter=',
        'class' => 'mrgn-lft-sm',
        'is_action' => true,
        'is_trusted' => true,
    ));
}

?>

<div class="col-sm-12">
    <div class="col-sm-8">
        <h4 class="mrgn-tp-md mrgn-bttm-0"><?php echo elgg_echo('missions:search_for_archived_opportunities') . ':'; ?></h4>
        <?php
            echo $simple_search_form;
        ?>
    </div>
</div>
<div class="col-sm-12">
    <h4><?php echo elgg_echo('missions:archived_opportunities') . ': '; ?></h4>
</div>

<div class="col-sm-12">
	<?php echo $sort_missions_form; echo $clear_link; ?>
    <?php echo $max_reached; ?>
</div>
<div class="col-sm-12">
	<?php echo $archive_list; ?>
</div>
<div class="col-sm-12">
	<?php echo $change_entities_per_page_form; ?>
</div>
