<?php 
	
	function widget_manager_accessibility_init(){
		// extend CSS
		elgg_extend_view("css/elgg", "widget_manager_accessibility/css/global_fix");
		elgg_extend_view("css/admin", "widget_manager_accessibility/css/global_fix");
		elgg_extend_view("js/elgg", "widget_manager_accessibility/js/add_js");

	}
	// register default Elgg events
	elgg_register_event_handler("init", "system", "widget_manager_accessibility_init");

	// regiser actions
	elgg_register_action("widget_manager/widgets/toggle_collapse", dirname(__FILE__) . "/actions/widgets/toggle_collapse.php");

	// additional function
	require_once( dirname(__FILE__) . "/lib/add_functions.php" );
	?>