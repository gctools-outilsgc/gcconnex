<?php
/**
 * Main content filter
 *
 * Select between user, friends, and all content
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['filter_override'] HTML for overriding the default filter (override)
 * @uses $vars['context']         Page context (override)
 *
 * Modified by Christine Yu : displays the task assigned to user
 */

// cyu - 06/16/2015: we need to make sure that the module is installed to avoid missing libraries
if (elgg_is_active_plugin('tasks')) {
	if (isset($vars['filter_override'])) {
		echo $vars['filter_override'];
		return true;
	}

	$context = elgg_extract('context', $vars, elgg_get_context());

	if (elgg_is_logged_in() && $context) {
		$username = elgg_get_logged_in_user_entity()->username;
		$filter_context = elgg_extract('filter_context', $vars, 'all');

		// generate a list of default tabs
		$tabs = array(
			'all' => array(
				'text' => elgg_echo('all'),
				'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
				'selected' => ($filter_context == 'all'),
				'priority' => 200,
			),
			'mine' => array(
				'text' => elgg_echo('mine'),
				'href' => (isset($vars['mine_link'])) ? $vars['mine_link'] : "$context/owner/$username",
				'selected' => ($filter_context == 'owner'),
				'priority' => 300,
			),
			'friend' => array(
				'text' => elgg_echo('friends:filterby'),	// GCchange - Ilia: changed to gramatically correct colleagues filter for Issue #25
				'href' => (isset($vars['friend_link'])) ? $vars['friend_link'] : "$context/friends/$username",
				'selected' => ($filter_context == 'friends'),
				'priority' => 400,
			),
		);
		
		// cyu - 02/06/2015: overrides the view for the main user page, added my tasks
		if ($context === 'tasks') {
			$tabs['task_assigned'] = array(
				'text' => elgg_echo('c_dump:my_tasks'),
				'href' => (isset($vars['myTask_link'])) ? $vars['myTask_link'] : "$context/my_tasks/$username",
				'selected' => ($filter_context == 'my_tasks'),
				'priority' => 500,
			);
		}

		foreach ($tabs as $name => $tab) {
			$tab['name'] = $name;
			elgg_register_menu_item('filter', $tab);
		}

		echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
	}
}