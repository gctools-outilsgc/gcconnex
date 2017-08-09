define(function (require) {

	var $ = require('jquery');

	require(["group_tools/ToolsEdit"], function (ToolsEdit) {
		$(".elgg-form-group-tools-group-tool-presets fieldset > div").not("#group-tools-tool-preset-base").each(function (index, object) {
			ToolsEdit.init(object);
		});
	});

	$(document).on('click', '.group-tools-admin-add-tool-preset', function (e) {
		e.preventDefault();

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
		$.each($inputs, function (index, object) {
			var name = $(object).attr("name");
			name = name.replace("params[i]", "params[" + counter + "]");
			$(object).attr("name", name);
		});

		require(["group_tools/ToolsEdit"], function (ToolsEdit) {
			ToolsEdit.init($clone);
		});

		// insert clone
		$clone.insertBefore($clone_base);

	});

	$(document).on('click', '.group-tools-admin-edit-tool-preset', function (e) {
		e.preventDefault();
		var $container = $(this).parent().parent().find(">div:last");
		if ($container.is(":visible")) {
			$container.addClass("hidden");
		} else {
			$container.removeClass("hidden");
		}
	});

	$(document).on('click', '.group-tools-admin-delete-tool-preset', function (e) {
		e.preventDefault();
		$(this).parent().parent().remove();
	});

	$(document).on('keyup keydown', '.group-tools-admin-change-tool-preset-title', function () {
		if (!$(this).val()) {
			return;
		}
		var $label = $(this).parent().parent().parent().find("label[rel='title']");
		$label.html($(this).val());
	});

	$(document).on('keyup keydown', '.group-tools-admin-change-tool-preset-description', function () {
		if (!$(this).val()) {
			return;
		}
		var $container = $(this).parent().parent().parent().find("div[rel='description']");
		$container.html($(this).val());
	});

});
