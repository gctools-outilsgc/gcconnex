<?php ?>
//<script>
elgg.provide("elgg.widget_manager");

elgg.widget_manager.init_admin = function() {
	$(".widget-manager-fix").live("click", function(event) {
		$(this).toggleClass("fixed");
		guid = $(this).attr("href").replace("#", "");
		
		elgg.action('widget_manager/widgets/toggle_fix', {
				data: {
					guid: guid
				}
			});
		event.stopPropagation();
	});
	
	$("#widget-manager-settings-add-extra-context").live("click", function(event) {
		$("#widget-manager-settings-extra-contexts tr.hidden").clone().insertBefore($("#widget-manager-settings-extra-contexts tr.hidden")).removeClass("hidden");
	});
	
	$("#widget-manager-settings-extra-contexts .elgg-icon-delete").live("click", function(event) {
		$(this).parent().parent().remove();
	});
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.widget_manager.init_admin);