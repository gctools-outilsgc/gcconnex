<?php 
	$topic_count = sanitise_int($vars["entity"]->topic_count, false);
	if(empty($topic_count)){
		$topic_count = 4;
	}		
?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?>
	<?php echo elgg_view("input/dropdown", array("name" => "params[topic_count]", "options" => range(1, 10), "value" => $topic_count)); ?>
</div>