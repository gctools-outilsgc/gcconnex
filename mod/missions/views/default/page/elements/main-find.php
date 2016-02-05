<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page content for finding missions and a link to create them.
 */

$_SESSION['mission_search_switch'] = 'mission';

// Simple search form.
$simple_search_form = '<div style="display:inline-block;margin-right:16px;">' . elgg_view_form('missions/search-simple') . '</div>';

// Advanced search form which gets hidden.
$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
));
$advanced_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:filter_search'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'field_bordered' => true
));

// Displays the latest missions to be posted up to search_limit.
$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['limit'] = elgg_get_plugin_setting('search_limit', 'missions');

$entity_list = elgg_get_entities($options);

$count = count($entity_list);
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

// Displays the list of mission entities.
$latest_missions .= elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'gallery_class' => 'mission-gallery',
		'mission_full_view' => false
), $offset, $max);
?>

<div>
	<?php echo $create_button; ?>
</div>
</br>
<div>
	<?php 
		echo $simple_search_form;
		echo $advanced_field;
	?>
</div>
</br>
<div>
	<h4><?php echo elgg_echo('missions:latest_opportunities'); ?></h4>
	<?php echo $latest_missions; ?>
</div>

