<?php
/**
 * cleanup the group profile sidebar
 */
$group = elgg_get_page_owner_entity();

if (!empty($group)) {
	$prefix = "group_tools:cleanup:";
	
	if (!$group->canEdit()) {
		
		$owner_block = $group->getPrivateSetting($prefix . "owner_block");
		$actions = $group->getPrivateSetting($prefix . "actions");
		$menu = $group->getPrivateSetting($prefix . "menu");
		
		$css = "";
		
		if ($owner_block == "yes") {
			$css .= "div.elgg-sidebar ul.elgg-menu-extras {";
			$css .= "display:none;";
			$css .= "}";
		}
		
		if (($actions == "yes") && elgg_in_context("group_profile")) {
			$css .= "ul.elgg-menu-title {";
			$css .= "display:none;";
			$css .= "}";
		}
		
		if ($menu == "yes") {
			$css .= "div.elgg-sidebar div.elgg-owner-block div.elgg-body {";
			$css .= "display:none;";
			$css .= "}";
		}
		
		if (!empty($css)) {
			echo "<style type='text/css'>";
			echo $css;
			echo "</style>";
		}
	}
	
	// show featured groups in the sidebar
	$featured = $group->getPrivateSetting($prefix . "featured");
	
	if (!empty($featured) && ($featured != "no")) {
		$featured_sorting = $group->getPrivateSetting($prefix . "featured_sorting");
		$featured = sanitise_int($featured, false);
		
		echo elgg_view("groups/sidebar/featured", array("limit" => $featured, "sort" => $featured_sorting));
	}
}
