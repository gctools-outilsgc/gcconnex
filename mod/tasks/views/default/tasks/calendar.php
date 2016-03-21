
<script type="text/javascript" >
;(function($) {
	console.log($, $.fullCalendar);
	
	$(document).ready(function() {
	
		$('#task-calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?php echo date('Y-m-d'); ?>',
			editable: true,
			eventResize: function(event, delta, revertFunc) {
				if (!confirm("Are you sure to change " + event.title + " to " + event.start.format() + " ?")) {
					revertFunc();
				}else{
					elgg.action('tasks/edit',{
						data: {
							
							title : event.title,
							start_date: event.start.format(),
							end_date: event.end.format(),
							
							description : event.description,
							task_type :event.task_type,
							status :event.status,
							assigned_to :event.assigned_to,
							percent_done :event.percent_done,
							work_remaining :event.work_remaining,
							tags :event.tags,
							access_id :event.access_id,
							write_access_id :event.write_access_id,
							
							task_guid: event.id,
							container_guid: event.container_guid,
							parent_guid: event.parent_guid,
							
							__elgg_ts: elgg.security.token.__elgg_ts,
							__elgg_token:elgg.security.token.__elgg_token,
						},
						
						success: function(json) {
							console.log(json);
							if (json.status == -1){
								alert(json.system_messages.error[0]);
								revertFunc();
							}else{
								alert("Updated Successfully");
							}
						}
					});
				
				}

			},
			eventDrop: function(event, delta, revertFunc) {

				if (!confirm("Are you sure to move " + event.title + " to " + event.start.format() + " ?")) {
					revertFunc();
				}else{
					elgg.action('tasks/edit',{
						data: {
							
							title : event.title,
							start_date: event.start.format(),
							end_date: event.end.format(),
							
							description : event.description,
							task_type :event.task_type,
							status :event.status,
							assigned_to :event.assigned_to,
							percent_done :event.percent_done,
							work_remaining :event.work_remaining,
							tags :event.tags,
							access_id :event.access_id,
							write_access_id :event.write_access_id,
							
							task_guid: event.id,
							container_guid: event.container_guid,
							parent_guid: event.parent_guid,
							
							__elgg_ts: elgg.security.token.__elgg_ts,
							__elgg_token:elgg.security.token.__elgg_token,
						},
						
						success: function(json) {
							console.log(json);
							if (json.status == -1){
								alert(json.system_messages.error[0]);
								revertFunc();
							}else{
								alert("Updated Successfully");
							}
						}
					});
				
				}

			},
			events: {
				url	: '<?php echo elgg_get_site_url() . 'tasks/get-tasks'; ?>',
				data : {
					owner  : '<?php echo $vars['owner']; ?>',
					filter : '<?php echo $vars['filter']; ?>'
				},
				error: function() {
					$('#script-warning').show();
				}
			},
			loading: function(bool) {
				$('#loading').toggle(bool);
			}
		});
		
	});
})(jQuery);
</script>

<div id='task-calendar-script-warning'>
	<code><?php echo elgg_get_site_url() . 'tasks/get-tasks'; ?></code> must be running.
</div>

<div id='task-calendar-loading'>loading...</div>

<div id='task-calendar'></div>

