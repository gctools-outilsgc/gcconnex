<?php 

	$widget = $vars["entity"];

	$count = sanitise_int($widget->member_count , false);
	if(empty($count)){
		$count = 8;
	}

	$options = array(
		"type" => "user",
		"limit" => $count,
		"relationship" => "member_of_site",
		"relationship_guid" => elgg_get_site_entity()->getGUID(),
		"inverse_relationship" => true,
		"full_view" => false,
		"pagination" => false,
		"list_type" => "users",
		"gallery_class" => "elgg-gallery-users",
		"size" => "small"
	);
	
	if($widget->user_icon == "yes"){
		$options["metadata_name"] = "icontime";
	}
	
	if(!($result = elgg_list_entities_from_relationship($options))){
		$result = elgg_echo("widget_manager:widgets:index_members:no_result");
	}
	
	echo $result;