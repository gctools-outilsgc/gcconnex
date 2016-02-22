<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Creates an input field with autocomplete feature for departments.
 */
elgg_load_js('typeahead'); 

$add_department_field = elgg_view('input/text', array(
		'name' => 'department',
		'value' => $vars['department'],
		'class' => 'mission-auto-department',
		'id' => 'mission-department-auto-complete-text-input'
));

echo $add_department_field;
?>

<script>
	$(document).ready(function() {
		var departments = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: elgg.get_site_url() + 'mod/b_extended_profile/actions/b_extended_profile/autodept.php?query=%QUERY'
            }
        });

        departments.initialize();

        $('#mission-department-auto-complete-text-input').typeahead(null, {
            name: 'department',
            displayKey: 'value',
            limit: 10,
            source: departments.ttAdapter()
        });
	});
</script>