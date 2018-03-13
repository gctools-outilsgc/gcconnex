<?php
 if (elgg_is_logged_in()) {	
	$body = elgg_view("page/elements/topbar/account_details");
	
	$spacer_url = elgg_get_site_url() . "_graphics/spacer.gif";
	
	$icon_url = elgg_format_url(elgg_get_logged_in_user_entity()->getIconURL("tiny"));
	$icon = elgg_view("output/img", array(
		"src" => $spacer_url,
		"alt" => elgg_get_logged_in_user_entity()->name,
		"title" => elgg_get_logged_in_user_entity()->name,
		"class" => "elgg-avatar elgg-avatar-small",
		"style" => "background: url($icon_url) no-repeat;",
	));
	
	$messages = "";
	if(elgg_is_active_plugin("messages")){ 
		if($message_count = messages_count_unread()){
			$messages = " <span class=\"subsite-manager-account-dropdown-messages\">[" . $message_count . "]</span>";
		}
	}
	
	echo "<div id=\"subsite-manager-login-dropdown\">";
	
	echo elgg_view("output/url", array(
		"href" => "login#login-dropdown-box",
		"rel" => "popup",
		"class" => "elgg-button elgg-button-dropdown subsite-manager-account-dropdown-button",
		"text" => $icon . elgg_get_logged_in_user_entity()->name . $messages,
	)); 
	echo elgg_view_module("dropdown", "", $body, array("id" => "login-dropdown-box", "class" => "subsite-manager-account-dropdown")); 
	echo "</div>";
}