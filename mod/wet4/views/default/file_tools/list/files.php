<?php

$files = elgg_extract("files", $vars, array());
$folder = elgg_extract("folder", $vars);
$show_more = (bool) elgg_extract("show_more", $vars, false);
$limit = (int) elgg_extract("limit", $vars, file_tools_get_list_length());
$offset = (int) elgg_extract("offset", $vars, 0);

// only show the header if offset == 0
$folder_content = "";
if (empty($offset)) {
	$folder_content = elgg_view("file_tools/breadcrumb", array("entity" => $folder));
	
	if (!($sub_folders = file_tools_get_sub_folders($folder))) {
		$sub_folders = array();
	}
	
	$entities = array_merge($sub_folders, $files);
} else {
	$entities = $files;
}

if (!empty($entities)) {
	$params = array(
		"full_view" => false,
		"pagination" => false
	);
	
	elgg_push_context("file_tools_selector");
	
	$files_content = elgg_view_entity_list($entities, $params);
	
	elgg_pop_context();
}

if (empty($files_content)) {
	$files_content = elgg_echo("file_tools:list:files:none");
} else {
	if ($show_more) {
		$files_content .= "<div class='center' id='file-tools-show-more-wrapper'>";
		$files_content .= elgg_view("input/button", array(
			"value" => elgg_echo("file_tools:show_more"),
			"class" => "elgg-button-action",
			"id" => "file-tools-show-more-files",
		));
		$files_content .= elgg_view("input/hidden", array("name" => "offset", "value" => ($limit + $offset)));
		if (!empty($folder)) {
			$files_content .= elgg_view("input/hidden", array("name" => "folder_guid", "value" => $folder->getGUID()));
		} else {
			$files_content .= elgg_view("input/hidden", array("name" => "folder_guid", "value" => "0"));
		}
		$files_content .= "</div>";
	}
	
	// only show selectors on the first load
	if (empty($offset)) {
		$files_content .= "<div class='clearfix'>";
		
		if (elgg_get_page_owner_entity()->canEdit()) {
			$files_content .= '<a id="file_tools_action_bulk_delete" href="javascript:void(0);">' . elgg_echo("file_tools:list:delete_selected") . '</a> | ';
		}
		
		$files_content .= "<a id='file_tools_action_bulk_download' href='javascript:void(0);'>" . elgg_echo("file_tools:list:download_selected") . "</a>";
		
		$files_content .= "<a id='file_tools_select_all' class='float-alt' href='javascript:void(0);'>";
		$files_content .= "<span>" . elgg_echo("file_tools:list:select_all") . "</span>";
		$files_content .= "<span style='display:none'>" . elgg_echo("file_tools:list:deselect_all") . "</span>";		// added  wb-invisible class
		$files_content .= "</a>";
		
		$files_content .= "</div>";
	}
}

// show the listing
echo "<div id='file_tools_list_files'>";
echo "<div id='file_tools_list_files_overlay'></div>";
echo $folder_content;
echo $files_content;
echo elgg_view("graphics/ajax_loader");
echo "</div>";

$page_owner = elgg_get_page_owner_entity();

if ($page_owner->canEdit() || (elgg_instanceof($page_owner, "group") && $page_owner->isMember())) { ?>
<script type="text/javascript">

	$(function(){
		
		elgg.file_tools.initialize_file_draggable();
		elgg.file_tools.initialize_folder_droppable();
		
	});

</script>
<?php
}
