<?php 

	$widget = $vars["entity"];
	
	$query = $widget->query;
	$title = $widget->tw_title;
	$sub = $widget->tw_subtitle;
	
	$height = sanitise_int($widget->height, false);
	if(empty($height)){
		$height = 300;
	}
	
	$background = $widget->background;
	if(empty($background)){
		$background = "4690d6";
	}

?>
<div>
	<?php echo elgg_echo("widgets:twitter_search:query"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[query]", "value" => $query)); ?>
	<div class='elgg-subtext'>
		<?php echo elgg_view("output/url", array("href" => "http://support.twitter.com/groups/31-twitter-basics/topics/110-search/articles/71577-how-to-use-advanced-twitter-search", "target" => "_blank", "text" => elgg_echo("widgets:twitter_search:query:help"))); ?>
	</div>
</div>

<div>
	<?php echo elgg_echo("widgets:twitter_search:title"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[tw_title]", "value" => $title)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:twitter_search:subtitle"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[tw_subtitle]", "value" => $sub)); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:twitter_search:height"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[height]", "value" => $height, "size" => "4", "maxlength" => "4")); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:twitter_search:background"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[background]", "value" => $background, "size" => "6", "maxlength" => "6")); ?>
</div>