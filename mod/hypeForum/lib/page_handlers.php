<?php

// Page handler
elgg_register_page_handler('forum', 'hj_forum_page_handler');

/**
 * Forum page handler
 */
function hj_forum_page_handler($page, $handler) {

	$plugin = 'hypeForum';
	$shortcuts = hj_framework_path_shortcuts($plugin);
	$pages = $shortcuts['pages'] . 'forum/';

	elgg_load_css('forum.base.css');
	elgg_load_js('forum.base.js');

	elgg_push_breadcrumb(elgg_echo('forums'), 'forum/dashboard/site');

	switch ($page[0]) {

		default :
		case 'dashboard' :

			$dashboard = elgg_extract(1, $page, 'site');
			set_input('dashboard', $dashboard);

			switch ($dashboard) {

				default :
				case 'site' :
					include "{$pages}dashboard/site.php";
					break;

				case 'groups' :
					gatekeeper();
					include "{$pages}dashboard/groups.php";
					break;

				case 'bookmarks' :
					gatekeeper();
					include "{$pages}dashboard/bookmarks.php";
					break;

				case 'subscriptions' :
					gatekeeper();
					include "{$pages}dashboard/subscriptions.php";
					break;
			}

			break;

		case 'group' :
			$group_guid = elgg_extract(1, $page, false);
			if (!$group_guid) {
				return false;
			}
			$group = get_entity($group_guid);

			if (!elgg_instanceof($group, 'group')) {
				return false;
			}

			elgg_set_page_owner_guid($group->guid);

			include "{$pages}dashboard/group.php";
			break;

		case 'create' :

			gatekeeper();

			list($action, $subtype, $container_guid) = $page;

			if (!$subtype) {
				return false;
			}

			if (!$container_guid) {
				$site = elgg_get_site_entity();
				$container_guid = $site->guid;
			}

			elgg_set_page_owner_guid($container_guid);

			set_input('container_guid', $container_guid);

			$include = "{$pages}create/{$subtype}.php";

			if (!file_exists($include)) {
				return false;
			}

			include $include;
			break;

		case 'edit' :

			gatekeeper();

			list($action, $guid) = $page;

			set_input('guid', $guid);

			$include = "{$pages}edit/object.php";

			if (!file_exists($include)) {
				return false;
			}

			include $include;
			break;

		case 'view' :
			if (!isset($page[1])) {
				return false;
			}
			$entity = get_entity($page[1]);

			if (!$entity)
				return false;

			if (elgg_instanceof($entity, 'object', 'hjforum')) {
				$sidebar = elgg_view('framework/forum/dashboard/sidebar');
			}

			echo elgg_view_page($entity->title, elgg_view_layout('framework/entity', array('entity' => $entity, 'sidebar' => $sidebar)));
			break;
	}

	return true;
}