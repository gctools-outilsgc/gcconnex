<?php
/**
 * Avatar crop form
 *
 * @uses $vars['entity']
 */

elgg_load_js('jquery.imgareaselect');
elgg_load_js('elgg.avatar_cropper');
elgg_load_css('jquery.imgareaselect');

$master_img = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('master'),
	'alt' => elgg_echo('avatar'),
	'class' => 'mrl',
	'id' => 'user-avatar-cropper',
));

$preview_img = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('master'),
	'alt' => elgg_echo('avatar'),
));

?>
<div class="clearfix">
	<?php echo $master_img ?>
	<div id="user-avatar-preview-title"><label><?php echo elgg_echo('avatar:preview'); ?></label></div>
	<div id="user-avatar-preview"><?php echo $preview_img; ?></div>
</div>
<div class="elgg-foot">
<?php
$coords = array('x1', 'x2', 'y1', 'y2');
foreach ($coords as $coord) {
	echo elgg_view('input/hidden', array('name' => $coord, 'value' => $vars['entity']->$coord));
}

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));

/*****************  GCConnex addition for picture badges *******************/
require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
	global $badgemap;

	// get groups list
	$user = elgg_get_logged_in_user_entity();
$options = array(
	'type' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'limit' => 100,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_get_entities_from_relationship($options);

	$options = array( 'none' => '- - - - - - - - - - - -' );
	foreach ( $content as $group ){
		if ( $badgemap[$group->name] != null )
			$options[$group->name] = $group->name;
	}
	// select badge
	echo "<div>";
	echo elgg_echo("gcProfilePictureBadges:badgeselectdesc");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "badge", "options_values" => $options, "value" => $user->active_badge));
	echo "</div>";
	// position of badge
	/*$corner_options = array( 'TL' => 'Top Left',
							 'TR' => 'Top Right',
							 'BL' => 'Bottom Left',
							 'BR' => 'Bottom Right' );
	echo "<div>";
	echo elgg_echo("gcProfilePictureBadges:badgeposdesc");
	echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "badge", "options_values" => $corner_options, "value" => 'none'));
	echo "</div>";*/
	
/***************** End of  GCConnex addition for picture badges *******************/

echo elgg_view('input/submit', array('value' => elgg_echo('avatar:create')));

?>
</div>
