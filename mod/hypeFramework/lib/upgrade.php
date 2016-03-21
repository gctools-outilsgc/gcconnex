<?php
//run_function_once('hj_framework_upgrade_187');
function hj_framework_upgrade_187() {

	$formconfig = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'formconfig',
		'limit' => 1
			));

	if (!$formconfig) {
		$formconfig = new ElggObject();
		$formconfig->subtype = 'formconfig';
		$formconfig->access_id = ACCESS_PUBLIC;
		$guid = $formconfig->save();
		elgg_set_plugin_setting('formconfig', $guid, 'hypeFramework');
	} else {
		$formconfig = $formconfig[0];
	}

	$forms = elgg_get_entities(array(
		'types' => array('object'),
		'subtypes' => array('hjform'),
		'limit' => 0
			));

	if ($forms) {
		foreach ($forms as $f) {

			// reset form attributes
			$options['attributes'] = array(
				'action' => $f->action,
				'method' => $f->method,
				'enctype' => $f->enctype,
				'title' => $f->title,
				'description' => $f->description
			);

			$subject_entity_type = $f->subject_entity_type;
			if (!$subject_entity_type) {
				$subject_entity_type = 'object';
			}

			$subject_entity_subtype = $f->subject_entity_subtype;
			if (!$subject_entity_subtype || empty($subject_entity_subtype)) {
				$subject_entity_subtype = 'hjformsubmission';
			}

			$handler = $f->handler;

			// reset subject entity attributes
			$options['subject_entity'] = array(
				'type' => $subject_entity_type,
				'subtype' => $subject_entity_subtype,
				'handler' => $handler
			);

			// remove plugin setting
			$dbprefix = elgg_get_config('dbprefix');
			$statement = "DELETE from {$dbprefix}private_settings WHERE name = 'hj:form:{$subject_entity_type}:{$subject_entity_subtype}'";
			delete_data($statement);

			if ($handler) {
				$options['name'] = "{$subject_entity_subtype}:{$handler}:edit";
			} else {
				$options['name'] = "{$subject_entity_subtype}:edit";
			}

			// reset form fields
			$fields = elgg_get_entities(array(
				'type' => 'object',
				'subtype' => 'hjfield',
				'container_guid' => $f->guid,
				'limit' => 0
					));

			$new_fields = array();
			if ($fields) {
				foreach ($fields as $field) {
					$new_fields[$field->name] = array(
						'label' => array(
							'text' => $field->label
						),
						'hint' => (isset($field->tooltip)) ? array(
							'text' => $field->tooltip
								) : false,
						'type' => $field->input_type,
						'class' => $field->class,
						'required' => $field->mandatory,
						'priority' => $field->priority
					);

					if (isset($field->value)) {
						$value = $field->value;
						if (is_string($value)) {
							if (substr($to_eval, -1) == ';') {
								eval("\$value = $value");
							} else {
								eval("\$value = $value;");
							}
						}
						$new_fields[$field->name]['value'] = $value;
					}

					if (isset($field->options)) {
						$value = $field->options;
						if (is_string($value)) {
							if (substr($to_eval, -1) == ';') {
								eval("\$value = $value");
							} else {
								eval("\$value = $value;");
							}
						}
						$new_fields[$field->name]['options'] = $value;
					}

					if (isset($field->options_values)) {
						$value = $field->options_values;
						if (is_string($value)) {
							if (substr($to_eval, -1) == ';') {
								eval("\$value = $value");
							} else {
								eval("\$value = $value;");
							}
						}
						$new_fields[$field->name]['options_values'] = $value;
					}

					$field->delete();
				}
			}

			// reset post validation
			$new_fields['submit'] = array(
				'label' => false,
				'type' => 'submit',
				'value' => elgg_echo('submit'),
				'priority' => 900,
				'fieldset' => 'footer'
			);

			$options['inputs'] = $new_fields;
			$options['validate'] = array(
				'notify_admins' => $f->notify_admins,
				'add_to_river' => $f->add_to_river,
				'comments_on' => $f->comments_on,
				'forward' => $f->forward_to,
			);

			$entities = elgg_get_entities_from_metadata(array(
				'type' => 'object',
				'metadata_name_value_pairs' => array(
					'name' => 'data_pattern',
					'value' => $f->guid
				),
				'limit' => 0
					));

			if ($entities) {
				foreach ($entities as $entity) {

					$entity->form_name = $options['name'];
					unset($entity->data_pattern);

					$widget_guid = $entity->widget;
					if (!check_entity_relationship($widget_guid, 'widget', $entity->guid)) {
						add_entity_relationship($widget_guid, 'widget', $entity->guid);
					}
					unset($entity->widget);

					$segment_guid = $entity->segment;
					if (!check_entity_relationship($segment_guid, 'segment', $entity->guid)) {
						add_entity_relationship($segment_guid, 'segment', $entity->guid);
					}
					unset($entity->segment);
				}
			}

			$f->delete();

			create_metadata($formconfig->guid, "forms", serialize($options), '', $formconfig->owner_guid, ACCESS_PUBLIC, true);
		}
	}
}

