elgg.provide("elgg.translation_editor");

elgg.translation_editor.disable_language = function() {
	
	var lan = [];
	$('#translation_editor_language_table input[name="disabled_languages[]"]:checked').each(function(index, elm){
		lan.push($(this).val());
	});

	elgg.action("translation_editor/disable_languages", {
		data: {
			disabled_languages: lan
		}
	});
};

elgg.translation_editor.toggle_view_mode = function(mode) {
	$("#translation_editor_plugin_toggle a").removeClass("view_mode_active");
	$("#translation_editor_plugin_toggle a[rel='" + mode + "']").addClass("view_mode_active");

	var $table = $(".translation_editor_translation_table");
	if (mode == "all") {
		$table.find("tr").show();
	} else {
		$table.find("tr").hide();
		$table.find("tr[rel='" + mode + "']").show();
		$table.find("tr:first").show();
	}
};

elgg.translation_editor.save = function(elem) {
	var key = $(elem).attr("name");
	var value = $(elem).val();

	var data = { };
	data[key] = value;
	
	elgg.action("translation_editor/translate", {
		data: data
	});
};

elgg.translation_editor.init = function() {
	$(document).on("change", ".translation-editor-input", function() {
		elgg.translation_editor.save(this);
	});
};

elgg.register_hook_handler("init", "system", elgg.translation_editor.init);
