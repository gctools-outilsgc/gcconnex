<?php
	
$content = "";

$entities = elgg_extract("entities", $vars, false);
if (!empty($entities)) {
	$content .= "<ul class='elgg-list'>";
	
	foreach ($entities as $entity) {
		$icon = elgg_view_entity_icon($entity, "small");
		
		$info = elgg_view("output/url", array(
			"href" => $entity->getURL(),
			"text" => $entity->name
		));
		$info .= "<br />";
		$info .= elgg_view("output/url", array(
			"href" => "action/friend_request/revoke?guid=" . $entity->getGUID(),
			"text" => elgg_echo("friend_request:revoke"),
			"is_action" => true
		));
		
		$content .= "<li class='elgg-item'>";
		$content .= elgg_view_image_block($icon, $info);
		$content .= "</li>";
	}
	
	$content .= "</ul>";
} else {
	$content = elgg_echo("friend_request:sent:none");
}

echo elgg_view_module("info", elgg_echo("friend_request:sent:title"), $content, array("class" => "mbm"));
