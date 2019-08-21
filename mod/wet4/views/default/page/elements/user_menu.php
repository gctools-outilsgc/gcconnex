<?php
/**
 * user_menu.php
 *
 * Access profile/messages/colleagues/settings
 *
 * @package wet4
 * @author GCTools Team
 */

$user = elgg_get_logged_in_user_entity();
$username = $user->username;

$dropdown = '<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
<li><a href="/profile/' . $username .'">'.elgg_echo('userMenu:profile').'</a></li>
<li><a href="/settings/user/' . $username .'">'.elgg_echo('userMenu:account').'</a></li>
<li role="separator" class="divider"></li>
<li><a href="/action/logout">'.elgg_echo('logout').'</a></li>
</ul>';

// TODO: Add badge to show user has actionable items
/*
$options = array(
    "type" => "user",
    "relationship" => "friendrequest",
    "relationship_guid" => $user->getGUID(),
    "inverse_relationship" => true,
    "limit" => 1,
);

$friend_count = elgg_get_entities_from_relationship($options);

echo count($friend_count);

$user = elgg_get_logged_in_user_entity();

$list = elgg_get_entities_from_metadata(array(
        'type' => 'object',
        'subtype' => 'messages',
        'owner_guid' => $user->guid,
        'full_view' => false,
        'metadata_name' => 'readYet',
        'metadata_value' => false,
        'limit' => 1,
    ));
    
echo count($list);
*/

// cyu - remove the user menu when the gsa hits the page
if ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false )
{
    // do nothing
} else {
    ?>

    <ul class="elgg-menu elgg-menu-user-menu list-inline visited-link elgg-menu-user-menu-default">
        <?php if(elgg_is_admin_logged_in()) {
            // admin
            echo '<li class="elgg-menu-item-admin">
                <a href="/admin" title="Admin" class="elgg-menu-content">
                    <i class="fa fa-wrench fa-lg mrgn-rght-sm"></i>
                    <span class="hidden-xs">Admin</span>
                </a>
            </li>';
        } ?>
        <li>
            <?php 
                echo elgg_view('output/url', array(
                    'text' => '<i class="fa fa-bookmark fa-lg"><span class="wb-invisible">Bookmark</span></i>',
                    'href' => '/bookmarks/owner/' .$username,
                ));
            ?>
        </li>
        <li class="elgg-menu-item-colleagues">
            <?php
                // colleagues
                echo '<a href="/friends/'.$username.'" title="'.elgg_echo("userMenu:colleagues").'" class="elgg-menu-content">
                    <i class="fa fa-users fa-lg"><span class="wb-invisible">'.elgg_echo("userMenu:colleagues").'</span></i>
                </a>';
            ?>
        </li>
        <li class="elgg-menu-item-notifications messagesLabel close-notif-dd">
            <?php
                // notifications
                echo '<a href="/messages/notifications/'.$username.'" title="'.elgg_echo('notifications:subscriptions:changesettings').'" data-dd-type="notif_dd" class="elgg-menu-content">
                    <i class="fa fa-bell fa-lg"><span class="wb-inv">'.elgg_echo('notifications:subscriptions:changesettings').'</span></i>   
                </a>';
            ?>
        </li>
        <li class="elgg-menu-item-profile dropdown">
            <?php
                // profile / settings / logout
                echo '<a href="#" title="'.elgg_echo('userMenu:usermenuTitle').'" data-toggle="dropdown" id="dropdownMenu" aria-haspopup="true" tab-index="0" class="elgg-menu-content dropdown-toggle  dropdownToggle dd-close" aria-expanded="false"> 
                    <img class="img-circle" alt="" src="'. elgg_get_logged_in_user_entity()->geticonURL("small"). '">
                    <span class="wb-invisible">'.elgg_echo('userMenu:profile').'</span>
                </a>';
            echo $dropdown;
            ?>
        </li>
    </ul>
    <?php
}
