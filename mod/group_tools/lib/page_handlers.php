<?php
/**
 * All page handlers are bundled here
 */

/**
 * Take over the groupicon page handler for fallback
 *
 * @param array $page the url elements
 *
 * @return void
 */
function group_tools_groupicon_page_handler($page) {
	
	// group guid
	if (!isset($page[0])) {
		header("HTTP/1.1 400 Bad Request");
		exit;
	}
	$group_guid = $page[0];
	$group = get_entity($group_guid);
	
	if (empty($group) || !elgg_instanceof($group, "group")) {
		header("HTTP/1.1 400 Bad Request");
		exit;
	}
	
	$owner_guid = $group->getOwnerGUID();
	$icontime = (int) $group->icontime;
	
	if (empty($icontime)) {
		header("HTTP/1.1 404 Not Found");
		exit;
	}
	
	// size
	$size = "medium";
	if (isset($page[1])) {
		$icon_sizes = elgg_get_config("icon_sizes");
		if (!empty($icon_sizes) && array_key_exists($page[1], $icon_sizes)) {
			$size = $page[1];
		}
	}
	
	$params = array(
		"group_guid" => $group_guid,
		"guid" => $owner_guid,
		"size" => $size,
		"icontime" => $icontime
	);
	$url = elgg_http_add_url_query_elements("mod/group_tools/pages/groups/thumbnail.php", $params);
	
	forward($url);
}
