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

$options = array(
    "type" => "user",
    "relationship" => "friendrequest",
    "relationship_guid" => $user->getGUID(),
    "inverse_relationship" => true,
    "limit" => 1,
);

$friend_count = elgg_get_entities_from_relationship($options);

if(count($friend_count) > 0){
    $friend_badge = '<span class="notif-badge um-badge"><span class="wb-invisible">'.elgg_echo('friend_request:new').'</span></span>';
}

$db_prefix = elgg_get_config('dbprefix');
$user_guid = $user->guid;
$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1);
$map = array();
foreach ($strings as $string) {
	$id = elgg_get_metastring_id($string);
	$map[$string] = $id;
}

$list = elgg_get_entities_from_metadata(array(
        'type' => 'object',
        'subtype' => 'messages',
        'joins' => array(
			"JOIN {$db_prefix}metadata msg_toId on e.guid = msg_toId.entity_guid",
			"JOIN {$db_prefix}metadata msg_readYet on e.guid = msg_readYet.entity_guid",
			"JOIN {$db_prefix}metadata msg_msg on e.guid = msg_msg.entity_guid",
		),
		'wheres' => array(
			"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
			"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
			"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
		),
        'owner_guid' => $user->guid,
        'full_view' => false,
        'distinct' => false,
        'limit' => 1,
    ));

if(count($list) > 0){
    $notification_badge = '<span class="notif-badge um-badge"><span class="wb-invisible">'.elgg_echo('messages:unreadmessages').'</span></span>';
}

// cyu - remove the user menu when the gsa hits the page
if ( strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') !== false )
{
    // do nothing
} else {
    ?>

    <ul class="elgg-menu elgg-menu-user-menu list-inline visited-link elgg-menu-user-menu-default">
        
        <li>
            <?php 
                // invite button removed 
                // echo elgg_view('output/url', array(
                    // 'text' => elgg_echo('invite'),
                    // 'href' => '/invite/' .$username,
                    // 'class' => 'btn btn-primary invite-btn'
                // ));
            ?> 

        </li>
        <li class="elgg-menu-item-search">
            <button type="button" class="btn btn-link" href="/search" title="Search" tabindex="0" data-toggle="collapse" data-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch"> 
                <span class="glyphicon-search glyphicon" style="color:#36013f"></span>
            </button> 
        <?php 

            //search tag label in the user menu 
            //echo '<label for="tagSearch" class="wb-inv">'.elgg_echo('wet:searchHead').'</label>';
            //echo elgg_view('input/text', array(
            //    'id' => 'tagSearch',
            //    'name' => 'tag',
            //    'class' => 'elgg-input-search mbm',
            //   'placeholder' => elgg_echo('wet:searchgctools'),
            //    'required' => true
            //));
            //echo elgg_view('input/submit', array('value' => '<span class="glyphicon-search glyphicon"></span> ' . elgg_echo(' '))); 
        ?>
        </li>
        
        <li class="elgg-menu-item-gcmessages">
            <a href="https://message.gccollab.ca" style="color:#6b5088;" title="GCMessage" tabindex="0">
                <img style="width:25px; display:inline-block; margin-right:3px;" src="/mod/gccollab_theme/graphics/message_icon_pilot.png" alt="GCMessages">
            </a>
        </li>

        <?php if(elgg_is_admin_logged_in()) {
            // admin
            echo '<li class="elgg-menu-item-admin">
                <a href="/admin" title="Admin" class="elgg-menu-content" tabindex="0">
                    <span class="fa fa-wrench fa-lg mrgn-rght-sm"></span>
                </a>
            </li>';
        } ?>
        <li>
            <?php 
            // bookmarks
                echo elgg_view('output/url', array(
                    'text' => '<span class="fa fa-bookmark fa-lg" tabindex="0"><span class="wb-invisible">'.elgg_echo('bookmarks').'</span></span>',
                    'href' => '/bookmarks/owner/' .$username,
                    'title' => elgg_echo('bookmarks')
                ));
            ?>
        </li>
        <li class="elgg-menu-item-notifications messagesLabel close-notif-dd">
            <?php
                // notifications
                echo '<a href="/messages/notifications/'.$username.'" title="'.elgg_echo('notifications:subscriptions:changesettings').'" data-dd-type="notif_dd" class="elgg-menu-content" tabindex="0">
                    <span class="fa fa-bell fa-lg"><span class="wb-inv">'.elgg_echo('notifications:subscriptions:changesettings').'</span></span>'.$notification_badge.'   
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
