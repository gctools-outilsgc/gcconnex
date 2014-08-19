<?php
/**
 * Elgg dropdown input
 * Displays a combobox (text + select) input field
 *
 * @warning Default values of FALSE or NULL will match '' (empty string) but not 0.
 *
 * @package ElggGroupOperators
 *
 * @uses $vars['value']          The current value, if any
 * @uses $vars['options']        An array of strings representing the options for the dropdown field
 * @uses $vars['options_values'] An associative array of "value" => "option"
 *                               where "value" is an internal name and "option" is
 * 								 the value displayed on the button. Replaces
 *                               $vars['options'] when defined.
 * @uses $vars['class']          Additional CSS class
 */

echo elgg_view('input/dropdown',$vars);

if($vars['id']):
	elgg_load_js('jquery-combobox');
	elgg_load_css('jquery-ui-buttons');
	elgg_load_css('jquery-ui-theme');
?>

<script type="text/javascript">
	$("#<?php echo $vars['id']; ?>").combobox();
</script>

<?php
endif;
