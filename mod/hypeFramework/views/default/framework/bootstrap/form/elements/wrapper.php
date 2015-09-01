<?php

/*
 * Form Element Wrapper
 * Wraps input element, hint and label into a div
 *
 * @uses $vars['input'] markup of an input element
 * @uses $vars['label'] markup of a label element
 * @uses $vars['hint'] markup of a hint element
 * @uses $vars['type'] input type
 */

if (isset($vars['field'])) {
	$field = elgg_extract('field', $vars);

	$type = elgg_extract('input_type', $field, 'text');
	$valtype = elgg_extract('value_type', $field, 'default');

	$class = "elgg-input-wrapper elgg-input-wrapper-$type elgg-input-wrapper-$valtype";
} else {
	$class = "elgg-input-wrapper";
}

if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$label = elgg_extract('label', $vars, '');
$hint = elgg_extract('hint', $vars, '');
$input = elgg_extract('input', $vars, '');
$message = elgg_extract('validation_message', $vars, '');

if ($type == 'hidden' || $valtype == 'hidden') {
	$class = 'hidden';
	$label = '';
	$hint = '';
}

echo <<<HTML
<div class="$class">
		$label
		$input
		$hint
		$message
</div>
HTML;
