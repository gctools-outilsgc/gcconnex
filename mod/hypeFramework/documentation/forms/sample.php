<?php

$form = array(
	'attributes' => array(
		'enctype' => 'multipart/form-data',
		'id' => 'some-form-id'
	),
	'title' => array(
		'edit' => elgg_echo(''),
		'create' => elgg_echo('')
	),
	'description' => array(
		'edit' => elgg_echo(''),
		'create' => elgg_echo('')
	),
	'fields' => array(
		'long' => array(
			'input_type' => 'dropdown',
			'value' => '',
			'override_view' => '',
			'options' => array(),
			'options_values' => array(),
			'label' => array(
				'text' => '',
				'attribute1' => 'value1'
			),
			'hint' => array(
				'text' => '',
				'attribute1' => 'value1'
			),
		)
	)
);