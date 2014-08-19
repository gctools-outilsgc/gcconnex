<?php 
	/* init file for rss widget */
	
	function widget_rss_init(){
		elgg_register_widget_type("rss", elgg_echo("widgets:rss:title"), elgg_echo("widgets:rss:description"), "groups,index,profile,dashboard", true);
		
		// extend CSS
		elgg_extend_view("css/elgg", "widgets/rss/css");
		
		// make cache directory
		if(!is_dir(elgg_get_data_path() . "/widgets/")){
			mkdir(elgg_get_data_path() . "/widgets/");
		}
		
		if(!is_dir(elgg_get_data_path() . "/widgets/rss/")){
			mkdir(elgg_get_data_path() . "/widgets/rss/");
		}
		
		elgg_register_library("simplepie", elgg_get_plugins_path() . "widget_manager/widgets/rss/vendors/simplepie/simplepie.inc");
		
		// set cache settings
		define("WIDGETS_RSS_CACHE_LOCATION", elgg_get_data_path() . "widgets/rss/");
		define("WIDGETS_RSS_CACHE_DURATION", 600);
	}
	
	/**
	 * Removes cached rss feeds
	 * 
	 * @param unknown_type $hook
	 * @param unknown_type $type
	 * @param unknown_type $params
	 * @param unknown_type $return_value
	 */
	function widget_rss_cron_handler($hook, $type, $params, $return_value){		
		if($fh = opendir(WIDGETS_RSS_CACHE_LOCATION)){
			while($filename = readdir($fh)){
				if(is_file(WIDGETS_RSS_CACHE_LOCATION . $filename)){
					if(filemtime(WIDGETS_RSS_CACHE_LOCATION . $filename) < (time() - (24 * 60 * 60))){
						unlink(WIDGETS_RSS_CACHE_LOCATION . $filename);
					}
				}
			}
		}
	}
	
	// register widget init
	elgg_register_event_handler("widgets_init", "widget_manager", "widget_rss_init");
	
	// register cron for cleanup
	elgg_register_plugin_hook_handler("cron", "daily", "widget_rss_cron_handler");