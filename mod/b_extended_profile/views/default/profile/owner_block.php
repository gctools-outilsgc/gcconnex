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
if (elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()) {
    /*
    $blicon = elgg_view('output/img', array(
        'src' => $user->getIconURL('large'),
        'alt' => 'test',
        'title' => 'test',
        'class' => 'test',
    ));*/
    /*
    $icon = elgg_view_entity_icon($user, 'large', array(
        'use_hover' => false,
        'href' => 'avatar/edit/' . $user->username,
    ));
    */
    $iconimg = '<div class="avatar-hover-edit">' . elgg_echo('gcconnex_profile:profile:edit_avatar') . '</div><img src="';
    $iconimg .= $user->getIcon('large') . '" class="avatar-profile-page img-responsive ">';

    $size = 'large';
    $icon = elgg_view('output/img', array(
        
	'src' => $user->getIconURL($size),
	'alt' => $name,
	'title' => $name,
	'class' => $img_class,
));

    $iconfinal = elgg_view('output/url', array(
            'text' => $icon,
            'href' => 'avatar/edit/' . $user->username,
            'class' => "avatar-profile-edit img-responsive"
        )
    );


}
else {
   // $icon = '<img src="';
   // $icon .= $user->getIcon('large') . '" class="avatar-profile-page img-responsive">';
    $size = 'large';
    $iconfinal = elgg_view('output/img', array(
        'text' => $iconimg,
	'src' => $user->getIconURL($size),
	'alt' => $name,
	'title' => $name,
	'class' => $img_class . ' img-responsive',
));

    /*
    $icon = elgg_view_entity_icon($user, 'large', array(
        'use_hover' => false,
    ));*/
}


//$profile_actions
echo <<<HTML

<div class="col-xs-3 col-md-4 mrgn-bttm-md" id="profile-owner-block-wet4">
	$iconfinal
</div>

HTML;
