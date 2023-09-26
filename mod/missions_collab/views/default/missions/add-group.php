<?php

elgg_load_js('typeahead'); 

$no_delete = $vars['no_delete'];

$numerator = $_SESSION['mission_group_input_number'];

$name = 'key_groups_' . $numerator;
if($vars['name_override']) {
	$name = $vars['name_override'];
}

$add_group_field = elgg_view('input/text', array(
		'name' => $name,
		'value' => $vars['value'],
		'class' => 'mission-auto-group',
		'id' => 'mission-groups-text-input-' . $numerator,
		'style' => 'display:inline;'
));

if(!$no_delete) {
	$delete_group_button = elgg_view('output/url', array(
			'text' => '<div class=" fa fa-times-circle"></div>  ' . elgg_echo('missions:delete'),
			'class' => 'elgg-button btn',
			'id' => 'missions-groups-button-delete-' . $numerator,
			'onclick' => 'delete_group_field(this)',
			'style' => 'display:inline;'
	));
}
	
echo '<div id="missions-groups-divison-' . $numerator . '">' . $add_group_field . $delete_group_button . '</div>';

$_SESSION['mission_group_input_number'] = $numerator + 1;
?>

<script>
	$(document).ready(function() {
		var numerator = <?php echo $numerator ?>;
		var ident = '#mission-groups-text-input-' + numerator;
		
		var newgroup = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: elgg.get_site_url() + 'mod/b_extended_profile/actions/b_extended_profile/autogroup.php?query=%QUERY'
            }
        });

        newGroup.initialize();

        $(ident).typeahead(null, {
            name: 'newGroup',
            displayKey: 'value',
            limit: 10,
            source: newGroup.ttAdapter()
        });
	});

	function delete_group_field(button) {
		var splitter = button.id.split("-");
		var ident = '#missions-groups-division-' + splitter.pop();
		$(ident).remove();
	}	
</script>