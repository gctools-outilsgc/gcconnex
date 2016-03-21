<?php
/**
 * All plugin hook handlers are bundled here
 */

/**
 * Override canEditMetadata
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param bool   $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return bool
 */
function file_tools_can_edit_metadata_hook($hook, $type, $returnvalue, $params) {
	
	if ($returnvalue) {
		// already have access
		return $returnvalue;
	}
	
	if (empty($params) || !is_array($params)) {
		// invalid input
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	$user = elgg_extract("user", $params);

	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $returnvalue;
	}
	
	if (empty($entity) || !elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)) {
		return $returnvalue;
	}
	
	$container_entity = $entity->getContainerEntity();
	if (empty($container_entity) || !elgg_instanceof($container_entity, "group")) {
		return $returnvalue;
	}
	
	if ($container_entity->isMember($user) && ($container_entity->file_tools_structure_management_enable != "no")) {
		// is group member
		$returnvalue = true;
	}
	
	return $returnvalue;
}

/**
 * override the folder icon url
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param string $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return string
 */
function file_tools_folder_icon_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	$size = elgg_extract("size", $params, "small");
	
	if (empty($entity) || !elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)) {
		return $returnvalue;
	}
	
	switch($size){
		case "topbar":
		case "tiny":
		case "small":
			$returnvalue = "mod/file_tools/_graphics/folder/" . $size . ".png";
			break;
		default:
			$returnvalue = "mod/file_tools/_graphics/folder/medium.png";
			break;
	}
	
	return $returnvalue;
}

/**
 * change the folder access options
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param array  $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return array
 */
function file_tools_write_acl_plugin_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}

	if (!elgg_in_context("file_tools")) {
		return $returnvalue;
	}
	
	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner) || !elgg_instanceof($page_owner, "group")) {
		return $returnvalue;
	}
	
	$returnvalue = array(
		$page_owner->group_acl => elgg_echo("groups:group") . ": " . $page_owner->name,
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC")
	);
	
	return $returnvalue;
}

/**
 * Listen to the file pagehandler
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param array  $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return array|bool
 */
function file_tools_file_route_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($returnvalue) || !is_array($returnvalue)) {
		return $returnvalue;
	}
	
	$page = elgg_extract("segments", $returnvalue);
	
	switch ($page[0]) {
		case "view":
			if (!elgg_is_logged_in() && isset($page[1])) {
				if (!get_entity($page[1])) {
					gatekeeper();
				}
			}
			break;
		case "owner":
			if (file_tools_use_folder_structure()) {
				$returnvalue = false;
					
				include(dirname(dirname(__FILE__)) . "/pages/list.php");
			}
			break;
		case "group":
			if (file_tools_use_folder_structure()) {
				$returnvalue = false;
				
				include(dirname(dirname(__FILE__)) . "/pages/list.php");
			}
			break;
		case "add":
			$returnvalue = false;
			
			include(dirname(dirname(__FILE__)) . "/pages/file/new.php");
			break;
		case "zip":
			if (isset($page[1])) {
				$returnvalue = false;
				
				elgg_set_page_owner_guid($page[1]);
				
				register_error(elgg_echo("changebookmark"));
				forward("file/add/" . $page[1] . "?upload_type=zip");
			}
			break;
		case "bulk_download":
			$returnvalue = false;
			
			include(dirname(dirname(__FILE__)) . "/pages/file/download.php");
			break;
	}
	
	return $returnvalue;
}

/**
 * Set correct url on widgets
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param string $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return string
 */
function file_tools_widget_url_hook($hook, $type, $returnvalue, $params) {
	
	if (!empty($returnvalue)) {
		return $returnvalue;
	}
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$widget = elgg_extract("entity", $params);
	if (empty($widget) || !elgg_instanceof($widget, "object", "widget")) {
		return $returnvalue;
	}
	
	$owner = $widget->getOwnerEntity();
	
	switch ($widget->handler) {
		case "file_tree":
			if (elgg_instanceof($owner, "user")) {
				$returnvalue = "file/owner/" . $owner->username;
			} elseif (elgg_instanceof($owner, "group")) {
				$returnvalue = "file/group/" . $owner->getGUID() . "/all";
			}
			
			break;
		case "filerepo":
			if (elgg_instanceof($owner, "user")) {
				$returnvalue = "file/owner/" . $owner->username;
			} elseif (elgg_instanceof($owner, "group")) {
				$returnvalue = "file/group/" . $owner->getGUID() . "/all";
			}
			
			break;
		case "group_files":
			$returnvalue = "file/group/" . $owner->getGUID() . "/all";
			break;
		case "index_file":
			$returnvalue = "file/all";
			break;
	}
	
	return $returnvalue;
}

/**
 * Set folder breadcrumb menu
 *
 * @param string         $hook        the name of the hook
 * @param string         $type        the type of the hook
 * @param ElggMenuItem[] $returnvalue current return value
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function file_tools_folder_breadcrumb_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$folder = elgg_extract("entity", $params);
	if (!empty($folder) && elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
		$container = $folder->getContainerEntity();
		
		$priority = 9999999;
		$folder_options = array(
			"name" => "folder_" . $folder->getGUID(),
			"text" => $folder->title,
			"href" => false,
			"priority" => $priority
		);
		
		$returnvalue[] = ElggMenuItem::factory($folder_options);
		
		$parent_guid = (int) $folder->parent_guid;
		while (!empty($parent_guid) && ($parent = get_entity($parent_guid))) {
			$priority--;
			
			$folder_options = array(
				"name" => "folder_" . $parent->getGUID(),
				"text" => $parent->title,
				"href" => $parent->getURL(),
				"priority" => $priority
			);
			
			$returnvalue[] = ElggMenuItem::factory($folder_options);
			$parent_guid = (int) $parent->parent_guid;
		}
	} else {
		$container = elgg_get_page_owner_entity();
	}
	
	// make main folder item
	$main_folder_options = array(
		"name" => "main_folder",
		"text" => elgg_echo("file_tools:list:folder:main"),
		"priority" => 0
	);
	
	if (elgg_instanceof($container, "group")) {
		$main_folder_options["href"] = "file/group/" . $container->getGUID() . "/all#";
	} else {
		$main_folder_options["href"] = "file/owner/" . $container->username . "/all#";
	}
	
	$returnvalue[] = ElggMenuItem::factory($main_folder_options);
	
	return $returnvalue;
}

/**
 * build the folder tree
 *
 * @param string         $hook        the name of the hook
 * @param string         $type        the type of the hook
 * @param ElggMenuItem[] $returnvalue current return value
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function file_tools_folder_sidebar_tree_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$container = elgg_extract("container", $params);
	if (empty($container) || (!elgg_instanceof($container, "user") && !elgg_instanceof($container, "group"))) {
		return $returnvalue;
	}
	
	$main_menu_item = ElggMenuItem::factory(array(
		"name" => "root",
		"text" => elgg_echo("file_tools:list:folder:main"),
		"href" => "#",
		"id" => "0",
		"rel" => "root",
		"priority" => 0
	));
	
	if ($folders = file_tools_get_folders($container->getGUID())) {
		$main_menu_item->setChildren(file_tools_make_menu_items($folders));
	}
	
	$returnvalue[] = $main_menu_item;
	
	return $returnvalue;
}

/**
 * change the entity menu options
 *
 * @param string         $hook        the name of the hook
 * @param string         $type        the type of the hook
 * @param ElggMenuItem[] $returnvalue current return value
 * @param array          $params      supplied params
 *
 * @return ElggMenuItem[]
 */
function file_tools_entity_menu_hook($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "object")) {
		return $returnvalue;
	}
	
	if (elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)) {
		$remove_items = array("like", "unlike");
		
		foreach ($returnvalue as $index => $menu_item) {
			if (in_array($menu_item->getName(), $remove_items)) {
				unset($returnvalue[$index]);
			}
		}
	} elseif (elgg_instanceof($entity, "object", "file")) {
		$returnvalue[] = ElggMenuItem::factory(array(
			"name" => "download",
			"text" => elgg_view_icon("download"),
			"href" => "file/download/" . $entity->getGUID(),
			"title" => elgg_echo("file:download"),
			"priority" => 200
		));
	}
	
	return $returnvalue;
}

/**
 * Set correct url for folder entities
 *
 * @param string $hook        the name of the hook
 * @param string $type        the type of the hook
 * @param string $returnvalue current return value
 * @param array  $params      supplied params
 *
 * @return string
 */
function file_tools_folder_url_handler($hook, $type, $returnvalue, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $returnvalue;
	}
	
	$entity = elgg_extract("entity", $params);
	if (empty($entity) || !elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)) {
		return $returnvalue;
	}
	
	$container = $entity->getContainerEntity();

	if (elgg_instanceof($container, "group")) {
		$returnvalue = "file/group/" . $container->getGUID() . "/all#" . $entity->getGUID();
	} else {
		$returnvalue = "file/owner/" . $container->username . "#" . $entity->getGUID();
	}

	return $returnvalue;
}
