define(function (require) {

	var $ = require('jquery');

	$(document).on('click', '#group-tools-group-edit-tabbed li', function (e) {

		e.preventDefault();
		
		// remove selected class
		$(this).siblings().removeClass("elgg-state-selected");
		$(this).addClass("elgg-state-selected");

		// hide everything
		$("#group-tools-group-edit-tabbed").nextAll("form, div").hide();
		$(".group-tools-group-edit-section").hide();
		
		var link = $(this).children("a").attr("href");
		switch (link) {
			case "#group-tools-group-edit-profile":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-profile").show();

				break;
			case "#group-tools-group-edit-access":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-access").show();

				break;
			case "#group-tools-group-edit-tools":
				$("#group-tools-group-edit-tabbed").nextAll("form").show();
				$("#group-tools-group-edit-tools").show();

				break;
			default:
				$("#group-tools-group-edit-tabbed").nextAll("div").show();
				break;
		}

	});
});
