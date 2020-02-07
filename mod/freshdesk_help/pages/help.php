<?php

	//redirect to new portal if set to gccollab
	if(elgg_get_plugin_setting("custom_domain_url", "freshdesk_help")){
		header("Location: " + elgg_get_plugin_setting("custom_domain_url", "freshdesk_help")); 
		exit();
	}

	// Set context and title
	elgg_set_context('freshdesk');

	$title = elgg_echo('freshdesk:page:title');

	$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => elgg_view('freshdesk/knowledge')
	));

	echo elgg_view_page($title, $body);
?>
