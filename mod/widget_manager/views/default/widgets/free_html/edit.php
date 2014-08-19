<?php 
	$widget = $vars["entity"];
	
?>
<div>
	<?php echo elgg_echo("widgets:free_html:settings:html_content"); ?><br /> 
	<?php echo elgg_view("input/plaintext", array("name" => "params[html_content]", "value" => $widget->html_content)); ?>
</div>
