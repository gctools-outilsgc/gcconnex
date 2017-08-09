define(function (require) {
	
	var elgg = require('elgg');
	var $ = require('jquery');
	
	$(document).on('click', '.group-tools-accept-request', function (e) {
		
		e.preventDefault();
		var guid = $(this).attr('rel');
		
		elgg.action($(this).attr('href'), {
			success: function () {
				var $wrapper = $('#elgg-user-' + guid);
				if ($wrapper.length) {
					$wrapper.remove();
				}
			}
		});
	});
});
