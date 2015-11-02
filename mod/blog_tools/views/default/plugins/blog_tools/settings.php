<?php
	
$plugin = $vars["entity"];

// define possible values
$align_options = array(
	"none" => elgg_echo("blog_tools:settings:align:none"),
	"left" => elgg_echo("blog_tools:settings:align:left"),
	"right" => elgg_echo("blog_tools:settings:align:right"),
);

$size_options = array(
	"tiny" => elgg_echo("blog_tools:settings:size:tiny"),
	"small" => elgg_echo("blog_tools:settings:size:small"),
	"medium" => elgg_echo("blog_tools:settings:size:medium"),
	"large" => elgg_echo("blog_tools:settings:size:large"),
	"master" => elgg_echo("blog_tools:settings:size:master"),
);

$strapline_options = array(
	"default" => elgg_echo("blog_tools:settings:strapline:default"),
	"time" => elgg_echo("blog_tools:settings:strapline:time")
);

$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);

$noyes_options = array_reverse($yesno_options);

$show_full_owner_options = array(
	"no" => elgg_echo("option:no"),
	"optional" => elgg_echo("blog_tools:settings:full:show_full_owner:optional"),
	"yes" => elgg_echo("option:yes")
);

$show_full_related_options = array(
	"no" => elgg_echo("option:no"),
	"full_view" => elgg_echo("blog_tools:settings:full:show_full_related:full_view"),
	"sidebar" => elgg_echo("blog_tools:settings:full:show_full_related:sidebar")
);

// get settings
$listing_align = $plugin->listing_align;
$listing_size = $plugin->listing_size;
$full_align = $plugin->full_align;
$full_size = $plugin->full_size;

// make default settings
if (empty($listing_align)) {
	$listing_align = "right";
}

if (empty($listing_size)) {
	$listing_size = "small";
}

if (empty($full_align)) {
	$full_align = "right";
}

if (empty($full_size)) {
	$full_size = "large";
}

$settings_image = "<table>";

$settings_image .= "<tr>";
$settings_image .= "<td>" . elgg_echo('blog_tools:settings:listing:strapline') . "</td>";
$settings_image .= "<td>" . elgg_view("input/dropdown", array("name" => "params[listing_strapline]", "options_values" => $strapline_options, "value" => $plugin->listing_strapline)) . "</td>";
$settings_image .= "</tr>";

$settings_image .= "<tr>";
$settings_image .= "<td>" . elgg_echo('blog_tools:settings:listing:image_align') . "</td>";
$settings_image .= "<td>" . elgg_view("input/dropdown", array("name" => "params[listing_align]", "options_values" => $align_options, "value" => $listing_align)) . "</td>";
$settings_image .= "</tr>";

$settings_image .= "<tr>";
$settings_image .= "<td>" . elgg_echo('blog_tools:settings:listing:image_size') . "</td>";
$settings_image .= "<td>" . elgg_view("input/dropdown", array("name" => "params[listing_size]", "options_values" => $size_options, "value" => $listing_size)) . "</td>";
$settings_image .= "</tr>";

$settings_image .= "<tr>";
$settings_image .= "<td>" . elgg_echo('blog_tools:settings:full:image_align') . "</td>";
$settings_image .= "<td>" . elgg_view("input/dropdown", array("name" => "params[full_align]", "options_values" => $align_options, "value" => $full_align)) . "</td>";
$settings_image .= "</tr>";

$settings_image .= "<tr>";
$settings_image .= "<td>" . elgg_echo('blog_tools:settings:full:image_size') . "</td>";
$settings_image .= "<td>" . elgg_view("input/dropdown", array("name" => "params[full_size]", "options_values" => $size_options, "value" => $full_size)) . "</td>";
$settings_image .= "</tr>";

$settings_image .= "</table>";

echo elgg_view_module("inline", elgg_echo("blog_tools:settings:image"), $settings_image);

$settings_full = "<table>";

$settings_full .= "<tr>";
$settings_full .= "<td>" . elgg_echo('blog_tools:settings:full:show_full_navigation') . "</td>";
$settings_full .= "<td>" . elgg_view("input/dropdown", array("name" => "params[show_full_navigation]", "options_values" => $noyes_options, "value" => $plugin->show_full_navigation)) . "</td>";
$settings_full .= "</tr>";

$settings_full .= "<tr>";
$settings_full .= "<td>" . elgg_echo('blog_tools:settings:full:show_full_owner') . "</td>";
$settings_full .= "<td>" . elgg_view("input/dropdown", array("name" => "params[show_full_owner]", "options_values" => $show_full_owner_options, "value" => $plugin->show_full_owner)) . "</td>";
$settings_full .= "</tr>";

$settings_full .= "<tr>";
$settings_full .= "<td>" . elgg_echo('blog_tools:settings:full:show_full_related') . "</td>";
$settings_full .= "<td>" . elgg_view("input/dropdown", array("name" => "params[show_full_related]", "options_values" => $show_full_related_options, "value" => $plugin->show_full_related)) . "</td>";
$settings_full .= "</tr>";

$settings_full .= "</table>";

echo elgg_view_module("inline", elgg_echo("blog_tools:settings:full"), $settings_full);

$settings_other = "<table>";

$settings_other .= "<tr>";
$settings_other .= "<td>" . elgg_echo('blog_tools:settings:advanced_gatekeeper') . "</td>";
$settings_other .= "<td>" . elgg_view("input/dropdown", array("name" => "params[advanced_gatekeeper]", "options_values" => $yesno_options, "value" => $plugin->advanced_gatekeeper)) . "</td>";
$settings_other .= "</tr>";

$settings_other .= "<tr>";
$settings_other .= "<td colspan='2' class='elgg-subtext'>" . elgg_echo('blog_tools:settings:advanced_gatekeeper:description') . "</td>";
$settings_other .= "</tr>";

$settings_other .= "<tr>";
$settings_other .= "<td>" . elgg_echo('blog_tools:settings:advanced_publication') . "</td>";
$settings_other .= "<td>" . elgg_view("input/dropdown", array("name" => "params[advanced_publication]", "options_values" => array_reverse($yesno_options, true), "value" => $plugin->advanced_publication)) . "</td>";
$settings_other .= "</tr>";

$settings_other .= "<tr>";
$settings_other .= "<td colspan='2' class='elgg-subtext'>" . elgg_echo('blog_tools:settings:advanced_publication:description') . "</td>";
$settings_other .= "</tr>";

$settings_other .= "</table>";

echo elgg_view_module("inline", elgg_echo("blog_tools:settings:other"), $settings_other);
	