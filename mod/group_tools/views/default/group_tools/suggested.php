<?php
/**
 * List all suggested groups
 */

$groups = elgg_extract("groups", $vars);

if (!empty($groups)) {
	echo "<ul class='elgg-gallery group-tools-suggested-groups'>";
	
	foreach ($groups as $group) {
		
		$group_url = $group->getURL();
		
		$join_url = "action/groups/join?group_guid={$group->getGUID()}";
		
		if ($group->isPublicMembership() || $group->canEdit()) {
			$join_text = elgg_echo("groups:join");
		} else {
			// request membership
			$join_text = elgg_echo("groups:joinrequest");
		}
		
		echo "<li class=\"elgg-item\"><div>";
		echo "<h3>" . elgg_view("output/url", array("text" => $group->name, "href" => $group_url)) . "</h3>";
		echo elgg_view("output/url", array("text" => elgg_view_entity_icon($group, "large"), "href" => $group_url));
		echo "<div class='elgg-subtext'>" . elgg_view("output/text", array("value" => $group->briefdescription)) . "</div>";
		echo "<div>" . elgg_view("output/url", array("text" => $join_text, "href" => $join_url, "is_action" => true, "class" => "elgg-button elgg-button-action")) . "</div>";
		echo "</div></li>";
	}
		
	echo "</ul>";
}
