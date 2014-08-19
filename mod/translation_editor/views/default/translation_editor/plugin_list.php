<?php 
	$plugins = $vars["plugins"];
	$current_language = $vars["current_language"];
	
	if(!empty($plugins)){
		$total = 0;
		$exists = 0; 
		$custom = 0;
		
		$list .= "<table id='translation_editor_plugin_list' class='elgg-table' title='" . elgg_echo("translation_editor:plugin_list:title") . "'>";
		$list .= "<tr>";
		$list .= "<th class='first_col'>" . elgg_echo("translation_editor:plugin_list:plugin") . "</th>";
		$list .= "<th>" . elgg_echo("translation_editor:plugin_list:total") . "</th>";
		$list .= "<th>" . elgg_echo("translation_editor:plugin_list:exists") . "</th>";
		$list .= "<th>" . elgg_echo("translation_editor:plugin_list:custom") . "</th>";
		$list .= "<th>" . elgg_echo("translation_editor:plugin_list:percentage") . "</th>";
		$list .= "<th>&nbsp;</th>";
		$list .= "</tr>";
		
		foreach($plugins as $plugin_name => $plugin_stats){
			
			$url = $vars["url"] . "translation_editor/" . $current_language . "/" . $plugin_name;
			
			$total += $plugin_stats["total"];
			$exists += $plugin_stats["exists"];
			$custom += $plugin_stats["custom"];
			
			if(!empty($plugin_stats["total"])){
				$percentage = round(($plugin_stats["exists"] / $plugin_stats["total"]) * 100);
			} else {
				$percentage = 100;
			}
			
			$complete_class = "";
			
			if($percentage == 100){
				$complete_class = " class='translation_editor_translation_complete'";
			} elseif($percentage == 0){
				$complete_class = " class='translation_editor_translation_needed'";
			}
			
			$list .= "<tr>";
			$list .= "<td class='first_col'><a href='" . $url . "'>" . $plugin_name . "</a></td>";
			$list .= "<td>" . $plugin_stats["total"] . "</td>";
			$list .= "<td>" . $plugin_stats["exists"] . "</td>";
			
			if($plugin_stats["custom"] > 0){
				$list .= "<td>" . $plugin_stats["custom"] . "</td>";
			} else {
				$list .= "<td>&nbsp;</td>";
			}
			
			$list .= "<td" . $complete_class . ">" . $percentage . "%</td>";
			
			if($plugin_stats["custom"] > 0){
				$merge_url = $vars["url"] . "action/translation_editor/merge?current_language=" . $current_language . "&plugin=" . $plugin_name;
				
				$list .= "<td>";
				$list .= elgg_view("output/url", array("href" => $merge_url, "is_action" => true, "title" => elgg_echo("translation_editor:plugin_list:merge"), "text" => elgg_view_icon("download")));
				if(elgg_is_admin_logged_in()){
					$delete_url = $vars["url"] . "action/translation_editor/delete?current_language=" . $current_language . "&plugin=" . $plugin_name;
					
					$list .= elgg_view("output/confirmlink", array("href" => $delete_url, "title" => elgg_echo("delete"), "text" => elgg_view_icon("delete-alt")));
				}
				$list .= "</td>";
			} else {
				$list .= "<td>&nbsp;</td>";
			}
			$list .= "</tr>";
		}
		
		$list .= "<tr class='translation_editor_plugin_list_total_row'>";
		$list .= "<td>&nbsp;</td>";
		$list .= "<td>" . $total . "</td>";
		$list .= "<td>" . $exists . "</td>";
		$list .= "<td>" . $custom . "</td>";
		$list .= "<td>" . round(($exists / $total) * 100, 2) . "%</td>";
		$list .= "<td>&nbsp;</td>";
		$list .= "</tr>";
		
		$list .= "</table>";
		
		echo $list;
	}
