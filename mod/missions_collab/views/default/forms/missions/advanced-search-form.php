<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which contains the input fields for the advanced search.
 * Input fields are generated dynamically using javascript.
 */
elgg_load_js('typeahead');
$advanced_form = elgg_get_sticky_values('advancedfill');
$form_name = $_SESSION['mission_search_switch'];

// The arrays are different depending on whether the user is searching for missions or candidates.
if ($form_name == 'candidate') {
	$search_fields = array(
		'', //'' => 'Choose',
		elgg_echo('missions:education'),
		elgg_echo('missions:experience'),
		elgg_echo('missions:skill'),
		elgg_echo('missions:portfolio'),
		//elgg_echo('missions:user_department'),
		elgg_echo('missions:opt_in')
	);
  
	$subtitle = elgg_echo('missions:advanced_find_candidates');
	$limit_options = array(10,25,50,100);
	$button_text = elgg_echo('missions:find');
}
else
{	// $form_name == mission
	$search_fields = array(
		'', //'' => 'Choose',
		elgg_echo('missions:title'),
		elgg_echo('missions:department'),
		elgg_echo('missions:key_skills'),
		elgg_echo('missions:security_clearance'),
		elgg_echo('missions:location'),
		elgg_echo('missions:language'),
		elgg_echo('missions:groupandlevel'),
		elgg_echo('missions:time'),
		elgg_echo('missions:period'),
		elgg_echo('missions:start_time'),
		elgg_echo('missions:duration'),
		elgg_echo('missions:work_remotely'),
		elgg_echo('missions:program_area')
	);
  
	$subtitle = elgg_echo('missions:advanced_search_for_opportunities');
	$limit_options = array(9,18,30,60,120);
	$button_text = elgg_echo('missions:search');
}

$input_advanced_limit = elgg_view('input/dropdown', array(
	'name' => 'limit',
	'value' => $limit,
	'options' => $limit_options,
	'id' => 'search-mission-limit-dropdown-input'
));

$number_of_rows = elgg_get_plugin_setting('advanced_element_limit', 'missions');
$content = '<div class="form-group">';
$content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">' . elgg_echo('missions:field') . '</div>';
$content .= '<div class="mission-emphasis-extra col-sm-4">' . elgg_echo('missions:value') . '</div></div>';

// Generates the rows of the form according to the settings.
if ($advanced_form) {
	for ($s = 0; $s < $number_of_rows; $s++) {
		if ($advanced_form[$form_name.'_'.$s]) {
			$content .= '<div class="form-group">';
			// Dropdown with a name that is numbered according to its row.
			$content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">';
			$content .= elgg_view('input/dropdown', array(
				'name' => $form_name.'_'.$s,
				'value' => $advanced_form[$form_name.'_'.$s],
				'options' => $search_fields,
				'onchange' => 'element_switch(this)',
				'onload' => 'element_switch(this)',
				'id' => 'search-mission-advanced-selection-'.$s.'-dropdown-input',
				'selected' => 'selected'
	    ));
	    $content .= '</div>';
	    $content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$s.'"></div>';
	    $content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$s.'_element"></div>';
	    // Backup dropdown for when Javascript is disabled.
	    $content .= '<noscript>';
	    $content .= elgg_view('input/text', array(
				'name' => 'backup_'.$s,
				'value' => '',
				'id' => 'search-mission-advanced-selection-'.$s.'-dropdown-input-backup'
	    ));
	    $content .= '</noscript></div>';
			$all_values = array(
				"value_answer" => $advanced_form[$form_name.'_'.$s.'_element'],
				"reading" => $advanced_form[$form_name.'_'.$s.'_element_lwc'],
				"writing" => $advanced_form[$form_name.'_'.$s.'_element_lwe'],
				"oral" => $advanced_form[$form_name.'_'.$s.'_element_lop'],
				"operand" => $advanced_form[$form_name.'_'.$s.'_operand'],
				"day" => $advanced_form[$form_name.'_'.$s.'_element_day'],
				"lvl" => $advanced_form[$form_name.'_'.$s.'_element_lvl']
			);
?> 
			<script type="text/javascript">
				var name = "<?php echo $form_name.'_'.$s; ?>";
				var value = "<?php echo $advanced_form[$form_name.'_'.$s]; ?>";
				var all_values= <?php echo json_encode($all_values ); ?>;

				element_switch2(name, value, all_values);

				function element_switch2(name, value, all_values) {
					var name_length = name.length;
					var name_sub = name.substring(name_length - 8, name_length);
					var further = false;
					if(name_sub === '_element') {
						further = true;
					}
					
					var section = "#".concat(name);

					// Calls the view which selects which element to output according to the dropdown value.
					elgg.get('ajax/view/missions/element-select', {
						data: {
							// Name and value of the dropdown that was modified.
							caller_name: name,
							caller_value: value,
							caller_second: further,
							all_values:all_values
						},
						success: function(result, success, xhr) {
							$(section).html(result);
						}
					});
				}
			</script>
<?php
		} else {
			$content .= '<div class="form-group">';
	    // Dropdown with a name that is numbered according to its row.
	    $content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">';
	    $content .= elgg_view('input/dropdown', array(
				'name' => $form_name.'_'.$s,
				'value' => '',
				'options' => $search_fields,
				'onchange' => 'element_switch(this)',
				'onload' => 'element_switch(this)',
				'id' => 'search-mission-advanced-selection-'.$s.'-dropdown-input'
	    ));
	    $content .= '</div>';
	    $content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$s.'"></div>';
	    $content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$s.'_element"></div>';
	    // Backup dropdown for when Javascript is disabled.
	    $content .= '<noscript>';
	    $content .= elgg_view('input/text', array(
				'name' => 'backup_'.$s,
				'value' => '',
				'id' => 'search-mission-advanced-selection-'.$s.'-dropdown-input-backup'
	    ));
			$content .= '</noscript>';
			$content .= '</div>';
		}
	}
} else {
	for ($i = 0; $i < $number_of_rows; $i ++) {

		if ($i === 0) {
			$content .= '<label for="mission-emphasis-extra col-sm-offset-1 col-sm-4" class="required" aria-required="true">' . elgg_echo('missions:select');
			$content .= '<strong class="required" aria-required="true">' . elgg_echo('missions:required') . '</strong>';
		}
		else {
			$content .= '<label for="mission-emphasis-extra col-sm-offset-1 col-sm-4">' . elgg_echo('missions:select');
		}

		// Dropdown with a name that is numbered according to its row.
		$content .= '<div class="form-group">';
		$content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">';
		$content .= elgg_view('input/dropdown', array(
			'name' => $form_name.'_'.$i,
			'value' => '',
			'options' => $search_fields,
			'onchange' => 'element_switch(this)',
			'onload' => 'element_switch(this)',
			'id' => 'search-mission-advanced-selection-'.$i.'-dropdown-input_element'
		));
		$content .= '</div>';
		$content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$i.'"></div>';
		$content .= '<div class="mission-emphasis-extra col-sm-6" id="'.$form_name.'_'.$i.'_element"></div>';
		// Backup dropdown for when Javascript is disabled.
		$content .= '<noscript>';
		$content .= elgg_view('input/text', array(
			'name' => 'backup_'.$i,
			'value' => '',
			'id' => 'search-mission-advanced-selection-'.$i.'-dropdown-input-backup'
		));
		$content .= '</noscript></div>';
	}
}

$hidden_input = elgg_view('input/hidden', array(
	'name' => 'hidden_return',
	'value' => $vars['return_to_referer']
));

if($advanced_form) {
	if($_SESSION['mission_search_switch'] == 'candidate') {
		$page = 'members';
	} else {
		$page = 'find';
	}

	$clear_link = elgg_view('output/url', array(
		'text' => elgg_echo('missions:clear_search'),
		'href' => 'missions/main/'.$page.'?clear=true&search='.$advanced_form,
		'class' => 'mrgn-lft-sm',
		'is_action' => true,
		'is_trusted' => true,
	));
}
?>

<h2 class="h4" style="margin:0;"><?php echo $subtitle.':'; ?></h2>
<?php echo $hidden_input; ?>
<?php echo $content; ?>
<p>
	<?php echo elgg_echo('missions:advanced_note_paragraph_one'); ?>
</p>
<noscript>
	<p>
		<?php echo elgg_echo('missions:advanced_note_paragraph_two'); ?>
	</p>
</noscript>

<div style="text-align:right;"> 
	<?php
		echo elgg_view('input/submit', array(
			'value' => $button_text,
			'id' => 'mission-advanced-search-form-submission-button'
		));
		echo $clear_link;
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-advanced-search-form-submission-button'));
	?>
</div>

<script>
	// Gets called when the dropdown value changes.
	function element_switch(control) {
		var name_length = control.name.length;
		var name_sub = control.name.substring(name_length - 8, name_length);
		var further = false;
		if(name_sub === '_element') {
			further = true;
			if (control.value === '') {
				$("#".concat(control.name)).html('');
			}
		}
		if (control.value === '' && $("#".concat(control.name))) {
			$("#".concat(control.name)).html('');
		}
		if (control.value !== '') {
			elgg.get('ajax/view/missions/element-select', {
				data: { // Name and value of the dropdown that was modified.
					caller_name: control.name,
					caller_value: control.value,
					caller_second: further,
				},
				success: function(result, success, xhr) {
					$("#".concat(control.name)).html(result);
					$("#".concat(control.name).concat("_element")).html('');
				}
			});
		}
	}
</script>
