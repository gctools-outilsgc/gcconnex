<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Layout of the splash page which is shown to users not opted in to micro missions.
 */

// Gets a sample of micro missions of size defined by mission_front_page_limit.
$options['type'] = 'object';
$options['subtype'] = 'mission';
$options['metadata_name_value_pairs'] = array(array(
		'name' => 'state',
		'operand' => '=',
		'value' => 'posted'
));
$options['limit'] = elgg_get_plugin_setting('mission_front_page_limit', 'missions');

$entity_list = elgg_get_entities($options);

$count = count($missions);
$offset = (int) get_input('offset', 0);
$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

// Displays the sample of micro missions.
$entity_list = elgg_view_entity_list(array_slice($entity_list, $offset, $max), array(
		'count' => $count,
		'offset' => $offset,
		'limit' => $max,
		'pagination' => true,
		'list_type' => 'gallery',
		'gallery_class' => 'mission-gallery',
		'override_buttons' => true,
		'mission_full_view' => false
), $offset, $max);

// Simple search form.
$simple_search_form = elgg_view_form('missions/search-simple');

// Advanced search form which gets hidden.
$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
));
$advanced_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:advanced_search'),
		'toggle_text_hidden' => elgg_echo('missions:simple_search'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'hideable_pre_content' => $simple_search_form,
		'field_bordered' => true
));
?>
<div>
	<?php echo elgg_echo('missions:placeholder_a'); ?>
</div>
<h4><?php echo elgg_echo('missions:splash:what_are_missions'); ?></h4>
<div>
	<?php echo elgg_echo('missions:first_splash_paragraph')?>
</div>
<br>
<h4><?php echo elgg_echo('missions:splash:how_to_apply'); ?></h4>
<div>
	<?php echo elgg_echo('missions:second_splash_paragraph')?>
</div>
<br>
<h4><?php echo elgg_echo('missions:splash:missions_right_now'); ?></h4>
<div>
	<h4><?php echo elgg_echo('missions:search_for_opportunities') . ':'; ?></h4>
	<?php 
		//echo $simple_search_form;
		echo $advanced_field;
	?>
</div>
<div class="col-sm-12">
	<?php echo $entity_list; ?>
</div>
<br>
<div>
	<?php 
		echo elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'profile/' . elgg_get_logged_in_user_entity()->username . '#opt-in-anchor',
				'text' => elgg_echo('missions:opt_in_to_opportunities'),
				'class' => 'elgg-button btn btn-primary clearfix',
				'is_action' => false,
				'confirm' => elgg_echo('missions:opt_in_confirmation_text'),
				'style' => 'float:right;',
				'id' => 'mission-opt-in-button'
		));
	?>
</div>