<?php

$widget = $vars["entity"];

$height = sanitise_int($widget->height, false);
$widget_id = $widget->widget_id;
$widget_type = $widget->widget_type;
error_log(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> widget url:  {$widget->embed_url}");

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
		echo '<a class="twitter-timeline" href="'.$widget->embed_url.'">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
		break;
	case "Tweets":
		break;
	case "Hashtags":
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

Collection
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

Profile
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

List
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

Likes
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

Handles
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Twitter Title</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

Hashtags
<a href="https://twitter.com/intent/tweet?button_hashtag=LoveTwitter" class="twitter-hashtag-button" data-show-count="false">Tweet #LoveTwitter</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
*/
	
	//echo '<a href="'.$widget->embed_url.' class="twitter-timeline" data-show-count="false"> Twitter Title </a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
	

	/*
	<a href="https://twitter.com/intent/tweet?button_hashtag=LoveTwitter" class="twitter-hashtag-button" data-show-count="false">Tweet #LoveTwitter</a>
	<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	*/
		//echo $widget->embed_code;
		//echo "<a class='twitter-timeline' href='{}'></a>"; 
		//echo '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
	}
/*
<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Tweets by TwitterDev</a> 
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
*/
?>
<a class="twitter-timeline" href="<?php echo $widget->embed_url; ?>">Tweets by TwitterDev</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script> 
---------<br/>
<!--<a href="https://twitter.com/intent/tweet?button_hashtag=LoveTwitter" class="twitter-hashtag-button" data-show-count="false">Tweet #LoveTwitter</a>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>-->

<a class="twitter-timeline" href="https://twitter.com/TwitterDev">Tweets by TwitterDev</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script> 
<!--	<a class="twitter-timeline" href="https://twitter.com/TwitterDev/timelines/539487832448843776">National Park Tweets - Curated tweets by TwitterDev</a> 
	<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
-->
</div>
<!-- <a href="https://twitter.com/intent/tweet?screen_name=TwitterDev" class="twitter-mention-button" data-show-count="false">Tweet to @TwitterDev</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<a href="https://twitter.com/intent/tweet?button_hashtag=LoveTwitter" class="twitter-hashtag-button" data-show-count="false">Tweet #LoveTwitter</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
-->


