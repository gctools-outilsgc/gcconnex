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
 $alignment = $vars['alignment'];
 $additional_class = $vars['additional_class'];
 if($alignment != '') {
 	$alignment = 'float:' . $alignment . ';';
 }
 
 if($vars['field_bordered']) {
 	$bordering = "brdr-tp brdr-rght brdr-bttm brdr-lft";
 }
 
 $field_id = 'hidden-field-' . $append;
 $pre_field_id = 'hidden-pre-field-' . $append;
 $icon_id = 'toggle-icon-' . $append;
 $text_id = 'text-stored-' . $append;
 $text_id_other = 'text-stored-other-' . $append;
 
 $toggle = elgg_view('output/url', array(
 		'href' => 'javascript:;',
		'text' => $text,
 		'onclick' => 'hidden_field_toggle(this)',
 		'id' => $append
 ));
 ?>
 
 
<div hidden id="<?php echo $text_id; ?>"><?php echo $text; ?></div>
<div hidden id="<?php echo $text_id_other; ?>"><?php echo $hidden_content_text; ?></div>
<div id="<?php echo $pre_field_id; ?>" style="display:inline-block;">
	<?php echo $pre_content; ?>
</div>
<div  style="display:inline-block;<?php echo $alignment; ?>">

    <span class="<?php echo $additional_class; ?>"><i class="fa fa-caret-right caret-color mrgn-rght-sm" id="<?php echo $icon_id; ?>"></i><?php echo $toggle; ?></span>
	 <span style="font-style:italic;"><?php echo $additional_text; ?></span>
</div>
 <div class="<?php echo $bordering; ?>" id="<?php echo $field_id; ?>" style="display:none;padding:8px;">
 	<?php echo $content; ?>
 </div>
 
 <script>
	function hidden_field_toggle(toggle) {
		var append = toggle.id;
		var field = document.getElementById('hidden-field-'.concat(append));
		var pre_field = document.getElementById('hidden-pre-field-'.concat(append));
		var icon = document.getElementById('toggle-icon-'.concat(append));
		
		var text = document.getElementById('text-stored-'.concat(append)).textContent;
		var other_text = document.getElementById('text-stored-other-'.concat(append)).textContent;
		
		if(field.style.display == 'none') {
			if('<?php echo $hidden_content_text; ?>') {
				toggle.innerHTML = other_text;
			}
			field.style.display = 'block';
			pre_field.style.display = 'none';
			icon.className = 'fa fa-caret-down caret-color';
		}
		else {
			toggle.innerHTML = text;
			field.style.display = 'none';
			pre_field.style.display = 'inline-block';
			icon.className = 'fa fa-caret-right caret-color';
		}
	}
 </script>