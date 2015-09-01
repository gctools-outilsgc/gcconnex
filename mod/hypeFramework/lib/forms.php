<?php

/**
 * 	Rendering and validation of forms
 * 
 * @example mod/hypeFramework/documentation/examples/form.php An example of how to create / render form
 * @link mod/hypeFramework/views/default/framework/bootstrap/form/body.php
 */
function hj_framework_view_form($form_name, $params = array()) {

	$params = hj_framework_prepare_form($form_name, $params);

	$form = elgg_extract('form', $params, array());
	$attributes = elgg_extract('attributes', $form, array());

	$attributes['body'] = elgg_view('framework/bootstrap/form/body', $params);

	return elgg_view('input/form', $attributes);
}

/**
 * Rendering of a form body
 * 
 * @param str $form_name
 * @param mixed $params
 */
function hj_framework_view_form_body($form_name, $params = array()) {

	$params = hj_framework_prepare_form($form_name, $params);
	return elgg_view('framework/bootstrap/form/body', $params);
}

function hj_framework_prepare_form($form_name, $params = array()) {

	$config = elgg_trigger_plugin_hook('init', "form:$form_name", $params, array());

	$fields = elgg_extract('fields', $config, array());

	$params['form'] = $config;
	$params['form_name'] = $form_name;

	// Get sticky values
	if (elgg_is_sticky_form($form_name)) {
		$sticky_values = elgg_get_sticky_values($form_name);
		elgg_clear_sticky_form($form_name);
	}

	// Get validation errors and messages
	$validation_status = hj_framework_get_form_validation_status($form_name);
	hj_framework_clear_form_validation_status($form_name);

	// Add missing entity attribute fields as hidden inputs
	$entity_attributes = array(
		'guid', 'type', 'subtype', 'owner_guid', 'container_guid', 'access_id', 'title', 'description'
	);

	foreach ($entity_attributes as $attr) {

		if (!array_key_exists($attr, $fields)) {

			$params['form']['fields'][$attr] = array(
				'name' => $attr,
				'input_type' => 'hidden',
				'value' => ($params['entity']) ? $params['entity']->$attr : elgg_extract($attr, $params)
			);
		}
	}

	// Prepare fields
	if ($fields && count($fields)) {

		foreach ($fields as $name => $options) {

			if (!$options || empty($options)) {
				unset($fields['name']);
				continue;
			}

			$field['name'] = $name;

			if (isset($sticky_values[$name])) {
				$field['sticky_value'] = $sticky_values[$name];
			}

			if (isset($validation_status[$name])) {
				$field['validation_status'] = $validation_status[$name];
			}

			if (is_string($options)) {  // field options are set as a callback function
				if (is_callable($options)) {
					$params['field'] = $field;
					$options = call_user_func($options, $params);
					$options['name'] = $name;
				} else {
					continue;
				}
			} else {
				$options = array_merge($options, $field);
			}

			$params['field'] = $options;

			// Walk through field options to see if value, options or options_values parameter was set as callback function
			array_walk($params['field'], 'hj_framework_map_callable_field_options', $params);

			if ($params['field']['input_type'] == 'file' || $params['field']['value_type'] == 'file') {
				$multipart = true;
			}

			$params['form']['fields'][$name] = $params['field'];

			unset($params['field']);
		}
	}

	if ($multipart) {
		$params['form']['attributes']['enctype'] = 'multipart/form-data';
	}

	if (!isset($params['form']['attributes']['action'])) {
		$params['form']['attributes']['action'] = 'action/framework/edit/object';
	}

	if (!isset($params['form']['attributes']['method'])) {
		$params['form']['attributes']['method'] = 'POST';
	}

	if (!isset($params['form']['attributes']['id'])) {
		$params['form']['attributes']['id'] = preg_replace('/[^a-z0-9\-]/i', '-', $form_name);
	}

	return $params;
}

/**
 * Validate the form before proceeding with the action
 * 
 * @param str $form_name
 * @return bool
 */
function hj_framework_validate_form($form_name = null) {

	if (!$form_name) {
		return false;
	}

	$form = hj_framework_prepare_form($form_name);
	$fields = $form['form']['fields'];

	if ($fields) {

		foreach ($fields as $name => $options) {

			if (!$options)
				continue;

			$type = elgg_extract('input_type', $options, 'text');

			$valid['status'] = true;
			$valid['msg'] = elgg_echo('hj:framework:input:validation:success');


			if ($options['required'] === true || $options['required'] == 'required' || $options['ltrequired'] == true) {
				$value = get_input($name, '');

				$fail = false;

				if (is_array($value)) {
					$empty = 0;
					foreach ($value as $val) {
						if (!$val || empty($val))
							$empty++;
					}
					if ($empty == count($value)) {
						$fail = true;
					}
				} else if (!$value || empty($value)) {
					$fail = true;
				}

				if ($fail) {
					if (is_string($options['label'])) {
						$options['label'] = array('text' => $options['label']);
					}

					if (!isset($options['label']['text'])) {
						$options['label']['text'] = elgg_echo("$form_name:$name");
					}

					$valid['status'] = false;
					$valid['msg'] = elgg_echo('hj:framework:input:validation:error:requiredfieldisempty', array($options['label']['text']));
				}
			}

			$valid = elgg_trigger_plugin_hook('validate:input', "form:input:name:$name", array('form_name' => $form_name), $valid);
			$valid = elgg_trigger_plugin_hook('validate:input', "form:input:type:$type", array('form_name' => $form_name), $valid);

			hj_framework_set_form_validation_status($form_name, $name, $valid['status'], $valid['msg']);

			if ($valid['status'] === false) {
				$error = true;
			}
		}
	}

	if ($error) {
		elgg_make_sticky_form($form_name);
		register_error(elgg_echo('hj:framework:form:validation:error'));
		return false;
	}

	return true;
}

/**
 * Let the views know the validation status so that appropriated messages can be shown to the user
 *
 * @param str $form_name
 * @return mixed
 */
function hj_framework_get_form_validation_status($form_name) {

	$validation_status = null;

	if (isset($_SESSION['form_validation_status'][$form_name])) {
		$validation_status = $_SESSION['form_validation_status'][$form_name];
	}

	return $validation_status;
}

/**
 * Store field validation status and message
 *
 * @param str $form_name
 * @param str $field_name
 * @param bool $status
 * @param str $msg
 * @return void
 */
function hj_framework_set_form_validation_status($form_name, $field_name, $status = true, $msg = '') {

	if (!isset($_SESSION['form_validation_status'][$form_name])) {
		$_SESSION['form_validation_status'][$form_name] = array();
	}

	$_SESSION['form_validation_status'][$form_name][$field_name] = array(
		'status' => $status,
		'msg' => $msg
	);

	return;
}

/**
 * Clear validation status after informing the user about errors
 *
 * @param str $form_name
 * @return void
 */
function hj_framework_clear_form_validation_status($form_name) {

	if (isset($_SESSION['form_validation_status'][$form_name])) {
		unset($_SESSION['form_validation_status'][$form_name]);
	}

	return;
}

// Custom input processing
elgg_register_plugin_hook_handler('process:input', 'form:input:type:tags', 'hj_framework_process_tags_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:type:file', 'hj_framework_process_file_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:type:entity_icon', 'hj_framework_process_entity_icon_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:name:category', 'hj_framework_process_category_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:name:category_guid', 'hj_framework_process_category_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:name:category_guids', 'hj_framework_process_category_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:name:add_to_river', 'hj_framework_process_add_to_river_input');
elgg_register_plugin_hook_handler('process:input', 'form:input:name:notify_admins', 'hj_framework_process_notify_admins_input');

function hj_framework_process_tags_input($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);

	if (!elgg_instanceof($entity)) {
		return false;
	}

	$name = elgg_extract('name', $params, 'tags');
	$access_id = elgg_extract('access_id', $params);

	$value = get_input($name, '');

	$value = string_to_tag_array($value);

	elgg_delete_metadata(array(
		'guid' => $entity->guid,
		'metadata_names' => $name
	));

	if ($value) {
		foreach ($value as $val) {
			create_metadata($entity->guid, $name, $val, '', $entity->owner_guid, $access_id, true);
		}
	}

	return true;
}

function hj_framework_process_file_input($hook, $type, $return, $params) {

	if (!elgg_is_logged_in())
		return false;

	// Maybe someone doesn't want us to save the file in this particular way
	if (!elgg_trigger_plugin_hook('process:upload', 'form:input:type:file', $params, false)) {
		hj_framework_process_file_upload($params['name'], $params['entity']);
	}

	return true;
}

function hj_framework_process_entity_icon_input($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	$name = elgg_extract('name', $params);

	global $_FILES;
	if ((isset($_FILES[$name])) && (substr_count($_FILES[$name]['type'], 'image/')) && !$_FILES[$name]['error']) {

		$file = new hjFile();
		$file->owner_guid = $entity->guid;
		$file->setFilename('hjfile/' . time() . $_FILES[$name]['name']);
		$file->open("write");
		$file->close();
		move_uploaded_file($_FILES[$name]['tmp_name'], $file->getFilenameOnFilestore());

		hj_framework_generate_entity_icons($entity, $file);

		$file->delete();
	}
	return true;
}

function hj_framework_process_notify_admins_input($hook, $type, $return, $params) {

	$admins = elgg_get_admins();
	foreach ($admins as $admin) {
		$to[] = $admin->guid;
	}

	$form = elgg_extract('form', $params);
	$entity = elgg_extract('entity', $params);

	$from = elgg_get_config('site')->guid;
	$subject = elgg_echo('hj:framework:form:submitted:subject', elgg_echo($form->title));

	$submissions_url = $form->getURL();
	$message = elgg_echo('hj:framework:form:submitted:message', array($entity->getURL()));
	notify_user($to, $from, $subject, $message);

	return true;
}

/**
 * Helper function used to dynamically construct options arrays for form fields
 *
 * @see hj_framework_forms_init()
 *
 * @param mixed $value		Callback function or array
 * @param str	$key		Field name
 * @param mixed $params		An array of parameters recieved from the form view, including $entity (if any)
 */
function hj_framework_map_callable_field_options_array(&$value, $key, $params = array()) {
	if (is_string($value) && is_callable($value)) {
		$value = call_user_func($value, $params);
	}
}

/**
 * Helper function used to dynamically determine 'value', 'options', 'options_values' keys for the 'input/$input_type' view
 *
 * @param mixed $value		Callback function
 * @param str	$key		Field option name
 * @param mixed $params		An array of parameters received from the form view, include $entity (if any)
 */
function hj_framework_map_callable_field_options(&$value, $key, $params = array()) {
	$mappable_values = array('value', 'options', 'options_values');
	if (in_array($key, $mappable_values) && is_string($value) && is_callable($value)) {
		$value = call_user_func($value, $params);
	}
}

function hj_framework_process_add_to_river_input($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);
	$event = elgg_extract('event', $params, 'create');
	$name = elgg_extract('name', $params);

	$add_to_river = get_input($name, false);

	if (!$entity || !$add_to_river)
		return false;

	$view = "river/{$entity->getType()}/{$entity->getSubtype()}/$event";
	if (!elgg_view_exists($view)) {
		$view = "river/object/hjformsubmission/create";
	}
	add_to_river($view, "$event", elgg_get_logged_in_user_guid(), $entity->guid);

	return true;
}

function hj_framework_process_category_input($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);
	$name = elgg_extract('name', $params);

	$category_guids = get_input($name, 0);

	if (is_string($category_guids) && !is_numeric($category_guids)) {
		return false;
	}

	if (!$category_guids || empty($category_guids)) {
		return false;
	}

	if ($category_guids && !is_array($category_guids)) {
		$category_guids = array($category_guids);
	}

	$current_categories = elgg_get_entities_from_relationship(array(
		'relationship' => 'filed_in',
		'relationship_guid' => $entity->guid,
	));

	// 1. check if the forum is under any category
	//		a. if category is nil, place forum under move to category
	// 2. check if current category = move under category
	//		a. if equal, do nothing
	// 		b. if not equal, remove old category then add new category

	if (!$current_categories[0])
	{
		$category = get_entity($category_guids[0]);
		if (!check_entity_relationship($entity->guid, 'filed_in', $category->guid)) {
			add_entity_relationship($entity->guid, 'filed_in', $category->guid);
		}
		$category = $category->getContainerEntity();

	} elseif ($current_categories[0]->guid == $category_guids[0]) {

		$category = $current_categories[0];
		$category = $category->getContainerEntity();
	
	} else {

		remove_entity_relationship($entity->guid, 'filed_in', $current_categories[0]->guid);
		add_entity_relationship($entity->guid, 'filed_in', $category_guids[0]);
		$category = get_entity($category_guids[0]);
		$category = $category->getContainerEntity();
	}

	return true;
}

elgg_register_plugin_hook_handler('init', 'form:edit:plugin:hypeframework', 'hj_framework_init_plugin_settings_form');
elgg_register_plugin_hook_handler('init', 'form:edit:object:hjfile', 'hj_framework_init_file_form');

function hj_framework_init_plugin_settings_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	$settings = array(
		'interface_ajax',
		'interface_location',
		'files_keep_originals',
	);

	foreach ($settings as $s) {
		$config['fields']["params[$s]"] = array(
			'input_type' => 'dropdown',
			'options_values' => array(
				0 => elgg_echo('disable'),
				1 => elgg_echo('enable')
			),
			'value' => $entity->$s,
			'hint' => elgg_echo("hj:framework:settings:hint:$s")
		);
	}

	$config['buttons'] = false;

	return $config;
}

function hj_framework_init_file_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, null);
	$container_guid = ($entity) ? $entity->container_guid : elgg_extract('container_guid', $params, ELGG_ENTITIES_ANY_VALUE);
	$container = get_entity($container_guid);

	$config = array(
		'attributes' => array(
			'enctype' => 'multipart/form-data',
			'id' => 'form-edit-object-hjfile',
			'action' => 'action/edit/object/hjfile'
		),
		'fields' => array(
			'type' => array(
				'input_type' => 'hidden',
				'value' => 'object'
			),
			'subtype' => array(
				'input_type' => 'hidden',
				'value' => 'hjfile'
			),
			'upload' => array(
				'input_type' => 'file',
				'value' => ($entity),
			),
			'title' => array(
				'value' => ($entity) ? $entity->title : '',
				'required' => true,
			),
			'description' => array(
				'value' => ($entity) ? $entity->description : '',
				'input_type' => 'longtext',
				'class' => 'elgg-input-longtext',
			),
			'tags' => array(
				'input_type' => 'tags',
				'value' => $entity->tags,
			),
			'access_id' => array(
				'input_type' => 'access',
				'value' => ($entity->access_id) ? $entity->access_id : get_default_access()
			)
		)
	);

	return $config;
}