<?php

	function file_tools_page_handler($page) {
		$include_file = false;
		
		switch($page[0]) {
			case "list":
				if(elgg_is_xhr() && !empty($page[1])) {
					elgg_set_page_owner_guid($page[1]);
						
					if(get_input("folder_guid", false) !== false) {
						set_input("draw_page", false);
					}
						
					if(isset($page[2])) {
						set_input("folder_guid", $page[2]);
					}
					
					$include_file = dirname(dirname(__FILE__)) . "/pages/list.php";
				}
				break;
			case "folder":
				if($page[1] == 'new') {
					if(!empty($page[2])) {
						elgg_set_page_owner_guid($page[2]);
					}
					$include_file = dirname(dirname(__FILE__)) . "/pages/folder/new.php";
				} elseif($page[1] == 'edit') {
					if(!empty($page[2])) {
						set_input("folder_guid", $page[2]);
	
						$include_file = dirname(dirname(__FILE__)) . "/pages/folder/edit.php";
					}
				}
				break;
			case "file":
				if($page[1] == 'new') {
					if(!empty($page[2])) {
						elgg_set_page_owner_guid($page[2]);
					}
					$include_file = dirname(dirname(__FILE__)) . "/pages/file/new.php";
				} elseif($page[1] == 'download') {
					$include_file = dirname(dirname(__FILE__)) . "/pages/file/download.php";
				}
				break;
			case "proc":
				if(file_exists(dirname(dirname(__FILE__)) . "/procedures/" . $page[1] . "/" . $page[2] . ".php")) {
					$include_file = dirname(dirname(__FILE__)) . "/procedures/" . $page[1] . "/" . $page[2] . ".php";
				} else {
					echo json_encode(array('valid' => 0));
					exit;
				}
				break;
		}
	
		if(!empty($include_file)){
			include($include_file);
			return true;
		} else {
			forward("file/all");
		}		
	}