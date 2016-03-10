<?php
$user_guid = elgg_get_logged_in_user_guid();
$PageOwner=elgg_get_page_owner_guid();
if($user_guid==$PageOwner){
    echo '<div class="panel panel-custom elgg-module-aside"><div class="panel-heading"><h2 class="">'.elgg_echo('ps:profilestrength').'</h2></div><div class="panel-body clearfix">'.elgg_view('widgets/profile_completness/content').'</div></div>';
}