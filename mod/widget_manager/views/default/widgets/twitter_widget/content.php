<?php

$widget = $vars["entity"];

$height = sanitise_int($widget->height, false);
$widget_id = $widget->widget_id;
$widget_type = $widget->widget_type;
$widget_twitter_title = $widget->twitter_title;

?>

<div style='height:300px; overflow:scroll;'>


<?php 

	if (!$widget->embed_url) {
		echo elgg_echo('widgets:twitter_search:not_configured');
		
	} else {

		switch ($widget_type) {

			case "Collection":
			case "Profile":
			case "List":
			case "Likes":
			case "Handles":
				echo '<a class="twitter-timeline" href="'.$widget->embed_url.'">'.$widget->embed_title.'</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
				break;
			case "Tweets":
				echo '<blockquote class="twitter-tweet">'.$widget->embed_url.'</blockquote> 
						<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
				break;
			case "Hashtags":
				echo '<a href="'.$widget->embed_url.'" class="twitter-hashtag-button" data-show-count="false">'.$widget->embed_title.'</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
				break;
			default:
				break;
		}
	}

?>

</div>

