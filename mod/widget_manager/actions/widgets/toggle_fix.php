<?php 
	
	$entity_guid = get_input("guid");
	if($entity = get_entity($entity_guid)){
		if($entity instanceof ElggWidget){
			$current = $entity->fixed;
			if($current){
				$entity->fixed = false;
			} else {
				$entity->fixed = true;
			}
			
			// trigger save event for registration of change to status
			$entity->save();
		}		
	} 
	exit();
	