<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$node = $vars['entity'];

$input_org_name_english = elgg_view('input/text', array(
		'name' => 'org_name_english',
		'value' => $node->name,
		'id' => 'edit-organization-english-name-text-input'
));

$input_org_abbr_english = elgg_view('input/text', array(
		'name' => 'org_abbr_english',
		'value' => $node->abbr,
		'id' => 'edit-organization-english-abbreviation-text-input'
));

$input_org_name_french = elgg_view('input/text', array(
		'name' => 'org_name_french',
		'value' => $node->name_french,
		'id' => 'edit-organization-french-name-text-input'
));

$input_org_abbr_french = elgg_view('input/text', array(
		'name' => 'org_abbr_french',
		'value' => $node->abbr_french,
		'id' => 'edit-organization-french-abbreviation-text-input'
));

$hidden_guid = elgg_view('input/hidden', array(
		'name' => 'hidden_guid',
		'value' => $node->guid
));
?>

<div>
	<?php echo $hidden_guid; ?>
</div>
<div class="form-group">
	<label class="col-sm-3" for="edit-organization-english-name-text-input" style="text-align:right;">
		<?php echo elgg_echo('missions_organization:name_english') . ': '; ?>
	</label>
	<div class="col-sm-5">
		<?php echo $input_org_name_english; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3" for="edit-organization-english-abbreviation-text-input" style="text-align:right;">
		<?php echo elgg_echo('missions_organization:abbreviation_english') . ': '; ?>
	</label>
	<div class="col-sm-5">
		<?php echo $input_org_abbr_english; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3" for="edit-organization-french-name-text-input" style="text-align:right;">
		<?php echo elgg_echo('missions_organization:name_french') . ': '; ?>
	</label>
	<div class="col-sm-5">
		<?php echo $input_org_name_french; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3" for="edit-organization-french-abbreviation-text-input" style="text-align:right;">
		<?php echo elgg_echo('missions_organization:abbreviation_french') . ': '; ?>
	</label>
	<div class="col-sm-5">
		<?php echo $input_org_abbr_french; ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
			'value' => elgg_echo('missions_organization:save'),
			'class' => 'elgg-button btn btn-primary elgg-button-action',
			'style' => 'float:right;'
		)); 
	?>
</div>