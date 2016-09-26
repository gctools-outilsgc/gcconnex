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
  $settings_link = '';
}else if($info_type =='notif_dd'){
  $type = 'notif';
  //Nick - add a notifications setting link
  $settings_link = elgg_view('output/url', array(
    'href'=>elgg_get_site_url().'settings/plugins/'.get_entity($user)->username.'/cp_notifications',
    'text'=>'<i class="fa fa-cog fa-lg icon-unsel"><span class="wb-inv">Settings</span></i>',

  ));
}

$latest_messages = latest_messages_preview($user, $type);

?>
<div class="">

  <?php
  echo '<span class="pull-right">'.$settings_link .'</span>';
  elgg_push_context('messages_dd');
  echo elgg_view('page/elements/message_dd_list', array(
    'items'=>$latest_messages,
    'limit'=>6,
    'pagination'=>false,

  ));
  elgg_pop_context();
  ?>

</div>
