<?php

$shortcuts = hj_framework_path_shortcuts('hypeFramework');
$path_actions = $shortcuts['actions'];

elgg_register_action('framework/edit/object', $path_actions . 'framework/edit/object.php');
elgg_register_action('framework/delete/object', $path_actions . 'framework/delete/object.php');
elgg_register_action('framework/access/set', $path_actions . 'framework/access/set.php');

elgg_register_action('framework/bookmark', $path_actions . 'framework/bookmark/default.php');
elgg_register_action('framework/bookmark/create', $path_actions . 'framework/bookmark/create.php');
elgg_register_action('framework/bookmark/remove', $path_actions . 'framework/bookmark/remove.php');

elgg_register_action('framework/subscription', $path_actions . 'framework/subscription/default.php');
elgg_register_action('framework/subscription/create', $path_actions . 'framework/subscription/create.php');
elgg_register_action('framework/subscription/remove', $path_actions . 'framework/subscription/remove.php');

elgg_register_action('framework/file/temp', $path_actions . 'framework/file/temp.php');

elgg_register_action('edit/object/hjfile', $path_actions . 'framework/edit/object/hjfile.php');

// hjForum / hjForumTopic / hjForumCategory
function hj_framework_edit_object_action() {

	$form_name = get_input('form_name', false);
	elgg_make_sticky_form($form_name);

	if (!hj_framework_validate_form($form_name)) {
		return false;
	}

	$guid = get_input('guid', ELGG_ENTITIES_ANY_VALUE);
	$event = ($guid) ? 'edit' : 'create';
	$type = get_input('type');
	$subtype = get_input('subtype');
	$class = get_subtype_class($type, $subtype);

	if ($class) {

		$entity = new $class($guid);

	} else {

		switch (get_input('type', 'object')) {
			case 'object' :
				$entity = new ElggObject($guid);
				break;

			case 'user' :
				$entity = new ElggUser($guid);
				break;

			case 'group' :
				$entity = new ElggGroup($guid);
				break;

			default:
				return false;
				break;

		}
	}

	if ($guid) { // ENTITY ALREADY EXISTS

		if ((int) get_input('container_guid', 0) > 0) {
			$entity->container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
		}

		if ($title = get_input('title', '')) {
			$entity->title = $title;
		}

		$entity->description = get_input('description', '');

		if ($access_id = get_input('access_id', ACCESS_DEFAULT)) {
			$entity->access_id = $access_id;
		}
		
	} else { // ENTITY NOT FOUND; CREATE NEW ENTITY

		$entity->subtype = get_input('subtype', 'hjformsubmission');

		if ($owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE)) {
			$entity->owner_guid = $owner_guid;
		}

		if ($container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE)) {
			$entity->container_guid = $container_guid;
		}

		$entity->title = get_input('title', '');
		$entity->description = get_input('description', '');

		$entity->access_id = get_input('access_id', ACCESS_DEFAULT);

	} // end if else


	$guid = $entity->save();
	if (!$guid) { 

		register_error(elgg_echo('hj:framework:error:cannotcreateentity'));
		return false;

	} else {

		$accesslevel = get_input('accesslevel', false);

		$params = array(
			'entity' => $entity
		);

		$form = hj_framework_prepare_form($form_name, $params);
		$fields = $form['form']['fields'];

		$ignore_fields = array('guid', 'type', 'subtype', 'owner_guid', 'container_guid', 'access_id', 'title', 'description');

		foreach ($fields as $name => $options) {

			if (in_array($name, $ignore_fields))
				continue;

			if (!$options)
				continue;
			
			$type = elgg_extract('input_type', $options, 'text');

			$accesslevel_id = (isset($accesslevel[$name])) ? $accesslevel[$name] : $entity->access_id;

			$params = array(
				'name' => $name,
				'form_name' => $form_name,
				'field' => $options,
				'access_id' => $accesslevel_id,
				'entity' => $entity,
				'event' => $event
			);

			if (!elgg_trigger_plugin_hook('process:input', "form:input:name:$name", $params, false)
				&& !elgg_trigger_plugin_hook('process:input', "form:input:type:$type", $params, false)) {

				$value = get_input($name);
				set_input($name, null);

				$entity->$name = $value;
			}

		} // end foreach loop

		$entity->save();
		elgg_trigger_plugin_hook('process:form', "form:$form_name", array('form_name' => $form_name, 'entity' => $entity), null);
	
	} // end if else

	$forward_url = elgg_trigger_plugin_hook('action:forward', 'form', array('entity' => $entity, 'form_name' => $form_name), $entity->getURL());
	system_message(elgg_echo('hj:framework:submit:success'));

	// cyu - 12/11/2014: this will direct user back to the first layer (not group page)
	$container_guid = get_entity($guid)->getContainerEntity()->guid;
	if (get_entity($guid)->getContainerEntity() instanceof ElggGroup)
		$forward_url = elgg_get_site_url().'forum/group/'.$container_guid;

	elgg_clear_sticky_form($form_name);
	hj_framework_clear_form_validation_status($form_name);

	return array(
		'entity' => $entity,
		'forward' => $forward_url
	);
}