<?php 

	gatekeeper();
	
	$folder_guid = get_input("folder_guid");
	$forward = true;
	
	if(!empty($folder_guid)){
		if($folder = get_entity($folder_guid)) {
			if(elgg_instanceof($folder, "object", FILE_TOOLS_SUBTYPE) && $folder->canEdit()) {
				$forward = false;
				
				// set context and page_owner
				elgg_set_context("file");
				elgg_set_page_owner_guid($folder->getContainerGUID());
				
				// build page elements
				$title_text = elgg_echo("file_tools:edit:title");
				
				$form_vars = array(
					"id" => "file_tools_edit_form"
				);
				$body_vars = array(
					"folder" => $folder, 
					"page_owner_entity" => elgg_get_page_owner_entity()
				);
				
				$edit = elgg_view_form("file_tools/folder/edit", $form_vars, $body_vars);
				
				// build page
				$body = elgg_view_layout("one_sidebar", array(
					"title" => $title_text,
					"content" => $edit
				));
			}
		}
	}

	if(!$forward) {
		echo elgg_view_page($title_text, $body);
	} else {
		forward(REFERER);
	}