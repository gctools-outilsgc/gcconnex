<?php ?>
function widget_manager_fix_widget(elem, guid){
	var url = "<?php echo elgg_add_action_tokens_to_url($vars["url"] . "action/widget_manager/widgets/toggle_fix"); ?>";
	$.post(url, {
		guid: guid}, function(data){
			if(data){
				$(elem).toggleClass("fixed");
					
				$(elem).parents("div.collapsable_box").parent().toggleClass("free_widgets");
				$(elem).parents("div.collapsable_box_header").toggleClass("fixed_widget").toggleClass("draggable_widget");
			}
		});
}

$(document).ready(function(){
	$(".widget-manager-fix").live("click", function(event){
		$(this).toggleClass("fixed");
		guid = $(this).attr("href").replace("#", "");
		
		elgg.action('widget_manager/widgets/toggle_fix', {
				data: {
					guid: guid
				}
			});
		event.stopPropagation();
	});
});