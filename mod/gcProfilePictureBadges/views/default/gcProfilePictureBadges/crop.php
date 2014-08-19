<?php
/**
 * Avatar crop form picture badge additions
 *
 * @uses $vars['entity']
 */

<?php
$badgemap = array(
	'testlong' => 'test'
);

	$plugin = $vars["entity"];
	$user = elgg_get_logged_in_user_entity();
	
	//////////////////
$options = array(
	'type' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'limit' => 100,
	'full_view' => FALSE,
	'pagination' => FALSE,
	);

	$content = elgg_get_entities_from_relationship($options);

$user->active_badge = $badgemap[ $plugin->getUserSetting("gcProfilePictureBadges_badge", elgg_get_page_owner_guid()) ];
	/*echo "-> " . $user->active_badge;*/
	
	$options = array( 'none' => '- Do not display a badge -' );
	foreach ( $content as $group ){
		if ( $badgemap[$group->name] != null )
			$options[$group->name] = $group->name;
	}
	
	$display_badge = $plugin->getUserSetting("gcProfilePictureBadges_badge", elgg_get_page_owner_guid());
	if(empty($display_badge)) {
		$display_badge = elgg_get_plugin_setting("gcProfilePictureBadges_display_badge", "gcProfilePictureBadges");
	}
	
	echo "<div>";
	echo elgg_echo("gcProfilePictureBadges:usersettings:descr");
	echo "</div>";
	
	echo "<div>";
	echo elgg_echo("gcProfilePictureBadges:usersettings:desc2");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "badge", "options_values" => $options, "value" => $display_badge));
	echo "</div>";

?>
