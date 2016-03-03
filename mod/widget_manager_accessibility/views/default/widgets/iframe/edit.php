<?php
$widget = $vars["entity"];
$widgetId = $widget->getGUID();
?>
<div>
    <?php echo '<label for="params[iframe_url]-'.$widgetId.'">'.elgg_echo("widgets:iframe:settings:iframe_url").'</label>'; ?><br />
    <?php echo elgg_view("input/text", array("name" => "params[iframe_url]", "value" => $widget->iframe_url, 'id'=>'params[iframe_url]-'.$widgetId,)); ?>
</div>
<div>
    <?php echo '<label for="params[iframe_height]-'.$widgetId.'">'.elgg_echo("widgets:iframe:settings:iframe_height").'</label>'; ?><br />
    <?php echo elgg_view("input/text", array("name" => "params[iframe_height]", "value" => $widget->iframe_height,'id'=>'params[iframe_height]-'.$widgetId,)); ?>
</div>
