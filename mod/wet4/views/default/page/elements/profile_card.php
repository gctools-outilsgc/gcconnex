<?php
/*
 * profile_card.php
 * 
 * Formats the users information and the logout / settings buttons into the profile card. This drops down from the user menu
 * 
 * @package wet4
 * @author GCTools Team
 */

$site_url = elgg_get_site_url();
$user = elgg_get_logged_in_user_entity()->username;
$displayName = elgg_get_logged_in_user_entity()->name;
$user_avatar = elgg_get_logged_in_user_entity()->geticonURL('medium');
$email = elgg_get_logged_in_user_entity()->email;

$department = elgg_get_logged_in_user_entity()->get('department');
?>

<div>
    <ul class="list-unstyled">
        <li><a href="<?php echo  $site_url ?>profile/<?php echo  $user ?>" class=""><?php echo elgg_echo('userMenu:profile') ?></a></li>
        <li><a href="<?php echo  $site_url ?>settings/user/<?php echo $user ?>" class=""><?php echo elgg_echo('userMenu:account') ?></a></li>
        <li><a href="<?php echo  $site_url ?>action/logout" class=""><?php echo elgg_echo('logout') ?></a></li>
    </ul>
</div>