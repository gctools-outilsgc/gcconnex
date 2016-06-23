<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which determines which value missions are being sorted by and whether or not they are in ascending or descending order.
 */
$sort_field = $_SESSION['missions_sort_field_value'];
$order_field = $_SESSION['missions_order_field_value'];

$options_array = array(
		'missions:date_posted' => elgg_echo('missions:date_posted'),
		'missions:deadline' => elgg_echo('missions:deadline'),
		'missions:opportunity_type' => elgg_echo('missions:opportunity_type')
);
if($vars['mission_sort_archive']) {
	$options_array = array(
			'missions:date_closed' => elgg_echo('missions:date_closed'),
			'missions:opportunity_type' => elgg_echo('missions:opportunity_type')
	);
}

$input_sort_field = elgg_view('input/dropdown', array(
		'name' => 'sort_field',
		'value' => $sort_field,
		'options_values' => $options_array,
		'id' => 'missions-sort-missions-sort-field-text-input'
));

$input_order_field = elgg_view('input/dropdown', array(
		'name' => 'order_field',
		'value' => $order_field,
		'options_values' => array(
				'missions:descending' => elgg_echo('missions:descending'),
				'missions:ascending' => elgg_echo('missions:ascending')
		),
		'id' => 'missions-sort-missions-order-field-text-input'
));
?>

<div class="col-sm-12" style="border:solid;padding:4px;">
	<div>
		<label for="missions-sort-missions-sort-field-text-input" class="col-sm-6" style="margin:4px;">
			<?php echo elgg_echo('missions:sort_by') . ': '; ?>
		</label>
		<div class="col-sm-5" style="margin:4px;">
			<?php echo $input_sort_field; ?>
		</div>
		
	</div>
	<div>
		<label for="missions-sort-missions-order-field-text-input" class="col-sm-6" style="margin:4px;">
			<?php echo elgg_echo('mission:following_order') . ': '; ?>
		</label>
		<div class="col-sm-5" style="margin:4px;">
			<?php echo $input_order_field; ?>
		</div>
	</div>
	<div>
		<?php 
			echo elgg_view('input/submit', array(
					'value' => elgg_echo('missions:sort'),
					'class' => 'elgg-button btn btn-default',
					'id' => 'missions-sort-missions-form-submission-button',
					'style' => 'margin:8px;float:right;'
			));
		?>
	</div>
</div>