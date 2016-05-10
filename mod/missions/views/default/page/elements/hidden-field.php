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
 $hidden_content_text = $vars['toggle_text_hidden'];
 $append = $vars['toggle_id'];
 $content = $vars['hidden_content'];
 $pre_content = $vars['hideable_pre_content'];
 $additional_text = $vars['additional_text'];
 if($vars['field_bordered']) {
 	$bordering = "brdr-tp brdr-rght brdr-bttm brdr-lft";
 }
 
 $field_id = 'hidden-field-' . $append;
 $pre_field_id = 'hidden-pre-field-' . $append;
 $icon_id = 'toggle-icon-' . $append;
 
 $toggle = elgg_view('output/url', array(
 		'href' => 'javascript:;',
		'text' => $text,
 		'onclick' => 'hidden_field_toggle(this)',
 		'id' => $append
 ));
 ?>
 
<div id="<?php echo $pre_field_id; ?>" style="display:inline-block;">
	<?php echo $pre_content; ?>
</div>
<div style="display:inline-block;max-width:500px;">
 	<i class="fa fa-chevron-right" id="<?php echo $icon_id; ?>"></i>
 	<span><?php echo $toggle; ?></span>
 	<span style="font-style:italic;"><?php echo $additional_text; ?></span>
</div>
 <div class="<?php echo $bordering; ?>" id="<?php echo $field_id; ?>" style="display:none;padding:8px;">
 	<?php echo $content; ?>
 </div>
 
 <script>
	function hidden_field_toggle(toggle) {
		var field = document.getElementById('<?php echo $field_id; ?>');
		var pre_field = document.getElementById('<?php echo $pre_field_id; ?>');
		var icon = document.getElementById('<?php echo $icon_id; ?>');
		var text = document.getElementById('<?php echo $append; ?>');
		
		if(field.style.display == 'none') {
			if('<?php echo $hidden_content_text; ?>') {
				text.innerHTML = '<?php echo $hidden_content_text; ?>';
			}
			field.style.display = 'block';
			pre_field.style.display = 'none';
			icon.className = 'fa fa-chevron-down';
		}
		else {
			text.innerHTML = '<?php echo $text ?>';
			field.style.display = 'none';
			pre_field.style.display = 'inline-block';
			icon.className = 'fa fa-chevron-right';
		}
	}
 </script>