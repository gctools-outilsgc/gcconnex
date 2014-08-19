<?php 

	$languages = $vars["languages"];
	$current_language = $vars["current_language"];
	$plugin = $vars["plugin"];
	$disabled_languages = $vars["disabled_languages"];
	$site_language = $vars["site_language"];
	
	if(!empty($languages)){
		$list = "<table id='translation_editor_language_table' class='elgg-table' title='" . elgg_echo("translation_editor:language_selector:title") . "'>";
		$list .= "<tr>";
		$list .= "<th class='translation_editor_flag'>&nbsp;</th>";
		$list .= "<th>" . elgg_echo("translation_editor:language") . "</th>";
		if(elgg_is_admin_logged_in()){
			$list .= "<th class='translation_editor_enable'>" . elgg_echo("translation_editor:disabled") . "</th>";
		}
		$list .= "</tr>";
		
		foreach($languages as $language){
			$list .= "<tr>";
			
			// flag
			$lang_flag_file = "mod/translation_editor/_graphics/flags/" . $language . ".gif";
	
			if(file_exists(elgg_get_root_path() . $lang_flag_file)){
				$list .= "<td class='translation_editor_flag'>"; 
				$list .= "<img src='" . $vars['url'] . $lang_flag_file . "' alt='" . elgg_echo($language)  . "' title='" . elgg_echo($language) . "'> ";
				$list .= "</td>";
			} else {
				$list .= "<td class='translation_editor_flag'>&nbsp;</td>";
			}
			
			// language
			$list .= "<td>";
			if($language != $current_language){
				$url = $vars["url"] . "translation_editor/" . $language . "/" . $plugin;
				
				if($language != "en"){
					$completeness = translation_editor_get_language_completeness($language); 
					$list .= "<a href='" . $url . "'>" . elgg_echo($language) . " (" . $completeness . "%)</a>";
					
					if(elgg_is_admin_logged_in() && $completeness == 0){
						$list .= elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/translation_editor/delete_language?language=" . $language, "confirm" => elgg_echo("translation_editor:language_selector:remove_language:confirm"), "text" => elgg_view_icon("delete-alt")));
					}
				} else {
					$list .= "<a href='" . $url . "'>" . elgg_echo($language) . "</a>";
					
				}
			} else {
				if($language != "en"){
					$list .= elgg_echo($language) . " (" . translation_editor_get_language_completeness($language) . "%)";
				} else {
					$list .= elgg_echo($language);
				}
			}
			
			if($site_language == $language){
				$list .= "<span id='translation_editor_site_language'>" . elgg_echo("translation_editor:language_selector:site_language") . "</span>";
			}
			$list .= "</td>";
			
			// checkbox
			if(elgg_is_admin_logged_in()){
				$list .= "<td class='translation_editor_enable'>";
				if($language != "en"){
					$list .= "<input type='checkbox' name='disabled_languages[]' value='" . $language . "' onchange='translation_editor_disable_language();' ";
					if(in_array($language, $disabled_languages)){
						$list .= "checked='checked' ";
					}
					$list .= "/>";
				}
				$list .= "</td>";
			}
			
			$list .= "</tr>";
		}
		
		$list .= "</table>";
		
		echo $list;	
	}
	
	if(elgg_is_admin_logged_in()){
		// add a new language
		echo elgg_view("translation_editor/add_language");
	}	
	
	echo "<br />";