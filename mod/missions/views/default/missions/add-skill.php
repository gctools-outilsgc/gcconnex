<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Adds a skill text input with autocomplete.
 */
elgg_load_js('typeahead'); 

$numerator = $_SESSION['mission_skill_input_number'];

$add_skill_field = elgg_view('input/text', array(
		'name' => 'key_skills_' . $numerator,
		'value' => $vars['value'],
		'class' => 'mission-auto-skill',
		'id' => 'mission-skills-text-input-' . $numerator,
		'style' => 'display:inline;'
));

$add_skill_button = elgg_view('output/url', array(
		'text' => ' ' . elgg_echo('missions:delete'),
		'class' => 'elgg-button btn fa fa-times-circle',
		'id' => 'missions-skills-button-delete-' . $numerator,
		'onclick' => 'delete_skill_field(this)',
		'style' => 'display:inline;'
));

echo '<div id="missions-skills-division-' . $numerator . '">' . $add_skill_field . $add_skill_button . '</div>';

$_SESSION['mission_skill_input_number'] = $numerator + 1;
?>

<script>
	$(document).ready(function() {
		var numerator = <?php echo $numerator ?>;
		var ident = '#mission-skills-text-input-' + numerator;
		
		var newSkill = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: elgg.get_site_url() + 'mod/b_extended_profile/actions/b_extended_profile/autoskill.php?query=%QUERY'
            }
        });

        newSkill.initialize();

        $(ident).typeahead(null, {
            name: 'newSkill',
            displayKey: 'value',
            limit: 10,
            source: newSkill.ttAdapter()
        });
	});

	function delete_skill_field(button) {
		var splitter = button.id.split("-");
		var ident = '#missions-skills-division-' + splitter.pop();
		$(ident).remove();
	}	
</script>