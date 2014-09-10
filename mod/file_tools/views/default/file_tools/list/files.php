<?php

	$files = elgg_extract("files", $vars, array());
	$folder = elgg_extract("folder", $vars);
	
	$folder_content = elgg_view("file_tools/breadcrumb", array("entity" => $folder));	
	
	if(!($sub_folders = file_tools_get_sub_folders($folder))){
		$sub_folders = array();
	}
	
	$entities = array_merge($sub_folders, $files) ;
	
	if(!empty($entities)) {
		$params = array(
			"full_view" => false,
			"pagination" => false
		);
		
		elgg_push_context("file_tools_selector");
		
		$files_content = elgg_view_entity_list($entities, $params);
		
		elgg_pop_context();
	}
	
	if(empty($files_content)){
		$files_content = elgg_echo("file_tools:list:files:none");
	} else {
		$files_content .= "<div class='clearfix'>";
		
		if(elgg_get_page_owner_entity()->canEdit()) {
			$files_content .= '<a id="file_tools_action_bulk_delete" href="javascript:void(0);">' . elgg_echo("file_tools:list:delete_selected") . '</a> | ';
		}
		
		$files_content .= "<a id='file_tools_action_bulk_download' href='javascript:void(0);'>" . elgg_echo("file_tools:list:download_selected") . "</a>";
		
		$files_content .= "<a id='file_tools_select_all' class='float-alt' href='javascript:void(0);'>";
		$files_content .= "<span>" . elgg_echo("file_tools:list:select_all") . "</span>";
		$files_content .= "<span class='hidden wb-invisible'>" . elgg_echo("file_tools:list:deselect_all") . "</span>";
		$files_content .= "</a>";
		
		$files_content .= "</div>";
	}
	
	$files_content .= elgg_view("graphics/ajax_loader");
	
?>
<div id="file_tools_list_files">
	<div id="file_tools_list_files_overlay"></div>
	<?php 
		echo $folder_content;
		echo $files_content;
	?>
</div>

<?php 
$page_owner = elgg_get_page_owner_entity();

if($page_owner->canEdit() || (elgg_instanceof($page_owner, "group") && $page_owner->isMember())) { ?>
<script type="text/javascript">

	$(function(){
		$("#file_tools_list_files .file-tools-file").draggable({
			revert: "invalid",
			opacity: 0.8,
			appendTo: "body",
			helper: "clone",
			start: function(event, ui) {
				$(this).css("visibility", "hidden");
				$(ui.helper).width($(this).width());
			},
			stop: function(event, ui) {
				$(this).css("visibility", "visible");
			}
		});

		$("#file_tools_list_files .file-tools-folder").droppable({
			accept: "#file_tools_list_files .file-tools-file",
			drop: function(event, ui){
				droppable = $(this);
				draggable = ui.draggable;

				drop_id = droppable.parent().attr("id").split("-").pop();
				drag_id = draggable.parent().attr("id").split("-").pop();

				elgg.file_tools.move_file(drag_id, drop_id, draggable);
			}
		});
	});

</script>
<?php 
} 