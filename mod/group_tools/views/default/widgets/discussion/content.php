<?php
/**
 * content of the discussions widget
 */
$widget = $vars["entity"];

$discussion_count = sanitise_int($widget->discussion_count, false);
if (empty($discussion_count)) {
	$discussion_count = 5;
}

$options = array(
	"type" => "object",
	"subtype" => "groupforumtopic",
	"limit" => $discussion_count,
	"order_by" => "e.last_action desc",
	"pagination" => false,
	"full_view" => false
);

if ($widget->group_only == "yes") {
	$owner = $widget->getOwnerEntity();
	$groups = $owner->getGroups("", false);

	if (!empty($groups)) {
		
		$group_guids = array();
		foreach ($groups as $group) {
			$group_guids[] = $group->getGUID();
		}
		$options["container_guids"] = $group_guids;
	}
}

$content = elgg_list_entities($options);
if (empty($content)) {
	$content = elgg_echo("grouptopic:notcreated");
} else {
	$content .= "<div class='elgg-widget-more'>";
	$content .= elgg_view("output/url", array("text" => elgg_echo("widgets:discussion:more"), "href" => "discussion/all"));
	$content .= "</div>";
}

// prepend a quick start form
$params = $vars;
$params["embed"] = true;
echo elgg_view("widgets/start_discussion/content", $params);

// view listing of discussions
echo $content;
