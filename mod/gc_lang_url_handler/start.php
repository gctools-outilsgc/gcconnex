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
 * @param $info
 * @return False to stop processing the response, True will let elgg handle the response
 */
function global_url_handler($hook, $type, $returnvalue, $params) {
	//error_log("taking over ... Loading ... found : " . $_GET["language"] );

	if ($_GET["language"] == 'fr') {
		//error_log('+++++ language - french');
		setcookie('connex_lang', 'fr', 0, '/');
		//header("Refresh:0");

	} elseif ($_GET["language"] == 'en') {
		//error_log('+++++ language - english');
		setcookie('connex_lang', 'en', 0, '/');
		//header("Refresh:0");

	} else {
		if ($_GET["language"] == '' || $_GET["language"] != 'en' || $_GET["language"] != 'fr'  )  {
			//error_log('nothing is set...');	
			forward("?language=" . get_current_language());
		}

	}
}







