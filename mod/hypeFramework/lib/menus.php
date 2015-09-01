<?php

// cyu - 12/15/2014 modified: this creates "public" text in the members page
//elgg_register_plugin_hook_handler('register', 'menu:entity', 'hj_framework_entity_menu');
elgg_register_plugin_hook_handler('register', 'menu:title', 'hj_framework_entity_title_menu');

function hj_framework_entity_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);

if ($entity instanceof ElggUser)
	return $return;

if (!elgg_instanceof($entity))
	return $return;

switch ($entity->getSubtype()) {

	case 'hjfile' :
		$items = array(
			'download' => array(
				'text' => elgg_echo('download'),
				'href' => $entity->getDownloadURL(),
				'class' => 'elgg-button-download',
				'data-uid' => $entity->guid,
				'priority' => 500
			),
			'edit' => array(
				'text' => elgg_echo('edit'),
				'href' => $entity->getEditURL(),
				'class' => 'elgg-button-edit-entity',
				'data-toggle' => 'dialog',
				'data-callback' => 'refresh:lists::framework',
				'data-uid' => $entity->guid,
				'priority' => 995
			),
			'delete' => array(
				'text' => elgg_echo('delete'),
				'href' => $entity->getDeleteURL(),
				'class' => 'elgg-button-delete-entity',
				'data-uid' => $entity->guid,
				'priority' => 1000
			)
		);
		break;
}

if ($items) {
	foreach ($items as $name => $options) {
		$options['name'] = $name;
		$return[$name] = ElggMenuItem::factory($options);
	}
}
	return $return;
}


function hj_framework_entity_title_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);

	if (!elgg_instanceof($entity)) {
		return $return;
	}

	switch ($entity->getSubtype()) {
			
		case 'hjfile' :

			$items = array(
				'access' => array(
					'text' => elgg_view('output/access', array('entity' => $entity)),
					'href' => false,
					'data-uid' => $entity->guid,
					'priority' => 100
				),
				'download' => array(
					'text' => elgg_echo('hj:framework:download'),
					'href' => $entity->getDownloadURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-download',
					'data-uid' => $entity->guid,
					'priority' => 500
				),
				'edit' => array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-uid' => $entity->guid,
					'priority' => 995
				),
				'delete' => array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button elgg-button-delete elgg-requires-confirmation',
					'data-uid' => $entity->guid,
					'priority' => 1000
				)
			);
			break;
	}

	if ($items) {
		foreach ($items as $name => $options) {
			$options['name'] = $name;
			$return[$name] = ElggMenuItem::factory($options);
		}
	}
	return $return;
}
