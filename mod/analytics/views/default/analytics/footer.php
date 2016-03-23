<?php

// do we have the plugin configured correctly
if (!elgg_get_plugin_setting('analyticsSiteID', 'analytics')) {
	return;
}

$trackActions = analytics_google_track_actions_enabled();
$trackEvents = analytics_google_track_events_enabled();

// do we track actions/events
if (!$trackActions && !$trackEvents) {
	return;
}

?>
<script type='text/javascript' id='analytics_ajax_result'>

	$(document).ajaxSuccess(function(event, XMLHttpRequest, ajaxOptions) {
		
		elgg.get('analytics/ajax_success', {
			global: false,
			success: function(data) {
				if (data) {
					var temp = document.createElement('script');
					temp.setAttribute('type', 'text/javascript');
					temp.innerHTML = data;
					
					$('#analytics_ajax_result').after(temp);
				}
			}
		});
	});
</script>
