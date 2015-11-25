<?php
/**
 * Group edit form
 *
 * @package ElggGroups
 */

/* @var ElggGroup $entity */
$entity = elgg_extract("entity", $vars, false);

// context needed for input/access view
elgg_push_context("group-edit");

// build the group profile fields
echo "<div id='group-tools-group-edit-profile' class='group-tools-group-edit-section'>";
echo elgg_view("groups/edit/profile", $vars);
echo elgg_view("groups/edit/access", $vars);
echo "</div>";

// build the group access options
/*
echo "<div id='group-tools-group-edit-access' class='group-tools-group-edit-section'>";

echo "</div>";
*/

// build the group tools options
echo "<div id='group-tools-group-edit-tools' class='group-tools-group-edit-section'>";
echo elgg_view("groups/edit/tools", $vars);
echo "</div>";

// display the save button and some additional form data
?>
<div class="elgg-foot">
<?php

if ($entity) {
	echo elgg_view("input/hidden", array(
		"name" => "group_guid",
		"value" => $entity->getGUID(),
	));
}

if ($entity) {
    echo elgg_view("input/submit", array("value" => elgg_echo("save"), 'class' => 'btn btn-primary',));
} else {
    echo elgg_view("input/submit", array("value" => elgg_echo("gprofile:create"), 'class' => 'btn btn-primary',));
}

if ($entity) {
	$delete_url = "action/groups/delete?guid=" . $entity->getGUID();
	echo elgg_view("output/url", array(
		"text" => elgg_echo("groups:delete"),
		"href" => $delete_url,
		"confirm" => elgg_echo("groups:deletewarning"),
		"class" => "elgg-button elgg-button-delete float-alt",
	));
}

elgg_pop_context();
?>
</div>
