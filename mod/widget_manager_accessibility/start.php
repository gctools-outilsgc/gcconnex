<?php 
	
	function widget_manager_accessibility_init(){
		// extend CSS
		elgg_extend_view("css/elgg", "widget_manager_accessibility/css/global_fix");
		elgg_extend_view("css/admin", "widget_manager_accessibility/css/global_fix");
		elgg_extend_view("js/elgg", "widget_manager_accessibility/js/add_js");

	}
	// register default Elgg events
	elgg_register_event_handler("init", "system", "widget_manager_accessibility_init");

	?>