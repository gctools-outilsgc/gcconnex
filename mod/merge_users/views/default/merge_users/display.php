<?php
$old = get_input("old");
$new = get_input("new");

$old_user = get_user_by_username($old);
$new_user = get_user_by_username($new);

echo '<p>This will merge the account <span class="old">'.$old_user->username.'</span> into <span class="new">'.$new_user->username.'</span> and delete the <span class="old">'.$old_user->username.'</span>\'s profile. Look below to confirm both profiles.</p>';
?>
<div class="user-display" id="user-old">
  <span class="info-header">Old Account</span>
  <?php echo elgg_view_entity_icon($old_user, 'large', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf')); ?>
  <div class="info">
    <?php
    if(!$old_user){
      echo '<p>User not found</p>';
    } else {
      echo '<p>'.$old_user->name.'</p>';
      echo '<p>@'.$old_user->username.'</p>';
      echo '<p>'.$old_user->email.'</p>';
      echo '<p>'.$old_user->department.'</p>';

      $objects = elgg_get_entities(array(
        'limit' => 0,
        'owner_guid' => $old_user->getGUID(),
        'count' => true,
        'type' => 'object',
      ));

      $groups = elgg_get_entities(array(
        'limit' => 0,
        'owner_guid' => $old_user->getGUID(),
        'count' => true,
        'type' => 'group',
      ));

      echo '<p>Objects: '.$objects.' Groups: '.$groups.'</p>';
    }
    ?>
  </div>
</div>
<div class="user-display" id="user-new">
  <span class="info-header">New Account</span>
  <?php echo elgg_view_entity_icon($new_user, 'large', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf')); ?>

  <div class="info">
    <?php
    if(!$new_user){
      echo '<p>User not found</p>';
    } else {
      echo '<p>'.$new_user->name.'</p>';
      echo '<p>@'.$new_user->username.'</p>';
      echo '<p>'.$new_user->username.'</p>';
      echo '<p>'.$new_user->department.'</p>';
    }
    ?>
  </div>
</div>

<div style="width:100%; float:left">
<?php
if(!$new_user || !$old_user){
  echo '<p>Cannot find one or both accounts.</p>';
} else if($old_user == $new_user){
  echo '<p>Cannot merge same user account.</p>';
} else {
 echo elgg_view('input/submit', array('value' => "Merge and delete", 'class' => 'btn btn-submit mrgn-tp-md'));
}
 ?>
</div>

<style>
  .elgg-avatar {
    width:125px;
    margin:10px;
    float:left;
  }

  .info {
    float: left;
  }

  .info-header {
    font-size: 18px;
    width: 100%;
    margin: 5px;
    float: left;
    font-weight:bold;
  }
</style>
