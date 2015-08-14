<?php
?>
// add a custom case-insensitive Contains function for widget filter (jQuery > 1.3)
jQuery.expr[':'].Contains = function(a,i,m){
     return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
};

function widget_manager_widgets_search(q){
	if(q === ""){
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper").show();
	} else {
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper").hide();
		$("#widget_manager_widgets_select .widget_manager_widgets_lightbox_wrapper:Contains('" + q + "')").show();
	}
}

function widget_manager_init(){
	// reset draggable functionality to pointer
	$(".elgg-widgets").sortable("option", "tolerance", "pointer");
	
	$(".elgg-widgets").bind({
		sortstart: function(event, ui){
			$(".widget-manager-groups-widgets-top-row").addClass("widget-manager-groups-widgets-top-row-highlight");
		},
		sortstop: function(event, ui){
			$(".widget-manager-groups-widgets-top-row").removeClass("widget-manager-groups-widgets-top-row-highlight");
		}
	});
	

	// live update of widget titles
    $('.elgg-form-widgets-save input.elgg-button-submit').live('click', function() {
 
      var widgetId = $(this).siblings('input:hidden[name="guid"]').val();
      var customTitle = $('#widget-manager-widget-edit-advanced-'+widgetId+' input:text[name="params[widget_manager_custom_title]"]').val();
      
      var customUrl = $('#widget-manager-widget-edit-advanced-'+widgetId+' input:text[name="params[widget_manager_custom_url]"]').val();
	  
	  // clean custom title, prevent scripting
	  var cleanText = $('<div class="stripHTMLClass">text</div>');
	  customTitle = cleanText.text(customTitle).html();
      
      if (customTitle.length == 0) {
        return;
      }
      
      // big long regex provided by the jquery validation plugin
      // only create link if the url is valid
      if(/^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(customUrl)) {
        var completeTitle = '<a href="'+customUrl+'">'+customTitle+'</a>';
      } else {
        var completeTitle = customTitle;
      }
      
      $('#elgg-widget-'+widgetId+' .elgg-widget-handle h3').html(completeTitle);
    });

}

elgg.register_hook_handler('init', 'system', widget_manager_init);
