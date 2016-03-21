<?php

$field_source = $field = elgg_extract('field', $vars, array());

if (isset($field['sticky_value'])) {
	$sticky_value = elgg_extract('sticky_value', $field);
	unset($field['sticky_value']);
}

if (isset($field['validation_status'])) {
	$validation_status = elgg_extract('validation_status', $field);
	unset($field['validation_status']);
}

// Get input type to use / default to text
if (isset($field['input_type'])) {
	$input_type = $field['input_type'];
	unset($field['input_type']);
} else {
	$input_type = 'text';
}

// Get value type (tags, file etc)
if (isset($field['value_type'])) {
	$value_type = $field['value_type'];
	unset($field['value_type']);
} else {
	$value_type = '';
}

if ($field['label'] !== false && $input_type != 'hidden' && $value_type != 'hidden') {
	if (is_string($field['label'])) {
		$field['label'] = array('text' => $field['label']);
	}

	if (!isset($field['label']['text'])) {
		$field['label']['text'] = elgg_echo("{$field['form_name']}:{$field['name']}");
	}
	if (!isset($field['label']['for'])) {
		$field['label']['for'] = $field['name'];
	}

	$field['label']['required'] = ($field['required'] || $field['ltrequired']);

	if (isset($field['label']['override_view'])) {
		$label_view = $field['label']['override_view'];
	}
	if ($label_view && elgg_view_exists($label_view)) {
		$label = elgg_view($label_view, $field['label']);
	} else {
		$label = elgg_view('framework/bootstrap/form/elements/label', $field['label']);
	}

	unset($field['label']);
}

if (isset($field['hint']) && $field['hint'] !== false) {

	if (is_string($field['hint'])) {
		$field['hint'] = array('text' => $field['hint']);
	} else if (!isset($field['hint']['text'])) {
		$field['hint']['text'] = elgg_echo("hint:{$field['name']}");
	}

	$hint_view = $field['hint']['override_view'];
	if ($hint_view && elgg_view_exists($hint_view)) {
		$hint = elgg_view($hint_view, $field['hint']);
	} else {
		$hint = elgg_view('framework/bootstrap/form/elements/hint', $field['hint']);
	}

	unset($field['hint']);
}

if (isset($validation_status['status'])) {

	$status = $validation_status['status'];

	if ($status === false) {
		if (isset($field['class'])) {
			$field['class'] = "{$field['class']} elgg-input-unvalidated";
		} else {
			$field['class'] = 'elgg-input-unvalidated';
		}
		$wrapper_class = 'elgg-input-wrapper-unvalidated';
	} else if ($status == true) {
		if (isset($field['class'])) {
			$field['class'] = "{$field['class']} elgg-input-validated";
		} else {
			$field['class'] = 'elgg-input-validated';
		}
		$wrapper_class = 'elgg-input-wrapper-validated';
	}

	$validation_message = elgg_extract('msg', $validation_status, null);
	if ($validation_message) {
		$validation_message = elgg_view('framework/bootstrap/form/elements/validation_message', array('msg' => $validation_message));
	}
}

if ($sticky_value) {
	$field['value'] = $sticky_value;
}

$view = "input/$input_type";
if (isset($field['override_view'])) {
	if (elgg_view_exists($field['override_view'])) {
		$view = $field['override_view'];
	}
	unset($field['override_view']);
} else if (!elgg_view_exists($view)) {
	$view = 'input/text';
}

unset($field['form_name']);

$input = elgg_view($view, $field);

$wrapper_params = array(
	'label' => $label,
	'hint' => $hint,
	'input' => $input,
	'validation_message' => $validation_message,
	'class' => $wrapper_class,
	'field' => $field_source
);

echo elgg_view('framework/bootstrap/form/elements/wrapper', $wrapper_params);