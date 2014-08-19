<?php

	function translation_editor_upgrade_event($event, $type, $object){
		
		if(defined("UPGRADING") && (UPGRADING == "upgrading")){
			// call action hook function to avoid coding the same thing twice
			translation_editor_actions_hook("action", "upgrading", null, null);
		}
	}