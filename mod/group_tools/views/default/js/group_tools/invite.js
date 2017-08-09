define(function (require) {
	
	var $ = require('jquery');
	
	// tab filter
	$(document).on('click', '.group-tools-invite-tab', function (e) {
		e.preventDefault();
		
		var $elem = $(this);
		var target = $elem.find('a').eq(0).attr('href');
		
		$elem.siblings('.group-tools-invite-tab').andSelf().removeClass('elgg-state-selected');
		$elem.addClass('elgg-state-selected');
		
		$(target).siblings('.group-tools-invite-form').andSelf().removeClass('elgg-state-active').addClass('hidden');
		$(target).addClass('elgg-state-active').removeClass('hidden');
	});
	
	// toggle all friends
	$(document).on('click', '#group-tools-friends-toggle', function () {
		
		if ($('#group-tools-friends-toggle span:first').is(':visible')) {
			$('#friends-picker1 input[type="checkbox"]').attr("checked", "checked");
		} else {
			$('#friends-picker1 input[type="checkbox"]').removeAttr("checked");
		}

		$('#group-tools-friends-toggle span').toggle();
	});
	
});
