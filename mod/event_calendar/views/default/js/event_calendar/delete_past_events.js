define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$('#elgg-event-calendar-past-delete-submit').click(function() {
		var delete_upper_limit = $("input[name=delete_upper_limit]:checked").val();
		var delete_repeating_events = $("input[name=delete_repeating_events]").is(':checked');
		$("#elgg-event-calendar-past-delete-results").html('<div class="elgg-ajax-loader"></div>');
		elgg.action('event_calendar/delete_past_events', {
			data: {
				delete_upper_limit: delete_upper_limit,
				delete_repeating_events: delete_repeating_events
			},
			cache: false,
			success: function(res) {
				if (res.success) {
					$("#elgg-event-calendar-past-delete-results").html(res.message);
				} else {
					$("#elgg-event-calendar-past-delete-results").html(res.message);
				}
			}
		});
	});
});
