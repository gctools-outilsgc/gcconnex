<?php
if(elgg_is_logged_in()){
  if(!isset(elgg_get_logged_in_user_entity()->colleagueNotif) || elgg_get_logged_in_user_entity()->colleagueNotif == ''){
    $filter_link = elgg_view('output/url', array(
      'text' => elgg_echo('dept:activity:hide'),
      'href' => elgg_add_action_tokens_to_url(elgg_get_site_url().'action/newsfeed/filter')
    ));
  } else {
    $filter_link = elgg_view('output/url', array(
      'text' => elgg_echo('dept:activity:show'),
      'href' => elgg_add_action_tokens_to_url(elgg_get_site_url().'action/newsfeed/filter')
    ));
  }

  $filter_form = '<a href="#" style="position:absolute; top:10px; right:20px;" title="'.elgg_echo('newsfeed:filter:title').'" class="dropdown  pull-right mrgn-rght-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v fa-2x icon-unsel"><span class="wb-inv">'.elgg_echo('newsfeed:filter:title').'</span></i></a><ul style="top:45px; right: 8px;" class="dropdown-menu pull-right act-filter" aria-labelledby="dropdownMenu2"><li id="filter_form">'.$filter_link.'</li></ul>';

  echo $filter_form;
}
?>
