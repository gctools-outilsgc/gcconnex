<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the profile owner's profile picture/icon and any admin links if necessary. Adapted from the file with the same name in the c_module_dump plugin.
 */
?>
<!-- Probably unnecessary styling but it was written by Christine and included in the c_module_dump plugin (under /views/default/profile/ownder_block.php)
    so leaving it here in case it's needed -->
    <style>
        .c_table {
            border:1px solid #ccc;
            background-color:;
        }

        .table th,td {
            padding:10px;
        }

    </style>

<?php

$user = elgg_get_page_owner_entity();
$name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8', false);
if (!$user) {
    // no user so we quit view
    echo elgg_echo('viewfailure', array(__FILE__));
    return TRUE;
}

// @todo: create a link to edit the user profile picture

// just dont display anything with icons when gsa hits page
if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') === false) {
    if (elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {

        $iconimg = '<div class="avatar-hover-edit">' . elgg_echo('gcconnex_profile:profile:edit_avatar') . '</div><img src="';
        $iconimg .= $user->getIcon('large') . '" class="avatar-profile-page img-responsive ">';
        $size = 'medium';

        //Ew - change icon display to show badge if they have one
        $icon = elgg_view_entity_icon($user, $size, array(
            'use_hover' => false,
            'use_link' => false,
            'class' => 'pro-avatar',
            'force_size' => true,
        ));

        $iconfinal = elgg_view('output/url', array(
                'text' => $icon,
                'href' => 'avatar/edit/' . $user->username,
                'class' => " img-responsive img-circle",
                'title' => elgg_echo('gcconnex_profile:profile:edit_avatar')
            )
        );
    }else {

        $size = 'medium';

        //Ew - change icon display to show badge if they have one
        $iconfinal = elgg_view_entity_icon($user, $size, array(
            'use_hover' => false,
            'use_link' => false,
            'class' => 'pro-avatar',
            'force_size' => true,
        ));
    }
}
//$profile_actions
echo <<<HTML

<div class="col-xs-3 col-md-4 mrgn-bttm-md" id="profile-owner-block-wet4">
	$iconfinal
</div>

HTML;
