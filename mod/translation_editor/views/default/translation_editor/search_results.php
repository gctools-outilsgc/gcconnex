<?php 

	$search_results = $vars["results"];
	$current_language = $vars["current_language"];

	if(!empty($search_results)){
		$en_flag_file = "mod/translation_editor/_graphics/flags/en.gif";
		
		if(file_exists(elgg_get_root_path() . $en_flag_file)){
			$en_flag = "<img src='" . $vars['url'] . $en_flag_file . "' alt='" . elgg_echo("en") . "' title='" . elgg_echo("en") . "'>";
		} else {
			$en_flag = "en";
		}
		
		$lang_flag_file = "mod/translation_editor/_graphics/flags/" . $current_language . ".gif";
		
		if(file_exists(elgg_get_root_path() . $lang_flag_file)){
			$lang_flag = "<img src='" . $vars['url'] . $lang_flag_file . "' alt='" . elgg_echo($current_language)  . "' title='" . elgg_echo($current_language) . "'>";
		} else {
			$lang_flag = $current_language;
		}
		
		foreach($search_results as $plugin => $data){
			$translated_language = $data["current_language"];
			
			$list .= "<table class='elgg-table translation_editor_translation_table'>";
			$list .= "<col class='first_col'/>";
			$list .= "<tr class='first_row'><th colspan='2'>";
			$list .= "<a href='" . $vars["url"] . "translation_editor/" . $current_language . "/" . $plugin . "'>" . $plugin . "</a>";
			$list .= "</th></tr>";
			
			foreach($data["en"] as $key => $value){
				
				// English information
				$list .= "<tr>";
				$list .= "<td>" . $en_flag . "</td>";
				$list .= "<td>";
				$list .= "<span class='translation_editor_plugin_key' title='" . $key . "'></span>";
				$list .= "<pre class='translation_editor_pre'>" . nl2br(htmlspecialchars($value)) . "</pre>";
				$list .="</td>";
				$list .= "</tr>";
				
				// Custom language information
				$list .= "<tr>";
				$list .= "<td>" . $lang_flag . "</td>";
				$list .= "<td>";
				$list .= "<textarea name='translation[" . $plugin . "][" . $key . "]' onchange='translationEditorJQuerySearchSave();'>";
				$list .= $translated_language[$key];
				$list .= "</textarea>";
				$list .= "</td>";
				$list .= "</tr>";
			}
			
			$list .= "</table>";
		}
		
		$form_data = elgg_view("input/hidden", array("name" => "current_language", "value" => $current_language));
		$form_data .= $list;
		
		$form_data .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		
		$list = elgg_view("input/form", array("body" => $form_data,
												"action" => $vars["url"] . "action/translation_editor/translate_search",
												"id" => "translation_editor_search_result_form"));
	} else {
		$list .= elgg_echo("translation_editor:search_results:no_results");
	}

	echo $list;
?>
<style type="text/css">
	.translation_editor_translation_table tr {
		display: table-row;
		<!-- 
		display: inline-block;
		-->
	}
</style>