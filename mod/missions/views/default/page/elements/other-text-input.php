<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Text input for dropdown inputs with 'missions:other' as a choice.
 */
$parent_id = $vars['parent_id'];
$final_id = $parent_id . '-other-text-input';
$container_id = $parent_id . '-other-input-container';

$value = '';
$container_style = 'none';
if($vars['value_override']) {
	$value = $vars['value_override'];
	$container_style = 'block';
}

$input_other = elgg_view('input/text', array(
		'name' => 'other_text',
		'value' => $value,
		'id' => $final_id
));
?>

<div id="<?php echo $container_id; ?>" style="display:<?php echo $container_style; ?>;">
	<label for="<?php echo $final_id; ?>"><?php echo elgg_echo('missions:other') . ':'; ?></label>
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo $input_other; ?> 
	</div>
</div>

<script>
	document.getElementById(<?php echo json_encode($parent_id); ?>).onchange = function() {
		var parent_value = document.getElementById(<?php echo json_encode($parent_id); ?>).value;
		if(parent_value == 'missions:other') {
			document.getElementById(<?php echo json_encode($container_id); ?>).style.display = 'block';
		}
		else {
			document.getElementById(<?php echo json_encode($container_id); ?>).style.display = 'none';
		}
	}
</script>