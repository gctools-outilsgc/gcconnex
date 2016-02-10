<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which displays 3 dropdown fields for written comprehension, written expression and oral proficiency.
 * Values in the dropdown fields are extracted from the language_string found in settings.
 */
$array = explode(',', elgg_get_plugin_setting('language_string', 'missions'));

$language_written_comprehension = get_input('ilwc');
$language_written_expression = get_input('ilwe');
$language_oral_proficiency = get_input('ilop');

if (elgg_is_sticky_form('lsdropfill')) {
    extract(elgg_get_sticky_values('lsdropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$input_written_comprehension = elgg_view('input/dropdown', array(
    'name' => 'lwc',
    'value' => $language_written_comprehension,
    'options' => $array,
    'class' => 'language-dropdown',
    'id' => 'single-language-written-comprehension-dropdown-input'
));
$input_written_expression = elgg_view('input/dropdown', array(
    'name' => 'lwe',
    'value' => $language_written_expression,
    'options' => $array,
    'class' => 'language-dropdown',
    'id' => 'single-language-written-expression-dropdown-input'
));
$input_oral_proficiency = elgg_view('input/dropdown', array(
    'name' => 'lop',
    'value' => $language_oral_proficiency,
    'options' => $array,
    'class' => 'language-dropdown',
    'id' => 'single-language-oral-proficiency-dropdown-input'
));
?>

<table class="mission-post-table-two">
	<tr>
		<td class="mission-post-table-lefty"><label for='single-language-written-comprehension-dropdown-input'><?php echo elgg_echo('missions:written_comprehension') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center">
			<div>
			<?php echo '<span class="missions-inline-drop">' . $input_written_comprehension . '</span>'; ?>
		</div>
		</td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty"><label for='single-language-written-expression-dropdown-input'><?php echo elgg_echo('missions:written_expression') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center">
			<div>
			<?php echo '<span class="missions-inline-drop">' . $input_written_expression . '</span>'; ?>
		</div>
		</td>
	</tr>
	<tr>
		<td class="mission-post-table-lefty"><label for='single-language-oral-proficiency-dropdown-input'><?php echo elgg_echo('missions:oral_proficiency') . ':';?></label><br />
		</td>
		<td class="mission-post-table-center">
			<div>
			<?php echo '<span class="missions-inline-drop">' . $input_oral_proficiency . '</span>'; ?>
		</div>
		</td>
	</tr>
</table>