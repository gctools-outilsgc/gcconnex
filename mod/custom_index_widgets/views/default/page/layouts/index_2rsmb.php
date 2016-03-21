<?php
		$leftcolumn_widgets = $vars['area3'];
		$middlecolumn_widgets = $vars['area2'];
		$rightcolumn_widgets = $vars['area1'];
		$layoutmode   = $vars['layoutmode']; //edit, index
?>
    <div class="first full col centered <?php echo elgg_echo($layoutmode); ?>">
		<div class="first onethird col">
			<div id="leftcolumn_widgets" class="half_<?php echo elgg_echo($layoutmode); ?>_box">
			<?php custom_index_show_widget_area($leftcolumn_widgets) ?>
			</div>
		</div>
		<div class="twothird col">
			<div id="middlecolumn_widgets" class="half_<?php echo elgg_echo($layoutmode); ?>_box">
			<?php custom_index_show_widget_area($middlecolumn_widgets) ?>
			</div>
		</div>
		<div class="first full col">
			<div id="rightcolumn_widgets" class="half_<?php echo elgg_echo($layoutmode); ?>_box">
			<?php custom_index_show_widget_area($rightcolumn_widgets) ?>
			</div>
        </div>
    </div>
	
