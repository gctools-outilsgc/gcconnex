<?php

$widget = $vars["entity"];
$height = sanitise_int($widget->height, false);

?>
<div>
	<?php // Plain text box for the Twitter Widget embed code ?>
	<p> <?php echo elgg_echo("widgets:twitter_search:embed_code"); ?> </p>
	<p> <?php echo elgg_view("input/plaintext", array("name" => "params[embed_code]")); ?> </p>

	<?php // Dropdown for Twitter Widget type 
		$options = array("Collection", "Tweets", "Profile", "List", "Likes", "Handles", "Hashtags");
	?>
	<p> <?php echo elgg_echo("Widget Type"); ?> </p>
	<p> <?php echo elgg_view("input/dropdown", array("name" => "params[widget_type]", "options_values" => $options)); ?> </p>

	<?php // help link to create the twitter widget on Elgg ?>
	<div class='elgg-subtext'>
		<?php echo elgg_view("output/url", array("href" => "https://twitter.com/settings/widgets", "target" => "_blank", "text" => elgg_echo("widgets:twitter_search:embed_code:help"))); ?>
	</div>
</div>
ddfsdfsd
<div>
	<?php echo elgg_echo("widgets:twitter_search:height"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[height]", "value" => $height, "size" => "4", "maxlength" => "4")); ?>
</div>



<!--

Collection
<a class="twitter-timeline" href="https://twitter.com/TwitterDev/timelines/539487832448843776">National Park Tweets - Curated tweets by TwitterDev</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

Tweet
Profile
List
Likes
Handles
Hashtags





<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Sunsets don&#39;t get much better than this one over <a href="https://twitter.com/GrandTetonNPS">@GrandTetonNPS</a>. <a href="https://twitter.com/hashtag/nature?src=hash">#nature</a> <a href="https://twitter.com/hashtag/sunset?src=hash">#sunset</a> <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a></p>&mdash; US Dept of Interior (@Interior) <a href="https://twitter.com/Interior/status/463440424141459456">May 5, 2014</a></blockquote> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>


-->

