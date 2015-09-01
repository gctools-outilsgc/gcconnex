<?php
/**
 * Elgg Label From Element
 *
 * @uses $vars['label'] Array of label attributes array('text' => $label_text, 'for' => $input_name)
 * @uses $vars['required'] Is associated field required?
 */
if (!isset($vars['text'])) {
	return true;
}

$text = $vars['text'];
unset($vars['text']);

if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-label {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-label";
}

if (isset($vars['required'])) {
	if ($vars['required'] === true || $vars['required'] == 'required') {
		$vars['class'] = "{$vars['class']} elgg-input-label-for-required";
		$text .= '<span class="elgg-input-symbol-required" title="' . elgg_echo('hj:framework:input:required') . '">*</span>';
//		$text .= elgg_view('output/url', array(
//			'text' => '<span class="elgg-label-required">' . elgg_echo('required') . '</span>',
//			//'title' => elgg_echo('required'),
//			'href' => false,
//			'class' => 'framework-ui-tooltip framework-label-required'
//				));
	}
	unset($vars['required']);
}

?>
<label <?php echo elgg_format_attributes(elgg_clean_vars($vars)); ?>><?php echo $text ?></label>