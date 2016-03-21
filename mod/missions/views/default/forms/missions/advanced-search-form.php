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
/*$selection_zeroth = get_input('assz');
$selection_first = get_input('assf');
$selection_second = get_input('asss');
$selection_third = get_input('asst');
$selection_fourth = get_input('assfo');
$selection_fifth = get_input('assfi');
$selection_sixth = get_input('asssi');
$selection_seventh = get_input('assse');
$selection_eigth = get_input('asse');
$selection_ninth = get_input('assn');*/

/*if (elgg_is_sticky_form('advancedfill')) {
    extract(elgg_get_sticky_values('advancedfill'));
    elgg_clear_sticky_form('advancedfill');
}*/

// The arrays are different depending on whether the user is searching for missions or candidates.
if($_SESSION['mission_search_switch'] == 'candidate') {
    $search_fields = array(
        '',
        elgg_echo('missions:education'),
        elgg_echo('missions:experience'),
        elgg_echo('missions:skill'),
        elgg_echo('missions:portfolio')
    );
    
    $subtitle = elgg_echo('missions:advanced_search_for_candidates');
}
else {
    $search_fields = array(
        '',
        elgg_echo('missions:title'),
        elgg_echo('missions:type'),
        elgg_echo('missions:department'),
        elgg_echo('missions:key_skills'),
        elgg_echo('missions:security_clearance'),
        elgg_echo('missions:location'),
        elgg_echo('missions:language'),
        elgg_echo('missions:time'),
        elgg_echo('missions:period'),
        elgg_echo('missions:start_time'),
        elgg_echo('missions:duration')
    );
    
    $subtitle = elgg_echo('missions:advanced_search_for_opportunities');
}

$number_of_rows = elgg_get_plugin_setting('advanced_element_limit', 'missions');
$content = '<div class="form-group">';
$content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">' . elgg_echo('missions:field') . '</div>';
$content .= '<div class="mission-emphasis-extra col-sm-4">' . elgg_echo('missions:value') . '</div></div>';

// Generates the rows of the form according to the settings.
for ($i = 0; $i < $number_of_rows; $i ++) {
    $content .= '<div class="form-group">';
    // Dropdown with a name that is numbered according to its row.
    $content .= '<div class="mission-emphasis-extra col-sm-offset-1 col-sm-4">';
    $content .= elgg_view('input/dropdown', array(
        'name' => 'selection_' . $i,
        'value' => '',
        'options' => $search_fields,
        'onchange' => 'element_switch(this)',
        'onload' => 'element_switch(this)',
        'id' => 'search-mission-advanced-selection-' . $i . '-dropdown-input'
    ));
    $content .= '</div>';
    $content .= '<div class="mission-emphasis-extra col-sm-3" id="selection_' . $i . '"></div>';
    $content .= '<div class="mission-emphasis-extra col-sm-3" id="selection_' . $i . '_element"></div>';
    // Backup dropdown for when Javascript is disabled.
    $content .= '<noscript>';
    $content .= elgg_view('input/text', array(
        'name' => 'backup_' . $i,
        'value' => $variable_array[$i],
        'id' => 'search-mission-advanced-selection-' . $i . '-dropdown-input-backup'
    ));
    $content .= '</noscript></div>';
}
$content .= '</table>';
?>

<h4><?php echo $subtitle . ':'; ?></h4>
<?php echo $content; ?>
<p>
	<?php echo elgg_echo('missions:advanced_note_paragraph_one'); ?>
</p>
<noscript>
	<p>
	<?php echo elgg_echo('missions:advanced_note_paragraph_two'); ?>
</p>
</noscript>

<div style="text-align:right;"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:search'))); ?> </div>

<script>
	// Gets called when the dropdown value changes.
	function element_switch(control) {
		var name_length = control.name.length;
		var name_sub = control.name.substring(name_length - 8, name_length);
		var further = false;
		if(name_sub === '_element') {
			further = true;
		}
		
		var section = "#".concat(control.name);

		// Calls the view which selects which element to output according to the dropdown value.
		elgg.get('ajax/view/missions/element-select', {
			data: {
				// Name and value of the dropdown that was modified.
				caller_name: control.name,
				caller_value: control.value,
				caller_second: further
			},
			success: function(result, success, xhr) {
				$(section).html(result);
			}
		});
	}
</script>