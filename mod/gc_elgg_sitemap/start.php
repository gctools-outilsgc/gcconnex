<?php

elgg_register_event_handler('init','system','gc_elgg_sitemap_init');


function gc_elgg_sitemap_init() {

	// display text only if user agent string is gsa-crawler (or whatever is set)
	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {

	    elgg_register_plugin_hook_handler('register', 'menu:site', 'elgg_site_menu_handler', array());
	    elgg_register_plugin_hook_handler('register', 'menu:user_menu', 'elgg_user_menu_handler', array());
	    elgg_register_plugin_hook_handler('register', 'menu:title', 'elgg_user_menu_handler', array());
	    elgg_register_plugin_hook_handler('register', 'menu:filter', 'elgg_entity_menu_handler', array());
	    elgg_register_plugin_hook_handler('prepare', 'breadcrumbs', 'elgg_breadcrumb_handler', array());
	    elgg_register_plugin_hook_handler('register', 'menu:title2', 'elgg_site_menu_handler', array());

	    elgg_register_menu_item('site', array('name' => 'pages', 'text' => 'Pages', 'href' => '/pages/all'));

	
	    /// remove all the sidebars across the site
	    elgg_register_plugin_hook_handler('view', 'bookmarks/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'blog/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'event_calendar/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'file/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'groups/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'members/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'missiona/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'thewire/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'photos/sidebar', 'elgg_sidebar_handler');
	    elgg_register_plugin_hook_handler('view', 'file/sidebar', 'elgg_sidebar_handler');
		elgg_register_plugin_hook_handler('view', 'input/longtext', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'input/submit', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'ouptput/url', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'event_calendar/show_events', 'elgg_event_calendar_list_handler');

		elgg_register_plugin_hook_handler('view', 'groups/profile/widget_area', 'elgg_generic_view_handler');
		elgg_register_plugin_hook_handler('view', 'page/elements/comments', 'elgg_comment_view_handler');
		elgg_register_plugin_hook_handler('view', 'page/elements/topbar_wrapper', 'elgg_view_topbar_handler');

	    /// renmove these pages so that it doesn't get crawled
		elgg_unregister_page_handler('activity');
		elgg_unregister_page_handler('dashboard');
		elgg_unregister_menu_item('topbar', 'dashboard');
		elgg_unregister_menu_item('site', 'activity');
		elgg_unregister_menu_item('site', 'career');
		elgg_unregister_menu_item('site', 'Help');
		elgg_unregister_menu_item('site', 'newsfeed');
		elgg_unregister_menu_item('site', 'communities');
		elgg_unregister_menu_item('title2', 'new_folder');

		/// list all entities

		/* WARNING: "Argument 2 passed to Elgg\\ViewsService::renderView() must be of the type array, null given */
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/summary', 'elgg_entities_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/full', 'elgg_full_entities_view_handler');
		elgg_register_plugin_hook_handler('view_vars', 'object/elements/thewire_summary', 'elgg_thewire_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'group/elements/summary', 'elgg_entities_list_handler');
		elgg_register_plugin_hook_handler('view_vars', 'page/components/image_block', 'elgg_sidebar_handler');

		elgg_register_plugin_hook_handler('view', 'members/nav', 'elgg_members_menu_handler');
		elgg_register_plugin_hook_handler('view', 'event_calendar/filter_menu', 'elgg_members_menu_handler');

		elgg_register_plugin_hook_handler('route', 'comment', 'elgg_display_comment_handler');

	    elgg_register_plugin_hook_handler('register','menu:owner_block','group_navigation_handler');
		elgg_extend_view('groups/profile/summary', 'group_tabs', 600);

		elgg_register_plugin_hook_handler('entity:url', 'group', 'redirect_group_url');
		elgg_register_plugin_hook_handler('entity:url', 'object', 'redirect_content_url', 1);
		elgg_register_plugin_hook_handler('view', 'output/longtext', 'strip_content_hyperlinks_handler');

		// modifying view in the user's profile
		elgg_register_plugin_hook_handler('view', 'b_extended_profile/portfolio', 'linkedin_profile_handler');
		elgg_register_plugin_hook_handler('view', 'b_extended_profile/skills', 'elgg_view_topbar_handler');

	}

	// simple page listing the latest objects created
	elgg_register_page_handler('sitemap-latest-users', 'sitemap_latest_users_handler');
	elgg_register_page_handler('sitemap-latest-groups', 'sitemap_latest_groups_handler');
	elgg_register_page_handler('sitemap-latest-wire', 'sitemap_latest_wire_handler');
	elgg_register_page_handler('sitemap-latest-blog', 'sitemap_latest_blog_handler');
	elgg_register_page_handler('sitemap-latest-page_top', 'sitemap_latest_page_top_handler');
	elgg_register_page_handler('sitemap-latest-page', 'sitemap_latest_page_handler');
	elgg_register_page_handler('sitemap-latest-bookmarks', 'sitemap_latest_bookmarks_handler');
	elgg_register_page_handler('sitemap-latest-event_calendar', 'sitemap_latest_event_calendar_handler');
	elgg_register_page_handler('sitemap-latest-comment', 'sitemap_latest_comment_handler');
	elgg_register_page_handler('sitemap-latest-idea', 'sitemap_latest_idea_handler');
}

function sitemap_list_subtype( $subtype, $offset ) {
	echo '<meta name="robots" content="noindex, follow">';

	// list page
	if ( $offset == "list" ) {
		$items_count = elgg_get_entities( array('type' => 'object', 'subtype' => $subtype, 'full_view' => false, 'count' => true) );

		for ($i=0; $i <= $items_count/500; $i++) { 
			echo "<br /> " . elgg_view('output/url', array(
				'href' => "sitemap-latest-$subtype/" . (500 * $i),
				'text' => "Offset " . (500 * $i),
				'rel' => false,
			));
		}
		return true;
	}

	$limit = 500;

	echo "simple list page <br />";
	$items = elgg_get_entities( array('type' => 'object', 'subtype' => $subtype, 'full_view' => false, 'limit' => $limit, 'offset' => $offset) );

	foreach ($items as $n => $item) {
		if ( !($item instanceof \ElggEntity) )
			continue;

		echo "<br /> " . elgg_view('output/url', array(
			'href' => $item->getURL(),
			'text' => ($item->title ? $item->title : $item->name),
			'rel' => false,
		));
	}

	return true;
}

function sitemap_latest_users_handler($page) {
	echo '<meta name="robots" content="noindex, follow">';

	// list page
	if ( $page[0] == "list" ) {
		$users = elgg_get_entities( array('type' => 'user', 'full_view' => false, 'count' => true) );

		for ($i=0; $i <= $users/500; $i++) { 
			echo "<br /> " . elgg_view('output/url', array(
				'href' => "sitemap-latest-users/" . (500 * $i),
				'text' => "Offset " . (500 * $i),
				'rel' => false,
			));
		}
		return true;
	}

	$offset = $page[0];
	$limit = 500;

	echo "simple user list page <br />";
	$users = elgg_get_entities( array('type' => 'user', 'full_view' => false, 'limit' => $limit, 'offset' => $offset) );

	foreach ($users as $n => $item) {
		if ( !($item instanceof \ElggEntity) )
			continue;

		echo "<br /> " . elgg_view('output/url', array(
			'href' => $item->getURL(),
			'text' => ($item->title ? $item->title : $item->name),
			'rel' => false,
		));
	}

	return true;
}

function sitemap_latest_groups_handler($page) {
	echo '<meta name="robots" content="noindex, follow">';

	// list page
	if ( $page[0] == "list" ) {
		$groups = elgg_get_entities( array('type' => 'group', 'full_view' => false, 'count' => true) );

		for ($i=0; $i <= $groups/500; $i++) { 
			echo "<br /> " . elgg_view('output/url', array(
				'href' => "sitemap-latest-groups/" . (500 * $i),
				'text' => "Offset " . (500 * $i),
				'rel' => false,
			));
		}
		return true;
	}

	$offset = $page[0];
	$limit = 500;

	echo "simple group list page <br />";
	$groups = elgg_get_entities( array('type' => 'group', 'full_view' => false, 'limit' => $limit, 'offset' => $offset) );

	foreach ($groups as $n => $item) {
		if ( !($item instanceof \ElggEntity) )
			continue;

		echo "<br /> " . elgg_view('output/url', array(
			'href' => $item->getURL(),
			'text' => ($item->title ? $item->title : $item->name),
			'rel' => false,
		));
	}

	return true;
}

function sitemap_latest_wire_handler($page) {
	sitemap_list_subtype( "thewire", $page[0] );
	return true;
}

function sitemap_latest_blog_handler($page) {
	sitemap_list_subtype( "blog", $page[0] );
	return true;
}
function sitemap_latest_page_top_handler($page) {
	sitemap_list_subtype( "page_top", $page[0] );
	return true;
}
function sitemap_latest_page_handler($page) {
	sitemap_list_subtype( "page", $page[0] );
	return true;
}
function sitemap_latest_bookmarks_handler($page) {
	sitemap_list_subtype( "bookmarks", $page[0] );
	return true;
}
function sitemap_latest_event_calendar_handler($page) {
	sitemap_list_subtype( "event_calendar", $page[0] );
	return true;
}
function sitemap_latest_comment_handler($page) {
	sitemap_list_subtype( "comment", $page[0] );
	return true;
}
function sitemap_latest_idea_handler($page) {
	sitemap_list_subtype( "idea", $page[0] );
	return true;
}

function elgg_display_comment_handler($hook, $type, $return, $params) {
    $segments = elgg_extract('segments', $return, array());

    if ($segments[0] === 'view') {
        $entity = get_entity($segments[1]);

        // comments do not have a title
        $title = "";
        $content = $entity->description;

        echo elgg_view_page($title, $content);

        // in the route hook, return false says, "stop rendering, we've handled this request"
        return false;
    }
}

function elgg_view_topbar_handler($hook, $type, $return, $params) {
	return "";
}

function linkedin_profile_handler($hook, $type, $return, $params) {

	$user = elgg_get_page_owner_entity();
	$portfolio_guid = $user->portfolio;

	// when no portfolio for user exists
	if (empty($portfolio_guid) || $portfolio_guid == NULL)
		return;

	if (!is_array($portfolio_guid))
		$portfolio_guid = array($portfolio_guid);

	foreach ($portfolio_guid as $guid) {
		
		$entry = get_entity($guid);
		if ($entry instanceof ElggEntity) {
			echo gc_explode_translation($entry->title, 'en').' / '.gc_explode_translation($entry->title, 'fr');
		}
	}

	return "";
}


function strip_content_hyperlinks_handler($hook, $type, $return, $params) {
	
	// pull the user agent string and/or user testing
	$gsa_agentstring = strtolower(elgg_get_plugin_setting('gsa_agentstring','gc_fedsearch_gsa'));
	$gsa_usertest = elgg_get_plugin_setting('gsa_test','gc_fedsearch_gsa');
	if ($gsa_usertest) $current_user = elgg_get_logged_in_user_entity();

	/*blog pages bookmarks file discussion*/
	$filter_entity = array('blog', 'pages', 'discussion', 'file', 'bookmarks');
	$context = get_context();

	// only do it for the main content, comments will be left the way it is
	$comment = new DOMDocument();
	$comment->loadHTML($return);
	$comment_block = $comment->getElementsByTagName('div');

	if (strstr($return, 'data-role="comment-text"') !== false) {
		return;
	}

	if (!empty($comment_block) || $comment_block === null)
		$comment_text = $comment_block->item(0)->getAttribute('data-role');
	else
		$comment_text = "";

	if (( strcmp($comment_text,'comment-text') == 0 || strcmp($comment_text, 'discussion-reply-text') == 0 ))
		return;

	if (!in_array($context, $filter_entity))
		return;


	$page_url = get_sanitized_url();
	// url: /file/view/1102
	$entity = get_entity($page_url[2]);

	// if $entity is not valid, then just don't do anything, to avoid error
	if (!($entity instanceof ElggEntity))
		return;

	if (isJsonString($entity->description)) {
		$json = json_decode($entity->description, true);
		$description_en = $json['en'];
		$description_fr = $json['fr'];
	} else {
		$description_en = $entity->description;
		$description_fr = $entity->description2;

	}

	// english body text
	$description = new DOMDocument();
	$description->loadHTML($description_en);
	$links = $description->getElementsByTagName('a');
	for ($i = $links->length - 1; $i >= 0; $i--) {
		$linkNode = $links->item($i);
		$lnkText = $linkNode->textContent;
		$newTxtNode = $description->createTextNode($lnkText);
		$linkNode->parentNode->replaceChild($newTxtNode, $linkNode);
	}
	$return = $description->textContent."<br/><br/>";


	// french body text
	if (!empty($description_fr)) {
		$description->loadHTML($description_fr);
		$links = $description->getElementsByTagName('a');
		for ($i = $links->length - 1; $i >= 0; $i--) {
			$linkNode = $links->item($i);
			$lnkText = $linkNode->textContent;
			$newTxtNode = $description->createTextNode($lnkText);
			$linkNode->parentNode->replaceChild($newTxtNode, $linkNode);
		}
	}
	$return .= $description->textContent;

	return $return;
}


function redirect_group_url($hook, $type, $url, $params) {
	// from: 192.168.xx.xx/gcconnex/groups/profile/1111/group-name
	// to: 192.168.xx.xx/gcconnex/groups/profile/1111/
	if (strpos($_SERVER['REQUEST_URI'],"/groups/profile/") !== false && strrpos( $_SERVER['REQUEST_URI'], '/', strrpos( $_SERVER['REQUEST_URI'], ''.$params['entity']->guid ) ) )
		forward("groups/profile/{$params['entity']->guid}");
}


function get_sanitized_url() {

	$base_site_url = str_replace('/', ' ', elgg_get_site_entity()->getURL());
	$current_url = str_replace('/', ' ', ((isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"));
	$current_url = str_replace($base_site_url, '', $current_url);
	$current_url = str_replace(' ', '/', $current_url);
	$current_url = explode("/", $current_url);

	return $current_url;
}

/**
 * covers: blogs, files, pages
 * does not cover: bookmarks, missions, images, polls, wire, event
 */
function redirect_content_url($hook, $type, $url, $params) {

	// display only the comment when the url is directing to a specific comment
	// only do this when the user agent is solr-crawler
	if (strpos($_SERVER['REQUEST_URI'], '/comment/view/') !== false ) return;

	if (strpos($_SERVER['REQUEST_URI'], "/view/") !== false)
	{
		$subtype = $params['entity']->getSubtype();

		if ($subtype === 'groupforumtopic') $subtype = 'discussion';
		if ($subtype === 'page_top') $subtype = 'pages';
		if ($subtype === 'idea') $subtype = 'ideas';

		if ( strrpos( $_SERVER['REQUEST_URI'], '/', strrpos( $_SERVER['REQUEST_URI'], ''.$params['entity']->guid ) ) )
			forward("{$subtype}/view/{$params['entity']->guid}");
	}
}


function group_navigation_handler($hook, $type, $value, $params) {

	if (elgg_get_context() === 'group_profile' || elgg_get_context() === 'groupSubPage') {
	
		$base_url = elgg_get_site_entity()->getURL();
		$group_id = elgg_get_page_owner_entity()->guid;

		foreach ($value as $key => $item) {

			if ($item->getName() === 'activity' || $item->getName() === 'more' || $item->getName() === 'photo_albums' || $item->getName() === 'event_calendar' || $item->getName() === 'polls' || $item->getName() === 'pages') 
				continue;

			if ($item->getName() === 'discussion') {
				$url = "{$base_url}{$item->getName()}/owner/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			} else if ($item->getName() === 'about') {
				$url = "{$base_url}groups/profile/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			} else {
				$url = "{$base_url}{$item->getName()}/group/{$group_id}";
				echo "<a href='{$url}'>{$item->getName()}</a> <br/>";
			}

		}
	}
	return array();
}


function elgg_members_menu_handler($hook, $type, $menu, $params) {
	return "";
}

function elgg_generic_view_handler($hook, $type, $value, $params) {
	return array();
}



function elgg_comment_view_handler($hook, $type, $value, $params) {
	//echo "type: {$type} /// hook: {$hook} /// ".print_r($value,true);

	if ($type === 'page/elements/comments') {

		$comments = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'comment',
			'container_guid' => $params['vars']['entity']->guid,
			'limit' => 0,
			'distinct' => false
		));

		foreach ($comments as $comment) {
			$comment_list .= "<a href='{$comment->getURL()}'>{$comment->description}</a> <br/>";
		}
	}

	return $comment_list;
}

function elgg_event_calendar_list_handler($hook, $type, $value, $params) {

	$event_list = elgg_list_entities([
	    'type' => 'object',
	    'subtype' => 'event_calendar',
	]);

	return $event_list;
}



function elgg_entity_menu_handler($hook, $type, $menu, $params) {
	return array();
}

/**
 * checks if string input is json
 * @param string $string
 */
function isJsonString($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}


function elgg_full_entities_view_handler($hook, $type, $value, $params) {

	$description = "";

	switch ($value['entity']->getSubtype()) {

		case 'event_calendar':
			if (isJsonString($value['entity']->long_description)) {
				
				$description_array = json_decode($value['entity']->long_description, true);
				$description .= "<p> {$description_array['en']} </p> <p> {$description_array['fr']} </p>";
			} else {
				
				$description .= "<p> {$value['entity']->long_description} </p> <p> {$value['entity']->long_description2} </p>";
			}
			break;

		default:
			if (isJsonString($value['entity']->description)) {
				
				$description_array = json_decode($value['entity']->description, true);
				$description .= "<p> {$description_array['en']} </p> <p> {$description_array['fr']} </p>";
			} else {
				
				$description .= "<p> {$value['entity']->description} </p> <p> {$value['entity']->description2} </p>";
			}
	}

	echo $description;

	return array();
}


function elgg_thewire_list_handler($hook, $type, $value, $params) {

	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {
		echo "<a href='{$value['entity']->getURL()}?language=en'>{$value['entity']->description}</a>  <br/>";
		echo "<a href='{$value['entity']->getURL()}?language=fr'>{$value['entity']->description}</a>  <br/>";
	} else {
		echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->description}</a>  <br/>";
	}
	return array();

}

/// lists out all the entities on the page
function elgg_entities_list_handler($hook, $type, $value, $params) {
	
	$empty = array();
	// brief view: display content (excerpt)
	// full view: content does not exist (it will display the title link again)
	if (!$value['content'] && get_context() !== 'members' && get_context() !== 'polls' && get_context() !== 'event_calendar' && get_context() !== 'file' && get_context() !== 'groups') {
		return $empty;
	}


	if ($value['entity']->title !== '') {
		$pArray = json_decode($value['entity']->title);
		if ($pArray->en === '' && $pArray->fr === '') return $empty;
	} 

	$context = get_context();
	switch ($context) {
		case 'file':
		case 'event_calendar':
			if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {
				echo "<a href='{$value['entity']->getURL()}?language=en'>{$value['entity']->title}</a>  <br/>";
				echo "<a href='{$value['entity']->getURL()}?language=fr'>{$value['entity']->title}</a>  <br/>";
			} else {
				echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->title}</a>  <br/>";
			}
			break;
		case 'groups':
			$group_url = elgg_get_site_url()."groups/profile/{$value['entity']->guid}/";
			if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {
				echo "<a href='{$group_url}?language=en'>{$value['entity']->name}</a>  <br/>";
				echo "<a href='{$group_url}?language=fr'>{$value['entity']->name}</a>  <br/>";
			} else {
				echo "<a href='{$group_url}'>{$value['entity']->name}</a>  <br/>";
			}

			break;

		case 'members':
			$member_url = elgg_get_site_url()."profile/{$value['entity']->username}";
			if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {
				echo "<a href='{$member_url}?language=en'>{$value['entity']->username}</a>  <br/>";
				echo "<a href='{$member_url}?language=fr'>{$value['entity']->username}</a>  <br/>";
			} else {
				echo "<a href='{$member_url}'>{$value['entity']->username}</a>  <br/>";
			}
			break;

		default:
			if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false) {
				echo "<a href='{$value['entity']->getURL()}?language=en'>{$value['entity']->title}</a>  <br/>";
				echo "<a href='{$value['entity']->getURL()}?language=fr'>{$value['entity']->title}</a>  <br/>";
			} else {
				echo "<a href='{$value['entity']->getURL()}'>{$value['entity']->title}</a>  <br/>";
			}
		
	}

	return $empty;
}

function elgg_sidebar_handler($hook, $type, $menu, $params) {
	if (is_array($menu) && $menu['body'])
		echo $menu['body'];
	return array();
}

/**
 * hide the breadcrumbs
 */
function elgg_breadcrumb_handler($hook, $type, $menu, $params) {
	return array();
}



/**
 * hide the user menu bar
 */
function elgg_user_menu_handler($hook, $type, $menu, $params) {
	return array();
}


/**
 * xml the links for the site navigation
 */
function elgg_site_menu_handler($hook, $type, $menu, $params) {
	$menu_item = "";
	foreach ($menu as $key => $item) {

		if ($item->getName() === 'translation_editor' || $item->getName() === 'new_folder' || $item->getName() === 'questions' || $item->getName() === 'polls')
			continue;

		if ($item->getName() === 'groups') {
			$group_url = elgg_get_site_url()."groups/";
			$menu_item .= " <a style='color:white;' href='{$group_url}'> {$item->getName()}</a> ";
		}
		else 
			$menu_item .= " <a style='color:white;' href='{$item->getHref()}'> {$item->getName()}</a> ";
	}
	echo $menu_item;

	return array();
}

