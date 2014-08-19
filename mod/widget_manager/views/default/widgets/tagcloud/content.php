<?php 

	$owner = $vars["entity"]->getOwnerEntity();
	
	$cloud_options = array();
	
	if($owner instanceof ElggUser){
		$cloud_options["owner_guid"] = $owner->getGUID();
	} elseif($owner instanceof ElggGroup){
		$cloud_options["container_guid"] = $owner->getGUID();
	}

	if($cloud_data = elgg_get_tags($cloud_options)){
		shuffle($cloud_data);
		$cloud = elgg_view("output/tagcloud", array(
				'value' => $cloud_data
		));
	} else {
		$cloud = elgg_echo("widgets:tagcloud:no_data");
	}
	
	echo $cloud;
	