<?php 

	function analytics_track_action($action){
		$action_result = true;
		
		if(elgg_trigger_plugin_hook("track_action", "analytics", array("action" => $action), true)){
			if(count_messages("error") > 0){
				$action_result = false;
			}
			
			if(!array_key_exists("analytics", $_SESSION)){
				$_SESSION["analytics"] = array();
			}
			
			if(!array_key_exists("actions", $_SESSION["analytics"])){
				$_SESSION["analytics"]["actions"] = array();
			}
			
			$_SESSION["analytics"]["actions"][$action] = $action_result;
		}
		
		return true;
	}

	function analytics_track_event($category, $action, $label = ""){
		
		if(elgg_trigger_plugin_hook("track_event", "analytics", array("category" => $category, "action" => $action, "label" => $label), true)){
			if(!empty($category) && !empty($action)){
				if(!array_key_exists("analytics", $_SESSION)){
					$_SESSION["analytics"] = array();
				}
				
				if(!array_key_exists("events", $_SESSION["analytics"])){
					$_SESSION["analytics"]["events"] = array();
				}
				
				$t_event = array(
					"category" => $category,
					"action" => $action
				);
				
				if(!empty($label)){
					$t_event["label"] = $label;
				}
				
				$_SESSION["analytics"]["events"][] = $t_event;
			}
		}
		
		return true;
	}
	