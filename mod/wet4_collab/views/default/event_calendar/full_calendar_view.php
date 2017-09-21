<?php

elgg_load_js('elgg.full_calendar');
elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_load_css('elgg.full_calendar');

$timeformat = elgg_get_plugin_setting('timeformat', 'event_calendar') == 24 ? 'H(:mm)' : 'h(:mm)t';
// TODO: is there an easy way to avoid embedding JS?
?>
<style type="text/css">
	.fc-toolbar {
		font-size: 90%;
	}
	a.fc-event:visited {
	    color: #fff;
	}
    @media print {
    	html, html * { visibility: hidden; }
    	header, footer, main > h2, main > div.row > section:first-child, div.row.pagedetails { display: none; }
    	#calendar, #calendar * { visibility: visible; }
		#calendar a[href]:after { visibility: hidden; }
		#calendar .fc-scroller { height: auto !important; }
    }
</style>
<script>

Date.prototype.addHours = function(h){
    this.setHours(this.getHours() + h);
    return this;
}

var goToDateFlag = 0;

handleEventClick = function(event) {
	if (event.url) {
		if (event.is_event_poll) {
			window.location.href = event.url;
		} else {
			window.location.href = event.url;
			//$.colorbox({'href':event.url});
		}
		return false;
	}
};

handleDayClick = function(date, jsEvent, view) {
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

/*
handleEventDrop = function(event, delta, revertFunc) {
	var dayDelta = delta.days;
	var minuteDelta = delta.minutes;
	if (!event.is_event_poll && !confirm("<?php echo elgg_echo('event_calendar:are_you_sure'); ?>")) {
		revertFunc();
	} else {
		if (event.is_event_poll) {
			if (confirm("<?php echo elgg_echo('event_calendar:resend_poll_invitation'); ?>")) {
				var resend = 1;
			} else {
				resend = 0;
			}
			var data = {event_guid: event.guid, startTime: event.start.toISOString(), dayDelta: dayDelta, minuteDelta: minuteDelta, resend: resend};
		} else {
			data = {event_guid: event.guid, startTime: event.start.toISOString(), dayDelta: dayDelta, minuteDelta: minuteDelta};
		}
		elgg.action('event_calendar/modify_full_calendar',
			{
				data: data,
				success: function (res) {
					console.log(data, res);
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
};
*/

getISODate = function(d) {
	var year = d.year();
	var month = d.month()+1;
	month =	month < 10 ? '0' + month : month;
	var day = d.day();
	day = day < 10 ? '0' + day : day;
	return year +"-"+month+"-"+day;
}

handleEventRender = function(event, element, view) {
	/*if (event.is_event_poll) {
		element.draggable = false;
	}*/
}

getEvents = function(start, end, timezone, callback) {
	var start_date = getISODate(start);
	var end_date = getISODate(end);
	var url = "event_calendar/get_fullcalendar_events/"+start_date+"/"+end_date+"/<?php echo $vars['filter']; ?>/<?php echo $vars['group_guid']; ?>";
	var lang = '<?php echo get_current_language(); ?>';

	elgg.getJSON(url, {
		success: function(events) {
			var newEvents = [];
			$.each(events, function(i, item) {
				var titleParsed = $.parseJSON(item.title);
				var title = titleParsed[lang] ? titleParsed[lang] : titleParsed['en'];
			    newEvents.push({'title': title, 'start': new Date(item.start), 'end': new Date(item.end), 'allDay': item.allDay, 'url': item.url, 'guid': item.guid, 'id': item.id, 'is_event_poll': item.is_event_poll });
			});
			callback(newEvents);
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

fullcalendarInit = function() {
	var loadFullCalendar = function() {
		var locale = $.datepicker.regional[elgg.get_language()];

		if (!locale) {
			locale = $.datepicker.regional[''];
		}

		setTimeout(function(){
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listYear'
				},
				month: <?php echo date('n', strtotime($vars['start_date'])) - 1; ?>,
				ignoreTimezone: true,
				editable: false,
				slotMinutes: 15,
				eventRender: handleEventRender,
				// eventDrop: handleEventDrop,
				eventClick: handleEventClick,
				dayClick: handleDayClick,
				viewRender: handleViewDisplay,
				events: getEvents,
				eventColor: '#46246A',
				isRTL:  locale.isRTL,
				firstDay: locale.firstDay,
				monthNames: locale.monthNames,
				monthNamesShort: locale.monthNamesShort,
				dayNames: locale.dayNames,
				dayNamesShort: locale.dayNamesShort,
				buttonText: {
					today: locale.currentText,
				<?php if ( get_current_language() == "en" ){ ?> // Only way to translate without bug
					month: elgg.echo('Month'),
					week: elgg.echo('Week'),
					day: elgg.echo('Day'),
					list: elgg.echo('List')
				<?php } else { ?>
					month: elgg.echo('Mois'),
					week: elgg.echo('Semaine'),
					day: elgg.echo('Jour'),
					list: elgg.echo('Liste')
				<?php } ?>
				},
				timeFormat: "<?php echo $timeformat; ?>",
				eventDataTransform: function (event){
					if(event.allDay) {
						event.end = new Date(event.end).addHours(24);
					}
					return event;
				}
			});
		}, 500);
	}

	elgg.get({
		url: '/vendors/jquery/i18n/jquery.ui.datepicker-' + elgg.get_language() + '.js',
		dataType: "script",
		cache: true,
		success: loadFullCalendar,
		error: loadFullCalendar, // english language is already loaded
	});
}

elgg.register_hook_handler('init', 'system', fullcalendarInit);
</script>

<div id='calendar'></div>
<button class="mtm btn btn-primary" onclick="window.print();"><?php echo elgg_echo('event_calendar:print'); ?></button>
<input type="hidden" id="event-calendar-selected-date" />
