<?php

$question = elgg_extract('entity', $vars);
$show_group_selector = (bool) elgg_extract('show_group_selector', $vars, true);

$editing = true;
$container_options = false;
$show_access_options = true;
$access_setting = false;

if (!$question) {
	$editing = false;
	
	$question = new ElggQuestion();
	$question->container_guid = elgg_get_page_owner_guid();
	$question->access_id = get_default_access(null, [
		'entity_type' => $question->getType(),
		'entity_subtype' => $question->getSubtype(),
		'container_guid' => $question->getContainerGUID(),
	]);
}

$container = $question->getContainerEntity();

$title = [
	'name' => 'title',
	'id' => 'question_title',
	'value' => elgg_get_sticky_value('question', 'title', $question->title),
	'required' => true,
];

$description = [
	'name' => 'description',
	'id' => 'question_description',
	'value' => elgg_get_sticky_value('question', 'description', $question->description),
];

$tags = [
	'name' => 'tags',
	'id' => 'question_tags',
	'value' => elgg_get_sticky_value('question', 'tags', $question->tags),
];

$comment_options = [
	'name' => 'comments_enabled',
	'id' => 'questions-comments',
	'value' => elgg_get_sticky_value('question', 'comments_enabled', $question->comments_enabled),
	'options_values' => [
		'on' => elgg_echo('on'),
		'off' => elgg_echo('off'),
	],
	'class' => 'mls',
];

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

$access_id = [
	'name' => 'access_id',
	'id' => 'question_access_id',
	'value' => (int) elgg_get_sticky_value('question', 'access_id', $question->access_id),
];

// clear sticky form
elgg_clear_sticky_form('question');
?>
<div>
	<label for='question_title'><?php echo elgg_echo('questions:edit:question:title'); ?></label>
	<?php echo elgg_view('input/text', $title); ?>
</div>
<div>
	<label for='question_description'><?php echo elgg_echo('questions:edit:question:description'); ?></label>
	<?php echo elgg_view('input/longtext', $description); ?>
</div>
<div>
	<label for='question_tags'><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', $tags); ?>
</div>

<?php
// categories support
if (elgg_view_exists('input/categories')) {
	echo elgg_view('input/categories', $vars);
}

// comments
$comments = elgg_format_element('label', ['for' => 'questions-comments'], elgg_echo('comments'));
$comments .= elgg_view('input/select', $comment_options);
echo elgg_format_element('div', [], $comments);

// access options
if ($show_access_options) {
	$access = elgg_format_element('label', ['for' => 'question_access_id'], elgg_echo('access'));
	$access .= '<br />';
	$access .= elgg_view('input/access', $access_id);
	
	echo elgg_format_element('div', [], $access);
} else {
	echo elgg_view('input/hidden', ['name' => 'access_id', 'value' => $access_setting]);
}

// container selection options
if (!$editing || (questions_experts_enabled() && questions_is_expert(elgg_get_page_owner_entity()))) {
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
			if ($group->getGUID() == $question->getContainerGUID()) {
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
			if ($owner->getGUID() == $question->getContainerGUID()) {
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
				'class' => 'elgg-input-dropdown',
				'id' => 'questions-container-guid',
			];
			$select = elgg_format_element('select', $select_attr, implode('', $select_options));
			
			// build output
			$container_selector = elgg_format_element('label', ['for' => 'questions-container-guid'], elgg_echo('questions:edit:question:container'));
			$container_selector .= '<br />';
			$container_selector .= $select;
			
			echo elgg_format_element('div', [], $container_selector);
		}
	}
}

// end of the form
$footer = [];

if (!$container_options) {
	$footer[] = elgg_view('input/hidden', ['name' => 'container_guid', 'value' => $question->getContainerGUID()]);
}
$footer[] = elgg_view('input/hidden', ['name' => 'guid', 'value' => $question->getGUID()]);

if ($editing && questions_can_move_to_discussions($container)) {
	$footer[] = elgg_view('output/url', [
		'text' => elgg_echo('questions:edit:question:move_to_discussions'),
		'href' => false,
		'class' => 'elgg-button elgg-button-action float-alt',
		'id' => 'questions-move-to-discussions',
		'rel' => elgg_echo('questions:edit:question:move_to_discussions:confirm'),
	]);
}

$footer[] = elgg_view('input/submit', ['value' => elgg_echo('submit')]);

echo elgg_format_element('div', ['class' => 'elgg-foot'], implode('', $footer));
