<?php
$widget = $vars["entity"];
?>
<div>
	<?php echo elgg_echo("widgets:free_html:settings:html_content"); ?><br />
	<?php echo elgg_view("input/longtext", array("name" => "params[html_content]", "value" => $widget->html_content)); ?>
</div>
