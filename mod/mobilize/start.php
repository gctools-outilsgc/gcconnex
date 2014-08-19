<?php
/*
 *
 * Elgg mobilize
 * Elgg mobile responsive plugin
 *
 * @package mobilize
 * @author Per Jensen - Elggzone
 * @copyright Copyright (c) 2010 - 2012, Per Jensen
 *
 */ 

elgg_register_event_handler('init','system','mobilize_init'); 

function mobilize_init(){  

	elgg_extend_view('css/admin', 'mobilize/admin');
	
	elgg_register_page_handler('about', 'mobilize_expages_page_handler');
	elgg_register_page_handler('terms', 'mobilize_expages_page_handler');
	elgg_register_page_handler('privacy', 'mobilize_expages_page_handler');
	
	detectmobile();	
	$mobile = detectmobile();
	
	$url = elgg_get_simplecache_url('css', 'mobilize');
	elgg_register_css('elgg.mobilize', $url);
		
	if($mobile == true) {
	
		elgg_set_viewtype('mobile');
		
		if (!elgg_is_active_plugin('custom_index')) {
			elgg_unregister_plugin_hook_handler('index','system','custom_index');
			elgg_register_plugin_hook_handler('index', 'system', 'index_handler', 1);
		} 
		
		if (elgg_get_plugin_setting('use_friendspicker', 'mobilize') == 'yes'){			
			elgg_unregister_js('elgg.friendspicker');
		}
						
		elgg_unregister_js('elgg.tinymce');	
		elgg_extend_view('page/elements/head','mobilize/meta', 1);
		
		elgg_register_js('mobilize', 'mod/mobilize/vendors/js/mobilize.js', 'footer');
		elgg_load_js('mobilize');

		elgg_register_event_handler('pagesetup', 'system', 'mobilize_setup_handler', 1000);
	}
	elgg_register_viewtype_fallback('mobile'); 
}

function index_handler($hook, $type, $return, $params) {

	if ($return == true) {
		// another hook has already replaced the front page
		return $return;
	}
	if (!include_once(dirname(__FILE__) . "/index.php")) {
		return false;
	}
	// return true to signify that we have handled the front page
	return true;
	
}

function mobilize_expages_page_handler($page, $handler) {

	if ($handler == 'expages') {
		expages_url_forwarder($page[1]);
	}
	$type = strtolower($handler);

	$title = elgg_echo("expages:$type");
	$content = elgg_view_title($title);

	$object = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => $type,
		'limit' => 1,
	));
	if ($object) {
		$content .= elgg_view('output/longtext', array('value' => $object[0]->description));
	} else {
		$content .= elgg_echo("expages:notset");
	}
	$body = elgg_view_layout('one_sidebar', array('content' => $content));
	echo elgg_view_page($title, $body);

	return true;
}

function detectmobile(){
	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	} else {
		return false;
	}
}

function mobilize_setup_handler() {

	// remove more menu dropdown
	elgg_unregister_plugin_hook_handler('prepare', 'menu:site', 'elgg_site_menu_setup');
			
	elgg_unextend_view('page/elements/header', 'search/header');
	elgg_unregister_menu_item('footer', 'report_this');

	if (elgg_is_logged_in()) {		
		if (elgg_is_active_plugin('dashboard')) {
			elgg_unregister_menu_item('topbar', 'dashboard');		
			elgg_register_menu_item('site', array(
				'name' => 'dashboard',
				'href' => '/dashboard',
				'text' => elgg_echo('dashboard'),
			));
		}		
		$user = elgg_get_logged_in_user_entity();		
		elgg_register_menu_item('footer', array(
			'name' => 'logout',
			'href' => '/action/logout',
			'is_action' => TRUE,
			'text' => elgg_echo('logout'),
			'priority' => 100,
			'section' => 'alt',
		));
		elgg_register_menu_item('footer', array(
			'name' => 'usersettings',
			'href' => "/settings/user/$user->username",
			'text' => elgg_echo('settings'),
			'priority' => 101,
			'section' => 'alt',
		));
		elgg_unregister_menu_item('topbar', 'friends');
		elgg_register_menu_item('site', array(
			'name' => 'friends',
			'text' => elgg_echo('friends'),
			'href' => "/friends/$user->username",
		));
		if (elgg_is_active_plugin('profile')) {
			elgg_unregister_menu_item('topbar', 'profile');
			elgg_register_menu_item('site', array(
				'name' => 'profile',
				'text' => elgg_echo('profile'),
				'href' => "/profile/$user->username",
			));
		}
		if (elgg_is_active_plugin('messages')) {	
			elgg_unregister_menu_item('topbar', 'messages');			
			$num_messages = (int)messages_count_unread();
			if ($num_messages != 0) {
				$text .= "<span class=\"messages-new\">$num_messages</span>";
			}							
			elgg_register_menu_item('site', array(
				'name' => 'messages',
				'href' => 'messages/inbox/' . elgg_get_logged_in_user_entity()->username,
				'text' => elgg_echo('messages') . $text,
			));
		}
	}	
	if (elgg_is_admin_logged_in()) {		
		elgg_register_menu_item('footer', array(
			'name' => 'administration',
			'href' => 'admin',
			'text' => elgg_echo('admin'),
			'priority' => 102,
			'section' => 'alt',
		));
	}
}
