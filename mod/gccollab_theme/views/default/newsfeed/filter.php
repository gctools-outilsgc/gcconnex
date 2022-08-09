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
  
  if(!isset(elgg_get_logged_in_user_entity()->newsfeedCard) || elgg_get_logged_in_user_entity()->newsfeedCard == '') {
    $view_link = elgg_view('output/url', array(
      'text' => elgg_echo('newsfeed:listview'),
      'href' => elgg_add_action_tokens_to_url(elgg_get_site_url() .'action/newsfeed/news_toggle'),
    ));
  } else {
    $view_link = elgg_view('output/url', array(
      'text' => elgg_echo('newsfeed:cardview'),
      'href' => elgg_add_action_tokens_to_url(elgg_get_site_url() .'action/newsfeed/news_toggle'),
    ));
  }

  $filter_form = '<a id="newsfeed_filter" href="#" style="margin-top: -35px;" title="'.elgg_echo('newsfeed:filter:title').'" class="dropdown  pull-right mrgn-rght-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-ellipsis-v fa-2x icon-unsel"><span class="wb-inv">'.elgg_echo('newsfeed:filter:title').'</span></span></a><ul style="position: relative;" class="dropdown-menu pull-right act-filter" aria-labelledby="newsfeed_filter"><li id="filter_form">'.$filter_link.'</li><li>'.$view_link.'</li></ul>';

  echo $filter_form;
}
?>
