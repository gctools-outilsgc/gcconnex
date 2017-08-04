<?php

function poll_get_choice_array($poll) {
	$responses = array();

	foreach($poll->getChoices() as $choice) {
		$responses[$choice->text] = $choice->text;
	}

	return $responses;
}

function poll_activated_for_group($group) {
	$group_poll = elgg_get_plugin_setting('group_poll', 'poll');
	if ($group && ($group_poll != 'no')) {
		if ( ($group->poll_enable == 'yes')
		|| ((!$group->poll_enable && ((!$group_poll) || ($group_poll == 'yes_default'))))) {
			return true;
		}
	}
	return false;
}

function poll_can_add_to_group($group, $user = null) {
	$poll_group_access = elgg_get_plugin_setting('group_access', 'poll');
	if (!$poll_group_access || $poll_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = elgg_get_logged_in_user_guid();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}

function poll_get_page_edit($page_type, $guid = 0) {
	gatekeeper();

	$form_vars = array('id' => 'poll-edit-form');

	// Get the post, if it exists
	if ($page_type == 'edit') {
		$poll = get_entity($guid);

		if (!$poll instanceof Poll) {
			register_error(elgg_echo('poll:not_found'));
			forward(REFERER);
		}

		if (!$poll->canEdit()) {
			register_error(elgg_echo('poll:permission_error'));
			forward(REFERER);
		}

		$container = $poll->getContainerEntity();

		elgg_set_page_owner_guid($container->guid);

		$title = elgg_echo('poll:editpost', array($poll->title));

		$body_vars = array(
			'fd' => poll_prepare_edit_body_vars($poll),
			'entity' => $poll
		);

		if ($container instanceof ElggGroup) {
			elgg_push_breadcrumb($container->name, 'poll/group/' . $container->guid);
		} else {
			elgg_push_breadcrumb($container->name, 'poll/owner/' . $container->username);
		}

		elgg_push_breadcrumb(elgg_echo("poll:edit"));
	} else {
		if ($guid) {
			$container = get_entity($guid);
			elgg_push_breadcrumb($container->name, 'poll/group/' . $container->guid);
		} else {
			$container = elgg_get_logged_in_user_entity();
			elgg_push_breadcrumb($container->name, 'poll/owner/' . $container->username);
		}

		elgg_set_page_owner_guid($container->guid);

		elgg_push_breadcrumb(elgg_echo('poll:add'));

		$title = elgg_echo('poll:addpost');

		$body_vars = array(
			'fd' => poll_prepare_edit_body_vars(),
			'container_guid' => $guid
		);
	}

	$content = elgg_view_form("poll/edit", $form_vars, $body_vars);

	$params = array(
		'title' => $title,
		'content' => $content,
		'filter' => ''
	);

	$body = elgg_view_layout('content', $params);

	// Display page
	return elgg_view_page($title, $body);
}

/**
 * Pull together variables for the edit form
 * @param ElggObject $poll
 * @return array
 *
 * TODO - put choices in sticky form as well
 */
function poll_prepare_edit_body_vars($poll = null) {

	// input names => defaults
	$values = array(
		'question' => null,
		'description' => null,
		'close_date' => null,
		'open_poll' => null,
		'max_votes' => null,
		'tags' => null,
		'front_page' => null,
		'access_id' => ACCESS_DEFAULT,
		'guid' => null
	);

	if ($poll) {
		foreach (array_keys($values) as $field) {
			if (isset($poll->$field)) {
				$values[$field] = $poll->$field;
			}
		}
	}

	if (elgg_is_sticky_form('poll')) {
		$sticky_values = elgg_get_sticky_values('poll');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('poll');

	return $values;
}

function poll_get_page_list($page_type, $container_guid = null) {
	elgg_register_rss_link();

	$user = elgg_get_logged_in_user_entity();
	$params = array();
	$options = array(
		'type'=>'object',
		'subtype'=>'poll',
		'full_view' => false,
		'limit' => 15
	);

	if ($page_type == 'group') {
		$group = get_entity($container_guid);
		if (!elgg_instanceof($group, 'group') || !poll_activated_for_group($group)) {
			forward();
		}
		$crumbs_title = $group->name;
		$params['title'] = elgg_echo('poll:group_poll:listing:title', array(htmlspecialchars($crumbs_title)));
		$params['filter'] = "";

		// set breadcrumb
		elgg_push_breadcrumb($crumbs_title);

		elgg_push_context('groups');

		elgg_set_page_owner_guid($container_guid);
		group_gatekeeper();

		$options['container_guid'] = $container_guid;
		$user_guid = elgg_get_logged_in_user_guid();
		if (elgg_get_page_owner_entity()->canWriteToContainer($user_guid)){
			elgg_register_menu_item('title', array(
				'name' => 'add',
				'href' => "poll/add/".$container_guid,
				'text' => elgg_echo('poll:add'),
				'link_class' => 'elgg-button elgg-button-action'
			));
		}

	} else {
		switch ($page_type) {
			case 'owner':
				$options['owner_guid'] = $container_guid;

				$container_entity = get_user($container_guid);
				elgg_push_breadcrumb($container_entity->name);

				if ($user->guid == $container_guid) {
					$params['title'] = elgg_echo('poll:your');
					$params['filter_context'] = 'mine';
				} else {
					$params['title'] = elgg_echo('poll:not_me', array(htmlspecialchars($container_entity->name)));
					$params['filter_context'] = "";
				}
				$params['sidebar'] = elgg_view('poll/sidebar');
				break;
			case 'friends':
				$container_entity = get_user($container_guid);
				$friends = $container_entity->getFriends(array('limit' => false));

				$options['container_guids'] = array();
				foreach ($friends as $friend) {
					$options['container_guids'][] = $friend->getGUID();
				}

				$params['filter_context'] = 'friends';
				$params['title'] = elgg_echo('poll:friends');

				elgg_push_breadcrumb($container_entity->name, "poll/owner/{$container_entity->username}");
				elgg_push_breadcrumb(elgg_echo('friends'));
				break;
			case 'all':
				$params['filter_context'] = 'all';
				$params['title'] = elgg_echo('item:object:poll');
				$params['sidebar'] = elgg_view('poll/sidebar');
				break;
		}

		$poll_site_access = elgg_get_plugin_setting('site_access', 'poll');

		if ((elgg_is_logged_in() && ($poll_site_access != 'admins')) || elgg_is_admin_logged_in()) {
			elgg_register_menu_item('title', array(
				'name' => 'add',
				'href' => "poll/add",
				'text' => elgg_echo('poll:add'),
				'link_class' => 'elgg-button elgg-button-action'
			));
		}
	}

	if (($page_type == 'friends') && (count($options['container_guids']) == 0)) {
		// this person has no friends
		$params['content'] = '';
	} else {
		$params['content'] = elgg_list_entities($options);
	}
	if (!$params['content']) {
		$params['content'] = elgg_echo('poll:none');
	}

	$body = elgg_view_layout("content", $params);

	return elgg_view_page($params['title'],$body);
}

function poll_get_page_view($guid) {
	elgg_require_js('elgg/poll/poll');

	$poll = get_entity($guid);
	if ($poll instanceof Poll) {
		// Set the page owner
		$page_owner = $poll->getContainerEntity();
		elgg_set_page_owner_guid($page_owner->guid);
		$title =  $poll->title;
		$content = elgg_view_entity($poll, array('full_view' => true));

		$allow_poll_reset = elgg_get_plugin_setting('allow_poll_reset', 'poll');
		if (elgg_is_admin_logged_in() || ($allow_poll_reset == 'yes' && $poll->canEdit())) {
			elgg_register_menu_item('title', array(
				'name' => 'poll_reset',
				'href' => elgg_get_site_url() . 'action/poll/reset?guid=' . $guid,
				'text' => elgg_echo('poll:poll_reset'),
				'title' => elgg_echo('poll:poll_reset_description'),
				'confirm' => elgg_echo('poll:poll_reset_confirmation'),
				'link_class' => 'elgg-menu-content elgg-button elgg-button-action'
			));
		}

		//check to see if comments are on
		if ($poll->comments_on != 'Off') {
			$content .= elgg_view_comments($poll);
		}

		if (elgg_instanceof($page_owner,'user')) {
			elgg_push_breadcrumb($page_owner->name, "poll/owner/{$page_owner->username}");
		} else {
			elgg_push_breadcrumb($page_owner->name, "poll/group/{$page_owner->guid}");
		}
		elgg_push_breadcrumb($poll->title);
	} else {
		// Display the 'post not found' page instead
		$title = elgg_echo("poll:notfound");
		$content = elgg_view("poll/notfound");
		elgg_push_breadcrumb($title);
	}

	$params = array('title' =>$title, 'content' => $content, 'filter' => '');
	$body = elgg_view_layout('content', $params);

	// Display page
	return elgg_view_page($title, $body);
}

function poll_manage_front_page($poll, $front_page) {
	$poll_front_page = elgg_get_plugin_setting('front_page','poll');
	if(elgg_is_admin_logged_in() && ($poll_front_page == 'yes')) {
		$options = array(
			'type' => 'object',
			'subtype' => 'poll',
			'metadata_name_value_pairs' => array(array('name' => 'front_page','value' => 1)),
			'limit' => 1
		);
		$poll_front = elgg_get_entities_from_metadata($options);
		if ($poll_front) {
			$front_page_poll = $poll_front[0];
			if ($front_page_poll->guid == $poll->guid) {
				if (!$front_page) {
					$front_page_poll->front_page = 0;
				}
			} else {
				if ($front_page) {
					$front_page_poll->front_page = 0;
					$poll->front_page = 1;
				}
			}
		} else {
			if ($front_page) {
				$poll->front_page = 1;
			}
		}
	}
}

function poll_is_upgrade_available() {
	require_once elgg_get_plugins_path() . "poll/version.php";

	$local_version = elgg_get_plugin_setting('local_version', 'poll');
	if ($local_version === false) {
		$local_version = 0;
	}

	if ($local_version == $version) {
		return false;
	} else {
		return true;
	}
}
