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

/*****************  GCconnex addition for picture badges *******************/
require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
	global $badgemap;
    global $initbadges;

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



    //only give option of ambassador badge for users who are members of the ambassador group
    if(sizeof($options) > 1){
			// select badge
	    echo "<div class='mrgn-tp-md'>";
	    echo '<label for="badge">' .elgg_echo("gcProfilePictureBadges:badgeselectdesc") . '</label>';
        echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "badge", "id" => "badge", "options_values" => $options, "value" => $user->active_badge));
        echo "</div>";
    }

    $options = array( 'none' => '- - - - - - - - - - - -' );
    foreach ( $content as $group ){
		if ( $initbadges[$group->name] != null )
			$options[$group->name] = $group->name;
	}

    //get current selected value
    foreach($initbadges as $k => $v){
        if($user->init_badge == $v){
            $value = $k;
        }
    }

    // select initiative badge
	echo "<div class='mrgn-tp-sm mrgn-bttm-md'>";
  echo '<label for="init_badge">' .elgg_echo("gcProfilePictureBadges:badgeselectdesc") . '</label>';
	echo '<div class="timeStamp">'.elgg_echo('gcProfilePictureBadges:form:tooltip').'</div>';
	echo elgg_view("input/dropdown", array("name" => "init_badge", "id" => "init_badge", "options_values" => $options, "value" => $value));
	echo "</div>";


/***************** End of  GCConnex addition for picture badges *******************/

echo elgg_view('input/submit', array('value' => elgg_echo('avatar:create')));

?>
</div>
