<?php if (FALSE) : ?><script type="text/javascript"><?php endif; ?>
	
	elgg.provide('framework');
	elgg.provide('framework.colorpicker');

    framework.colorpicker.init = function() {
        $('.hj-color-picker').miniColors({
			change : function(hex, rgba) {
				$(this).val(hex).trigger('change.miniColors');
			}
		});
    };

    elgg.register_hook_handler('init', 'system', framework.colorpicker.init);
    elgg.register_hook_handler('ajax:success', 'framework', framework.colorpicker.init);

