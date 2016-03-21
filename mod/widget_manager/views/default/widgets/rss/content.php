<?php
$widget = $vars["entity"];

$feed_url = $widget->rssfeed;

$limit = $widget->rss_count;
if (empty($limit)) {
	$limit = 4;
}

$post_date = true;
if ($widget->post_date == "no") {
	$post_date = false;
} 	

$show_feed_title = false;
if ($widget->show_feed_title == "yes") {
	$show_feed_title = true;
}
$excerpt = false;
if ($widget->excerpt == "yes") {
	$excerpt = true;
}

$show_item_icon = false;
if ($widget->show_item_icon == "yes") {
	$show_item_icon = true;
}

$show_in_lightbox = false;
if ($widget->show_in_lightbox == "yes") {
	$show_in_lightbox = true;
}

if ($feed_url) {
	
	$attributes = array(
		"id" => "widget-manager-rss-" . $widget->guid,
		"data-feed-url" => $feed_url,
		"data-limit" => $limit,
		"data-post-date" => $post_date,
		"data-show-feed-title" => $show_feed_title,
		"data-show-excerpt" => $excerpt,
		"data-show-item-icon" => $show_item_icon,
		"data-show-in-lightbox" => $show_in_lightbox,
	);
	
	?>
	<div <?php echo elgg_format_attributes($attributes);?>"></div>
	<script>
		$(document).ready(function() {
			require(["widget_manager/widgets/rss"], function (rss) {
				rss("#widget-manager-rss-<?php echo $widget->guid;?>");
			});
		});
	</script>
	<?php 
} else {
	echo elgg_echo("widgets:rss:error:notset");
}