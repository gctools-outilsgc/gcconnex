<?php
/**
 * This file contains all the Javascript required for the admin side of this plugin
 */
?>
//<script>
elgg.provide("elgg.simplesaml_admin");

elgg.simplesaml_admin.init = function() {
	$("#simplesaml-settings-sources input[type='checkbox'][name$='_force_authentication]']").live("change", function() {
		if ($(this).is(":checked")) {
			// uncheck all others
			$("#simplesaml-settings-sources input[type='checkbox'][name$='force_authentication]']").not($(this)).removeAttr("checked");
		}
	});
};

elgg.register_hook_handler("init", "system", elgg.simplesaml_admin.init);