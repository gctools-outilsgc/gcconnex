<?php

/*

User profile Sidebar


*/

echo '<div class="panel panel-custom elgg-module-aside"><div class="panel-heading"><h2 class="">'.elgg_echo('ps:profilestrength').'</h2></div><div class="panel-body clearfix">'.elgg_view('widgets/profile_completness/content').'</div></div>';
echo elgg_view('profile/sidebar/colleagues', $vars);
echo elgg_view('profile/sidebar/user_groups', $vars);

?>