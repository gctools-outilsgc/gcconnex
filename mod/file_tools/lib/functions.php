<?php
/**
 * All helper functions are bundled here
 */

/**
 * Get the extension of an ElggFile
 *
 * @param ElggFile $file the file to check
 *
 * @return string
 */
function file_tools_get_file_extension($file) {
	$result = '';
	
	if ($file->getSubtype() == 'file') {
		if ($filename = $file->getFilename()) {
			$exploded_filename = explode('.', $filename);
			
			$result = end($exploded_filename);
		}
	}
	
	return strtolower($result);
}

/**
 * Read a folder structure for a zip file
 *
 * @param ElggObject $folder  the folder to read
 * @param string     $prepend current prefix
 *
 * @return array
 */
function file_tools_get_zip_structure($folder, $prepend) {
	$entries = array();
	
	if ($prepend) {
		$prepend .= '/';
	}
	
	if (!$folder) {
		$parent_guid = 0;
	} else {
		$parent_guid = $folder->getGUID();
	}
	
	$options = array(
		"type" => "object",
		"subtype" => FILE_TOOLS_SUBTYPE,
		"limit" => false,
		"metadata_name" => "parent_guid",
		"metadata_value" => $parent_guid,
	);
	
	// voor de hoogste map de sub bestanden nog ophalen
	if ($entities = elgg_get_entities_from_metadata($options)) {
		foreach ($entities as $subfolder) {
			$title = $prepend . $subfolder->title;
			$entries[] = array('directory' => $title, 'files' => file_tools_has_files($subfolder->getGUID()));
			
			$entries = array_merge($entries, file_tools_get_zip_structure($subfolder, $title));
		}
	}
	
	return $entries;
}

/**
 * Check if a folder has files
 *
 * @param ElggObject $folder the folder to check
 *
 * @return bool|array
 */
function file_tools_has_files($folder) {
	$files_options = array(
		"type" => "object",
		"subtype" => "file",
		"limit" => false,
		//"container_guid" => get_loggedin_userid(),
		"relationship" => FILE_TOOLS_RELATIONSHIP,
		"relationship_guid" => $folder,
		"inverse_relationship" => false
	);
	
	$file_guids = array();
	
	if ($files = elgg_get_entities_from_relationship($files_options)) {
		foreach ($files as $file) {
			$file_guids[] = $file->getGUID();
		}
		
		return $file_guids;
	}
	
	return false;
}

/**
 * Get the folders in a container
 *
 * @param int $container_guid the container to check
 *
 * @return bool|ElggObject[]
 */
function file_tools_get_folders($container_guid = 0) {
	$result = false;
	
	if (empty($container_guid)) {
		$container_guid = elgg_get_page_owner_guid();
	}
	
	if (!empty($container_guid)) {
		$options = array(
			"type" => "object",
			"subtype" => FILE_TOOLS_SUBTYPE,
			"container_guid" => $container_guid,
			"limit" => false
		);

		if ($folders = elgg_get_entities($options)) {
			$parents = array();

			foreach ($folders as $folder) {
				$parent_guid = (int) $folder->parent_guid;
				
				if (!empty($parent_guid)) {
					if ($temp = get_entity($parent_guid)) {
						if ($temp->getSubtype() != FILE_TOOLS_SUBTYPE) {
							$parent_guid = 0;
						}
					} else {
						$parent_guid = 0;
					}
				} else {
					$parent_guid = 0;
				}
				
				if (!array_key_exists($parent_guid, $parents)) {
					$parents[$parent_guid] = array();
				}
				
				$parents[$parent_guid][] = $folder;
			}
			
			$result = file_tools_sort_folders($parents, 0);
		}
	}
	
	return $result;
}

/**
 * Make folder select options
 *
 * @param array $folders folders to make the options for
 * @param int   $depth   current depth
 *
 * @return string
 */
function file_tools_build_select_options($folders, $depth = 0) {
	$result = array();
	
	if (!empty($folders)) {
		foreach ($folders as $index => $level) {
			/**
			 * $level contains
			 * folder: the folder on this level
			 * children: potential children
			 *
			 */
			if ($folder = elgg_extract("folder", $level)) {
				$result[$folder->getGUID()] = str_repeat("-", $depth) . $folder->title;
			}
			
			if ($childen = elgg_extract("children", $level)) {
				$result += file_tools_build_select_options($childen, $depth + 1);
			}
		}
	}
	
	return $result;
}


/**
 * Make sure you can't move folders into itself or it's children
 *
 * @param array $folders folders to make the options for
 * @param int   $depth   current depth
 * @param int   $folder_guid current folder being indexed
 * @param int   $removed guid of folder just removed
 *
 *
 * @return string
 */
function file_tools_get_child($folders, $depth = 0, $folder_guid, $removed) {
	$result = array();
    
    $bool = $removed;
    $targetFolder = $folder_guid;
	
	if (!empty($folders)) {
		foreach ($folders as $index => $level) {
			if ($folder = elgg_extract("folder", $level)) {
                
                //check to see if current folder being indexed or if parent folder
                    if($folder->getGUID() == $targetFolder || $folder->parent_guid == $bool || $folder->parent_guid == $targetFolder){
                        
                    //update removed guid
                    $bool = $folder->getGUID();
                        
                    } else {
                        
                        //add guid/name to list
                        $result[$folder->getGUID()] = str_repeat("-", $depth) . $folder->title;
                        
                    }
                
			}
			
			if ($childen = elgg_extract("children", $level)) {
				$result += file_tools_get_child($childen, $depth + 1, $folder_guid, $bool);
			}
		}
	}
	
	return $result;
}


/**
 * Get folder selection options for widgets
 *
 * @param array  $folder       the folder to create for
 * @param string $internalname the name of the input field
 * @param array  $selected     the current selected values
 *
 * @return string
 */
function file_tools_build_widget_options($folder, $internalname = "", $selected = array()) {
	$result = "";
	
	if (is_array($folder) && !array_key_exists("children", $folder)) {
		foreach ($folder as $folder_item) {
			$result .= "<ul>";
			$result .= file_tools_build_widget_options($folder_item, $internalname, $selected);
			$result .= "</ul>";
		}
	} else {
		$folder_item = $folder["folder"];
		
		$result .= "<li>";
		if (in_array($folder_item->getGUID(), $selected)) {
			$result .= "<input type='checkbox' name='" . $internalname . "' value='" . $folder_item->getGUID() . "' checked='checked'> " .  $folder_item->title;
		} else {
			$result .= "<input type='checkbox' name='" . $internalname . "' value='" . $folder_item->getGUID() . "'> " .  $folder_item->title;
		}
		
		if (!empty($folder["children"])) {
			$result .= file_tools_build_widget_options($folder["children"], $internalname, $selected);
		}
		$result .= "</li>";
	}
	
	return $result;
}

/**
 * Folder folders by their order
 *
 * @param array $folders     the folders to sort
 * @param int   $parent_guid the parent to sort for
 *
 * @return bool|array
 */
function file_tools_sort_folders($folders, $parent_guid = 0) {
	$result = false;
	
	if (array_key_exists($parent_guid, $folders)) {
		$result = array();
		
		foreach ($folders[$parent_guid] as $subfolder) {
			$children = file_tools_sort_folders($folders, $subfolder->getGUID());
			
			$order = $subfolder->order;
			if (empty($order)) {
				$order = 0;
			}
			
			while (array_key_exists($order, $result)) {
				$order++;
			}
			
			$result[$order] = array(
				"folder" => $subfolder,
				"children" => $children
			);
		}
		
		ksort($result);
	}
	
	return $result;
}

/**
 * Get the subfolders of a folder
 *
 * @param ElggObject $folder the folder to get the subfolders for
 * @param bool       $list   output a list (default: false)
 *
 * @return bool|array|string
 */
function file_tools_get_sub_folders($folder = false, $list = false) {
	$result = false;
	
	if (!empty($folder) && elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
		$container_guid = $folder->getContainerGUID();
		$parent_guid = $folder->getGUID();
	} else {
		$container_guid = elgg_get_page_owner_guid();
		$parent_guid = 0;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => FILE_TOOLS_SUBTYPE,
		"container_guid" => $container_guid,
		"limit" => false,
		"metadata_name" => "parent_guid",
		"metadata_value" => $parent_guid,
		"order_by_metadata" => array('name' => 'order', 'direction' => 'ASC', 'as' => 'integer'),
		"full_view" => false,
		"pagination" => false
	);
	
	if ($list) {
		$folders = elgg_list_entities_from_metadata($options);
	} else {
		$folders = elgg_get_entities_from_metadata($options);
	}
	
	if ($folders) {
		$result = $folders;
	}
	
	return $result;
}

/**
 * Create a folder menu
 *
 * @param array $folders the folders to create the menu for
 *
 * @return bool|ElggMenuItem[]
 */
function file_tools_make_menu_items($folders) {
	$result = false;
	
	if (!empty($folders) && is_array($folders)) {
		$result = array();
		
		foreach ($folders as $index => $level) {
			if ($folder = elgg_extract("folder", $level)) {
				$folder_title = $folder->title;
				if (empty($folder_title)) {
					$folder_title = elgg_echo("untitled");
				}
				
				$folder_menu = ElggMenuItem::factory(array(
					"name" => "folder_" . $folder->getGUID(),
					"text" => $folder_title,
					"href" => "#" . $folder->getGUID(),
					"priority" => $folder->order
				));
				
				if ($children = elgg_extract("children", $level)) {
					$folder_menu->setChildren(file_tools_make_menu_items($children));
				}
				
				$result[] = $folder_menu;
			}
		}
	}
	
	return $result;
}

/**
 * Recursivly change the access of subfolders (and files)
 *
 * @param ElggObject $folder       the folder to change the access for
 * @param bool       $change_files include files in this folder (default: false)
 *
 * @return void
 */
function file_tools_change_children_access($folder, $change_files = false) {
	
	if (!empty($folder) && ($folder instanceof ElggObject)) {
		if ($folder->getSubtype() == FILE_TOOLS_SUBTYPE) {
			// get children folders
			$options = array(
				"type" => "object",
				"subtype" => FILE_TOOLS_SUBTYPE,
				"container_guid" => $folder->getContainerGUID(),
				"limit" => false,
				"metadata_name" => "parent_guid",
				"metadata_value" => $folder->getGUID()
			);
			
			if ($children = elgg_get_entities_from_metadata($options)) {
				foreach ($children as $child) {
					$child->access_id = $folder->access_id;
					$child->save();
					
					file_tools_change_children_access($child, $change_files);
				}
			}
			
			if ($change_files) {
				// change access on files in this folder
				file_tools_change_files_access($folder);
			}
		}
	}
}

/**
 * Change the access of all file in a folder
 *
 * @param ElggObject $folder the folder to change the file access for
 *
 * @return void
 */
function file_tools_change_files_access($folder) {
	
	if (!empty($folder) && ($folder instanceof ElggObject)) {
		if ($folder->getSubtype() == FILE_TOOLS_SUBTYPE) {
			// change access on files in this folder
			$options = array(
				"type" => "object",
				"subtype" => "file",
				"container_guid" => $folder->getContainerGUID(),
				"limit" => false,
				"relationship" => FILE_TOOLS_RELATIONSHIP,
				"relationship_guid" => $folder->getGUID()
			);
			
			if ($files = elgg_get_entities_from_relationship($options)) {
				// need to unregister an event listener
				elgg_unregister_event_handler("update", "object", "file_tools_object_handler");
				
				foreach ($files as $file) {
					$file->access_id = $folder->access_id;
					
					$file->save();
				}
			}
		}
	}
}

/**
 * Get the allowed extensions for uploading
 *
 * @param bool $zip return zip upload dialog format
 *
 * @return bool|string
 */
function file_tools_allowed_extensions($zip = false) {
	
	$allowed_extensions_settings = elgg_get_plugin_setting('allowed_extensions', 'file_tools');
	$allowed_extensions_settings = string_to_tag_array($allowed_extensions_settings);
	
	if (!empty($allowed_extensions_settings)) {
		$result = $allowed_extensions_settings;
	} else {
		$result = array('txt','jpg','jpeg','png','bmp','gif','pdf','doc','docx','xls','xlsx','ppt','pptx','odt','ods','odp');
	}
	
	if (!$zip) {
		return $result;
	}
	
	$result = implode(";*.", $result);
	
	return "*." . $result;
}

if (!function_exists("mime_content_type")) {
	// @codingStandardsIgnoreStart
	function mime_content_type($fn) {
		static $mime_magic_data;
		
		#-- fallback
		$type = false;
		
		#-- read in first 3K of given file
		if (is_dir($fn)) {
			return("httpd/unix-directory");
		} elseif (is_resource($fn) || ($fn = @fopen($fn, "rb"))) {
			$bin = fread($fn, $maxlen=3072);
			fclose($fn);
		} elseif (!file_exists($fn)) {
			return false;
		} else {
			return("application/octet-stream");   // give up
		}
		
		#-- use PECL::fileinfo when available
		if (function_exists("finfo_buffer")) {
			if (!isset($mime_magic_data)) {
				$mime_magic_data = finfo_open(MAGIC_MIME);
			}
			$type = finfo_buffer($bin);
			return($type);
		}
      
		#-- read in magic data, when called for the very first time
		if (!isset($mime_content_type)) {
			
			if ((file_exists($fn = ini_get("mime_magic.magicfile")))
				or (file_exists($fn = "/usr/share/misc/magic.mime"))
				or (file_exists($fn = "/etc/mime-magic"))   ) {
				$mime_magic_data = array();
				
				#-- read in file
				$f = fopen($fn, "r");
				$fd = fread($f, 1<<20);
				fclose($f);
				$fd = str_replace("       ", "\t", $fd);
				
				#-- look at each entry
				foreach (explode("\n", $fd) as $line) {
					
					#-- skip empty lines
					if (!strlen($line) or ($line[0] == "#") or ($line[0] == "\n")) {
						continue;
					}
					
					#-- break into four fields at tabs
					$l = preg_split("/\t+/", $line);
					@list($pos, $typestr, $magic, $ct) = $l;
					#print_r($l);
					
					#-- ignore >continuing lines
					if ($pos[0] == ">") {
						continue;
					}
					
					#-- real mime type string?
					$ct = strtok($ct, " ");
					if (!strpos($ct, "/")) {
						continue;
					}
					
					#-- mask given?
					$mask = 0;
					if (strpos($typestr, "&")) {
						$typestr = strtok($typestr, "&");
						$mask = strtok(" ");
						if ($mask[0] == "0") {
							$mask = ($mask[1] == "x") ? hexdec(substr($mask, 2)) : octdec($mask);
						} else {
							$mask = (int)$mask;
						}
					}
					
					#-- strip prefixes
					if ($magic[0] == "=") {
						$magic = substr($magic, 1);
					}
					
					#-- convert type
					if ($typestr == "string") {
						$magic = stripcslashes($magic);
						$len = strlen($magic);
						if ($mask) {
							continue;
						}
					}
					#-- numeric values
               		else {
						
						if ((ord($magic[0]) < 48) or (ord($magic[0]) > 57)) {
							#echo "\nmagicnumspec=$line\n";
							#var_dump($l);
							continue;  #-- skip specials like  >, x, <, ^, &
						}
						
						#-- convert string representation into int
						if ((strlen($magic) >= 4) && ($magic[1] == "x")) {
							$magic = hexdec(substr($magic, 2));
						} elseif ($magic[0]) {
							$magic = octdec($magic);
						} else {
							$magic = (int) $magic;
							if (!$magic) {
								continue;
							}   // zero is not a good magic value anyhow
						}
						
						#-- different types
						switch ($typestr) {
							case "byte":
								$len = 1;
								break;
							case "beshort":
								$magic = ($magic >> 8) | (($magic & 0xFF) << 8);
							case "leshort":
							case "short":
								$len = 2;
								break;
							case "belong":
								$magic = (($magic >> 24) & 0xFF)
									| (($magic >> 8) & 0xFF00)
									| (($magic & 0xFF00) << 8)
									| (($magic & 0xFF) << 24);
							case "lelong":
							case "long":
								$len = 4;
								break;
							default:
								//date, ldate, ledate, leldate, beldate, lebelbe...
								continue;
						}
					}
					
					#-- add to list
					$mime_magic_data[] = array($pos, $len, $mask, $magic, trim($ct));
				}
			}
			#print_r($mime_magic_data);
		}
		
		#-- compare against each entry from the mime magic database
		foreach ($mime_magic_data as $def) {
			
			#-- entries are organized as follows
			list($pos, $len, $mask, $magic, $ct) = $def;
			
			#-- ignored entries (we only read first 3K of file for opt. speed)
			if ($pos >= $maxlen) {
				continue;
			}
			
			$slice = substr($bin, $pos, $len);
			#-- integer comparison value
			if ($mask) {
				$value = hexdec(bin2hex($slice));
				if (($value & $mask) == $magic) {
					$type = $ct;
					break;
				}
			}
			#-- string comparison
			else {
				if ($slice == $magic) {
					$type = $ct;
					break;
				}
			}
		} // foreach
		
		#-- built-in defaults
		if (!$type) {
			
			#-- some form of xml
			if (strpos($bin, "<"."?xml ") !== false) {
				return("text/xml");
			}
			#-- html
			elseif ((strpos($bin, "<html>") !== false) || (strpos($bin, "<HTML>") !== false)
				|| strpos($bin, "<title>") || strpos($bin, "<TITLE>")
				|| (strpos($bin, "<!--") !== false) || (strpos($bin, "<!DOCTYPE HTML ") !== false)) {
            
				$type = "text/html";
			}
			#-- mail msg
			elseif ((strpos($bin, "\nReceived: ") !== false) || strpos($bin, "\nSubject: ")
				|| strpos($bin, "\nCc: ") || strpos($bin, "\nDate: ")) {
				
				$type = "message/rfc822";
			}
			#-- php scripts
			elseif (strpos($bin, "<"."?php") !== false) {
				return("application/x-httpd-php");
			}
			#-- plain text, C source or so
			elseif (strpos($bin, "function ") || strpos($bin, " and ")
				|| strpos($bin, " the ") || strpos($bin, "The ")
				|| (strpos($bin, "/*") !== false) || strpos($bin, "#include ")) {
					
				return("text/plain");
			}
			#-- final fallback
			else {
				$type = "application/octet-stream";
			}
		}
		
		#-- done
      	return $type;
	}
	// @codingStandardsIgnoreEnd
}

/**
 * Check for unique folder names
 *
 * @param string $title          the title to check
 * @param int    $container_guid the container to limit the search to
 * @param int    $parent_guid    optional parent guid
 *
 * @return bool|ElggObject
 */
function file_tools_check_foldertitle_exists($title, $container_guid, $parent_guid = 0) {
	$result = false;
	
	$entities_options = array(
		'type' => 'object',
		'subtype' => FILE_TOOLS_SUBTYPE,
		'container_guid' => $container_guid,
		'limit' => 1,
		'joins' => array(
			"JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON e.guid = oe.guid"
		),
		'wheres' => array(
			"oe.title = '" . sanitise_string($title) . "'"
		),
		"order_by_metadata" => array(
			"name" => "order",
			"direction" => "ASC",
			"as" => "integer"
		)
	);
	
	if (!empty($parent_guid)) {
		$entities_options["metadata_name_value_pairs"] = array("parent_guid" => $parent_guid);
	}
				
	if ($entities = elgg_get_entities_from_metadata($entities_options)) {
		$result = $entities[0];
	}
	
	return $result;
}

/**
 * Create folders from a zip file structure
 *
 * @param zip_entry $zip_entry      the zip file entry
 * @param int       $container_guid the container where the folders need to be created
 * @param int       $parent_guid    the parent folder
 *
 * @return void
 */
function file_tools_create_folders($zip_entry, $container_guid, $parent_guid = 0) {
	$zip_entry_name = zip_entry_name($zip_entry);
	$filename = basename($zip_entry_name);
	
	if (substr($zip_entry_name, -1) != '/') {
		$zip_base = str_replace($filename, "", $zip_entry_name);
	} else {
		$zip_base = $zip_entry_name;
	}
	
	$zdir = substr($zip_base, 0, -1);
	
	if (!empty($zdir)) {
		$container_entity = get_entity($container_guid);
		
		$access_id = get_input("access_id", false);
		if ($access_id === false) {
			if ($parent_guid != 0) {
				$access_id = get_entity($parent_guid)->access_id;
			} else {
				if (elgg_instanceof($container_entity, "group")) {
					$access_id = $container_entity->group_acl;
				} else {
					$access_id = get_default_access($container_entity);
				}
			}
		}
		
		$sub_folders = explode("/", $zdir);
		if (count($sub_folders) == 1) {
			$entity = file_tools_check_foldertitle_exists($zdir, $container_guid, $parent_guid);

			if (!$entity) {
				$directory = new ElggObject();
				$directory->subtype = FILE_TOOLS_SUBTYPE;
				$directory->owner_guid = elgg_get_logged_in_user_guid();
				$directory->container_guid = $container_guid;
				
				$directory->access_id = $access_id;
				
				$directory->title = $zdir;
				$directory->parent_guid = $parent_guid;
						
				$order = elgg_get_entities_from_metadata(array(
					"type" => "object",
					"subtype" => FILE_TOOLS_SUBTYPE,
					"metadata_name_value_pairs" => array(
						"name" => "parent_guid",
						"value" => $parent_guid
					),
					"count" => true
				));
						
				$directory->order = $order;
						
				$directory->save();
			}
		} else {
			$parent = $parent_guid;
			
			foreach ($sub_folders as $folder) {
				if ($entity = file_tools_check_foldertitle_exists($folder, $container_guid, $parent)) {
					$parent = $entity->getGUID();
				} else {
					$directory = new ElggObject();
					$directory->subtype = FILE_TOOLS_SUBTYPE;
					$directory->owner_guid = elgg_get_logged_in_user_guid();
					$directory->container_guid = $container_guid;
					
					$directory->access_id = $access_id;
					
					$directory->title = $folder;
					$directory->parent_guid = $parent;
						
					$order = elgg_get_entities_from_metadata(array(
						"type" => "object",
						"subtype" => FILE_TOOLS_SUBTYPE,
						"metadata_name_value_pairs" => array(
							"name" => "parent_guid",
							"value" => $parent
						),
						"count" => true
					));
					
					$directory->order = $order;
							
					$parent = $directory->save();
				}
			}
		}
	}
}

/**
 * Unzip an uploaded zip file
 *
 * @param array $file           the $_FILES information
 * @param int   $container_guid the container to put the files/folders under
 * @param int   $parent_guid    the parrent folder
 *
 * @return bool
 */
function file_tools_unzip($file, $container_guid, $parent_guid = 0) {
	$extracted = false;
	
	if (!empty($file) && !empty($container_guid)) {
		$allowed_extensions = file_tools_allowed_extensions();
		
		$zipfile = elgg_extract("tmp_name", $file);
		
		$container_entity = get_entity($container_guid);
		
		$access_id = get_input("access_id", false);
		
		if ($access_id === false) {
			if (!empty($parent_guid) && ($parent_folder = get_entity($parent_guid)) && elgg_instanceof($parent_folder, "object", FILE_TOOLS_SUBTYPE)) {
				$access_id = $parent_folder->access_id;
			} else {
				if (elgg_instanceof($container_entity, "group")) {
					$access_id = $container_entity->group_acl;
				} else {
					$access_id = get_default_access($container_entity);
				}
			}
		}
		
		// open the zip file
		$zip = zip_open($zipfile);
		while ($zip_entry = zip_read($zip)) {
			// open the zip entry
			zip_entry_open($zip, $zip_entry);
			
			// set some variables
			$zip_entry_name = zip_entry_name($zip_entry);
			$filename = basename($zip_entry_name);
			
			// check for folder structure
			if (strlen($zip_entry_name) != strlen($filename)) {
				// there is a folder structure, check it and create missing items
				file_tools_create_folders($zip_entry, $container_guid, $parent_guid);
			}
			
			// extract the folder structure from the zip entry
			$folder_array = explode("/", $zip_entry_name);
			
			$parent = $parent_guid;
			foreach ($folder_array as $folder) {
				$folder = utf8_encode($folder);
				
				if ($entity = file_tools_check_foldertitle_exists($folder, $container_guid, $parent)) {
					$parent = $entity->getGUID();
				} else {
					if ($folder == end($folder_array)) {
						$prefix = "file/";
						$extension_array = explode('.', $folder);
						
						$file_extension	= end($extension_array);
						
						if (in_array(strtolower($file_extension), $allowed_extensions)) {
							$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
							
							// create the file
							$filehandler = new ElggFile();
							$filehandler->setFilename($prefix . $folder);
							
							$filehandler->title 			= $folder;
							$filehandler->originalfilename 	= $folder;
							$filehandler->owner_guid		= elgg_get_logged_in_user_guid();
							
							$filehandler->container_guid 	= $container_guid;
							$filehandler->access_id			= $access_id;
							
							$filehandler->open("write");
							$filehandler->write($buf);
							$filehandler->close();
							
							$mime_type = $filehandler->detectMimeType($filehandler->getFilenameOnFilestore());
							
							// hack for Microsoft zipped formats
							$info = pathinfo($folder);
							$office_formats = array("docx", "xlsx", "pptx");
							if ($mime_type == "application/zip" && in_array($info["extension"], $office_formats)) {
								switch ($info["extension"]) {
									case "docx":
										$mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
										break;
									case "xlsx":
										$mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
										break;
									case "pptx":
										$mime_type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
										break;
								}
							}
							
							// check for bad ppt detection
							if ($mime_type == "application/vnd.ms-office" && $info["extension"] == "ppt") {
								$mime_type = "application/vnd.ms-powerpoint";
							}
							
							$simple_type = file_get_simple_type($mime_type);
							
							$filehandler->setMimeType($mime_type);
							$filehandler->simpletype = $simple_type;
							
							if ($simple_type == "image") {
								$filestorename = elgg_strtolower(time() . $folder);
								
								$thumb = new ElggFile();
								$thumb->owner_guid = elgg_get_logged_in_user_guid();
								
								$thumbnail = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 60, 60, true);
								if ($thumbnail) {
									
									$thumb->setFilename($prefix . "thumb" . $filestorename);
									$thumb->open("write");
									$thumb->write($thumbnail);
									$thumb->close();
									
									$filehandler->thumbnail = $prefix . "thumb" . $filestorename;
									unset($thumbnail);
								}
								
								$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 153, 153, true);
								if ($thumbsmall) {
									$thumb->setFilename($prefix . "smallthumb" . $filestorename);
									
									$thumb->open("write");
									$thumb->write($thumbsmall);
									$thumb->close();
									
									$filehandler->smallthumb = $prefix . "smallthumb" . $filestorename;
									unset($thumbsmall);
								}
								
								$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 600, 600, false);
								if ($thumblarge) {
									$thumb->setFilename($prefix . "largethumb" . $filestorename);
									
									$thumb->open("write");
									$thumb->write($thumblarge);
									$thumb->close();
									
									$filehandler->largethumb = $prefix . "largethumb" . $filestorename;
									unset($thumblarge);
								}
								
								unset($thumb);
							}
							
							set_input('folder_guid', $parent);
							
							$filehandler->save();
							
							$extracted = true;
							
							if (!empty($parent)) {
								add_entity_relationship($parent, FILE_TOOLS_RELATIONSHIP, $filehandler->getGUID());
							}
						}
					}
				}
			}
			
			zip_entry_close($zip_entry);
		}
		
		zip_close($zip);
	}
	
	return $extracted;
}

/**
 * Helper function to check if we use a folder structure
 * Result is cached to increase performance
 *
 * @return bool
 */
function file_tools_use_folder_structure() {
	static $result;
	
	if (!isset($result)) {
		$result = false;
		
		// this plugin setting has a typo, should be use_folder_struture
		// @todo: update the plugin setting name
		if (elgg_get_plugin_setting("user_folder_structure", "file_tools") == "yes") {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Add a folder to a zip file
 *
 * @param ZipArchive &$zip_archive the zip file to add files/folder to
 * @param ElggObject $folder       the folder to add
 * @param string     $folder_path  the path of the current folder
 *
 * @return void
 */
function file_tools_add_folder_to_zip(ZipArchive &$zip_archive, ElggObject $folder, $folder_path = "") {
	
	if (!empty($zip_archive) && !empty($folder) && elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE)) {
		$folder_title = elgg_get_friendly_title($folder->title);
		
		$zip_archive->addEmptyDir($folder_path . $folder_title);
		$folder_path .= $folder_title . DIRECTORY_SEPARATOR;
		
		$file_options = array(
			"type" => "object",
			"subtype" => "file",
			"limit" => false,
			"relationship" => FILE_TOOLS_RELATIONSHIP,
			"relationship_guid" => $folder->getGUID()
		);
		
		// add files from this folder to the zip
		if ($files = elgg_get_entities_from_relationship($file_options)) {
			foreach ($files as $file) {
				// check if the file exists
				if ($zip_archive->statName($folder_path . $file->originalfilename) === false) {
					// doesn't exist, so add
					$zip_archive->addFile($file->getFilenameOnFilestore(), $folder_path . $file->originalfilename);
				} else {
					// file name exists, so create a new one
					$ext_pos = strrpos($file->originalfilename, ".");
					$file_name = substr($file->originalfilename, 0, $ext_pos) . "_" . $file->getGUID() . substr($file->originalfilename, $ext_pos);
					
					$zip_archive->addFile($file->getFilenameOnFilestore(), $folder_path . $file_name);
				}
			}
		}
		
		// check if there are subfolders
		$folder_options = array(
			"type" => "object",
			"subtype" => FILE_TOOLS_SUBTYPE,
			"limit" => false,
			"metadata_name_value_pairs" => array("parent_guid" => $folder->getGUID())
		);
		
		if ($sub_folders = elgg_get_entities_from_metadata($folder_options)) {
			foreach ($sub_folders as $sub_folder) {
				file_tools_add_folder_to_zip($zip_archive, $sub_folder, $folder_path);
			}
		}
	}
}

/**
 * Get a readable byte count
 *
 * @return string
 */
function file_tools_get_readable_file_size_limit() {
	
	$size_units = array("B", "KB", "MB", "GB", "TB", "PB");
	$i = 0;
	
	$file_size_limit = elgg_get_ini_setting_in_bytes("upload_max_filesize");
	while ($file_size_limit > 1024) {
		$i++;
		$file_size_limit /= 1024;
	}
	
	$result = $file_size_limit . $size_units[$i];
	
	return $result;
}

/**
 * Get the listing max length from the plugin settings
 *
 * @return int
 */
function file_tools_get_list_length() {
	static $result;
	
	if (!isset($result)) {
		$result = 50;
		
		$setting = (int) elgg_get_plugin_setting("list_length", "file_tools");
		if ($setting < 0) {
			$result = false;
		} elseif ($setting > 0) {
			$result = $setting;
		}
	}
	
	return $result;
}
