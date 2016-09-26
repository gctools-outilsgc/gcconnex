<?php
/*
This will populate a drop down that will show up when mousing over "notifications " or "messages " in the user menu.

['type'] = Are you asking for notifications or messages?
['count'] = How many do you want back?
*/

$info_type = get_input('type');
$info_count = get_input('count');
$user = elgg_get_logged_in_user_guid();


if($info_type == 'msg_dd'){
  $type ='inbox';
}else if($info_type =='notif_dd'){
  $type = 'notif';
}

$latest_messages = latest_messages_preview($user, $type);
?>
<div>
  <?php echo elgg_list_entities($latest_messages);?>

</div>
