<?php

	$guid = (int) get_input("guid");
	$title = get_input("title");
	$dashboard_type = get_input("dashboard_type", "widgets");
	$num_columns = (int) get_input("num_columns", 3);
	$iframe_url = get_input("iframe_url");
	$iframe_height = (int) get_input("iframe_height");
	$internal_url = get_input("internal_url");
	
	$forward_url = REFERER;
	
	if(!empty($title)){
		if(!empty($guid)){
			if($entity = get_entity($guid)){
				if(!elgg_instanceof($entity, "object", MultiDashboard::SUBTYPE)){
					unset($entity);
					register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, MultiDashboard::SUBTYPE)));
				}
			} else {
				register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
			}
		} else {
			$entity = new MultiDashboard();
			if(!$entity->save()){
				unset($entity);
				register_error(elgg_echo("IOException:UnableToSaveNew", array(MultiDashboard::SUBTYPE)));
			}
		}
		
		if(!empty($entity) && $entity->canEdit()){
			// set title
			$entity->title = $title;
			
			// set type
			switch ($dashboard_type){
				case "iframe":
					$entity->setDashboardType("iframe");
					
					$entity->setIframeUrl($iframe_url);
					$entity->setIframeHeight($iframe_height);
					
					break;
				case "internal":
					$entity->setDashboardType("internal");
					
					$internal_url = urldecode($internal_url);
					$entity->setInternalUrl($internal_url);
					break;
				case "widgets":
				default:
					$entity->setDashboardType("widgets");
					
					$entity->setNumColumns($num_columns);
					break;
			}
			
			if($entity->save()){
				$forward_url = $entity->getURL();
				
				system_message(elgg_echo("widget_manager:actions:multi_dashboard:edit:success"));
			} else {
				register_error(elgg_echo("IOException:CouldNotMake", array($title)));
			}
		}
	} else {
		register_error(elgg_echo("widget_manager:actions:multi_dashboard:edit:error:input"));
	}
	
	forward($forward_url);