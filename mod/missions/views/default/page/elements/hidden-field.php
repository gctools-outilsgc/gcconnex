<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Creates a field which can toggled between hidden and displayed using Javascript.
 */
 $text = $vars['toggle_text'];
 $append = $vars['toggle_id'];
 $content = $vars['hidden_content'];
 $additional_text = $vars['additional_text'];
 if($vars['field_bordered']) {
 	$bordering = "brdr-tp brdr-rght brdr-bttm brdr-lft";
 }
 
 $field_id = 'hidden-field-' . $append;
 $icon_id = 'toggle-icon-' . $append;
 
 $toggle = elgg_view('output/url', array(
 		'href' => 'javascript:;',
		'text' => $text,
 		'onclick' => 'hidden_field_toggle(this)',
 		'id' => $append
 ));
 ?>
 
 <div style="display:inline-block;max-width:500px;">
 	<i class="fa fa-chevron-right" id="<?php echo $icon_id; ?>"></i>
 	<span><?php echo $toggle; ?></span>
 	<span style="font-style:italic;"><?php echo $additional_text; ?></span>
</div>
 <div class="<?php echo $bordering; ?>" id="<?php echo $field_id; ?>" style="display:none;padding:8px;">
 	<?php echo $content; ?>
 </div>
 <!--<div>
 	<div>
 		<noscript>
 			<?php //echo $content; ?>
 		</noscript>
 	</div>
 </div>-->
 
 <script>
	function hidden_field_toggle(toggle) {
		append = toggle.id;
		field = document.getElementById('hidden-field-'.concat(append));
		icon = document.getElementById('toggle-icon-'.concat(append));
		
		if(field.style.display == 'none') {
			field.style.display = 'block';
			icon.className = 'fa fa-chevron-down';
		}
		else {
			field.style.display = 'none';
			icon.className = 'fa fa-chevron-right';
		}
	}
 </script>