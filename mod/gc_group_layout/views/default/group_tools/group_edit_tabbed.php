<?php
/**
 * Show tabs on the group edit form
 */

$tabs = array(
	"profile" => array(
		"text" => elgg_echo("group_tools:group:edit:profile"),
        'data-toggle' => 'tab',
		"href" => "#group-tools-group-edit-profile",
		"priority" => 100,
		"selected" => true
	),

	"tools" => array(
		"text" => elgg_echo('gprofile:edit:content'),
        'data-toggle' => 'tab',
		"href" => "#group-tools-group-edit-tools",
		"priority" => 200,
	)
);

if (!empty($vars["entity"])) {
	$tabs["other"] = array(
		"text" => elgg_echo('gprofile:edit:admin'),
		"href" => "#other",
		"priority" => 300
	);
}

foreach ($tabs as $name => $tab) {
	$tab["name"] = $name;
	
	elgg_register_menu_item("filter", $tab);
}

echo "<div id='group-tools-group-edit-tabbed'>";
echo elgg_view_menu("filter", array("sort_by" => "priority", "class" => "elgg-menu-hz"));
echo "</div>";
