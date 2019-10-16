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
		'value' => array('completed', 'cancelled')
));

if ($_SESSION['missions_type_field_value']){
    $options['metadata_name_value_pairs'][] = array(
		'name' => 'job_type',
		'value' => $_SESSION['missions_type_field_value']
    );
}

if ($_SESSION['missions_role_field_value']){
    $options['metadata_name_value_pairs'][] = array(
        'name' => 'role_type',
        'value' => $_SESSION['missions_role_field_value']
    );
}

$options['metadata_name_value_pairs_operator'] = 'AND';

switch($_SESSION['missions_sort_field_value']) {
    case 'missions:date_posted':
        $options['order_by'] = 'time_created ';
        break;
    case 'missions:date_closed':
        $options['order_by_metadata'] = array(
            'name' => 'time_closed',
            'direction' => 'DESC');
        break;
    case 'missions:deadline':
        $options['order_by_metadata'] = array(
            'name' => 'deadline',
            'direction' => 'DESC');
        break;
    case 'missions:opportunity_type':
        $options['order_by_metadata'] = array(
            'name' => 'job_type',
            'direction' => 'DESC');
        break;
}

if ( $options['order_by'] ){
    if ( $_SESSION['missions_order_field_value'] == 'missions:descending' )
        $options['order_by'] .= 'desc';
    else if ( $_SESSION['missions_order_field_value'] == 'missions:ascending' )
        $options['order_by'] .= 'asc';
}
else if ( $options['order_by_metadata'] && $_SESSION['missions_order_field_value'] == 'missions:ascending' ){
    $options['order_by_metadata']['direction'] = 'ASC';
}

$offset = (int) get_input('offset', 0);
if($entities_per_page) {
	$max = $entities_per_page;
}
else {
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
}

$options['limit'] = $max;
$options['offset'] = $offset;
$options['pagination'] = true;
$options['list_type'] = 'gallery';
$options['gallery_class'] = 'wb-eqht clearfix';
$options['item_class'] = 'col-sm-6 col-md-4';
$options['mission_full_view'] = false;


$archive_list = elgg_list_entities_from_metadata( $options );

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
        <h2 class="h4 mrgn-tp-md mrgn-bttm-0"><?php echo elgg_echo('missions:search_for_archived_opportunities') . ':'; ?></h2>
        <?php
            echo $simple_search_form;
        ?>
    </div>
</div>
<div class="col-sm-12">
    <h2 class="h4"><?php echo elgg_echo('missions:archived_opportunities') . ': '; ?></h2>
</div>

<div class="col-sm-12">
	<?php echo $sort_missions_form; echo $clear_link; ?>
</div>
<div class="col-sm-12">
	<?php echo $archive_list; ?>
</div>
<div class="col-sm-12">
	<?php echo $change_entities_per_page_form; ?>
</div>
