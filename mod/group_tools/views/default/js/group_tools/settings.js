define(function (require) {
	var elgg = require('elgg');
	var $ = require('jquery');

	$(document).on('click', '#group-tools-special-states-tabs a', function (e) {
		e.preventDefault();

		// remove all selected tabs
		$("#group-tools-special-states-tabs li").removeClass("elgg-state-selected");
		// select the correct tab
		$(this).parent().addClass("elgg-state-selected");

		// hide all content
		$("#group-tools-special-states-featured, #group-tools-special-states-auto-join, #group-tools-special-states-suggested").addClass("hidden");
		// show the selected content
		$($(this).attr("href")).removeClass("hidden");
	});

	$(document).on('click', '#group-tools-special-states-featured a.elgg-requires-confirmation, #group-tools-special-states-auto-join a.elgg-requires-confirmation, #group-tools-special-states-suggested a.elgg-requires-confirmation', function (e) {
		e.preventDefault();
		elgg.action($(this).attr("href"));
		$(this).parent().parent().remove();
	});
});