<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$entity_type = $vars['entity_type'];
$number_per = $vars['number_per'];
if($entity_type == 'candidate') {
	$number_array = array(10,25,50,100);
}
else {
	$number_array = array(9,18,30,60,120);
}

$input_per_page = elgg_view('input/dropdown', array(
		'name' => 'number_per',
		'value' => $number_per,
		'options' => $number_array,
		'id' => 'change-entities-per-page-dropdown-input',
		'onchange' => 'this.form.submit()'
));
?>

<div class="col-sm-12">
	<h4 style="display:inline-block;"><label for="change-entities-per-page-dropdown-input"><?php echo elgg_echo('missions:entities_per_page') . ':'; ?></label></h4>
	<div style="display:inline-block;">	
		<?php echo $input_per_page; ?>
	</div>
	<noscript>
		<div style="display:inline-block;">
			<?php 
				echo elgg_view('input/submit', array(
						'value' => elgg_echo('missions:change'),
						'id' => 'change-entities-per-page-submission-button'
				)); 
			?>
		</div>
	</noscript>
</div>