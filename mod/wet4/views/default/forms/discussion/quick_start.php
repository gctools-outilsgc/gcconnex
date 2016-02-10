<?php

$group_selection_options = elgg_extract("groups", $vars);
$group_access_options = elgg_extract("access", $vars);
$selected_group = elgg_extract("container_guid", $vars, ELGG_ENTITIES_ANY_VALUE);

global $form_count;
if (empty($form_count)) {
	$form_count = 1;
} else {
	$form_count++;
}

// show a button to expend the form
echo elgg_view("output/url", array(
	"text" => elgg_echo("discussion:add"),
	"href" => "discussion/add/111",

	"class" => "elgg-button elgg-button-action btn btn-primary pull-right"
));

// start the form
echo "<div id='group-tools-discussion-quick-start-wrapper-" . $form_count . "' class='hidden wb-invisible'>";

echo "<div>";
echo "<label for='group-tools-discussion-quick-start-group'>" . elgg_echo("group_tools:forms:discussion:quick_start:group") . "</label>";
echo "<br />";
echo elgg_view("input/dropdown", array("name" => "container_guid", "options_values" => $group_selection_options, "value" => $selected_group, "id" => "group-tools-discussion-quick-start-group"));
echo "</div>";

echo "<div class='hidden wb-invisible'>";
echo "<label for='group-tools-discussion-quick-start-access_id'>" . elgg_echo("access") . "</label>";
echo "<br />";
echo elgg_view("input/dropdown", array("name" => "access_id", "options_values" => $group_access_options, "id" => "group-tools-discussion-quick-start-access_id"));
echo "</div>";

echo "<div>";
echo "<label for='group-tools-discussion-quick-start-title'>" . elgg_echo("title") . "</label>";
echo elgg_view("input/text", array("name" => "title", "id" => "group-tools-discussion-quick-start-title"));
echo "</div>";

echo "<div>";
echo "<label for='group-tools-discussion-quick-start-description'>" . elgg_echo("groups:topicmessage") . "</label>";
echo elgg_view("input/plaintext", array("name" => "description", "id" => "group-tools-discussion-quick-start-description"));
echo "</div>";

echo "<div>";
echo "<label for='group-tools-discussion-quick-start-tags'>" . elgg_echo("tags") . "</label>";
echo elgg_view("input/tags", array("name" => "tags", "id" => "group-tools-discussion-quick-start-tags"));
echo "</div>";

echo "<div class='elgg-foot'>";
echo elgg_view("input/hidden", array("name" => "status", "value" => "open"));
echo elgg_view("input/submit", array("value" => elgg_echo("save")));
echo "</div>";

echo "</div>"; // end wrapper
