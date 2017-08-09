require(['elgg', 'jquery', 'elgg/widgets'], function(elgg, $) {

	elgg.provide('elgg.widget_manager');

	elgg.widget_manager.init = function() {
		// reset draggable functionality to pointer
		$('.elgg-widgets').sortable('option', 'tolerance', 'pointer');

		$('.elgg-widgets').bind({
			sortstart: function () {
				$('.widget-manager-groups-widgets-top-row').addClass('widget-manager-groups-widgets-top-row-highlight');
			},
			sortstop: function () {
				$('.widget-manager-groups-widgets-top-row').removeClass('widget-manager-groups-widgets-top-row-highlight');
			}
		});
	};

	// live update of widget titles
	$(document).on('click', '.elgg-form-widgets-save input.elgg-button-submit', function () {

		var widgetId = $(this).siblings('input:hidden[name="guid"]').val();
		var customTitle = $('#widget-manager-widget-edit-advanced-' + widgetId + ' input:text[name="params[widget_manager_custom_title]"]').val();

		var customUrl = $('#widget-manager-widget-edit-advanced-' + widgetId + ' input:text[name="params[widget_manager_custom_url]"]').val();

		if (customTitle.length === 0) {
			return;
		}

		// clean custom title, prevent scripting
		var cleanText = $('<div class="stripHTMLClass">text</div>');
		customTitle = cleanText.text(customTitle).html();

		if (customTitle.length === 0) {
			return;
		}

		// big long regex provided by the jquery validation plugin
		// only create link if the url is valid
		var completeTitle;
		if (/^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(customUrl)) {
			completeTitle = '<a href="' + customUrl + '">' + customTitle + '</a>';
		} else {
			completeTitle = customTitle;
		}

		$('#elgg-widget-' + widgetId + ' .elgg-widget-handle h3').html(completeTitle);
	});

	$(document).on('submit', '.elgg-form-widgets-save', function (event) {
		elgg.ui.lightbox.close();

		var widget_id = $(this).find("input[name='guid']").val();
		var $widgetContent = $("#elgg-widget-content-" + widget_id);

		// stick the ajax loader in there
		var $loader = $('#elgg-widget-loader').clone();
		$loader.attr('id', '#elgg-widget-active-loader');
		$loader.removeClass('hidden');
		$widgetContent.html($loader);

		var default_widgets = $("input[name='default_widgets']").val() || 0;
		if (default_widgets) {
			$(this).append('<input type="hidden" name="default_widgets" value="1">');
		}

		elgg.action('widgets/save', {
			data: $(this).serialize(),
			success: function (json) {
				$widgetContent.html(json.output);
				if (typeof (json.title) !== "undefined") {
					var $widgetTitle = $widgetContent.parent().parent().find('.elgg-widget-title');
					$widgetTitle.html(json.title);
				}
			}
		});
		event.preventDefault();
	});

	$(document).on('click', '.elgg-module-widget .elgg-menu-item-collapse a', function (event) {
		if (elgg.is_logged_in()) {
			var collapsed = 1;
			if ($(this).hasClass("elgg-widget-collapsed")) {
				collapsed = 0;
				// elgg changes collapsed class after this click event
			}

			var guid = $(this).attr("href").replace("#elgg-widget-content-", "");

			elgg.action('widget_manager/widgets/toggle_collapse', {
				data: {
					collapsed: collapsed,
					guid: guid
				}
			});
		}
	});
	
	elgg.register_hook_handler('init', 'system', elgg.widget_manager.init);
});