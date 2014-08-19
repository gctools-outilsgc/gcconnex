<?php 
	$widget = $vars["entity"];
	
	$count = sanitise_int($widget->num_entities);
	if(empty($count)){
		$count = 10;
	}
?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[num_entities]", "value" => $count, "size" => "4", "maxlength" => "4"));?>
</div>
