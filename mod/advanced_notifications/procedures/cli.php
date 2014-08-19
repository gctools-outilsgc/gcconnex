<?php
	
	if(isset($argv) && is_array($argv)){
		$memory_limit = "64M";
		$secret = "";
		$event = "";
		$type = "";
		$guid = 0;
		$id = 0;
		$inputs = array();
		
		foreach($argv as $index => $arg){
			// the first argument is this script
			if($index > 0){
				$arg = urldecode($arg);
				
				list($key, $value) = explode("=", $arg);
				
				switch ($key){
					case "host":
						$_SERVER["HTTP_HOST"] = $value;
						break;
					case "https":
						$_SERVER["HTTPS"] = $value;
						break;
					case "session_id":
						session_id($value);
						break;
					case "guid":
					case "id":
						$value = (int) $value;
						
						if($value > 0){
							$$key = (int) $value;
						}
						break;
					case "input":
						// value is name|base64_encode(value)
						list($input_name, $input_value) = explode("|", $value);
						$input_value = base64_decode($input_value);
						
						$inputs[$input_name] = $input_value;
						
						break;
					default:
						$$key = $value;
						break;
				}
			}
		}
		
		if(!empty($secret) && !empty($event) && !empty($type) && (!empty($guid) || !empty($id))){
			// set the provided memory limit
			ini_set("memory_limit", $memory_limit);
			
			// start Elgg
			require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
			
			// validate the provided secret
			if(advanced_notifications_validate_secret($secret)){
				// set the configured inputs
				if(!empty($inputs)){
					foreach($inputs as $input_name => $input_value){
						set_input($input_name, $input_value);
					}
				}
				
				// what do we need to do
				switch($type) {
					case "object":
						elgg_log('cyu - object type', 'NOTICE');
						advanced_notifications_entity_notification($guid, $event);
						break;
					case "annotation":
						elgg_log('cyu - object annotation', 'NOTICE');
						advanced_notifications_annotation_notification($id, $event);
						break;
					default:
						echo elgg_echo("advanced_notifications:cli:error:type", array($type));
						break;
				}
			} else {
				echo elgg_echo("advanced_notifications:cli:error:secret");
			}
		} else {
			echo "Invalid input, the script can't continue";
		}
	} else {
		echo "This script can only be run from the commandline";
	}
	