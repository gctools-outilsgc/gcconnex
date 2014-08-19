<?php

$link = get_input("link");
$title = get_input("title");
$guid = get_input("guid");

if((!empty($link) && !empty($title)) || !empty($guid)){

	if(!empty($guid) && ($entity = get_entity($guid)) && elgg_instanceof($entity, "object", "widget_favorite")){
		// if exists delete
		if($entity->canEdit()){
			$current_link = $entity->description;
			
			if($entity->delete()){
				system_message(elgg_echo("widgets:favorites:delete:success"));
				
				$text = elgg_view_icon("star-empty");
				$href = "action/favorite/toggle?link=" . elgg_normalize_url($current_link);
				$title = elgg_echo("widgets:favorites:menu:add");
				
				echo elgg_view("output/url", array("text" => $text, "href" => $href, "title" => $title, "is_action" => true));
			
			} else {
				register_error(elgg_echo("widgets:favorites:delete:error"));
			}
		} else {
			register_error(elgg_echo("widgets:favorites:delete:error"));
		}
	} elseif(!empty($link) && !empty($title)) {
		if(!widget_favorites_is_linked($link)){
			// create new favorite
			$object = new ElggObject();
			$object->title = $title;
			$object->description = $link;
			$object->subtype = "widget_favorite";
			$object->access_id = ACCESS_PRIVATE;
			
			if($object->save()){
				system_message(elgg_echo("widgets:favorites:save:success"));
				
				$text = elgg_view_icon("star-alt");
				$href = "action/favorite/toggle?guid=" . $object->getGUID();
				$title = elgg_echo("widgets:favorites:menu:remove");
				
				echo elgg_view("output/url", array("text" => $text, "href" => $href, "title" => $title, "is_action" => true));
			
			} else {
				register_error(elgg_echo("widgets:favorites:save:error"));
			}
		} else {
			// silent return, probably double clicked the action
		}
	} else {
		register_error(elgg_echo("widgets:favorites:toggle:missing_input"));
	}
} else {
	register_error(elgg_echo("widgets:favorites:toggle:missing_input"));
}
	
forward(REFERER);

