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
        'gallery_class'=>'wb-eqht',
        'item_class'=>'col-sm-6 col-md-4 ',

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
<div class="panel panel-default mission-info-card">
	<?php echo elgg_echo('missions:placeholder_a'); ?>
</div>
<h4><?php echo elgg_echo('missions:splash:what_are_missions'); ?></h4>
<div>
	<?php echo elgg_echo('missions:first_splash_paragraph')?>
</div>
<h4><?php echo elgg_echo('missions:splash:how_to_apply'); ?></h4>
<div>
	<?php echo elgg_echo('missions:second_splash_paragraph')?>
</div>



<div class="alert alert-info mrgn-tp-sm">
    <p>
        <?php echo elgg_echo('missions:splash:missions_right_now'); ?>
    </p>
</div>

<div>
	<?php 
//Nick - moving the opt in button and changing it to function with a lightbox
		echo elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'ajax/view/ajax/opt_in_splash',
				'text' => elgg_echo('missions:opt_in_to_opportunities'),
				'class' => 'elgg-button btn btn-primary btn-lg clearfix elgg-lightbox elgg-non-link',
				'is_action' => false,
                'rel'=>'nofollow',
				/*'confirm' => elgg_echo('missions:opt_in_confirmation_text'),*/
				'id' => 'mission-opt-in-button',
		));
	?>
</div>
<div>
	<h4><?php echo elgg_echo('missions:splash:missions_right_now') ; ?></h4>
	<?php 
		//echo $simple_search_form;
//Nick - Removing search from splash page as user still needs to opt in
		//echo $advanced_field;
	?>
</div>
<div class="col-sm-12">
	<?php echo $entity_list; ?>
</div>

