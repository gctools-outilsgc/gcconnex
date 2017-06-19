<?php

elgg_register_event_handler('init','system','gc_elgg_sitemap_init');


function gc_elgg_sitemap_init() {


	if (strcmp('gsa-crawler',strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) {

	    elgg_register_plugin_hook_handler('register', 'menu:site', 'elgg_site_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:user_menu', 'elgg_user_menu_handler');
	    elgg_register_plugin_hook_handler('prepare', 'breadcrumbs', 'elgg_breadcrumb_handler');

	    /// remove all the sidebars across the site
	    elgg_register_plugin_hook_handler('view','bookmarks/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','blog/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','event_calendar/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','file/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','groups/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','members/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','missiona/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','thewire/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','photos/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view','file/sidebar', 'elgg_sidebar_handler');

	    /// renmove these pages so that it doesn't get crawled
		elgg_unregister_page_handler('activity');
		elgg_unregister_page_handler('dashboard');
		elgg_unregister_menu_item('site', 'activity');
		elgg_unregister_menu_item('site', 'career');
		elgg_unregister_menu_item('site', 'Help');
		elgg_unregister_menu_item('site', 'newsfeed');
		elgg_unregister_menu_item('topbar', 'dashboard');

		/// list all entities
		elgg_register_plugin_hook_handler('view_vars','object/elements/summary', 'elgg_entities_list_handler');

		/// groups

	}
}


function elgg_entities_list_handler($hook, $type, $value, $params) {
	echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->name}</a>";

	return "";
}

function elgg_sidebar_handler($hook, $type, $menu, $params) {

	return "";
}

/**
 * hide the breadcrumbs
 */
function elgg_breadcrumb_handler($hook, $type, $menu, $params) {
	return "";
}



/**
 * hide the user menu bar
 */
function elgg_user_menu_handler($hook, $type, $menu, $params) {
	return "";
}


/**
 * xml the links for the site navigation
 */
function elgg_site_menu_handler($hook, $type, $menu, $params) {

	$display_xml .= "<font style='color:white;'>";
	foreach ($menu as $key => $item) {
		/// some item menu is not correct

		$display_xml .= "
		<p>
		<url>
			<loc><a href='{$item->getHref()}'> {$item->getName()} </a></loc>
			<name>(remove) {$item->getName()}</name>
			<lastmod>2005-01-01</lastmod>
			<changefreq>monthly</changefreq>
			<priority>0.8</priority>
		</url>
		</p>";
	}
	$display_xml .= "</font>";
	echo $display_xml;

	return true;
}



/*

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<url>

		<loc>http://www.example.com/</loc>

		<lastmod>2005-01-01</lastmod>

		<changefreq>monthly</changefreq>

		<priority>0.8</priority>

	</url>

</urlset>

*/
