<?php
$widget = $vars["entity"];
$widgetId = $widget->getGUID();
$rss_count = sanitise_int($widget->rss_count, false);
if (empty($rss_count)) {
	$rss_count = 4;
}

$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);


// @todo: use google feed finder to autocomplete/search rss feeds "//ajax.googleapis.com/ajax/services/feed/find?v=1.0&";
?>
<div>
    <?php echo '<label for="rssfeed-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:rssfeed").'</label>';?><br />
    <?php echo elgg_view("input/text", array("name" => "params[rssfeed]", "value" => $widget->rssfeed, 'id'=>'rssfeed-'.$widgetId,)); ?>
</div>

<div>
	<?php
	echo '<label for="rss_count-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:rss_count") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[rss_count]", "options" => range(1,10), "value" => $rss_count, 'id'=>'rss_count-'.$widgetId,));
	?>
</div>

<div>
	<?php
	echo '<label for="show_feed_title-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:show_feed_title") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[show_feed_title]", "options_values" => array_reverse($yesno_options), "value" => $widget->show_feed_title, 'id'=>'show_feed_title-'.$widgetId,));
	?>
</div>

<div>
	<?php
	echo '<label for="excerpt-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:excerpt") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[excerpt]", "options_values" => $yesno_options, "value" => $widget->excerpt, 'id'=>'excerpt-'.$widgetId,));
	?>
</div>

<div>
	<?php
	echo '<label for="show_item_icon-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:show_item_icon") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[show_item_icon]", "options_values" => array_reverse($yesno_options), "value" => $widget->show_item_icon, 'id'=>'show_item_icon-'.$widgetId,));
	?>
</div>

<div>
	<?php
	echo '<label for="post_date-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:post_date") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[post_date]", "options_values" => $yesno_options, "value" => $widget->post_date, 'id'=>'post_date-'.$widgetId,));
	?>
</div>

<div>
	<?php
	echo '<label for="show_in_lightbox-'.$widgetId.'">'.elgg_echo("widgets:rss:settings:show_in_lightbox") . "</label> ";
	echo elgg_view("input/dropdown", array("name" => "params[show_in_lightbox]", "options_values" => array_reverse($yesno_options), "value" => $widget->show_in_lightbox, 'id'=>'show_in_lightbox-'.$widgetId,));
	?>
</div>
	