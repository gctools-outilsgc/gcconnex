<?php


elgg_register_event_handler('init', 'system', 'gc_lang_url_handler_init');
elgg_register_plugin_hook_handler('route', 'all', 'global_url_handler', 10);

function gc_lang_url_handler_init($param1, $param2, $param3) {
	// empty ...
}

/**
 * Handles incoming HTTP Request from the GSA, this acts as the security layer for the GSA only
 * @param $hook
 * @param $type
 * @param $returnvalue
 * @param $params
 * @return False to stop processing the response, True will let elgg handle the response
 */
function global_url_handler($hook, $type, $returnvalue, $params) {

	// do not include the gsa crawler, this will be used for public and solr crawler
	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') === false) {
		// checks to make sure that the url does not affect the ajax calls
		if (strpos($_SERVER['REQUEST_URI'], 'ajax') !== false) return;
		
		if (strpos($_SERVER['REQUEST_URI'], '/comment/view/') === false && strpos($_SERVER['REQUEST_URI'], '/view') !== false || strpos($_SERVER['REQUEST_URI'], '/profile') !== false) {

			if ($_GET["language"] == 'fr') { 
				if ($_COOKIE['connex_lang'] != 'fr') {
					setcookie('connex_lang', 'fr', 0, '/');
					Header('Location: '.$_SERVER['REQUEST_URI']);
				}
			} elseif ($_GET["language"] == 'en') {
				if ($_COOKIE['connex_lang'] != 'en') {
					setcookie('connex_lang', 'en', 0, '/');
					Header('Location: '.$_SERVER['REQUEST_URI']);
				}
			} else {
				if ($_GET["language"] == '' || $_GET["language"] != 'en' || $_GET["language"] != 'fr'  )  {
					
					forward("?language=" . get_current_language());
				}
			}

		} else {

			return;
		}
	}
}


