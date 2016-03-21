/**
 * Support file for group tools edit
 */

define(["jquery", "elgg"], function($, elgg){
	
	function ToolsEdit(wrapper) {
		this.$wrapper = $(wrapper);
		this.$input = $(".elgg-input-radio", wrapper);
		
		this.$input.on("change", this.toggleTool);
		
		// set initial states
		$(".elgg-input-radio:checked", wrapper).each(function() {
			$(this).parent().parent().addClass("elgg-state-selected");
		});
	}
	
	ToolsEdit.prototype = {
		toggleTool : function() {
			var $ul = $(this).parent().parent().parent();
			var $li = $(this).parent().parent();
			
			$ul.find("li.elgg-state-selected").removeClass("elgg-state-selected");
			$li.addClass("elgg-state-selected");
		}
	};
	
	ToolsEdit.init = function(selector) {
		
		elgg.register_hook_handler("init", "system", function () {
			$(selector).each(function () {
				// we only want to wrap once
				if (!$(this).data("initialized")) {
					new ToolsEdit(this);
					$(this).data("initialized", 1);
				}
			});
		});
	};
	
	return ToolsEdit;
});