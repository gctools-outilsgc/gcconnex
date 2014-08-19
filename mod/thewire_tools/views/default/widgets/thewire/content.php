<?php
	
$widget = $vars["entity"];

$num_display = (int) $widget->num_display;
$owner = $widget->owner;
$filter = $widget->filter;

$error = false;

if ($num_display < 1) {
	$num_display = 4;
}

$options = array(
	"type" => "object",
	"subtype" => "thewire",
	"limit" => $num_display,
	"full_view" => false,
	"pagination" => false
);

$more_url = "";
switch ($owner) {
	case "friends":
		// get users friends
		$friends_options = array(
			"type" => "user",
			"limit" => false,
			"relationship" => "friend",
			"relationship_guid" => $widget->getOwnerGUID(),
			"joins" => array("JOIN " . elgg_get_config("dbprefix") . "entity_relationships r2 ON r2.guid_one = e.guid"),
			"wheres" => array("(r2.guid_two = " . elgg_get_site_entity()->getGUID() . " AND r2.relationship = 'member_of_site')"),
			"site_guids" => false
		);
		
		$friends = elgg_get_entities_from_relationship($friends_options);
		if (!empty($friends)) {
			$guids = array();
			
			foreach ($friends as $friend) {
				$guids[] = $friend->getGUID();
			}
			
			$options["container_guids"] = $guids;
			$more_url = "thewire/friends/" . $widget->getOwnerEntity()->username;
		} else {
			$error = true;
		}
		break;
	case "all":
		// show all posts
		$more_url = "thewire/all";
		break;
	default:
		$options["container_guid"] = $widget->getOwnerGUID();
		$more_url = "thewire/owner/" . $widget->getOwnerEntity()->username;
		break;
}


if (empty($error) && !empty($filter)) {
	$filters = string_to_tag_array($filter);
	$filters = array_map("sanitise_string", $filters);
	
	$options["joins"] = array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON oe.guid = e.guid");
	$options["wheres"] = array("(oe.description LIKE '%" . implode("%' OR oe.description LIKE '%", $filters) . "%')");
}

$content = elgg_list_entities($options);
if (empty($error) && !empty($content)) {
	echo $content;
	
	echo "<span class=\"elgg-widget-more\">";
	echo elgg_view("output/url", array("href" => $more_url, "text" => elgg_echo("thewire:moreposts")));
	echo "</span>";
} else {
	echo elgg_echo("thewire_tools:no_result");
}
