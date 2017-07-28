<?php

$widget = $vars["entity"];

$height = sanitise_int($widget->height, false);

?>
<div>
	<?php echo elgg_echo("widgets:twitter_search:embed_code"); ?><br />
	<?php echo elgg_view("input/plaintext", array("name" => "params[embed_code]")); ?>
	<div class='elgg-subtext'>
		<?php echo elgg_view("output/url", array("href" => "https://twitter.com/settings/widgets", "target" => "_blank", "text" => elgg_echo("widgets:twitter_search:embed_code:help"))); ?>
	</div>
</div>

<div>
	<?php echo elgg_echo("widgets:twitter_search:height"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[height]", "value" => $height, "size" => "4", "maxlength" => "4")); ?>
</div>