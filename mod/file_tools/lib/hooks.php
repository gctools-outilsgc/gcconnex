<?php

	function file_tools_can_edit_metadata_hook($hook, $type, $returnvalue, $params)	{
		$result = $returnvalue;
	
		if(($result !== true) && !empty($params) && is_array($params)) {
			if(array_key_exists("user", $params) && array_key_exists("entity", $params)) {
				$entity = elgg_extract("entity", $params);
				$user = elgg_extract("user", $params);
	
				if(elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)) {
					$container_entity = $entity->getContainerEntity();
						
					if(elgg_instanceof($container_entity, "group") && $container_entity->isMember($user) && ($container_entity->file_tools_structure_management_enable != "no")) {
						$result = true;
					}
				}
			}
		}
	
		return $result;
	}
	
	function file_tools_folder_icon_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
	
		if(!empty($params) && is_array($params)){
			$entity = elgg_extract("entity", $params);
			$size = elgg_extract("size", $params, "small");
			
			if(!empty($entity) && elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)){
				switch($size){
					case "topbar":
					case "tiny":
					case "small":
						$result = "mod/file_tools/_graphics/folder/" . $size . ".png";
						break;
					default:
						$result = "mod/file_tools/_graphics/folder/medium.png";
						break;
				}
			}
		}
	
		return $result;
	}
	
	function file_tools_write_acl_plugin_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		if(!empty($params) && is_array($params)) {
			
			if(elgg_in_context("file_tools") && ($page_owner = elgg_get_page_owner_entity()) && elgg_instanceof($page_owner, "group")){
				$result = array(
					$page_owner->group_acl => elgg_echo("groups:group") . ": " . $page_owner->name,
					ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
					ACCESS_PUBLIC => elgg_echo("PUBLIC")
				);
			}
		}
		
		return $result;
	}
	
	function file_tools_file_route_hook($hook, $type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(!empty($returnvalue) && is_array($returnvalue)){
			$page = elgg_extract("segments", $returnvalue);
			
			switch($page[0]){
				case "view":
					if(!elgg_is_logged_in() && isset($page[1])){
						if(!get_entity($page[1])){
							gatekeeper();
						}
					}
					break;
				case "owner":
					if(file_tools_use_folder_structure()){
						$result = false;
							
						include(dirname(dirname(__FILE__)) . "/pages/list.php");
					}
					break;
				case "group":
					if(file_tools_use_folder_structure()){
						$result = false;
						
						include(dirname(dirname(__FILE__)) . "/pages/list.php");
					}
					break;
				case "add":
					$result = false;
					
					include(dirname(dirname(__FILE__)) . "/pages/file/new.php");
					break;
				case "zip":
					if(isset($page[1])){
						$result = false;
						
						elgg_set_page_owner_guid($page[1]);
						
						register_error(elgg_echo("changebookmark"));
						forward("file/add/" . $page[1] . "?upload_type=zip");
					}
					break;
				case "bulk_download":
					$result = false;
					
					include(dirname(dirname(__FILE__)) . "/pages/file/download.php");
					break;
			}
		}
		
		return $result;
	}
	
	function file_tools_widget_url_hook($hook, $type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(empty($result) && !empty($params) && is_array($params)){
			$widget = elgg_extract("entity", $params);
			
			if(!empty($widget) && elgg_instanceof($widget, "object", "widget", "ElggWidget")){
				$owner = $widget->getOwnerEntity();
				
				switch($widget->handler){
					case "file_tree":
						if(elgg_instanceof($owner, "user")){
							$result = "file/owner/" . $owner->username;
						} elseif(elgg_instanceof($owner, "group")){
							$result = "file/group/" . $owner->getGUID() . "/all";
						}
						
						break;
					case "filerepo":
						if(elgg_instanceof($owner, "user")){
							$result = "file/owner/" . $owner->username;
						} elseif(elgg_instanceof($owner, "group")){
							$result = "file/group/" . $owner->getGUID() . "/all";
						}
						
						break;
					case "group_files":
						$result = "file/group/" . $owner->getGUID() . "/all";
						break;
					case "index_file":
						$result = "file/all";
						break;
				}
			}
		}
		
		return $result;
	}
	
	function file_tools_folder_breadcrumb_hook($hook, $type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(!empty($params) && is_array($params)){
			$folder = elgg_extract("entity", $params);
			
			$main_folder_options = array(
				"name" => "main_folder",
				"text" => elgg_echo("file_tools:list:folder:main"),
				"priority" => 0
			);
			
			if(!empty($folder) && elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)){
				$container = $folder->getContainerEntity();
				
				$priority = 9999999;
				$folder_options = array(
					"name" => "folder_" . $folder->getGUID(),
					"text" => $folder->title,
					"href" => false,
					"priority" => $priority
				);
				
				$result[] = ElggMenuItem::factory($folder_options);
				
				$parent_guid = (int) $folder->parent_guid;
				while(!empty($parent_guid) && ($parent = get_entity($parent_guid))){
					$priority--;
					$folder_options = array(
						"name" => "folder_" . $parent->getGUID(),
						"text" => $parent->title,
						"href" => $parent->getURL(),
						"priority" => $priority
					);
					
					$result[] = ElggMenuItem::factory($folder_options);
					$parent_guid = (int) $parent->parent_guid;
				}
			} else {
				$container = elgg_get_page_owner_entity();
			}
			
			// make main folder item
			if(elgg_instanceof($container, "group")){
				$main_folder_options["href"] = "file/group/" . $container->getGUID() . "/all#";
			} else {
				$main_folder_options["href"] = "file/owner/" . $container->username . "/all#";
			}
			
			$result[] = ElggMenuItem::factory($main_folder_options);
		}
		
		return $result;
	}
	
	function file_tools_folder_sidebar_tree_hook($hook, $type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(!empty($params) && is_array($params)){
			$container = elgg_extract("container", $params);
			
			if(!empty($container) && (elgg_instanceof($container, "user") || elgg_instanceof($container, "group"))){
				$main_menu_item =ElggMenuItem::factory(array(
					"name" => "root",
					"text" => elgg_echo("file_tools:list:folder:main"),
					"href" => "#",
					"id" => "0",
					"rel" => "root",
					"priority" => 0
				));
				
				if($folders = file_tools_get_folders($container->getGUID())){
					$main_menu_item->setChildren(file_tools_make_menu_items($folders));
				}
				
				$result[] = $main_menu_item;
			}
		}
		
		return $result;
	}
	
	function file_tools_entity_menu_hook($hook, $type, $returnvalue, $params){
		$result = $returnvalue;
		
		if(!empty($result) && is_array($result) && !empty($params) && is_array($params)){
			$entity = elgg_extract("entity", $params);
			
			if(!empty($entity)){
				if(elgg_instanceof($entity, "object", FILE_TOOLS_SUBTYPE)){
					foreach($result as $index => $menu_item){
						if($menu_item->getName() == "likes"){
							unset($result[$index]);
						}
					}
				} elseif(elgg_instanceof($entity, "object", "file")){
					$result[] = ElggMenuItem::factory(array(
						"name" => "download",
						"text" => elgg_view_icon("download"),
						"href" => "file/download/" . $entity->getGUID(),
						"title" => elgg_echo("file:download"),
						"priority" => 200
					));
				}
			}
		}
		
		return $result;
	}
	