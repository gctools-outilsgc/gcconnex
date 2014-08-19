<?php
	
	$widget = elgg_extract("entity", $vars);
	
	// how many files to display 
	$num_display = sanitise_int($widget->num_display, false);
	if(empty($num_display)){
		$num_display = 4;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => "file",
		"container_guid" => $widget->getOwnerGUID(),
		"limit" => $num_display,
		"pagination" => false,
		"full_view" => false
	);
	
	// show only featured files
	if($widget->featured_only == "yes"){
		$options["metadata_name_value_pairs"] = array(
			"name" => "show_in_widget",
			"value" => "0",
			"operand" => ">"
		);
	}
	
	// how to display the files
	if($widget->gallery_list == 2){
		if($files = elgg_get_entities_from_metadata($options)){
			$list = "<ul class='elgg-gallery'>";
			
			foreach($files as $file) {
				$list .= "<li class='elgg-item'>";
				$list .= elgg_view("output/url", array("text" => elgg_view_entity_icon($file, "small"), "href" => $file->getURL(), "title" => $file->title));
				$list .= "</li>";
			}
			$list .= "</ul>";
			
			$owner = $widget->getOwnerEntity();
			if(elgg_instanceof($owner, "user")){
				$more_link = $vars["url"] . "file/owner/" . $owner->username;
			} else {
				$more_link = $vars["url"] . "file/group/" . $owner->getGUID() . "/all";
			}
			$list .= "<span class='elgg-widget-more'>";
			$list .= elgg_view("output/url", array("text" => elgg_echo("file:more"), "href" => $more_link, "is_trusted" => true));
			$list .= "</span>";
			
		} else {
			$list = elgg_echo("file:none");
		}
	} elseif($list = elgg_list_entities_from_metadata($options)){
		$owner = $widget->getOwnerEntity();
		if(elgg_instanceof($owner, "user")){
			$more_link = $vars["url"] . "file/owner/" . $owner->username;
		} else {
			$more_link = $vars["url"] . "file/group/" . $owner->getGUID() . "/all";
		}
		$list .= "<span class='elgg-widget-more'>";
		$list .= elgg_view("output/url", array("text" => elgg_echo("file:more"), "href" => $more_link, "is_trusted" => true));
		$list .= "</span>";
	} else {
		$list = elgg_echo("file:none");
	}
	
	echo $list;
	