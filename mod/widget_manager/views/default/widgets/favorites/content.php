<?php 
	$widget = $vars["entity"];
	
	$count = sanitise_int($widget->num_entities);
	if(empty($count)){
		$count = 10;
	}
	
	$options = array(
			"type" => "object",
			"subtype" => "widget_favorite",
			"limit" => $count,
			"offset" => 0,
			"owner_guid" => $widget->getOwnerGUID()			
		);
	
	if($entities = elgg_get_entities($options)){
		echo "<ul class='elgg-list'>";
		foreach($entities as $entity){
			$remove_icon = elgg_view("output/url", array("text" => elgg_view_icon("delete-alt"), "is_action" => true, "href" => "action/favorite/toggle?guid=" . $entity->getGUID(), "class" => "widgets-favorite-entity-delete"));
			echo "<li class='elgg-item'><a href='" . $entity->description . "'>" . $entity->title . "</a> " . $remove_icon . "</li>";	
		}
		echo "</ul>";
		
	} else {
		echo elgg_echo("notfound");
		echo "<br />";
		echo "<br />";
		echo elgg_echo("widgets:favorites:content:more_info");
	}