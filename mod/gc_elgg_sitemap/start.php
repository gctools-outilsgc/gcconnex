<?php

elgg_register_event_handler('init','system','gc_elgg_sitemap_init');


function gc_elgg_sitemap_init() {

	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false) {
	    elgg_register_plugin_hook_handler('register', 'menu:site', 'elgg_site_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:user_menu', 'elgg_user_menu_handler');
	    elgg_register_plugin_hook_handler('register', 'menu:title', 'elgg_user_menu_handler');

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
		elgg_register_plugin_hook_handler('members:list', 'newest', 'elgg_members_list_handler');
		
		//
		elgg_register_plugin_hook_handler('view_vars', 'group/elements/summary', 'elgg_entities_list_handler');
		elgg_register_plugin_hook_handler('view_vars','object/elements/thewire_summary', 'elgg_thewire_list_handler');
		//elgg_register_plugin_hook_handler('view_vars','page/components/image_block', 'elgg_sidebar_handler');
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/full', 'elgg_full_entities_view_handler');

		//elgg_register_plugin_hook_handler('view', 'object/elements/summary', 'elgg_summary_entities_view_handler');
		elgg_register_plugin_hook_handler('view', 'event_calendar/show_events', 'elgg_event_calendar_list_handler');

		elgg_register_plugin_hook_handler('register', 'menu:filter', 'elgg_entity_menu_handler');

	}
}

function elgg_event_calendar_list_handler($hook, $type, $value, $params) {

	$event_list = elgg_list_entities([
	    'type' => 'object',
	    'subtype' => 'event_calendar',
	]);

	return $event_list;
}


function elgg_summary_entities_view_handler($hook, $type, $value, $params) {
	error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  ");
	return "";
}


function elgg_entity_menu_handler($hook, $type, $value, $params) {
	error_log(" >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>      blahp.");

	return "";
}

function elgg_full_entities_view_handler($hook, $type, $value, $params) {
	error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>  sup.");

	return "";
}

function elgg_members_list_handler($hook, $type, $value, $params) {
	//$members = elgg_get_entities(array('type' => 'user', 'limit' => false));
	error_log(" ppppppppppppppppppppppppppppppppppppppppppppppppppppppppp ");
	//echo print_r($params['options']);
	//$display = "";
	//foreach ($members as $member) {
	//	$display .= "<a href='{$member->getURL()}'>{$member->name}</a> <br/>";
	//}
	return "sdfdsfds";
}

function elgg_thewire_list_handler($hook, $type, $value, $params) {
	error_log(">>>>>>>>> wire list handler... ".get_context());
	echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->description}</a>  <br/>";
	return "";
}

function elgg_entities_list_handler($hook, $type, $value, $params) {
	error_log("++++++++++++++  context: ".get_context());
	error_log("++++++++++++++  user: ".$value['entity']->username);
	$context = get_context();
	switch ($context) {
		case 'groups':
			//echo print_r($value['entity']);
			$group_url = elgg_get_site_url()."groups/profile/{$value['entity']->guid}/";
			echo "<a href='{$group_url}'>{$value['entity']->name}</a>  <br/>";
			break;

		case 'members':
			$member_url = elgg_get_site_url()."profile/{$value['entity']->username}/";
			echo "<a href='{$member_url}'>{$value['entity']->username}</a>  <br/>";
			break;

		default:
			error_log(">>>>>>>>>  list handler".get_context()." ... {$value['fullview']}");
			echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->title}</a>  <br/>";
		
	}
	return "";
}

function elgg_sidebar_handler($hook, $type, $menu, $params) {
	error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>  sup.1");
	//elgg_trigger_plugin_hook('members:list', 'newest', $menu['entity'], null);
	return "";
}

/**
 * hide the breadcrumbs
 */
function elgg_breadcrumb_handler($hook, $type, $menu, $params) {
	error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>  sup.2");
	return "";
}



/**
 * hide the user menu bar
 */
function elgg_user_menu_handler($hook, $type, $menu, $params) {
	error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>  sup.3");
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
