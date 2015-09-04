<?php
/**
 * Display message about closed membership
 *
 * @package ElggGroups
 */

$group = elgg_get_page_owner_entity();

echo "<p class='mtm'>";
echo elgg_echo("groups:closedgroup");
if (elgg_is_logged_in()) {
	echo " " . elgg_echo("groups:closedgroup:request");
}
echo "</p>";

if (!empty($group) && ($group instanceof ElggGroup)) {
	if (!$group->isPublicMembership() && ($group->profile_widgets == "yes")) {
		$vars["entity"] = $group;
		echo elgg_view("groups/profile/widgets", $vars);
	}
}
