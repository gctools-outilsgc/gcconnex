<?php

/**
 * This extends the help page to contain links to start the modules from the help contact form
 *Contains links to profile module, group module, group tour link
 * @version 1.0
 * @author Nick
 */
$site_url = elgg_get_site_url();
$welcome_module_link = $site_url .'newsfeed?welcome=true';
$profile_module_link = $site_url .'profileonboard';
$group_module_link = $site_url .'groupsonboard';
//Production Welcome Group = 19980634
//Pre Prod Welcome Group = 17265559
$welcomeGroup_guid = elgg_get_plugin_setting("tour_group", "gc_onboard_collab");

if(!$welcomeGroup_guid){
    $welcomeGroup_guid = 967;
}

$group_tour_link = $site_url.'groups/profile/'.$welcomeGroup_guid .'?first_tour=true&help_launch=true';

?>

<h1 class="mrgn-bttm-md"><?php echo elgg_echo('onboard:helpHeader');?></h1>

<div class="col-sm-6 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h2><?php echo elgg_echo('onboard:helpWelcome'); ?></h2></div>
    <div class="panel-body">
      <p><?php echo elgg_echo('onboard:helpWelcome:info') ?></p>
      <a class="pull-right" href="<?php echo $welcome_module_link;?>"> <?php echo elgg_echo('onboard:helpWelcome'); ?></a>
    </div>
  </div>
</div>

<div class="col-sm-6 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h2><?php echo elgg_echo('onboard:helpProfile'); ?></h2></div>
    <div class="panel-body">
      <p><?php echo elgg_echo('onboard:helpProfile:info') ?></p>
      <a class="pull-right" href="<?php echo $profile_module_link;?>"> <?php echo elgg_echo('onboard:helpProfile'); ?></a>
    </div>
  </div>
</div>

<div class="col-sm-6 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h2><?php echo elgg_echo('onboard:helpGroup'); ?></h2></div>
    <div class="panel-body">
      <p><?php echo elgg_echo('onboard:helpGroup:info') ?></p>
      <a class="pull-right" href="<?php echo $group_module_link;?>"> <?php echo elgg_echo('onboard:helpGroup'); ?></a>
    </div>
  </div>
</div>

<div class="col-sm-6 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-heading"><h2><?php echo elgg_echo('onboard:helpGroupTour'); ?></h2></div>
    <div class="panel-body">
      <p><?php echo elgg_echo('onboard:helpGroupTour:info') ?></p>
      <a class="pull-right" href="<?php echo $group_tour_link;?>"> <?php echo elgg_echo('onboard:helpGroupTour'); ?></a>
    </div>
  </div>
</div>
