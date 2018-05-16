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

	$clean_domain = str_replace(array('https://', 'http://', '/', 'www.'), '', elgg_get_site_url());
	$domain = '.' . $clean_domain;

	$site_url = elgg_get_site_url();
	$site_url = preg_replace("(^https?://)", "", $site_url);
	$site_url = explode("/", $site_url);

	if (preg_match("/localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $site_url[0])) {
		$domain = $site_url[0];
	}

	// do not include the gsa crawler, this will be used for public and solr crawler
	if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') === false) {
		// checks to make sure that the url does not affect the ajax calls
		if (strpos($_SERVER['REQUEST_URI'], 'ajax') !== false) return;
		
		if (strpos($_SERVER['REQUEST_URI'], '/comment/view/') === false && strpos($_SERVER['REQUEST_URI'], '/view') !== false || strpos($_SERVER['REQUEST_URI'], '/profile') !== false) {

			if ($_GET["language"] == 'fr') { 
				if ($_COOKIE['lang'] != 'fr') {
					setcookie('lang', 'fr', 0, '/', $domain);
				}
			} elseif ($_GET["language"] == 'en') {
				if ($_COOKIE['lang'] != 'en') {
					setcookie('lang', 'en', 0, '/', $domain);
				}
			} else {
				
				if ($_GET["language"] == '' || $_GET["language"] != 'en' || $_GET["language"] != 'fr')
					forward("?language=" . get_current_language());


			}

			// make sure both cookie and url param match			
			if ($url_language !== $cookie_language) {
				forward("?language={$url_language}");
			}

		} else {

			return;
		}
	}
}


