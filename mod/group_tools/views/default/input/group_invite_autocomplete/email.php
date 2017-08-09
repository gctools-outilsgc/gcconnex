<?php
/**
 * User view for in the gorup invite autocomplete
 */

$name = elgg_extract('inputname', $vars);
$value = elgg_extract('value', $vars);

?>
<div class="group_tools_group_invite_autocomplete_autocomplete_result elgg-discover_result elgg-discover clearfix">
	<input type="hidden" value="<?php echo $value; ?>" name="<?php echo $name; ?>_email[]" />
	
	<?php echo elgg_view_icon('delete-alt', 'elgg-discoverable float-alt'); ?>
	<?php echo $value; ?>
</div>
