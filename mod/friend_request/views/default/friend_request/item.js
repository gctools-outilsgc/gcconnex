define(function(require) {

	var elgg = require('elgg');
	var $ = require('jquery');
	var spinner = require(['elgg/spinner']);

	$(document).on('click', '.friend-request-button', function(e) {
		e.preventDefault();
		var $elem = $(this);
		elgg.action($elem.attr('href'), {
			beforeSend: spinner.start,
			complete: spinner.stop,
			success: function(response) {
				if (response.status >= 0) {
					$elem.closest('.elgg-item').fadeOut().remove();
				}
			}
		});
	});

});