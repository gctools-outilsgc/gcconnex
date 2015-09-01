<?php

elgg_register_plugin_hook_handler('init', 'form:edit:plugin:hypeforum', 'hj_forum_init_plugin_settings_form');
elgg_register_plugin_hook_handler('init', 'form:edit:plugin:user:hypeforum', 'hj_forum_init_plugin_user_settings_form');
elgg_register_plugin_hook_handler('init', 'form:edit:object:hjforum', 'hj_forum_init_forum_form');
elgg_register_plugin_hook_handler('init', 'form:edit:object:hjforumtopic', 'hj_forum_init_forumtopic_form');
elgg_register_plugin_hook_handler('init', 'form:edit:object:hjforumpost', 'hj_forum_init_forumpost_form');
elgg_register_plugin_hook_handler('init', 'form:edit:object:hjforumcategory', 'hj_forum_init_forumcategory_form');

function hj_forum_init_plugin_settings_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	$settings = array(
		'categories_top',
		'categories',
		'subforums',
		'forum_cover',
		'forum_sticky',
		'forum_topic_cover',
		'forum_topic_icon',
		'forum_forum_river',
		'forum_topic_river',
		'forum_post_river',
		'forum_subscriptions',
		'forum_bookmarks',
		'forum_group_forums',
		'forum_user_signature'
	);

	foreach ($settings as $s) {
		$config['fields']["params[$s]"] = array(
			'input_type' => 'dropdown',
			'options_values' => array(
				0 => elgg_echo('disable'),
				1 => elgg_echo('enable')
			),
			'value' => $entity->$s,
			'hint' => elgg_echo("edit:plugin:hypeforum:hint:$s")
		);
	}

	$default_types = array('default', 'star', 'heart', 'question', 'important', 'info', 'idea', 'laugh', 'surprise', 'lightning', 'announcement', 'lock');
	$config['fields']['params[forum_topic_icon_types]'] = array(
		'value' => (isset($entity->forum_topic_icon_types)) ? $entity->forum_topic_icon_types : implode(',', $default_types),
		'hint' => elgg_echo('edit:plugin:hypeforum:topic_icon_hint')
	);

	$config['buttons'] = false;

	return $config;
}

function hj_forum_init_plugin_user_settings_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	$user = elgg_get_page_owner_entity();

	$config['fields'] = array(
//		'params[hypeforum_digest]' => array(
//			'input_type' => 'dropdown',
//			'options_values' => array(
//				'fiveminute' => elgg_echo('hj:forum:digest:fiveminute'),
//				'daily' => elgg_echo('hj:forum:digest:daily'),
//				'weekly' => elgg_echo('hj:forum:digest:weekly')
//			),
//			'value' => $entity->getUserSetting('hypeforum_digest', $user->guid)
//		),
		'params[hypeforum_signature]' => (HYPEFORUM_USER_SIGNATURE) ? array(
			'input_type' => 'longtext',
			'class' => 'elgg-input-longtext',
			'value' => $entity->getUserSetting('hypeforum_signature', $user->guid)
				) : null,
		
	);

	$config['buttons'] = false;

	return $config;
}

function hj_forum_init_forum_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, null);
	$container_guid = ($entity) ? $entity->container_guid : elgg_extract('container_guid', $params, ELGG_ENTITIES_ANY_VALUE);
	$container = get_entity($container_guid);

	$config = array(
		'attributes' => array(
			'enctype' => 'multipart/form-data',
			'id' => 'form-edit-object-hjforum',
			'action' => 'action/edit/object/hjforum'
		),
		'fields' => array(
			'type' => array(
				'input_type' => 'hidden',
				'value' => 'object'
			),
			'subtype' => array(
				'input_type' => 'hidden',
				'value' => 'hjforum'
			),
			'cover' => (HYPEFORUM_FORUM_COVER) ? array(
				'input_type' => 'entity_icon',
				'value_type' => 'file',
				'value' => (isset($entity->icontime))
					) : null,
			'title' => array(
				'value' => $entity->title,
				'required' => true
			),
			'description' => array(
				'value' => $entity->description,
				'input_type' => 'longtext',
				'class' => 'elgg-input-longtext',
			),
			'category' => hj_forum_get_forum_category_input_options($entity, $container),
			'enable_subcategories' => (HYPEFORUM_CATEGORIES) ? array(
				'input_type' => 'checkboxes',
				'options' => array(
					elgg_echo('edit:object:hjforum:enable_subcategories') => 1
				),
				'value' => $entity->enable_subcategories,
				'label' => false,
				'default' => false
					) : null,

			// cyu - 01/05/2015: allows moderators to allow/disallow topic posting on some levels of the forums
			'enable_posting' => array(
				'input_type' => 'checkboxes',
				'options' => array(
					elgg_echo('edit:object:hjforum:disable_posting') => 1
				),
				'value' => $entity->enable_posting,
				'label' => false,
				'default' => false 
				),

			'access_id' => array(
				'value' => 2, //$entity->access_id, // changed to public 12-10-2014 BA
				'input_type' => 'access'
			),
			'add_to_river' => (HYPEFORUM_FORUM_RIVER) ? array(
				'input_type' => 'hidden',
				'value' => ($entity) ? false : true
					) : null
		)
	);

	return $config;
}

function hj_forum_init_forumtopic_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, null);
	$container_guid = ($entity) ? $entity->container_guid : elgg_extract('container_guid', $params, ELGG_ENTITIES_ANY_VALUE);
	$container = get_entity($container_guid);

	$config = array(
		'attributes' => array(
			'enctype' => 'multipart/form-data',
			'id' => 'form-edit-object-hjforumtopic',
			'action' => 'action/edit/object/hjforumtopic'
		),
		'fields' => array(
			'type' => array(
				'input_type' => 'hidden',
				'value' => 'object'
			),
			'subtype' => array(
				'input_type' => 'hidden',
				'value' => 'hjforumtopic'
			),
			'cover' => (HYPEFORUM_FORUM_TOPIC_COVER) ? array(
				'input_type' => 'entity_icon',
				'value_type' => 'file',
				'value' => (isset($entity->icontime))
					) : null,
			'icon' => (HYPEFORUM_FORUM_TOPIC_ICON) ? array(
				'input_type' => 'radio',
				'options' => hj_forum_get_forum_icons($entity, $container),
				'class' => 'elgg-horizontal',
				'value' => ($entity) ? $entity->icon : 'default'
					) : null,
			'title' => array(
				'value' => $entity->title,
				'required' => true
			),
			'description' => array(
				'value' => $entity->description,
				'input_type' => 'longtext',
				'class' => 'elgg-input-longtext',
				'ltrequired' => true // hack for tinymce longtext
			),
			'sticky' => (HYPEFORUM_STICKY && elgg_is_admin_logged_in()) ? array(
				'input_type' => 'checkboxes',
				'options' => array(
					elgg_echo('edit:object:hjforum:sticky') => 1
				),
				'value' => $entity->sticky,
				'label' => false,
				'default' => false
					) : null,
			'category' => hj_forum_get_forum_category_input_options($entity, $container),
			'access_id' => array(
				'value' => 2, //$entity->access_id,	// cyu - 12/16/2014: modified to default to public
				'input_type' => 'access'
			),
			'add_to_river' => (HYPEFORUM_TOPIC_RIVER) ? array(
				'input_type' => 'hidden',
				'value' => ($entity) ? false : true
					) : null
		)
	);

	return $config;
}

function hj_forum_init_forumpost_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, null);
	$container_guid = ($entity) ? $entity->container_guid : elgg_extract('container_guid', $params, ELGG_ENTITIES_ANY_VALUE);
	$container = get_entity($container_guid);

	$config = array(
		'attributes' => array(
			'enctype' => 'multipart/form-data',
			'id' => 'form-edit-object-hjforumpost',
			'action' => 'action/edit/object/hjforumpost'
		),
		'fields' => array(
			'type' => array(
				'input_type' => 'hidden',
				'value' => 'object'
			),
			'subtype' => array(
				'input_type' => 'hidden',
				'value' => 'hjforumpost'
			),
			'title' => array(
				'input_type' => 'hidden',
				'value' => "Re: $entity->title",
			),
			'quote' => null,
			'quote_text' => null,
			'description' => array(
				'value' => $entity->description,
				'input_type' => 'longtext',
				'class' => 'elgg-input-longtext',
				'ltrequired' => true
			),
			'access_id' => array(
				'value' => ($entity) ? $entity->access_id : $container->access_id,
				'input_type' => 'hidden'
			),
			'add_to_river' => (HYPEFORUM_POST_RIVER) ? array(
				'input_type' => 'hidden',
				'value' => ($entity) ? false : true
					) : null
		)
	);

	$quote = get_input('quote', false);
	if (!$entity && $quote) {
		$quoted_entity = get_entity($quote);
		if ($quoted_entity) {
			$config['fields']['quote_text'] = array(
				'value' => $quoted_entity->description,
				'override_view' => 'output/longtext',
				'label' => false
				);
			$config['fields']['quote'] = array(
				'input_type' => 'hidden',
				'value' => $quote
			);
		}
	}

	return $config;
}

function hj_forum_init_forumcategory_form($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, null);

	$config = array(
		'attributes' => array(
			'id' => 'form-edit-object-hjforumcategory',
			'action' => 'action/edit/object/hjforumcategory'
		),
		'fields' => array(
			'type' => array(
				'input_type' => 'hidden',
				'value' => 'object'
			),
			'subtype' => array(
				'input_type' => 'hidden',
				'value' => 'hjforumcategory'
			),
			'title' => array(
				'value' => $entity->title,
				'required' => true
			),
			'description' => array(
				'value' => $entity->description,
				'input_type' => 'longtext',
				'class' => 'elgg-input-logntext'
			),
			'access_id' => array(
				'value' => ($entity) ? $entity->access_id : ACCESS_PUBLIC,
				'input_type' => 'hidden'
			)
		)
	);

	return $config;
}

function hj_forum_get_forum_category_input_options($entity = null, $container = null) {

	if ((elgg_instanceof($container, 'site') || elgg_instanceof($container, 'group')) && !HYPEFORUM_CATEGORIES_TOP) {
		return false;
	}

	if (elgg_instanceof($container, 'object', 'hjforum') && !HYPEFORUM_CATEGORIES) {
		return false;
	}

	if (!$entity && !$container)
		return false;

	if (elgg_instanceof($container, 'object', 'hjforum') && !$container->enable_subcategories) {
		return false;
	}

	$dbprefix = elgg_get_config('dbprefix');
	$categories = elgg_get_entities(array(
		'types' => 'object',
		'subtypes' => 'hjforumcategory',
		'limit' => 0,
		'container_guids' => $container->guid,
		'joins' => array("JOIN {$dbprefix}objects_entity oe ON oe.guid = e.guid"),
		'order_by' => 'oe.title ASC'
			));

	if ($categories) {
		foreach ($categories as $category) {
			$options_values[$category->guid] = $category->title;
		}

		if ($entity) {
			$categories = $entity->getCategories('hjforumcategory');
			$value = $categories[0]->guid;
		}

		$options = array(
			'input_type' => 'dropdown',
			'options_values' => $options_values,
			'value' => $value
		);
	} else {

		if ($container->canWriteToContainer(0, 'object', 'hjforumcategory')) {
			$options = array(
				'input_type' => 'text',
				'override_view' => 'output/url',
				'text' => elgg_echo('hj:forum:create:category'),
				'href' => "forum/create/category/$container->guid"
			);
		} else {
			return false;
		}
	}

	return $options;
}

function hj_forum_get_forum_icons($entity = null, $container = null) {
	$options = elgg_get_plugin_setting('forum_topic_icon_types', 'hypeForum');
	$options = array_map('trim', explode(',', $options));

	$options = elgg_trigger_plugin_hook('hj:forum:icons', 'all', array(
		'entity' => $entity,
		'container' => $container
			), $options);

	foreach ($options as $option) {
		$label = elgg_view('output/img', array(
			'src' => elgg_get_site_url() . 'mod/hypeForum/graphics/forumtopic/' . $option . '.png',
			'width' => 16,
			'height' => 16
				));
		$options_values["$label"] = $option;
	}

	return $options_values;
}