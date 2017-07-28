<?php

$widget = $vars["entity"];

$height = sanitise_int($widget->height, false);

$widget_id = $widget->widget_id;

if (!empty($widget_id)) {
	if ($height) {
		$height = "height='" . $height . "'";
	}
	?>
	<div style='height:300px; overflow:scroll;'>
	<a class="twitter-timeline" href="https://twitter.com/TwitterDev/timelines/539487832448843776"> National Park Tweets - Curated tweets by TwitterDev </a> 
	<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
	<?php
} else {
	echo elgg_echo("widgets:twitter_search:not_configured");
}
