<?php
if (elgg_is_active_plugin("rijkshuisstijl")) {
	if (elgg_is_logged_in()) {
		echo elgg_view("subsite_manager/account/dropdown");	
	} else {
		echo elgg_view("core/account/login_button");
	}
} else {
	if (!elgg_is_logged_in()) {
		return;
	}

	// link back to main site.
	$site = elgg_get_site_entity();
	$site_name = $site->name;
	$site_url = elgg_get_site_url();

	echo elgg_view("output/url", array(
		"text" => $site->name, 
		"title" => $site->name,
		"href" => "https://www.pleio.nl/",
		"class"=> "pleio-logo"
	));

	echo elgg_view("search/search_box");
	echo elgg_view("page/elements/topbar/account");
}