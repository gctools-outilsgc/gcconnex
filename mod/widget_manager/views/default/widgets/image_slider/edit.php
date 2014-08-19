<?php 

	$widget = $vars["entity"];
	
	$max_slider_options = 5;
	
	$seconds_per_slide = sanitise_int($widget->seconds_per_slide);
	if(empty($seconds_per_slide) || !is_int($seconds_per_slide)){
		$seconds_per_slide = 10;
	}
	
	$slider_height = sanitise_int($widget->slider_height);
	if(empty($slider_height) || !is_int($slider_height)){
		$slider_height = 300;
	}
	
	$overlay_color = $widget->overlay_color;
	if(empty($overlay_color)){
		$overlay_color = "4690D6";
	}
	
	$direction_options_values = array(
		"top" => elgg_echo("widget_manager:widgets:image_slider:direction:top"),
		"right" => elgg_echo("widget_manager:widgets:image_slider:direction:right"),
		"bottom" => elgg_echo("widget_manager:widgets:image_slider:direction:bottom"),
		"left" => elgg_echo("widget_manager:widgets:image_slider:direction:left"),
	);
	
	$slider_type_options = array(
		"s3slider" => elgg_echo("widget_manager:widgets:image_slider:slider_type:s3slider"),
		"flexslider" => elgg_echo("widget_manager:widgets:image_slider:slider_type:flexslider"),
	);
	
	for($i = 1; $i <= $max_slider_options; $i++){
			
		$direction = $widget->get("slider_" . $i . "_direction");
		if(empty($direction)){
			$direction = "top";
		}
		?>
		<span class='image_slider_settings'>
			<label onclick='$(this).next().toggle();'><?php echo elgg_echo("widget_manager:widgets:image_slider:title"); ?> - <?php echo $i; ?></label>
			<div>
				<div><?php echo elgg_echo("widget_manager:widgets:image_slider:label:url"); ?></div>
				<?php echo elgg_view("input/text", array("name" => "params[slider_" . $i . "_url]", "value" => $widget->get("slider_" . $i . "_url"))); ?>
				
				<div><?php echo elgg_echo("widget_manager:widgets:image_slider:label:text"); ?></div>
				<?php echo elgg_view("input/text", array("name" => "params[slider_" . $i . "_text]", "value" => $widget->get("slider_" . $i . "_text"))); ?>
				
				<div><?php echo elgg_echo("widget_manager:widgets:image_slider:label:link"); ?></div>
				<?php echo elgg_view("input/text", array("name" => "params[slider_" . $i . "_link]", "value" => $widget->get("slider_" . $i . "_link"))); ?>
				
				<div><?php echo elgg_echo("widget_manager:widgets:image_slider:label:direction"); ?></div>
				<?php echo elgg_view("input/dropdown", array("name" => "params[slider_" . $i . "_direction]", "options_values" => $direction_options_values, "value" => $direction)); ?>
			</div>
		</span><br />
		<?php 
	}	
?>
<hr />
<div>
	<?php echo elgg_echo("widget_manager:widgets:image_slider:slider_type"); ?><br />
	<?php echo elgg_view("input/dropdown", array("name" => "params[slider_type]", "value" => $widget->slider_type, "options_values" => $slider_type_options));?>
</div>

<div>
	<?php echo elgg_echo("widget_manager:widgets:image_slider:seconds_per_slide"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[seconds_per_slide]", "value" => $seconds_per_slide, "size" => "4", "maxlength" => "4"));?>
</div>

<div>
	<?php echo elgg_echo("widget_manager:widgets:image_slider:slider_height"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[slider_height]", "value" => $slider_height, "size" => "4", "maxlength" => "4"));?>
</div>

<div>
	<?php echo elgg_echo("widget_manager:widgets:image_slider:overlay_color"); ?><br />
	<?php echo elgg_view("input/text", array("name" => "params[overlay_color]", "value" => $overlay_color, "size" => "6", "maxlength" => "6"));?>
</div>
