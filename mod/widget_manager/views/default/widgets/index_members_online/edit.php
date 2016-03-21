<?php

$widget = $vars["entity"];

$count = sanitise_int($widget->member_count, false);
if (empty($count)) {
	$count = 8;
}

$user_icon_options_values = array(
	"no" => elgg_echo("option:no"),
	"yes" => elgg_echo("option:yes")
);

?>
<div>
	<?php echo elgg_echo("widget_manager:widgets:index_members_online:member_count"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[member_count]", "value" => $count, "size" => "4", "maxlength" => "4")); ?>
</div>

<div>
	<?php echo elgg_echo("widget_manager:widgets:index_members_online:user_icon"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[user_icon]", "options_values" => $user_icon_options_values, "value" => $widget->user_icon)); ?>
</div>
