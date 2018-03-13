<?php
$old = get_input("old");
$new = get_input("new");

$old_user = get_user_by_username($old);
$new_user = get_user_by_username($new);

echo '<p>This will merge the account <span class="old">'.$old_user->username.'</span> into <span class="new">'.$new_user->username.'</span>. Look below to confirm both profiles and choose what you would like to transfer.</p>';
echo '<p><i><strong>NOTE:</strong></i> all groups owned by <span class="old">'.$old_user->username.'</span> will be transferrd regardless of the selection below. </p>';

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
      echo '<p>GUID:'.$old_user->guid.'</p>';

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
      echo '<p>'.$new_user->email.'</p>';
      echo '<p>'.$new_user->department.'</p>';
      echo '<p>GUID:'.$new_user->guid.'</p>';
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
  echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'content', 'label'=> 'Transfer old account\'s written content (wire posts, blogs, discussions, comments, etc...)', 'value'=>'content',)).'</div>';
  echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'friends', 'label'=> 'Transfer colleagues', 'value'=>'friends',)).'</div>';
  echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'membership', 'label'=> 'Transfer group membership', 'value'=>'membership',)).'</div>';
  echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'profile', 'label'=> 'Transfer profile (education, work experience and skills)', 'value'=>'profile',)).'</div>';
  if(elgg_is_active_plugin('member_selfdelete')){
    echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'deactivate', 'label'=> 'Deactivate old account', 'value'=>'deactivate',)).'</div>';
  }
  echo '<div class="options-input">'.elgg_view('input/checkbox', array('name'=>'delete', 'label'=> 'Delete user', 'value'=>'delete',)).'</div>';
  echo elgg_view('input/submit', array('value' => "Merge", 'class' => 'btn btn-submit mrgn-tp-md', 'data-confirm' => 'Are you sure?'));
}
 ?>
</div>

<style>
  .options-input {
    width: 100%;
    margin-top:5px;
  }

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
