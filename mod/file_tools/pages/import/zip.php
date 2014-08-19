<?php 

	gatekeeper();	

	$page_owner = elgg_get_page_owner_entity();

	if($page_owner) {
		// make breadcrumb
		elgg_push_breadcrumb(elgg_echo("file"), "file/all");
		if(elgg_instanceof($page_owner, "group", null, "ElggGroup")){
			elgg_push_breadcrumb($page_owner->name, "file/group/" . $page_owner->getGUID() . "/all");
		} else {
			elgg_push_breadcrumb($page_owner->name, "file/owner/" . $page_owner->username);
		}
		elgg_push_breadcrumb(elgg_echo("file_tools:upload:new"));
		
		// make page elements
		elgg_register_title_button();
		$title_text = elgg_echo("file_tools:upload:new");

		$form = elgg_view_form("file_tools/import/zip", array("enctype" => "multipart/form-data"));
		
		// build page
		$body = elgg_view_layout("content", array(
			"title" => $title_text,
			"content" => $form,
			"filter" => false
		));

		// draw page
		echo elgg_view_page($title_text, $body);
	} else {
		register_error(elgg_echo("file_tools:error:pageowner"));
		forward(REFERER);
	}