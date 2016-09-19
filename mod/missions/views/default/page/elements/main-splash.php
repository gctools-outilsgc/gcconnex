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
<!--<div class="panel panel-default mission-info-card">
	<?php /*echo elgg_echo('missions:placeholder_a');*/ ?>
</div> -->

<div class="col-sm-12 clearfix">
    <h4><?php echo elgg_echo('missions:splash:welcome'); ?></h4>
	<div class="col-sm-8"><?php echo elgg_echo('missions:first_splash_paragraph')?></div>
</div>

<div class="col-sm-12 clearfix">
    <h4 class=""><?php echo elgg_echo('missions:splash:how_to_apply'); ?></h4>
    <div class="col-sm-8">
        <?php echo elgg_echo('missions:second_splash_paragraph'); ?>
        <div class="col-sm-12 alert alert-info mrgn-tp-sm clearfix">
            <p>
                <?php echo elgg_echo('missions:splash:missions_help_message'); ?>
            </p>
        </div>
    </div>
	
</div>





<div>
	<?php 
//Nick - moving the opt in button and changing it to function with a lightbox

	?>
</div>
<div class="clearfix col-sm-12 mrgn-bttm-md">
    <div class="col-sm-offset-4 col-sm-4">
        <style>
    .modal-open .modal {
        background: rgba(0,0,0,0.4);
    }
</style>
<button aria-hidden="true" type="button" id="optinPopup" class="btn btn-primary btn-lg btn-block gcconnex-edit-profile" data-toggle="modal" data-target="#showOptin" data-keyboard="false" data-backdrop="static" data-colorbox-opts='{"inline":true, "href":"#showOptin", "innerWidth": 600, "maxHeight": "80%", "margin-top":"15%"}'><?php echo elgg_echo('missions:opt_in_to_opportunities'); ?></button>
    </div>

</div>

<div class="modal fade" id="showOptin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg opt-in-modal" style="margin-top:10%;">
        <div class="panel panel-custom" id="welcome-step">
            
            <div class="panel-body">
                <div class="clearfix">
                     <div class="pull-right clearfix">

                    <a href ="#" type="button" class="" data-dismiss="modal"><i class="fa fa-times fa-lg" aria-hidden="true"></i><span class="wb-inv"><?php echo elgg_echo('close');?></span></a>

                    </div>
                    <div>
                        <h3 class="mrgn-tp-md"><?php echo elgg_echo('missions:splash:popup_title'); ?></h3>
                        <p class="timeStamp"><?php echo elgg_echo('missions:splash:popup_instruction'); ?></p>
                    </div>


                </div>

               
                <div>
                    <?php
                        echo elgg_view_form('missions/opt-in-splash');
                        
                        
                    ?>
                </div>


            </div>

        </div>

    </div>

</div>



<div class="brdr-tp mrgn-tp-md clearfix col-sm-12">
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

