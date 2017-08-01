define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	var goToDateFlag = 0;

	handleEventClick = function(event) {
		if (event.url) {
			if (event.is_event_poll) {
				window.location.href = event.url;
			} else {
				$.colorbox({'href':event.url});
			}
			return false;
		}
	}

	handleDayClick = function(date,allDay,jsEvent,view) {
		var iso = getISODate(date);
		var link = $('.elgg-menu-item-event-calendar-0add').find('a').attr('href');
		var ss = link.split('/');
		var link = $('.elgg-menu-item-event-calendar-0add').find('a').attr('href');
		var ss = link.split('/');
		var last_ss = ss[ss.length-1];
		var group_guid;
		if (last_ss == 'add') {
			group_guid = 0;
		} else if (last_ss.split('-').length == 3) {
			group_guid = ss[ss.length-2];
		} else {
			group_guid = last_ss;
		}
		var url = elgg.get_site_url();
		$('.fc-widget-content').removeClass('event-calendar-date-selected');
		var current_iso = $('#event-calendar-selected-date').val();
		if (current_iso == iso) {
			// deselect
			$('#event-calendar-selected-date').val("");
			$('.elgg-menu-item-event-calendar-0add').find('a').attr('href',url+'event_calendar/add/'+group_guid);
			$('.event-calendar-button-add').attr('href',url+'event_calendar/add/'+group_guid);
			$('.elgg-menu-item-event-calendar-1schedule').find('a').attr('href',url+'event_calendar/schedule/'+group_guid);
		} else {
			$('#event-calendar-selected-date').val(iso);
			$('.elgg-menu-item-event-calendar-0add').find('a').attr('href',url+'event_calendar/add/'+group_guid+'/'+iso);
			$('.event-calendar-button-add').attr('href',url+'event_calendar/add/'+group_guid+'/'+iso);
			$('.elgg-menu-item-event-calendar-1schedule').find('a').attr('href',url+'event_calendar/schedule/'+group_guid+'/'+iso);

			$(this).addClass('event-calendar-date-selected');
		}
	}

	handleEventDrop = function(event,dayDelta,minuteDelta,allDay,revertFunc) {
		if (!event.is_event_poll && !confirm(elgg.echo('event_calendar:are_you_sure'))) {
			revertFunc();
		} else {
			if (event.is_event_poll) {
				if (confirm(elgg.echo('event_calendar:resend_poll_invitation'))) {
					var resend = 1;
				} else {
					resend = 0;
				}
				var data = {event_guid: event.guid, startTime: event.start.toISOString(), dayDelta: dayDelta, minuteDelta: minuteDelta, resend: resend, minutes: event.minutes, iso_date: event.iso_date};
			} else {
				data = {event_guid: event.guid, startTime: event.start.toISOString(), dayDelta: dayDelta, minuteDelta: minuteDelta};
			}
			elgg.action('event_calendar/modify_full_calendar',
				{
					data: data,
					success: function (res) {
						var success = res.success;
						var msg = res.message;
						if (!success) {
							elgg.register_error(msg,2000);
							revertFunc()
						} else {
							event.minutes = res.minutes;
							event.iso_date = res.iso_date;
						}
					}
				}
			);
		}
	}

	getISODate = function(d) {
		var year = d.getFullYear();
		var month = d.getMonth()+1;
		month = month < 10 ? '0' + month : month;
		var day = d.getDate();
		day = day < 10 ? '0' + day : day;
		return year +"-"+month+"-"+day;
	}

	handleEventRender = function(event, element, view) {
		/*if (event.is_event_poll) {
			element.draggable = false;
		}*/
	}

	handleGetEvents = function(start, end, callback) {
		var start_date = getISODate(start);
		var end_date = getISODate(end);

		var filter = $('#calendar').data('filter');
		var groupguid = $('#calendar').data('groupguid');
		var region = $('#calendar').data('region');

		var url = "event_calendar/get_fullcalendar_events/"+start_date+"/"+end_date+"/"+filter+"/"+groupguid+"/"+region;
		elgg.getJSON(url, {success:
			function(events) {
				//alert(JSON.stringify(events));
				callback(events);
			}
		});
		// reset date links and classes
		//$('.fc-widget-content').removeClass('event-calendar-date-selected');
		var link = $('.elgg-menu-item-event-calendar-0add').find('a').attr('href');
		if (link != undefined) {
			var ss = link.split('/');
			var last_ss = ss[ss.length-1];
			var group_guid;
			if (last_ss == 'add') {
				group_guid = 0;
			} else if (last_ss.split('-').length == 3) {
				group_guid = ss[ss.length-2];
			} else {
				group_guid = last_ss;
			}
			var url = elgg.get_site_url();
			$('.elgg-menu-item-event-calendar-0add').find('a').attr('href',url+'event_calendar/add/'+group_guid);
			$('.elgg-menu-item-event-calendar-1schedule').find('a').attr('href',url+'event_calendar/schedule/'+group_guid);
		}
	}

	handleViewDisplay = function(view) {
		// TODO: finish this, need to highlight selected date if any
		var current_iso = $('#event-calendar-selected-date').val();
		if (view == 'month') {
			goToDateFlag = 0;
		} else if (goToDateFlag == 0 && current_iso != "") {
			goToDateFlag = 1;
			var a = current_iso.split("-");
			$('#calendar').fullCalendar('gotoDate',parseInt(a[0],10),parseInt(a[1],10)-1,parseInt(a[2],10));
			//$('.fc-widget-content').removeClass('event-calendar-date-selected');
			//$(".fc-widget-content[data-date='"+ciso+"']").addClass('event-calendar-date-selected');
		}

		//$(".fc-widget-content[data-date='20120105']")
	}

	function init() {
		var timeformat = $('#calendar').data('timeformat');
		var startdate = $('#calendar').data('startdate');

		var loadFullCalendar = function() {
			var locale = $.datepicker.regional[elgg.get_language()];

			if (!locale) {
				locale = $.datepicker.regional[''];
			}

			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				month: startdate,
				ignoreTimezone: true,
				editable: true,
				slotMinutes: 15,
				eventRender: handleEventRender,
				eventDrop: handleEventDrop,
				eventClick: handleEventClick,
				dayClick: handleDayClick,
				events: handleGetEvents,
				viewDisplay: handleViewDisplay,

				isRTL:  locale.isRTL,
				firstDay: locale.firstDay,
				monthNames: locale.monthNames,
				monthNamesShort: locale.monthNamesShort,
				dayNames: locale.dayNames,
				dayNamesShort: locale.dayNamesShort,
				buttonText: {
					today: locale.currentText,
					month: elgg.echo('event_calendar:month_label'),
					week: elgg.echo('event_calendar:week_label'),
					day: elgg.echo('event_calendar:day_label')
				},
				timeFormat: timeformat,
			});
		}

		var deps = ['jquery-ui', 'jquery-ui/datepicker'];
		if (elgg.get_language() != 'en') {
			deps.push('jquery-ui/i18n/datepicker-'+ elgg.get_language() + '.min');
		}
		require(deps, loadFullCalendar);
	}

	return init();

});