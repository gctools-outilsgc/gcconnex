<?php 

	$widget = elgg_extract("entity", $vars);
	
	if($folders = file_tools_get_folders($widget->owner_guid)){
		$selected_folders = $widget->folder_guids;
		if(!empty($selected_folders) && !is_array($selected_folders)){
			$selected_folders = array($selected_folders);
		} elseif(empty($selected_folders)){
			$selected_folders = array();
		}
		
		// select folder(s) to display
		echo elgg_echo("widgets:file_tree:edit:select");
		echo "<div>";
		echo elgg_view("input/hidden", array("name" => "params[folder_guids][]", "value" => "")); // needed to be able to empty the list
		echo file_tools_build_widget_options($folders, "params[folder_guids][]", $selected_folders);
		echo "</div>";
		
		// display folder or folder content
		$checkbox_options = array(
			"name" => "params[show_content]", 
			"value" => "1"
		);
		if(!empty($widget->show_content)){
			$checkbox_options["checked"] = "checked";
		}
		echo "<div>";
		echo elgg_view("input/checkbox", $checkbox_options);
		echo elgg_echo("widgets:file_tree:edit:show_content");
		echo "</div>";
	}
