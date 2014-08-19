<?php
	
	function maintenance_init(){
		
		global $CONFIG;
		
		//	check if new walled garden setting is activated. If it is then our view core/account/login_walled_garden.php
		//	will take care of displaying our maintenance screen (see view default/core/account/login_walled_garden.php)
		
		if ( !$CONFIG->walled_garden ) {
			
			//	walled garden is not active - so we check our setting and if we're in maintenance mode
			//	we register a plugin hook for the index page. Notice we set its priority to 200 to get us
			//	hooked before the custom index plugin. Otherwise we'd have to be installed and configured
			//	above the custom index plugin - which is a pain.
			
			if(get_plugin_setting("maintenance_active","maintenance")=="yes" && !isadminloggedin()){
				
				register_plugin_hook('index','system','maintenance_index',200);
				
				global $CONFIG;
				//	these are the lines that changed to make the plugin compatible with elgg installed in a sub
				//	directory. Author unknown.
				
				$base_uri = parse_url($CONFIG->wwwroot, PHP_URL_PATH);
				if($_SERVER["REQUEST_URI"] != $base_uri && $_SERVER["REQUEST_URI"] != "${base_uri}action/login"){
					
					admin_gatekeeper();
				}
			}
		}
	}
	
	function maintenance_index() {
		
		//	notice that this plugin does not check the return value sent in with the hook. If another plugin already hook system index
		//	then we just doubled up and hooked it too. This causes both pages to be displayed.
		
		//	the custom index plugin checks the value and returns if the page is already hooked.
		//	the code is:
		
		//	function custom_index($hook, $type, $return, $params) {
		//		if ($return == true) {
		// 			another hook has already replaced the front page
		//			return $return;
		//		}
		//		...
		//	}
		
		if (!include_once(dirname(__FILE__) . "/index.php")) {
			return false;
		}

		// return true to signify that we have handled the front page
		return true;
	}
	
	// Initialise plugin
	register_elgg_event_handler('init','system','maintenance_init');
?>