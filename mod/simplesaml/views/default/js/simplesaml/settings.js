define('simplesaml/settings', ['jquery', 'elgg'], function($, elgg) {
	
	$(document).on('change', '#simplesaml-settings-sources input[type="checkbox"][name$="force_authentication]"]', function() {
		console.log('heheheeh');
		if ($(this).is(':checked')) {
			// uncheck all others
			$('#simplesaml-settings-sources input[type="checkbox"][name$="force_authentication]"]').not($(this)).prop('checked', false);
		}
	});
	
});
