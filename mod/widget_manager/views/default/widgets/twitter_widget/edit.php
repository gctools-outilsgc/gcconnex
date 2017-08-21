<?php

$widget = $vars["entity"];
$height = sanitise_int($widget->height, false);

?>

<?php // help link to create the twitter widget on Elgg ?>
<div class='elgg-subtext'>
	<?php echo elgg_view("output/url", array("href" => "https://twitter.com/settings/widgets", "target" => "_blank", "text" => elgg_echo("widgets:twitter_search:embed_code:help"))); ?>
</div>

<div>
	<?php // Plain text box for the Twitter Widget embed code ?>
	<p> <?php echo elgg_echo("widgets:twitter_search:embed_code"); ?> </p>
	<p> <?php echo elgg_view("input/plaintext", array("name" => "params[embed_code]", "value" => $widget->embed_url)); ?> </p>

	<p> <?php echo elgg_echo("widgets:twitter_search:height"); ?> </p>
	<p> <?php echo elgg_view("input/text", array("name" => "params[height]", "value" => $height, "size" => "4", "maxlength" => "4")); ?> </p>
</div>


