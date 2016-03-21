<?php
$widget = $vars["entity"];

$url = $widget->iframe_url;
$height = sanitize_int($widget->iframe_height, true);
if(empty($height)) {
	$height = "100%";
} else {
	$height .= "px";
}

if (!empty($url)) {
	echo elgg_view("output/iframe", array("src" => $url, "width" => "100%", "height" => $height));
} else {
	echo elgg_echo("widgets:free_html:no_content");
}
