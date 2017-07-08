define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	function init() {
		$('.event_calendar_paged_checkbox').on('click', handlePagedPersonalCalendarToggle);
		$('.event-calendar-personal-calendar-toggle').on('click', toggleDisplayPagePersonalCalendar);
		$('#event-calendar-region').on('change', handleRegionChange);
		$('#event-calendar-ical-link').on('click', handleIcalPopup);
		$('.event-calendar-repeating-unselected').each(setRepeatingClass);
		$(document).on('click', '.event-calendar-repeating-unselected', handleRepeatingSelect);
		$(document).on('click', '.event-calendar-repeating-selected', handleRepeatingUnselect);
		$('#event-calendar-edit').on('submit', handleEditFormSubmit);
		$('.event-calendar-edit-schedule-type').on('click', handleScheduleType);
		handleScheduleType();

		var all_day_field = $('[name="all_day"][type="checkbox"]');
		if (all_day_field.is(':checked')) {
			//$('[name="start_time"]').val(0);
			$('#event-calendar-start-time-wrapper').attr('disabled','disabled');
			//$('[name="end_time"]').val(0);
			$('#event-calendar-end-time-wrapper').attr('disabled','disabled');
		}
		all_day_field.change(handleAllDayField());
	}

	handleScheduleType = function(e) {
		var st = $("[name='schedule_type']:checked").val();
		if (st == 'poll') {
			$(".event-calendar-edit-date-wrapper").hide();
			$(".event-calendar-edit-reminder-wrapper").hide();
			$(".event-calendar-edit-form-membership-block").hide();
			$(".event-calendar-edit-form-share-block").hide();
			$("[name='start_date_for_all_day']").hide();
		} else {
			$(".event-calendar-edit-reminder-wrapper").show();
			$(".event-calendar-edit-form-membership-block").show();
			$(".event-calendar-edit-form-share-block").show();
			if (st == 'all_day') {
				$(".event-calendar-edit-date-wrapper").hide();
				$("#event-calendar-start-time-wrapper").hide();
				$("#event-calendar-end-time-wrapper").hide();
				$(".event-calendar-edit-all-day-date-wrapper").show();
			} else {
				$(".event-calendar-edit-date-wrapper").show();
				$("#event-calendar-start-time-wrapper").show();
				$("#event-calendar-end-time-wrapper").show();
				$(".event-calendar-edit-all-day-date-wrapper").hide();
			}
		}
	}

	handleAllDayField = function(e) {
		var field = $('[name="start_time"]');
		if (field.attr('disabled') == 'disabled') {
			field.removeAttr('disabled');
		} else {
			field.attr('disabled','disabled');
		}

		field = $('[name="end_time"]');
		if (field.attr('disabled') == 'disabled') {
			field.removeAttr('disabled');
		} else {
			field.attr('disabled','disabled');
		}
	}

	handleEditFormSubmit = function(e) {
		if ($.trim($('[name="title"]').val()) == '') {
			alert(elgg.echo('event_calendar:edit_form:error:missing_title'));
			e.preventDefault();
		}
	}

	setRepeatingClass = function(e) {
		var id = $(this).attr('id');
		if ($("[name='"+id+"-value']").val() == 1) {
			$(this).removeClass('event-calendar-repeating-unselected');
			$(this).addClass('event-calendar-repeating-selected');
		}
	}

	handleRepeatingSelect = function(e) {
		$(this).removeClass('event-calendar-repeating-unselected');
		$(this).addClass('event-calendar-repeating-selected');
		var id = $(this).attr('id');
		$("[name='"+id+"-value']").val(1);
	}

	handleRepeatingUnselect = function(e) {
		$(this).removeClass('event-calendar-repeating-selected');
		$(this).addClass('event-calendar-repeating-unselected');
		var id = $(this).attr('id');
		$("[name='"+id+"-value']").val(0);
	}

	handleRegionChange = function(e) {
		url = $('#event-calendar-region-url-start').val()+"/"+escape($('#event-calendar-region').val());
		elgg.forward(url);
	}

	handleIcalPopup = function(e) {
		var message = elgg.echo('event_calendar:ical_popup_message')+"\n"+this.href;
		alert(message);
		return false;
	}

	handlePagedPersonalCalendarToggle = function() {
		guid = parseInt($(this).attr('id').substring('event_calendar_paged_checkbox_'.length));
		togglePagedPersonalCalendar(guid);
	}

	togglePagedPersonalCalendar = function(guid) {
		elgg.action('event_calendar/toggle_personal_calendar',
		{
			data: {event_guid: guid},
			success: function (res) {
						var success = res.success;
						var msg = res.message;
						if (success) {
							elgg.system_message(msg,2000);
						} else {
							elgg.register_error(msg,2000);
						}
						//$('#event_calendar_paged_messages').html(msg);
						if (!success) {
							// action failed so toggle checkbox
							$("#event_calendar_paged_checkbox_"+guid).attr('checked',!$("#event_calendar_paged_checkbox_"+guid).attr('checked'));
						}
					}
		});
	}

	/**
	 * Add/Remove an event from users personal calendar
	 */
	toggleDisplayPagePersonalCalendar = function() {
		var event_guid = $(this).data('event-guid');
		var user_guid = $(this).data('user-guid');

		elgg.action('event_calendar/toggle_personal_calendar', {
			data: {
				event_guid: event_guid,
				user_guid: user_guid,
				other: 'yes'
			},
			success: function (json) {
				if (json.success) {
					$('[data-user-guid=' + user_guid + ']').toggle();
				} else {
					elgg.register_error(json.message, 2000);
				}
			}
		});
	}

	return init();
});