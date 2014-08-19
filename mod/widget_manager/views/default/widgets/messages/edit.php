<?php

	$max_messages = sanitise_int($vars["entity"]->max_messages, false);
	if(empty($max_messages)){
		$max_messages = 5;
	}

?>
<div>
	<?php echo elgg_echo("widget:numbertodisplay"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[max_messages]", "value" => $max_messages, "size" => "4", "maxlength" => "4")); ?>
</div>

<div>
	<?php echo elgg_echo("widgets:messages:settings:only_unread"); ?><br />
	<?php echo elgg_view('input/dropdown', array('name' => 'params[only_unread]','value' => $vars['entity']->only_unread, 'options_values' => array("yes" => elgg_echo("option:yes"), "no" => elgg_echo("option:no"))));  ?>
</div>