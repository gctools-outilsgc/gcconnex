<?php
/**
 * EXIF sidebar module
 */

$image = $vars["image"];

elgg_load_library("tidypics:exif");

$exif = tp_exif_formatted($image);
if ($exif) {
	$title = "EXIF";
	
	$body = "<table class='elgg-table elgg-table-alt'>";
	foreach ($exif as $key => $value) {
		$body .= "<tr>";
		$body .= "<td>" . elgg_view("output/text", array("value" => filter_tags($key))) . "</td>";
		$body .= "<td>" . elgg_view("output/text", array("value" => filter_tags($value))) . "</td>";
		$body .= "</tr>";
	}
	$body .= "</table>";

	echo elgg_view_module("aside", $title, $body);
}
