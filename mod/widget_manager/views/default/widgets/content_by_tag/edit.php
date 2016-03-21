<?php

$widget = $vars["entity"];

$count = sanitise_int($widget->content_count, false);
if (empty($count)) {
	$count = 8;
}

$content_type = $widget->content_type;

$content_options_values = array();
if (elgg_is_active_plugin("blog")) {
	$content_options_values["blog"] = elgg_echo("item:object:blog");
}
if (elgg_is_active_plugin("file")) {
	$content_options_values["file"] = elgg_echo("item:object:file");
}
if (elgg_is_active_plugin("pages")) {
	$content_options_values["page"] = elgg_echo("item:object:page");
}
if (elgg_is_active_plugin("bookmarks")) {
	$content_options_values["bookmarks"] = elgg_echo("item:object:bookmarks");
}
if (elgg_is_active_plugin("thewire")) {
	$content_options_values["thewire"] = elgg_echo("item:object:thewire");
}
if (elgg_is_active_plugin("videolist")) {
	$content_options_values["videolist_item"] = elgg_echo("item:object:videolist_item");
}
if (elgg_is_active_plugin("event_manager")) {
	$content_options_values["event"] = elgg_echo("item:object:event");
}
if (elgg_is_active_plugin("tasks")) {
	$content_options_values["task_top"] = elgg_echo("item:object:task_top");
}
if (elgg_is_active_plugin("groups")) {
	$content_options_values["groupforumtopic"] = elgg_echo("item:object:groupforumtopic");
}

if (empty($content_type) && !empty($content_options_values)) {
	$keys = array_keys($content_options_values);
	$content_type = $keys[0];
}

$tags = $widget->tags;
$excluded_tags = $widget->excluded_tags;

$tags_option = $widget->tags_option;

if (empty($tags_option)) {
	$tags_option = "and";
}

$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);

$tags_options_values = array(
	"and" => elgg_echo("widgets:content_by_tag:tags_option:and"),
	"or" => elgg_echo("widgets:content_by_tag:tags_option:or")
);

$display_option_options_values = array(
	"normal" => elgg_echo("widgets:content_by_tag:display_option:normal"),
	"simple" => elgg_echo("widgets:content_by_tag:display_option:simple"),
	"slim" => elgg_echo("widgets:content_by_tag:display_option:slim")
);

echo "<div>";
echo elgg_echo("widgets:content_by_tag:owner_guids") . "<br />";
echo elgg_view("input/hidden", array("name" => "params[owner_guids]", "value" => 0));
echo elgg_view("input/userpicker", array("name" => "params[owner_guids]", "values" => $widget->owner_guids));
echo "<div class='elgg-subtext'>" . elgg_echo("widgets:content_by_tag:owner_guids:description") . "</div>";
echo "</div>";

if ($widget->context == "groups") {
	echo "<div>";
	echo elgg_echo("widgets:content_by_tag:group_only") . "<br />";
	echo elgg_view("input/dropdown", array("name" => "params[group_only]", "options_values" => array("yes" => elgg_echo("option:yes"), "no" => elgg_echo("option:no")), "value" => $widget->group_only));
	echo "</div>";
} elseif(elgg_view_exists("input/grouppicker")) {
	echo "<div>";
	echo elgg_echo("widgets:content_by_tag:container_guids") . "<br />";
	echo elgg_view("input/hidden", array("name" => "params[container_guids]", "value" => 0));
	echo elgg_view("input/grouppicker", array("name" => "params[container_guids]", "values" => $widget->container_guids));
	echo "<div class='elgg-subtext'>" . elgg_echo("widgets:content_by_tag:container_guids:description") . "</div>";
	echo "</div>";
}
?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[content_count]", "value" => $count, "size" => "4", "maxlength" => "4"));?>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:entities"); ?><br />
	<?php echo elgg_view("input/checkboxes", array("name" => "params[content_type]", "options" => array_flip($content_options_values), "value" => $content_type)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:tags"); ?><br />
	<?php echo elgg_view("input/tags", array("name" => "params[tags]", "value" => $tags)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:tags_option"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[tags_option]", "options_values" => $tags_options_values, "value" => $tags_option)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:excluded_tags"); ?><br />
	<?php echo elgg_view("input/tags", array("name" => "params[excluded_tags]", "value" => $excluded_tags)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:show_search_link"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[show_search_link]", "options_values" => array_reverse($yesno_options, true), "value" => $widget->show_search_link)); ?>
	<div class="elgg-subtext"><?php echo elgg_echo("widgets:content_by_tag:show_search_link:disclaimer"); ?></div>
</div>

<div>
	<?php echo elgg_echo("widgets:content_by_tag:display_option"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[display_option]", "options_values" => $display_option_options_values, "value" => $widget->display_option)); ?>
</div>

<div class="widgets-content-by-tag-display-options">
	<div class="widgets-content-by-tag-display-options-slim">
		<?php echo elgg_echo("widgets:content_by_tag:highlight_first"); ?><br />
		<?php echo elgg_view("input/text", array("name" => "params[highlight_first]", "value" => $widget->highlight_first)); ?>
	</div>

	<div class="widgets-content-by-tag-display-options-simple widgets-content-by-tag-display-options-slim">
		<?php echo elgg_echo("widgets:content_by_tag:show_avatar"); ?><br />
		<?php echo elgg_view("input/dropdown", array("name" => "params[show_avatar]", "options_values" => $yesno_options, "value" => $widget->show_avatar)); ?>
	</div>

	<div class="widgets-content-by-tag-display-options-simple widgets-content-by-tag-display-options-slim">
		<?php echo elgg_echo("widgets:content_by_tag:show_timestamp"); ?><br />
		<?php echo elgg_view("input/dropdown", array("name" => "params[show_timestamp]", "options_values" => $yesno_options, "value" => $widget->show_timestamp)); ?>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#elgg-widget-<?php echo $widget->getGUID(); ?> [name='params[display_option]']").change(function() {
				$("#elgg-widget-<?php echo $widget->getGUID(); ?> .widgets-content-by-tag-display-options > div").hide();
				$("#elgg-widget-<?php echo $widget->getGUID(); ?> .widgets-content-by-tag-display-options-" + $(this).val()).show();
			}).change();
		});
	</script>
</div>
<script type="text/javascript">
	$("#widget-edit-<?php echo $widget->getGUID(); ?> .elgg-user-picker").addClass("ui-front");
	
	if (typeof(filter) !== "function") {
		$.getScript(elgg.get_site_url() + "vendors/jquery/jquery.ui.autocomplete.html.js");
	}
</script>
