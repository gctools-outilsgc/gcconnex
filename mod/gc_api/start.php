<?php
/*
 * Plugin: GC_api
 * @package GC_api
 * Filename: start.php
 * 
 * Author: Troy T. Lawson - troy.lawson@tbs-sct.gc.ca; lawson.troy@gmail.com
 * 
 * Purpose: main start file for gc_api mod
 */
 	//include the files for api calls with exposed functions
	include elgg_get_plugins_path() . 'gc_api/lib/blog.php';
	include elgg_get_plugins_path() . 'gc_api/lib/profile.php'; 
	include elgg_get_plugins_path() . 'gc_api/lib/skillList.php';
	include elgg_get_plugins_path() . 'gc_api/lib/skillSearch.php';
	include elgg_get_plugins_path() . 'gc_api/lib/wire.php';

	//register css file for custom share form
	$css_url = 'mod/gc_api/views/default/gc_api/special.css';
	elgg_register_css('special-api', $css_url, -10);
	//register init system event
	elgg_register_event_handler('init', 'system', 'gcapi_init');
	
	/*************************************
	 * function: gcapi_init()
	 * input: na
	 * output: na
	 * purpose: Init gc_api plugin. Register action, page handler, and ajax view
	 */
	function gcapi_init() {
		
		$action_path = elgg_get_plugins_path()."gc_api/actions/gc_api";
		elgg_register_action('gc_api/sharer', "$action_path/sharer.php");//for saving object
			
		elgg_register_page_handler('share_bookmarks', 'share_bookmarks_page_handler');
		
		elgg_register_ajax_view('gc_api/ajax_access_view');//used for buidling access selector in share form
	}
	
	/*************************************
	 * function: gcapi_init()
	 * input: $page - formated url segement representing which file to load
	 * output: na
	 * purpose: direct user to proper file based on url entered.
	 */
	function share_bookmarks_page_handler($page) {
		
		elgg_load_library('elgg:bookmarks');
	
		if (!isset($page[0])) {
			return false;
		}
		$pages = dirname(__FILE__) . '/pages/gc_api';	

		switch ($page[0]) {
			//if url is share_bookmarks/share then direct to page containing custom share form
			case "share":
				include "$pages/share.php";
				break;
			//if url is share_bookmarks/login, then direct to page containing custom login form
			case "login":
				//error_log('share - test');
				include "$pages/login.php";
				break;
			default:
				return false;
		}

		elgg_pop_context();
		return true;
	}	