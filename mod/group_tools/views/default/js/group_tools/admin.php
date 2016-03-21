<?php
/**
 * extend the global JS on the admin side
 */
?>
//<script>
elgg.provide("elgg.group_tools_admin");

elgg.group_tools_admin.add_tool_preset = function() {
	var $clone_base = $("#group-tools-tool-preset-base");
	var $clone = $clone_base.clone();

	$clone.removeAttr("id").removeClass("hidden");
	$clone.find(">div.hidden").removeClass("hidden");

	// find inputs and set correct name
	var counter = $clone_base.parent().find(">div").length;
	while ($clone_base.parent().find("input[name^='params[" + counter + "]']").length) {
		counter++;
	}
	
	var $inputs = $clone.find(":input");
	$.each($inputs, function(index, object) {
		console.log(object);
		var name = $(object).attr("name");
		console.log(name);
		name = name.replace("params[i]", "params[" + counter + "]");
		
		$(object).attr("name", name);
	});

	require(["group_tools/ToolsEdit"], function(ToolsEdit) {
		ToolsEdit.init($clone);
	});
	
	// insert clone
	$clone.insertBefore($clone_base);

	return false;
}

elgg.group_tools_admin.edit_tool_preset = function(elm) {

	var $container = $(elm).parent().parent().find(">div:last");
	if ($container.is(":visible")) {
		$container.addClass("hidden");
	} else {
		$container.removeClass("hidden");
	}
	
	return false;
}

elgg.group_tools_admin.change_tool_preset_title = function(elm) {
	var $label = $(elm).parent().parent().parent().find("label[rel='title']");
	$label.html($(elm).val());
}

elgg.group_tools_admin.change_tool_preset_description = function(elm) {
	var $container = $(elm).parent().parent().parent().find("div[rel='description']");
	$container.html($(elm).val());
}

elgg.group_tools_admin.delete_tool_preset = function(elm) {
	$(elm).parent().parent().remove();

	return false;
}

elgg.group_tools_admin.init = function() {

	$("#group-tools-special-states-tabs a").live("click", function() {
		// remove all selected tabs
		$("#group-tools-special-states-tabs li").removeClass("elgg-state-selected");
		// select the correct tab
		$(this).parent().addClass("elgg-state-selected");

		// hide all content
		$("#group-tools-special-states-featured, #group-tools-special-states-auto-join, #group-tools-special-states-suggested").addClass("hidden");
		// show the selected content
		$($(this).attr("href")).removeClass("hidden");

		return false;
	});

	$("#group-tools-special-states-featured a.elgg-requires-confirmation, #group-tools-special-states-auto-join a.elgg-requires-confirmation, #group-tools-special-states-suggested a.elgg-requires-confirmation").live("click", function(){

		elgg.action($(this).attr("href"));

		$(this).parent().parent().remove();
		
		return false;
	});

	$("#group-tools-admin-bulk-delete input[name='checkall'][type='checkbox']").live("change", function() {

		if ($(this).is(":checked")) {
			// check
			$("#group-tools-admin-bulk-delete input[name='group_guids[]']").attr("checked", "checked");
		} else {
			// uncheck
			$("#group-tools-admin-bulk-delete input[name='group_guids[]']").removeAttr("checked");
		}
	});
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.group_tools_admin.init);
