<?php
/**
 *	Questions widget content
 **/

$widget = elgg_extract('entity', $vars);

$limit = (int) $widget->limit;
if ($limit < 1) {
	$limit = 5;
}

$options = [
	'type' => 'object',
	'subtype' => 'question',
	'limit' => $limit,
	'full_view' => false,
	'pagination' => false,
];

$base_url = 'questions/all';

switch ($widget->context) {
	case 'profile':
		$base_url = "questions/owner/{$widget->getOwnerEntity()->username}";
		
		$options['owner_guid'] = $widget->getOwnerGUID();
		break;
	case 'dashboard':
		$base_url = "questions/owner/{$widget->getOwnerEntity()->username}";
		
		$type = $widget->content_type;
		if (($type == 'todo') && !questions_is_expert()) {
			$type = 'mine';
		}
		
		// user shows owned
		switch ($type) {
			case 'todo':
				$base_url = 'questions/todo';
				
				// prepare options
				$dbprefix = elgg_get_config('dbprefix');
				$correct_answer_id = elgg_get_metastring_id('correct_answer');
				$site = elgg_get_site_entity();
				$user = elgg_get_logged_in_user_entity();
				
				$container_where = [];
								
				$options['wheres'] = ["NOT EXISTS (
					SELECT 1
					FROM {$dbprefix}entities e2
					JOIN {$dbprefix}metadata md ON e2.guid = md.entity_guid
					WHERE e2.container_guid = e.guid
					AND md.name_id = {$correct_answer_id})"
				];
				$options['order_by_metadata'] = ['name' => 'solution_time'];
				
				if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $site->getGUID())) {
					$container_where[] = "(e.container_guid NOT IN (
						SELECT ge.guid
						FROM {$dbprefix}entities ge
						WHERE ge.type = 'group'
						AND ge.site_guid = {$site->getGUID()}
						AND ge.enabled = 'yes'
					))";
				}
				
				$group_options = [
					'type' => 'group',
					'limit' => false,
					'relationship' => QUESTIONS_EXPERT_ROLE,
					'relationship_guid' => $user->getGUID(),
					'callback' => 'questions_row_to_guid',
				];
				
				$groups = elgg_get_entities_from_relationship($group_options);
				if (!empty($groups)) {
					$container_where[] = '(e.container_guid IN (' . implode(',', $groups) . '))';
				}
				
				$container_where = '(' . implode(' OR ', $container_where) . ')';
				
				$options['wheres'][] = $container_where;
								
				break;
			case 'all':
				// just get all questions
				break;
			case 'mine':
			default:
				$options['owner_guid'] = $widget->getOwnerGUID();
				break;
		}
		
		break;
	case 'groups':
		$base_url = "questions/group/{$widget->getOwnerGUID()}/all";
		
		// only in this container
		$options['container_guid'] = $widget->getOwnerGUID();
		break;
}

// add tags filter
$filter_tags = $widget->filter_tags;
if (!empty($filter_tags)) {
	$filter_tags = string_to_tag_array($filter_tags);
	
	$options['metadata_name_value_pairs'] = [
		'name' => 'tags',
		'value' => $filter_tags,
	];
} else {
	$filter_tags = null;
}

$content = elgg_list_entities_from_metadata($options);
if (empty($content)) {
	$content = elgg_view('output/longtext', ['value' => elgg_echo('questions:none')]);
} else {
	
	$content .= elgg_format_element('div', ['class' => 'elgg-widget-more'], elgg_view('output/url', [
		'text' => elgg_echo('widget:questions:more'),
		'href' => elgg_http_add_url_query_elements($base_url, ['tags' => $filter_tags]),
		'is_trusted' => true,
	]));
}

echo $content;
