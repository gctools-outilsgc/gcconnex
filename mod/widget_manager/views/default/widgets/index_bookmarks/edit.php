<?php

$count = sanitise_int($vars["entity"]->bookmark_count, false);
if (empty($count)) {
	$count = 8;
}

?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[bookmark_count]", "value" => $count, "size" => "4", "maxlength" => "4")); ?>
</div>