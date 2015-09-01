elgg.provide("elgg.widget_manager");

// add a custom case-insensitive Contains function for widget filter (jQuery > 1.3)
jQuery.expr[':'].Contains = function(a,i,m){
     return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
};

elgg.widget_manager.widgets_search = function(q) {
	if (q === "") {
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper").show();
	} else {
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper").hide();
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper:Contains('" + q + "')").show();
	}
}

elgg.widget_manager.widget_add_init = function() {
	$(document).ajaxSuccess(function(e, xhr, settings) {
		if (settings.url == elgg.normalize_url('/action/widgets/add')) {
			// move new widget to a new position (after fixed widgets) if needed
			if ($(this).find('.elgg-state-fixed').size() > 0) {
				$widget = $(this).find('.elgg-module-widget:first');
				$widget.insertAfter($(this).find('.elgg-state-fixed:last'));
				
				// first item is the recently moved widget, because fixed widgets are not part of the sortable
				var index = $(this).find('.elgg-module-widget').index($widget);
				var guidString = $widget.attr('id');
				guidString = guidString.substr(guidString.indexOf('elgg-widget-') + "elgg-widget-".length);

				elgg.action('widgets/move', {
					data: {
						widget_guid: guidString,
						column: 1,
						position: index
					}
				});
			}
		}
	});
}

elgg.register_hook_handler('init', 'system', elgg.widget_manager.widget_add_init);