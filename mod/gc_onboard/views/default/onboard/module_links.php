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
$welcomeGroup_guid = elgg_get_plugin_setting("tour_group", "gc_onboard");

if(!$welcomeGroup_guid){
    $welcomeGroup_guid = 19980634;
}

$group_tour_link = $site_url.'groups/profile/'.$welcomeGroup_guid .'?first_tour=true&help_launch=true';

?>

 <h3> <?php echo elgg_echo('onboard:helpHeader');?> </h3>
<ul class="list-unstyled">
    <li><a href="<?php echo $welcome_module_link;?>"> <?php echo elgg_echo('onboard:helpWelcome'); ?></a></li>
    <li><a href="<?php echo $profile_module_link;?>"> <?php echo elgg_echo('onboard:helpProfile'); ?></a></li>
    <li><a href="<?php echo $group_module_link;?>"> <?php echo elgg_echo('onboard:helpGroup'); ?></a></li>
    <li><a href="<?php echo $group_tour_link;?>"> <?php echo elgg_echo('onboard:helpGroupTour'); ?></a></li>
</ul>