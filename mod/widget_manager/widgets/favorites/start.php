<?php 
/* init file for favorites widget */

function widget_favorites_init(){
	elgg_register_widget_type("favorites", elgg_echo("widgets:favorites:title"), elgg_echo("widgets:favorites:description"), "dashboard");
	
	elgg_register_event_handler("pagesetup", "system", "widget_favorites_pagesetup");
	
	elgg_register_action("favorite/toggle", dirname(__FILE__) . "/actions/toggle.php");

	elgg_extend_view("js/elgg", "widgets/favorites/js");
}

function widget_favorites_pagesetup(){
	if(widget_favorites_has_widget()){
		if($favorite = widget_favorites_is_linked()){
			$text = elgg_view_icon("star-alt");
			$href = "action/favorite/toggle?guid=" . $favorite->getGUID();
			$title = elgg_echo("widgets:favorites:menu:remove");
		} else {
			$text = elgg_view_icon("star-empty");
			$href = "action/favorite/toggle?link=" . elgg_normalize_url(current_page_url());
			$title = elgg_echo("widgets:favorites:menu:add");
		} 
		elgg_register_menu_item("extras", array(
										"name" => "widget_favorites",
										"title" => $title,
										"href" => $href,
										"text" => $text
											
		));
	}
}

function widget_favorites_has_widget($owner_guid = 0){	
	$result = false;
	
	if(empty($owner_guid)){
		if($user_guid = elgg_get_logged_in_user_guid()){
			$owner_guid = $user_guid;
		}
	}
	
	if(!empty($owner_guid)){
		$options = array(
			"type" => "object",
			"subtype" => "widget",
			"private_setting_name_value_pairs" => array("handler" => "favorites"),
			"count" => true,
			"owner" => $owner_guid
		);
		
		if(elgg_get_entities_from_private_settings($options)){
			$result =true;
		}
	}
	
	return $result;
}

function widget_favorites_is_linked($url = ""){
	$result = false;
	
	if(empty($url)){
		$url = current_page_url();
	}
	
	if(!empty($url)){
		$options = array(
			"type" => "object",
			"subtype" => "widget_favorite",
			"joins" => array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON e.guid = oe.guid"),
			"wheres" => array("oe.description = '" . sanitise_string($url) . "'"),
			"limit" => 1
		);
		
		if($entities = elgg_get_entities($options)){
			$result = $entities[0];
		}
	}
	
	return $result;
}

elgg_register_event_handler("widgets_init", "widget_manager", "widget_favorites_init");