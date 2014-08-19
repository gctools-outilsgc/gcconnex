<?php

	$guids = get_input("guids");
	$order = 1;
	if(!empty($guids) && is_array($guids)){
		foreach($guids as $guid){
			if(($group = get_entity($guid)) && elgg_instanceof($group, "group")){
				$group->order = $order;
				$order++;
			}
		}
	}