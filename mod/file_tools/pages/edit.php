<?php 

	gatekeeper();
	
	$folder_guid = get_input("folder_guid");
	$forward = true;
	
	if(!empty($folder_guid)){
		if($folder = get_entity($folder_guid)) {
			if(($folder->getSubtype() == FILE_TOOLS_SUBTYPE) && $folder->canEdit()) {
				$forward = false;
				
				// set context and page_owner
				elgg_set_context("file");
				elgg_set_page_owner_guid($folder->getContainerGUID());
				
				// build page elements
				$title_text = elgg_echo("file_tools:edit:title");
				$title = elgg_view_title($title_text);
				
				$edit = elgg_view("file_tools/forms/edit", array("folder" => $folder, "page_owner_entity" => elgg_get_page_owner_entity()));
				
				// build page
				$page_data = $title . $edit;
			}
		}
	}

	if(!$forward) {
		echo elgg_view_page($title_text, elgg_view_layout("one_sidebar", array('content' => $page_data)));
	} else {
		forward(REFERER);
	}