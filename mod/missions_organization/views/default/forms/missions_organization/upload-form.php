<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$organization_upload = get_input('ou');

if (elgg_is_sticky_form('orguploadfill')) {
    extract(elgg_get_sticky_values('orguploadfill'));
    elgg_clear_sticky_form('orguploadfill');
}

$input_upload_path_text = elgg_view('input/text', array(
    'name' => 'organization_upload',
    'value' => $organization_upload
));
?>

<div class="form-group">
	<div style="display:inline-block;">
		<?php echo $input_upload_path_text; ?>
	</div>
	<div style="display:inline-block;">
		<?php echo elgg_view('input/submit', array('value' => elgg_echo('missions_organization:upload'))); ?>
	</div>
</div>