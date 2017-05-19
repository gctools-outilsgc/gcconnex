<?php
/**
 * All plugin hooks are bundled here
 */

/**
 * Add menu items to the owner_block menu
 *
 * @param string         $hook   the name of the hook
 * @param string         $type   the type of the hook
 * @param ElggMenuItem[] $items  current return value
 * @param array          $params supplied params
 *
 * @return void|ElggMenuItem[]
 */
function questions_owner_block_menu_handler($hook, $type, $items, $params) {
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract('entity', $params);
	if (($entity instanceof ElggGroup) && ($entity->questions_enable === 'yes')) {
		$items[] = ElggMenuItem::factory([
			'name' => 'questions',
			'href' => "questions/group/{$entity->getGUID()}/all",
			'text' => elgg_echo('questions:group'),
		]);
	} elseif ($entity instanceof ElggUser) {
		$items[] = ElggMenuItem::factory([
			'name' => 'questions',
			'href' => "questions/owner/{$entity->username}",
			'text' => elgg_echo('questions'),
		]);
	}
	
	return $items;
}

/**
 * Add menu items to the entity menu
 *
 * @param string         $hook   the name of the hook
 * @param string         $type   the type of the hook
 * @param ElggMenuItem[] $items  current return value
 * @param array          $params supplied params
 *
 * @return void|ElggMenuItem[]
 */
function questions_entity_menu_handler($hook, $type, $items, $params) {

	if (empty($params) || !is_array($params)) {
		return;
	}
	
	$entity = elgg_extract('entity', $params);
	if (empty($entity) || (!($entity instanceof ElggQuestion) && !($entity instanceof ElggAnswer))) {
		return;
	}
	
	if ($entity->canComment()) {
		if (elgg_extract('full_view', $params, false) || ($entity instanceof ElggAnswer)) {
			$items[] = ElggMenuItem::factory([
				'name' => 'comments',
				'rel' => 'toggle',
				'link_class' => 'elgg-toggler',
				'href' => "#comments-add-{$entity->getGUID()}",
				'text' => elgg_view_icon('speech-bubble'),
				'priority' => 600,
			]);
		}
	}
	
	if (elgg_in_context('questions') && ($entity instanceof ElggAnswer) && questions_can_mark_answer($entity)) {
		$question = $entity->getContainerEntity();
		$answer = $question->getMarkedAnswer();

		if (empty($answer)) {
			$items[] = ElggMenuItem::factory([
				'name' => 'questions_mark',
				'text' => elgg_echo('questions:menu:entity:answer:mark'),
				'href' => "action/answers/toggle_mark?guid={$entity->getGUID()}",
				'is_action' => true,
			]);
		} elseif ($entity->getGUID() === $answer->getGUID()) {
			// there is an anwser and it's this entity
			$items[] = ElggMenuItem::factory([
				'name' => 'questions_mark',
				'text' => elgg_echo('questions:menu:entity:answer:unmark'),
				'href' => "action/answers/toggle_mark?guid={$entity->getGUID()}",
				'is_action' => true,
			]);
		}
	}

	return $items;
}

/**
 * Add menu items to the filter menu
 *
 * @param string         $hook   the name of the hook
 * @param string         $type   the type of the hook
 * @param ElggMenuItem[] $items  current return value
 * @param array          $params supplied params
 *
 * @return void|ElggMenuItem[]
 */
function questions_filter_menu_handler($hook, $type, $items, $params) {

	if (empty($items) || !is_array($items) || !elgg_in_context('questions')) {
		return;
	}
	
	$page_owner = elgg_get_page_owner_entity();
	
	// change some menu items
	foreach ($items as $key => $item) {
		// remove friends
		if ($item->getName() == 'friend') {
			unset($items[$key]);
		}
		
		// in group context
		if ($page_owner instanceof ElggGroup) {
			// remove mine
			if ($item->getName() == 'mine') {
				unset($items[$key]);
			}

			// check if all is correct
			if ($item->getName() === 'all') {
				// set correct url
				$item->setHref("questions/group/{$page_owner->getGUID()}/all");
				
				// highlight all
				$current_page = current_page_url();
				if (stristr($current_page, "questions/group/{$page_owner->getGUID()}/all")) {
					$item->setSelected(true);
				}
			}
		}
	}
	
	if (questions_is_expert()) {
		$items[] = ElggMenuItem::factory([
			'name' => 'todo',
			'text' => elgg_echo('questions:menu:filter:todo'),
			'href' => 'questions/todo',
			'priority' => 700,
		]);

		if ($page_owner instanceof ElggGroup) {
			$items[] = ElggMenuItem::factory([
				'name' => 'todo_group',
				'text' => elgg_echo('questions:menu:filter:todo_group'),
				'href' => "questions/todo/{$page_owner->getGUID()}",
				'priority' => 710,
			]);
		}
	}

	if (questions_experts_enabled()) {
		$experts_href = 'questions/experts';
		if ($page_owner instanceof ElggGroup) {
			$experts_href .= "/{$page_owner->getGUID()}";
		}

		$items[] = ElggMenuItem::factory([
			'name' => 'experts',
			'text' => elgg_echo('questions:menu:filter:experts'),
			'href' => $experts_href,
			'priority' => 800,
		]);
	}

	return $items;
}

/**
 * Add menu items to the user_hover menu
 *
 * @param string         $hook   the name of the hook
 * @param string         $type   the type of the hook
 * @param ElggMenuItem[] $items  current return value
 * @param array          $params supplied params
 *
 * @return void|ElggMenuItem[]
 */
function questions_user_hover_menu_handler($hook, $type, $items, $params) {
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	// are experts enabled
	if (!questions_experts_enabled()) {
		return;
	}
	
	// get the user for this menu
	$user = elgg_extract('entity', $params);
	if (empty($user) || !($user instanceof ElggUser)) {
		return;
	}
	
	// get page owner
	$page_owner = elgg_get_page_owner_entity();
	if (!($page_owner instanceof ElggGroup)) {
		$page_owner = elgg_get_site_entity();
	}
	
	// can the current person edit the page owner, to assign the role
	// and is the current user not the owner of this page owner
	if (!$page_owner->canEdit()) {
		return;
	}
	
	$text = elgg_echo('questions:menu:user_hover:make_expert');
	$confirm_text = elgg_echo('questions:menu:user_hover:make_expert:confirm', [$page_owner->name]);
	if (check_entity_relationship($user->getGUID(), QUESTIONS_EXPERT_ROLE, $page_owner->getGUID())) {
		$text = elgg_echo('questions:menu:user_hover:remove_expert');
		$confirm_text = elgg_echo('questions:menu:user_hover:remove_expert:confirm', [$page_owner->name]);
	}
	
	$items[] = ElggMenuItem::factory([
		'name' => 'questions_expert',
		'text' => $text,
		'href' => "action/questions/toggle_expert?user_guid={$user->getGUID()}&guid={$page_owner->getGUID()}",
		'confirm' => $confirm_text,
		"section" => "admin",
	]);
	
	return $items;
}

/**
 * Check if a user can write an answer
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param bool   $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return void|bool
 */
function questions_container_permissions_handler($hook, $type, $returnvalue, $params) {
	static $experts_only;

	if ($returnvalue || empty($params) || !is_array($params)) {
		return;
	}
	
	$question = elgg_extract('container', $params);
	$user = elgg_extract('user', $params);
	$subtype = elgg_extract('subtype', $params);
	
	if (($subtype !== 'answer') || !($user instanceof ElggUser) || !($question instanceof ElggQuestion)) {
		return;
	}
	
	return questions_can_answer_question($question, $user);
}

/**
 * Check if a user has permissions
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param bool   $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return void|bool
 */
function questions_permissions_handler($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return;
	}
	
	// get the provided data
	$entity = elgg_extract('entity', $params);
	$user = elgg_extract('user', $params);
	
	if (!($user instanceof ElggUser)) {
		return;
	}
	
	if (!($entity instanceof ElggQuestion) && !($entity instanceof ElggAnswer)) {
		return;
	}
	
	// expert only changes
	if (questions_experts_enabled()) {
		// check if an expert can edit a question
		if (!$returnvalue && ($entity instanceof ElggQuestion)) {
			$container = $entity->getContainerEntity();
			if (!($container instanceof ElggGroup)) {
				$container = elgg_get_site_entity();
			}
			
			if (questions_is_expert($container, $user)) {
				$returnvalue = true;
			}
		}
		
		// an expert should be able to edit an answer, so fix this
		if (!$returnvalue && ($entity instanceof ElggAnswer)) {
			// user is not the owner
			if ($entity->getOwnerGUID() !== $user->getGUID()) {
				$question = $entity->getContainerEntity();
				
				if ($question instanceof ElggQuestion) {
					$container = $question->getContainerEntity();
					if (!($container instanceof ElggGroup)) {
						$container = elgg_get_site_entity();
					}
					
					// if the user is an expert
					if (questions_is_expert($container, $user)) {
						$returnvalue = true;
					}
				}
			}
		}
	}
	
	// questions can't be editted by owner if it is closed
	if ($returnvalue && ($entity instanceof ElggQuestion)) {
		// is the question closed
		if ($entity->getStatus() === 'closed') {
			// are you the owner
			if ($user->getGUID() === $entity->getOwnerGUID()) {
				$returnvalue = false;
			}
		}
	}

	return $returnvalue;
}

/**
 * A plugin hook for the CRON, so we can send out notifications to the experts about there workload
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param string $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return void
 */
function questions_daily_cron_handler($hook, $type, $returnvalue, $params) {

	if (empty($params) || !is_array($params)) {
		return;
	}
	
	// are experts enabled
	if (!questions_experts_enabled()) {
		return;
	}
		
	$time = (int) elgg_extract('time', $params, time());
	$dbprefix = elgg_get_config('dbprefix');
	$site = elgg_get_site_entity();

	// get all experts
	$expert_options = [
		'type' => 'user',
		'site_guids' => false,
		'limit' => false,
		'joins' => ["JOIN {$dbprefix}entity_relationships re2 ON e.guid = re2.guid_one"],
		'wheres' =>["(re2.guid_two = {$site->getGUID()} AND re2.relationship = 'member_of_site')"],
		'relationship' => QUESTIONS_EXPERT_ROLE,
		'inverse_relationship' => true,
	];
	$experts = new ElggBatch('elgg_get_entities_from_relationship', $expert_options);
	
	// sending could take a while
	set_time_limit(0);
	
	$status_id = elgg_get_metastring_id('status');
	$closed_id = elgg_get_metastring_id('closed');
	
	$status_where = "NOT EXISTS (
		SELECT 1
		FROM {$dbprefix}metadata md
		WHERE md.entity_guid = e.guid
		AND md.name_id = {$status_id}
		AND md.value_id = {$closed_id})";

	$question_options = [
		'type' => 'object',
		'subtype' => 'question',
		'limit' => 3,
	];
	
	// loop through all experts
	foreach ($experts as $expert) {
		// fake a logged in user
		$backup_user = elgg_extract('user', $_SESSION);
		$_SESSION['user'] = $expert;
		
		$subject = elgg_echo('questions:daily:notification:subject', [], get_current_language());
		$message = '';
		
		$container_where = [];
		if (check_entity_relationship($expert->getGUID(), QUESTIONS_EXPERT_ROLE, $site->getGUID())) {
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
			'relationship_guid' => $expert->getGUID(),
			'callback' => 'questions_row_to_guid',
		];
		$groups = elgg_get_entities_from_relationship($group_options);
		if (!empty($groups)) {
			$container_where[] = '(e.container_guid IN (' . implode(',', $groups) . '))';
		}
		
		if (empty($container_where)) {
			// no groups or site? then skip to next expert
			continue;
		}
		$container_where = '(' . implode(' OR ', $container_where) . ')';
		
		// get overdue questions
		// eg: solution_time < $time && status != closed
		$question_options['metadata_name_value_pairs'] = [
			'name' => 'solution_time',
			'value' => $time,
			'operand' => '<',
		];
		$question_options['wheres'] = [
			$status_where,
			$container_where
		];
		$question_options['order_by_metadata'] = [
			'name' => 'solution_time',
			'direction' => 'ASC',
			'as' => 'integer'
		];
		$questions = elgg_get_entities_from_metadata($question_options);
		if (!empty($questions)) {
			$message .= elgg_echo('questions:daily:notification:message:overdue', [], get_current_language()) . PHP_EOL;
			
			foreach ($questions as $question) {
				$message .= " - {$question->title} ({$question->getURL()})" . PHP_EOL;
			}
			
			$message .= elgg_echo('questions:daily:notification:message:more', [], get_current_language());
			$message .= " {$site->url}questions/todo" . PHP_EOL . PHP_EOL;
		}
		
		// get due questions
		// eg: solution_time >= $time && solution_time < ($time + 1 day) && status != closed
		$question_options['metadata_name_value_pairs'] = [
			[
				'name' => 'solution_time',
				'value' => $time,
				'operand' => '>=',
			],
			[
				'name' => 'solution_time',
				'value' => $time + (24 * 60 * 60),
				'operand' => '<',
			],
		];
		
		$questions = elgg_get_entities_from_metadata($question_options);
		if (!empty($questions)) {
			$message .= elgg_echo('questions:daily:notification:message:due', [], get_current_language()) . PHP_EOL;
			
			foreach ($questions as $question) {
				$message .= " - {$question->title} ({$question->getURL()})" . PHP_EOL;
			}
			
			$message .= elgg_echo('questions:daily:notification:message:more', [], get_current_language());
			$message .= " {$site->url}questions/todo" . PHP_EOL . PHP_EOL;
		}
		
		// get new questions
		// eg: time_created >= ($time - 1 day)
		unset($question_options['metadata_name_value_pairs']);
		unset($question_options['order_by_metadata']);
		$question_options['wheres'] = [
			$container_where,
			'(e.time_created > ' . ($time - (24 * 60 *60)) . ')'
		];
		$questions = elgg_get_entities_from_metadata($question_options);
		if (!empty($questions)) {
			$message .= elgg_echo('questions:daily:notification:message:new', [], get_current_language()) . PHP_EOL;
			
			foreach ($questions as $question) {
				$message .= " - {$question->title} ({$question->getURL()})" . PHP_EOL;
			}
			
			$message .= elgg_echo('questions:daily:notification:message:more', array(), get_current_language());
			$message .= " {$site->url}questions/all" . PHP_EOL . PHP_EOL;
		}
		
		// is there content in the message
		if (!empty($message)) {
			// force to email
			notify_user($expert->getGUID(), $site->getGUID(), $subject, $message, null, 'email');
		}
		
		// restore user
		$_SESSION['user'] = $backup_user;
	}
}
