<?php
/*
 * settings.php
 * 
 * Plugin settings for wet4 mod. Accessed through the site admin panel
 * 
 * @package wet4
 * @author GCTools Team
 */

$page_mode = get_input('script', 'default');

if ( $page_mode == 'bilingual_upgrade' ) {
	echo "<br /><h3>upgrade en/fr content storage</h3>";
	echo elgg_view("output/url",
		array(
			'href' => elgg_get_site_url().'admin/plugin_settings/wet4',
			'text' => '<< back to settings page',
		)
	);
	echo "<br />";
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	$title2_id = elgg_get_metastring_id('title2', true);	// get the metastring id, create the metastring if it does not exist
	$title3_id = elgg_get_metastring_id('title3', true);

	$name2_id = elgg_get_metastring_id('name2', true);	// get the metastring id, create the metastring if it does not exist
	$name3_id = elgg_get_metastring_id('name3', true);

	$description2_id = elgg_get_metastring_id('description2', true);	// get the metastring id, create the metastring if it does not exist
	$description3_id = elgg_get_metastring_id('description3', true);

	$briefdescription2_id = elgg_get_metastring_id('briefdescription2', true);	// get the metastring id, create the metastring if it does not exist
	$briefdescription3_id = elgg_get_metastring_id('briefdescription3', true);

	$excerpt2_id = elgg_get_metastring_id('excerpt2', true);	// get the metastring id, create the metastring if it does not exist
	$excerpt3_id = elgg_get_metastring_id('excerpt3', true);
	
	$poll_choice2_id = elgg_get_metastring_id('poll_choice2', true);	// get the metastring id, create the metastring if it does not exist
	$poll_choice3_id = elgg_get_metastring_id('poll_choice3', true);

	$db_prefix = elgg_get_config('dbprefix');
	$count = get_data_row("SELECT count(distinct o.guid) as objects from {$db_prefix}objects_entity o LEFT JOIN {$db_prefix}metadata md ON o.guid = md.entity_guid 
		WHERE md.name_id IN ({$title2_id}, {$title3_id}, {$name2_id}, {$name3_id}, {$description2_id}, {$description3_id}, {$briefdescription2_id}, {$briefdescription3_id}, {$excerpt2_id}, {$excerpt3_id}, {$poll_choice2_id}, {$poll_choice3_id})");

	echo elgg_view('admin/upgrades/view', array(
		'count' => $count->objects,
		'action' => 'action/wet4/update_to_json',
	));

	access_show_hidden_entities($access_status);
} 
else {
	$options = array(
		'name' => 'params[ExtTheme]',
		'value' => 1
	);
	if (elgg_get_plugin_setting('ExtTheme', 'wet4')) {
		$options['checked'] = 'checked';
	}
	echo "<div class='checkbox'>";
	echo elgg_echo('wet4:ExtTheme');
	echo "<label>".elgg_view('input/checkbox',$options);
	echo elgg_echo('wet4:ExtThemeYes')."</label>";
	echo "</div>";

	echo "<div>";
	echo "Run en/fr upgrade Script: <br />";
	echo elgg_view("output/url",
		array(
			'href' => '?script=bilingual_upgrade',
			'text' => 'bilingual upgrade script',
			'class' => 'btn btn-default elgg-button btn-primary elgg-button-submit only-one-click',
		)
	);
	echo "</div>";
}
?>