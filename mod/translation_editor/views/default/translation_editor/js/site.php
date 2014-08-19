<?php 

?>
//<script>
function translation_editor_disable_language(){
	var url = elgg.security.addToken("<?php echo $vars["url"]; ?>action/translation_editor/disable_languages?");
	
	var lan = new Array();
	$('#translation_editor_language_table input[name="disabled_languages[]"]:checked').each(function(index, elm){
		lan.push($(this).val());
	});

	$.post(url, {'disabled_languages[]': lan });
}

function toggleViewMode(mode){
	$("#translation_editor_plugin_toggle a").removeClass("view_mode_active");
	$("#view_mode_" + mode).addClass("view_mode_active");
	
	if(mode == "all"){
		$("#translation_editor_plugin_form tr").show();
	} else {
		$("#translation_editor_plugin_form tr").hide();
		$("#translation_editor_plugin_form tr[rel='" + mode + "']").show();
		$("#translation_editor_plugin_form tr:first").show();
	}
}

function translationEditorJQuerySave(){
	var url = $('#translation_editor_plugin_form').attr("action") + "?jquery=yes";
	var formData = $('#translation_editor_plugin_form').serialize();

	$.post(url, formData, function(data){}, "json");
}

function translationEditorJQuerySearchSave(){
	var url = $('#translation_editor_search_result_form').attr("action") + "?jquery=yes";
	var formData = $('#translation_editor_search_result_form').serialize();

	$.post(url, formData, function(data){}, "json");
}