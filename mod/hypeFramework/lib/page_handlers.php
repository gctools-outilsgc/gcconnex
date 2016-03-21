<?php

// Default framework page handler is 'framework'
elgg_register_page_handler('framework', 'hj_framework_page_handlers');

/**
 * Page handlers for hypeFramework
 *
 *
 * @param type $page
 * @return type
 */
function hj_framework_page_handlers($page) {

	if (!isset($page[0])) {
		forward();
	}

	$path_pages = elgg_get_root_path() . 'mod/hypeFramework/pages/';

	switch ($page[0]) {

		case 'edit' :
			set_input('guid', $page[1]);
			include $path_pages . 'edit/object.php';
			break;

		case 'icon':
			set_input('guid', $page[1]);
			set_input('size', $page[2]);
			include $path_pages . "icon/icon.php";
			break;

		case 'download':
			set_input('guid', $page[1]);
			include $path_pages . "file/download.php";
			break;

		case 'file' :

			switch ($page[1]) {
				case 'create' :
					gatekeeper();

					$container_guid = elgg_extract(2, $page, false);
					if (!$container_guid) {
						$container_guid = elgg_get_logged_in_user_guid();
					}

					elgg_set_page_owner_guid($container_guid);

					set_input('container_guid', $container_guid);

					include "{$path_pages}create/file.php";
					break;

				case 'edit' :
					gatekeeper();

					set_input('guid', $page[2]);

					include "{$path_pages}edit/object.php";
					break;

				case 'view' :
					if (!isset($page[2])) {
						return false;
					}
					$entity = get_entity($page[2]);

					if (!$entity)
						return false;

					$sidebar = elgg_view('framework/file/dashboard/sidebar', array('entity' => $entity));

					echo elgg_view_page($entity->title, elgg_view_layout('framework/entity', array('entity' => $entity, 'sidebar' => $sidebar)));
					break;
			}
			break;

		default :
			return false;
			break;
	}
	return true;
}

