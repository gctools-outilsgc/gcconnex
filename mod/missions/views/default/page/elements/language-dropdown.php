<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * View which display 3 dropdown fields for each required language.
 * The required languages are english and french and the dropdown fields represent written comprehension, written expression and oral proficiency.
 * Values in the dropdownfields are extracted from the language_string found in settings.
 */
$array = explode(',', elgg_get_plugin_setting('language_string', 'missions'));

$language_written_comprehension_english = $vars['mission_metadata']['lwc_english'];
$language_written_comprehension_french = $vars['mission_metadata']['lwc_french'];
$language_written_expression_english = $vars['mission_metadata']['lwe_english'];
$language_written_expression_french = $vars['mission_metadata']['lwe_french'];
$language_oral_proficiency_english = $vars['mission_metadata']['lop_english'];
$language_oral_proficiency_french = $vars['mission_metadata']['lop_french'];

if (elgg_is_sticky_form('ldropfill')) {
    extract(elgg_get_sticky_values('ldropfill'));
    // elgg_clear_sticky_form('thirdfill');
}

$input_english_written_comprehension = elgg_view('input/dropdown', array(
    'name' => 'lwc_english',
    'value' => $language_written_comprehension_english,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'english-language-written-comprehension-dropdown-input'
));
$input_french_written_comprehension = elgg_view('input/dropdown', array(
    'name' => 'lwc_french',
    'value' => $language_written_comprehension_french,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'french-language-written-comprehension-dropdown-input'
));
$input_english_written_expression = elgg_view('input/dropdown', array(
    'name' => 'lwe_english',
    'value' => $language_written_expression_english,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'english-language-written-expression-dropdown-input'
));
$input_french_written_expression = elgg_view('input/dropdown', array(
    'name' => 'lwe_french',
    'value' => $language_written_expression_french,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'french-language-written-expression-dropdown-input'
));
$input_english_oral_proficiency = elgg_view('input/dropdown', array(
    'name' => 'lop_english',
    'value' => $language_oral_proficiency_english,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'english-language-oral-proficiency-dropdown-input'
));
$input_french_oral_proficiency = elgg_view('input/dropdown', array(
    'name' => 'lop_french',
    'value' => $language_oral_proficiency_french,
    'options' => $array,
	'style' => 'min-width:63px;margin:auto;',
    'id' => 'french-language-oral-proficiency-dropdown-input'
));
?>

<div class="form-group">
	<div class="col-sm-3" style="text-align:right;font-weight:bold;display:inline-block;">
		
	</div>
	<div class="col-sm-1" style="font-weight:bold;display:inline-block;text-align:center;">
		<?php echo elgg_echo('missions:english');?>
	</div>
	<div class="col-sm-1" style="font-weight:bold;display:inline-block;text-align:center;">
		<?php echo elgg_echo('missions:french');?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-3" style="text-align:right;font-weight:bold;display:inline-block;">
		<?php echo elgg_echo('missions:written_comprehension') . ':';?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_english_written_comprehension; ?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_french_written_comprehension; ?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-3" style="text-align:right;font-weight:bold;display:inline-block;">
		<?php echo elgg_echo('missions:written_expression') . ':';?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_english_written_expression; ?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_french_written_expression; ?>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-3" style="text-align:right;font-weight:bold;display:inline-block;">
		<?php echo elgg_echo('missions:oral_proficiency') . ':';?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_english_oral_proficiency; ?>
	</div>
	<div class="col-sm-1" style="display:inline-block;">
		<?php echo $input_french_oral_proficiency; ?>
	</div>
</div>