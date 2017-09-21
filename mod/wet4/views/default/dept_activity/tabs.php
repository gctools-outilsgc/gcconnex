<?php
if(isset(elgg_get_logged_in_user_entity()->department)){

  $dept = elgg_get_logged_in_user_entity()->department;
  $dept = explode("/", $dept);

  if(elgg_in_context('dept_activity')){
    echo '<ul class="nav nav-tabs mrgn-bttm-sm"><li><a href="'.elgg_get_site_url().'newsfeed">'.elgg_echo('dept:activity:groupsandcolleagues').'</a></li><li class="elgg-state-selected active"><a href="'.elgg_get_site_url().'department">'.$dept[0].'</a></li></ul>';
  } else {
    echo '<ul class="nav nav-tabs"><li class="elgg-state-selected active"><a href="'.elgg_get_site_url().'newsfeed">'.elgg_echo('dept:activity:groupsandcolleagues').'</a></li><li><a href="'.elgg_get_site_url().'department">'.$dept[0].'</a></li></ul>';
  }

}
 ?>
