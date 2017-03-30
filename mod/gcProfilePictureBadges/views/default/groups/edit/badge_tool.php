<?php
/**
 * gcProfilePictureBadges Group Settings addition
 *
 * @package gcProfilePictureBadges
 *
 * Checks if the group has a badge associated with it and adds the form to the admin options 
 */

$group = elgg_get_page_owner_entity();

require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
global $initbadges;

//see if group is in the list
foreach ( $initbadges as $name => $badge ){
    if($name == $group->name){
        //grab badge name
        $init = $badge;
    }
}

if($init){
 ?>

<div class="panel panel-default">

  <div class="panel-heading">
  <?php
    echo '<h2>Badge Control</h2>'
  ?>
  </div>

  <div class="panel-body">
    <?php
      echo elgg_view('groups/enable_badge', array('badge' => $init));
     ?>
  </div>
</div>
<?php } ?>
