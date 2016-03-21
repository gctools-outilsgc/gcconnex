<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$input_org_abbr = elgg_view('input/text', array(
		'name' => 'target_org_abbr',
		'value' => $node->abbr,
		'id' => 'change-parent-organization-abbreviation-text-input'
));

$hidden_guid = elgg_view('input/hidden', array(
		'name' => 'hidden_subject_guid',
		'value' => $vars['node_guid']
));
?>

<div>
	<?php echo $hidden_guid; ?>
</div>
<div class="form-group">
	<label class="col-sm-3" for="change-parent-organization-abbreviation-text-input" style="text-align:right;">
		<?php echo elgg_echo('missions_organization:abbreviation') . ': '; ?>
	</label>
	<div class="col-sm-5" style="display:inline-block;">
		<?php echo $input_org_abbr; ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
			'value' => elgg_echo('missions_organization:change'),
			'class' => 'elgg-button btn btn-primary elgg-button-action',
			'style' => 'float:right;'
		)); 
	?>
</div>