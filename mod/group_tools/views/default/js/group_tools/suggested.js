define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');

	$(document).on('click', '.group-tools-suggested-groups .elgg-button-action', function (e) {
		e.preventDefault();
		elgg.action($(this).attr("href"));
		$(this).css("visibility", "hidden");
	});
});

