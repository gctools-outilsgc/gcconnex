<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * 
 */

$check_closed = true;
if($_SESSION['mission_refine_closed'] != 'SHOW_CLOSED') {
	$check_closed = false;
}

$input_closed = elgg_view('input/checkbox', array(
		'name' => 'check_closed',
		'checked' => $check_closed,
		'id' => 'show-my-close-missions-checkbox-input'
));
?>

<div class="form-group" style="display:inline-block;">
	<div style="display:inline;">
		<?php echo $input_closed; ?>
	</div>
	<p style="display:inline;">
		<?php echo elgg_echo('missions:show_closed_missions'); ?>
	</p>
	
</div>

<div style="display:inline-block;margin-left:23px;"> 
	<?php
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:save'),
				'class' => 'elgg-button btn btn-primary'
		)); 
	?> 
</div>