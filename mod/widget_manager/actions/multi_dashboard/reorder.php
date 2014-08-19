<?php

	$order = get_input("order");
	
	if(!empty($order)){
		if(!is_array($order)){
			$order = array($order);
		}
		
		foreach($order as $pos => $guid){
			if(($dashboard = get_entity($guid)) && elgg_instanceof($dashboard, "object", MultiDashboard::SUBTYPE, "MultiDashboard")){
				$dashboard->order = ($pos + 1);
			}
		}
		
		system_message(elgg_echo("widget_manager:actions:multi_dashboard:reorder:success"));
	} else {
		register_error(elgg_echo("widget_manager:actions:multi_dashboard:reorder:error:order"));
	}