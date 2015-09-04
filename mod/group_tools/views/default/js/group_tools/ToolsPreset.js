/**
 * Support file for group tool presets
 */

define(["jquery", "elgg"], function($, elgg) {
	
	function ToolsPreset(wrapper) {
		var self = this;
		
		$("#group-tools-preset-selector a", wrapper).on("click", function() {
			self.changePreset(this);
			
			return false;
		});
		
	}
	
	ToolsPreset.prototype = {
		changePreset : function(elem) {
			
			var rel = $(elem).attr("rel");
			
			$("#group-tools-preset-descriptions div").hide();
			$("#group-tools-preset-description-" + rel).show();
			
			this.resetTools();
			this.presetTools(rel);
			
			$("#group-tools-preset-more").hide();
			$("#group-tools-preset-active").show();
			
		},
		resetTools : function() {
			$("#group-tools-preset-active .elgg-input-checkbox").each(function(index, elm) {
				var $tool_parent = $(elm).parent().parent();
				
				$tool_parent.appendTo("#group-tools-preset-more div.elgg-body");
			});
			
			$("#group-tools-preset-more .elgg-input-checkbox[value='yes']:checked").click();
			$("#group-tools-preset-active .elgg-body > a").show();
		},
		presetTools : function(preset_id) {
			if (preset_id == "blank") {
				$("#group-tools-preset-more .elgg-body > div").each(function(index, elm) {
					
					$(this).prependTo("#group-tools-preset-active div.elgg-body");
				});
			} else {
				$("#group-tools-preset-more .group-tools-preset-" + preset_id).each(function(index, elm) {
					
					$(this).prependTo("#group-tools-preset-active div.elgg-body");
				});
				
				$("#group-tools-preset-active .elgg-input-checkbox[value='yes']").not(":checked").click();
			}
			
			if ($("#group-tools-preset-more .elgg-body > div").length == 0) {
				$("#group-tools-preset-active .elgg-body > a").hide();
			}
		}
	};
	
	ToolsPreset.init = function(selector) {
		new ToolsPreset(selector);
	};
	
	return ToolsPreset;
});