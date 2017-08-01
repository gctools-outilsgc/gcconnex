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
		echo "This widget has not been set yet";
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
				break;
			case "Hashtags":
				echo '<a href="'.$widget->embed_url.'" class="twitter-hashtag-button" data-show-count="false">'.$widget->embed_title.'</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
				break;
			default:
				break;
		}

/*

Tweet
<blockquote class="twitter-tweet">
	<p lang="en" dir="ltr">Sunsets don&#39;t get much better than this one over 
		<a href="https://twitter.com/GrandTetonNPS">@Twitter</a>. 
		<a href="https://twitter.com/hashtag/nature?src=hash">#nature</a> 
		<a href="https://twitter.com/hashtag/sunset?src=hash">#sunset</a> 
		<a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>
	&mdash; US Dept of Interior (@Interior) 
	<a href="https://twitter.com/Interior/status/463440424141459456">May 5, 2014</a>
</blockquote> 
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

*/
	}

?>

</div>

