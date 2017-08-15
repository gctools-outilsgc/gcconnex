<?php

$question = elgg_extract('entity', $vars);
$show_group_selector = (bool) elgg_extract('show_group_selector', $vars, true);

$editing = true;
$container_options = false;
$show_access_options = true;
$access_setting = false;

if (!($question instanceof ElggQuestion)) {
	$editing = false;
}

$container = get_entity(elgg_extract('container_guid', $vars));

// build form elements
echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('questions:edit:question:title'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('questions:edit:question:description'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
]);

echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('comments'),
	'name' => 'comments_enabled',
	'value' => elgg_extract('comments_enabled', $vars),
	'options_values' => [
		'on' => elgg_echo('on'),
		'off' => elgg_echo('off'),
	],
]);

// access options
if ($container instanceof ElggUser) {
	$access_setting = questions_get_personal_access_level();
	if ($access_setting !== false) {
		$show_access_options = false;
	}
} elseif ($container instanceof ElggGroup) {
	$access_setting = questions_get_group_access_level($container);
	if ($access_setting !== false) {
		$show_access_options = false;
	}
}

if ($show_access_options) {
	echo elgg_view_field([
		'#type' => 'access',
		'#label' => elgg_echo('access'),
		'name' => 'access_id',
		'value' => elgg_extract('access_id', $vars),
		'entity_type' => 'object',
		'entity_subtype' => ElggQuestion::SUBTYPE,
		'entity' => $question,
		'container_guid' => elgg_extract('container_guid', $vars),
	]);
} else {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'access_id',
		'value' => $access_setting,
	]);
}

// container selection options
if (!$editing || (questions_experts_enabled() && questions_is_expert($container))) {
	if ($show_group_selector && elgg_is_active_plugin('groups')) {
		$group_options = [
			'type' => 'group',
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'questions_enable',
				'value' => 'yes'
			],
			'joins' => ['JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid'],
			'order_by' => 'ge.name ASC'
		];
		
		if (!$editing) {
			$owner = elgg_get_logged_in_user_entity();
			
			$group_options['relationship'] = 'member';
			$group_options['relationship_guid'] = elgg_get_logged_in_user_guid();
		} else {
			$owner = $question->getOwnerEntity();
		}
		
		// group selector
		$groups = new ElggBatch('elgg_get_entities_from_relationship', $group_options);
		// build group optgroup
		$group_optgroup = [];
		foreach ($groups as $group) {
			
			// can questions be asked in this group
			if (!questions_can_ask_question($group)) {
				continue;
			}
			
			$selected = [
				'value' => $group->getGUID(),
			];
			if ($group->getGUID() === $container->getGUID()) {
				$selected['selected'] = true;
			}
			$group_optgroup[] = elgg_format_element('option', $selected, $group->name);
		}
		
		if (!empty($group_optgroup)) {
			$container_options = true;
			$select_options = [];
			
			// add user to the list
			$selected = [
				'value' => '',
			];
			if ($owner->getGUID() == $container->getGUID()) {
				$selected['selected'] = true;
			}
			
			if (!questions_limited_to_groups()) {
				$selected['value'] = $owner->getGUID();
				
				$select_options[] = elgg_format_element('option', $selected, $owner->name);
			} else {
				$select_options[] = elgg_format_element('option', $selected, elgg_echo('questions:edit:question:container:select'));
			}
			
			
			$select_options[] = elgg_format_element('optgroup', ['label' => elgg_echo('groups')], implode('', $group_optgroup));
			
			// format select
			$select_attr = [
				'name' => 'container_guid',
				'class' => 'elgg-input-dropdown form-control',
				'id' => 'questions-container-guid',
			];
			$select = elgg_format_element('select', $select_attr, implode('', $select_options));
			
			// build output
			$container_selector = elgg_format_element('label', [
				'for' => 'questions-container-guid',
			], elgg_echo('questions:edit:question:container'));
			$container_selector .= '<br />';
			$container_selector .= $select;
			
			echo elgg_format_element('div', [], $container_selector);
		}
	}
}

// end of the form
$footer = '';

if (!$container_options) {
	$footer .= elgg_view_field([
		'#type' => 'hidden',
		'name' => 'container_guid',
		'value' => elgg_extract('container_guid', $vars),
	]);
}

if ($editing) {
	$footer .= elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $question->guid,
	]);
}

if ($editing && questions_can_move_to_discussions($container)) {
	$footer .= elgg_view('output/url', [
		'text' => elgg_echo('questions:edit:question:move_to_discussions'),
		'href' => false,
		'class' => 'elgg-button elgg-button-action float-alt',
		'id' => 'questions-move-to-discussions',
		'rel' => elgg_echo('questions:edit:question:move_to_discussions:confirm'),
	]);
}

$footer .= elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('submit'),
]);

elgg_set_form_footer($footer);
