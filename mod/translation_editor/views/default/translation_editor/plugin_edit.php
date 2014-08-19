<?php 
	$current_language = $vars['current_language'];
	$english = $vars['translation']['en'];
	$translated_language = $vars['translation']['current_language'];
	$custom = $vars['translation']['custom'];
	
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
	
	$missing_count = 0;
	$equal_count = 0;
	$params_count = 0;
	$custom_count = 0;
	
	foreach($english as $en_key => $en_value){
		$en_params = translation_editor_get_string_parameters($en_value);
		$cur_params = translation_editor_get_string_parameters($translated_language[$en_key]);
		
		if(!array_key_exists($en_key, $translated_language)){
			$row_rel = "rel='missing'";
			$missing_count++;
		} elseif($en_value == $translated_language[$en_key]){
			$row_rel = "rel='equal'";
			$equal_count++;
		} elseif($en_params != $cur_params){
			$row_rel = "rel='params'";
			$params_count++;
		} elseif(array_key_exists($en_key, $custom)){
			$row_rel = "rel='custom'";
			$custom_count++;
		} else {
			$row_rel = "";
		}
		
		// English information
		$translation .= "<tr " . $row_rel . ">";
		$translation .= "<td>" . $en_flag . "</td>";
		$translation .= "<td>";
		$translation .= "<span class='translation_editor_plugin_key' title='" . $en_key . "'></span>";
		$translation .= "<pre class='translation_editor_pre'>" . nl2br(htmlspecialchars($en_value)) . "</pre>";
		$translation .="</td>";
		$translation .= "</tr>";
		
		// Custom language information
		$translation .= "<tr ". $row_rel . ">";
		$translation .= "<td>" . $lang_flag . "</td>";
		$translation .= "<td>";
		$translation .= "<textarea name='translation[" . $en_key . "]' >";
		$translation .= $translated_language[$en_key];
		$translation .= "</textarea>";
		$translation .= "</td>";
		$translation .= "</tr>";
	}
	
	$selected_view_mode = "missing";
	
	if($missing_count == 0){
		$selected_view_mode = "all";
		?>
		<style type="text/css">
			.translation_editor_translation_table tr {
				display: table-row;
				<!-- 
				display: inline-block;
				-->
			}
		</style>
		<?php 
	}

	$toggle = "<span id='translation_editor_plugin_toggle' class='float-alt'>";
		
	$toggle .= elgg_echo("translation_editor:plugin_edit:show") . " ";
	
	$missing_class = "";
	$equal_class = "";
	$params_class = "";
	$custom_class = "";
	$all_class = "";
	
	switch($selected_view_mode){
		case "missing":
			$missing_class = "view_mode_active";
			break;
		case "all":
			$all_class = "view_mode_active";
			break;
		case "equal":
			$equal_class = "view_mode_active";
			break;
		case "custom":
			$custom_class = "view_mode_active";
			break;
		case "params":
			$params_class = "view_mode_active";
			break;
	}
	
	$toggle .= "<a class='$missing_class' id='view_mode_missing' href='javascript:toggleViewMode(\"missing\");'>" . elgg_echo("translation_editor:plugin_edit:show:missing") . "</a> (" . $missing_count . "), ";
	$toggle .= "<a class='$equal_class' id='view_mode_equal' href='javascript:toggleViewMode(\"equal\");'>" . elgg_echo("translation_editor:plugin_edit:show:equal") . "</a> (" . $equal_count . "), ";
	$toggle .= "<a class='$params_class' id='view_mode_params' href='javascript:toggleViewMode(\"params\");'>" . elgg_echo("translation_editor:plugin_edit:show:params") . "</a> (" . $params_count . "), ";
	$toggle .= "<a class='$custom_class' id='view_mode_custom' href='javascript:toggleViewMode(\"custom\");'>" . elgg_echo("translation_editor:plugin_edit:show:custom") . "</a> (" . $custom_count . "), ";
	$toggle .= "<a class='$all_class' id='view_mode_all' href='javascript:toggleViewMode(\"all\");'>" . elgg_echo("translation_editor:plugin_edit:show:all") . "</a> (" . $vars['translation']['total'] . ")";
	$toggle .= "</span>";
	
	$list .= "<table class='elgg-table translation_editor_translation_table'>";
	$list .= "<col class='first_col'/>";
	$list .= "<tr class='first_row'><th colspan='2'>";
	$list .= $toggle;
	$list .= elgg_echo("translation_editor:plugin_edit:title") . " " . $vars['plugin'];
	$list .= "</th></tr>";
	$list .= $translation;
	$list .= "</table>";
	
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#translation_editor_plugin_form textarea').live("change", function(){
			translationEditorJQuerySave();
		});
	});
</script>

<div>
	<form id="translation_editor_plugin_form" action="<?php echo $vars['url'];?>action/translation_editor/translate" method="post">
		<?php echo elgg_view("input/securitytoken"); ?>
		<input type='hidden' name='current_language' value='<?php echo $current_language; ?>' />
		<input type='hidden' name='plugin' value='<?php echo $vars['plugin']; ?>' />
		<?php 
			echo $list;
			echo elgg_view("input/submit", array("value" => elgg_echo("save")));
		?>	
	</form>
</div>