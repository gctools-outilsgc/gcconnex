<?php 

	/**
	 * jQuery call to echo tracked events and actions
	 * 
	 */


	$trackActions = elgg_get_plugin_setting("trackActions", "analytics");
	$trackEvents = elgg_get_plugin_setting("trackEvents", "analytics");

	if($trackActions == "yes") { 
		if(!empty($_SESSION["analytics"]["actions"])){
			foreach($_SESSION["analytics"]["actions"] as $action => $result){
				if($result){
					echo "_gaq.push(['_trackPageview', '/action/" . $action . "/succes']);\n";
				} else {
					echo "_gaq.push(['_trackPageview', '/action/" . $action . "/error']);\n";
				}
			}
			
			$_SESSION["analytics"]["actions"] = array();
		}
	}
	
	if($trackEvents == "yes"){
		if(!empty($_SESSION["analytics"]["events"])){
			
			foreach($_SESSION["analytics"]["events"] as $event){
				$output = "_gaq.push(['_trackEvent', '" . $event["category"] . "', '" . $event["action"] . "'";
				
				if(array_key_exists("label", $event) && !empty($event["label"])){
					$output .= ", '" . str_replace("'", "", $event["label"]) . "'";
				}
				
				$output .= "]);\n";
				echo $output;
			}
			
			$_SESSION["analytics"]["events"] = array();
		}
	}
