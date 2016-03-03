<?php
/**
 * settings for the group news widget
 */
$widget = $vars["entity"];
$widgetId = $widget->getGUID();
$blog_count = sanitise_int($widget->blog_count);
if ($blog_count < 1) {
	$blog_count = 5;
}

$options_values = array("" => elgg_echo("widgets:group_news:settings:no_project"));
$options = array(
	"type" => "group",
	"limit" => false,
	"joins" => array("JOIN " . elgg_get_config("dbprefix") . "groups_entity ge ON e.guid = ge.guid"),
	"order_by" => "ge.name ASC"
);

$batch = new ElggBatch("elgg_get_entities", $options);
foreach ($batch as $group) {
	$options_values[$group->getGUID()] = $group->name;
}

for ($i = 1; $i < 6; $i++) {
	$metadata_name = "project_" . $i;
	
	echo "<div>";
	echo '<label for="'.$metadata_name.'-'.$widgetId.'">'.elgg_echo("widgets:group_news:settings:project") . "</label> ";
	echo elgg_view("input/dropdown", array("options_values" => $options_values, "name" => "params[" . $metadata_name . "]", "value" => $widget->$metadata_name, 'id'=>$metadata_name.'-'.$widgetId,));
	echo "</div>";
}

echo "<div>";
echo '<label for="blog_count-'.$widgetId.'">'.elgg_echo("widgets:group_news:settings:blog_count") . "</label> ";
echo elgg_view("input/dropdown", array("options" => array(1,2,3,4,5,6,7,8,9,10,15,20), "name" => "params[blog_count]", "value" => $blog_count, 'id'=>'blog_count-'.$widgetId,));
echo "</div>";

echo "<div>";
echo '<label for="group_icon_size-'.$widgetId.'">'.elgg_echo("widgets:group_news:settings:group_icon_size") . "</label> ";
echo elgg_view("input/dropdown", array("options_values" => array("medium" => elgg_echo("widgets:group_news:settings:group_icon_size:medium"), "small" => elgg_echo("widgets:group_news:settings:group_icon_size:small")), "name" => "params[group_icon_size]", "value" => $widget->group_icon_size, 'id'=>'group_icon_size-'.$widgetId,));
echo "</div>";
