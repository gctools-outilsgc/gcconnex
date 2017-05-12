<?php
/**
 * Avatar crop form
 *
 * @uses $vars['entity']
 */


$photo = $vars['entity'];
elgg_load_js('jquery.imgareaselect');
elgg_load_js('elgg.avatar_cropper');
elgg_load_css('jquery.imgareaselect');

$master_img = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('master').'&newtime='.$time,
	'alt' => elgg_echo('avatar'),
	'class' => 'mrl rotate',
	'id' => 'user-avatar-cropper',
));

$preview_img = elgg_view('output/img', array(
	'src' => $vars['entity']->getIconUrl('master').'&newtime='.$time,
	'alt' => elgg_echo('avatar'),
	'class' => 'rotate',
));

echo '<div class="rotate2"></div>';



?>
<div class="clearfix">
	<?php echo $master_img ?>
	<div id="user-avatar-preview-title"><label><?php echo elgg_echo('avatar:preview'); ?></label></div>
	<div id="user-avatar-preview"><?php echo $preview_img; ?></div>
</div>

<?php

//rotate
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'rotation':
            rotation($photo);
            break;

    }
}

//function to rotate image
function rotation($photo){
  $time = time();
  $file = new ElggFile();
  $file->owner_guid = $user_guid;

  $picture_size = array('master');

  for($x = 0; $x < 6; $x++) {
     // $imgsrc = $_SERVER['DOCUMENT_ROOT'].'1/'.$photo->guid.'\profile/'.$photo->guid.''.$picture_size[$x].'.jpg';
      $file->setFilename("profile/{$photo->guid}{$picture_size[$x]}.jpg");
      $filepath = $file->getFilenameOnFilestore();

      $imgsrc = $filepath;

      if (exif_imagetype($imgsrc) == IMAGETYPE_JPEG) {
          if (file_exists($imgsrc)) {
              $img = imagecreatefromjpeg($imgsrc);

              if ($img !== false) {
                $imgRotated = imagerotate($img,90,0);

                if ($imgRotated !== false) {
                    imagejpeg($imgRotated,$imgsrc,100);
                }
              }else{
                echo 'Error, Image rotate false. JPEG';

              }

          }else{
              echo'Error, file not exist. JPEG';

          }
              imagedestroy($img);
      imagedestroy($imgRotated);
    }
  }
}

$image_src = $vars['entity']->getIconUrl('master');


echo'<div class="col-md-7 col-md-offset-5 mrgn-tp-md">';
echo'<span class="btn btn-default" onclick=rotate_ajax_profil("'.$image_src.'")>'.elgg_echo('rotate:image').'</span></div>';

?>

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
		if ( $initbadges[$group->name] != null ){
			$badge = $initbadges[$group->name];
			//check if group has enabled their badge
			if($group->getPrivateSetting("group:badge:".$badge) == 'yes'){
				$options[$group->name] = $group->name;
			}
		}
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
