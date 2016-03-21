<?php

$widget = $vars["entity"];

$height = sanitise_int($widget->height, false);

$widget_id = $widget->widget_id;

if (!empty($widget_id)) {
	if ($height) {
		$height = "height='" . $height . "'";
	}
	?>
	<a class="twitter-timeline" data-dnt="true" data-widget-id="<?php echo $widget_id; ?>" <?php echo $height; ?>></a>
	<script>
		$(document).ready(function() {
			require(["widget_manager/widgets/twitter_search"], function (twitter_search) {
				twitter_search();
			});
		});
	</script>
	<?php
} else {
	echo elgg_echo("widgets:twitter_search:not_configured");
}
