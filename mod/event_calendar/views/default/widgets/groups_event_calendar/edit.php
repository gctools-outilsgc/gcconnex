<?php

$count = sanitise_int($vars["entity"]->events_count, false);
if(empty($count)){
	$count = 4;
}

?>
<div>
	<?php echo elgg_echo("event_calendar:num_display"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[events_count]", "value" => $count, "size" => "4", "maxlength" => "4")); ?>
</div>
