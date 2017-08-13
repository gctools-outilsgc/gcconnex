define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");
	
	function init() {
		$('.event-calendar-datepicker-inline').each(function () {
			var $this = $(this);

			var selectedWeek = $this.data('selectedweek');
			var name = $this.data('name');
			var linkbit = $this.data('linkbit');
			var startdate = $this.data('startdate');
			var enddate = $this.data('enddate');
			var mode = $this.data('mode');
			
			var highlightWeek = function(d) {
				if (!selectedWeek) {
					return [true,''];
				}

				var dayOfWeek = d.getUTCDay();
				var weekNumber = $.datepicker.iso8601Week(d);
				if (dayOfWeek == 6) {
					weekNumber += 1;
				}

				if (selectedWeek == weekNumber) {
					return [true,'week-highlight'];
				}
				return [true,''];
			}

			var loadDatePickerInline = function() {
				var done_loading = false;
				$("#"+name).datepicker( {
					onChangeMonthYear: function(year, month, inst) {
						if(inst.onChangeToday) {
							day = inst.selectedDay;
						} else {
							day = 1;
						}
						if (done_loading) {
							// in this case the mode is forced to month
							document.location.href = linkbit.replace('%s', year+'-'+month+'-1');
						}
					},
					onSelect: function(date) {
						// jump to the new page
						document.location.href = linkbit.replace('%s', date.substring(0,10));
					},
					prevText: "<<<",
					nextText: ">>>",
					dateFormat: "yy-mm-dd",
					defaultDate: startdate+' - '+enddate,
					beforeShowDay: highlightWeek
				});

				var start_date = $.datepicker.parseDate("yy-mm-dd", startdate);
				var end_date = $.datepicker.parseDate("yy-mm-dd", enddate);
				// not sure why this is necessary, but it seems to be
				if (mode == "month") {
					end_date += 1;
				}

				$("#"+name).datepicker("setDate", start_date, end_date);
				done_loading = true;
			};
			
			if ($("#"+name).length && elgg.get_language() == 'en') {
				loadDatePickerInline();
			} else if ($("#"+name).length) {
				elgg.get({
					url: elgg.config.wwwroot + 'vendors/jquery/i18n/jquery.ui.datepicker-'+ elgg.get_language() +'.js',
					dataType: "script",
					cache: true,
					success: loadDatePickerInline,
					error: loadDatePickerInline // english language is already loaded.
				});
			}
		});
	}

	return init();
});