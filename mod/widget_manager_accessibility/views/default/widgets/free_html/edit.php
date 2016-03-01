<?php
$widget = $vars["entity"];

$widgetId = $widget->getGUID();
?>
<div>
	<?php echo '<label for="'.$widgetId.'">'.elgg_echo("widgets:free_html:settings:html_content") .'</label>'; ?><br />
	<?php echo elgg_view("input/longtext", array("name" => "params[html_content]", "value" => $widget->html_content, 'id'=> $widgetId,)); ?>
</div>
