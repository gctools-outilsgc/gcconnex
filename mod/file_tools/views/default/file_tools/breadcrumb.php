<?php 

	$folder = elgg_extract("entity", $vars);
	
	echo "<div id='file_tools_breadcrumbs' class='clearfix'>";	
	echo elgg_view_menu("file_tools_folder_breadcrumb", array(
		"entity" => $folder,
		"sort_by" => "priority",
		"class" => "elgg-menu-hz"
	));	
	
	echo "</div>";
	
	if($folder) {
		echo elgg_view_entity($folder, array("full_view" => true));
	}
	