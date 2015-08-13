<?php
	
$content = "";

$entities = elgg_extract("entities", $vars, false);
if (!empty($entities)) {
	foreach ($entities as $entity) {
		$icon = elgg_view_entity_icon($entity, "small");
		
		$info = elgg_view("output/url", array(
			"href" => $entity->getURL(),
			"text" => $entity->name
		));
		$info .= "<br />";
		$info .= elgg_view("output/url", array(
			"href" => "action/friend_request/approve?guid=" . $entity->getGUID(),
			"text" => elgg_echo("friend_request:approve"),
			"is_action" => true
		));
		$info .= "&nbsp;|&nbsp;";
		$info .= elgg_view("output/url", array(
			"href" => "action/friend_request/decline?guid=" . $entity->getGUID(),
			"text" => elgg_echo("friend_request:decline"),
			"is_action" => true
		));
		
		$content .= elgg_view_image_block($icon, $info);
	}
} else {
	$content = elgg_echo("friend_request:received:none");
}

echo elgg_view_module("info", elgg_echo("friend_request:received:title"), $content, array("class" => "mbm"));
