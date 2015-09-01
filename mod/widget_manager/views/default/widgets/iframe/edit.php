<?php
$widget = $vars["entity"];
?>
<div>
	<?php echo elgg_echo("widgets:iframe:settings:iframe_url"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[iframe_url]", "value" => $widget->iframe_url)); ?>
</div>
<div>
	<?php echo elgg_echo("widgets:iframe:settings:iframe_height"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[iframe_height]", "value" => $widget->iframe_height)); ?>
</div>
