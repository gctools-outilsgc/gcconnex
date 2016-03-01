<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the profile details for the user profile in question.
 * Requires: gcconnex-profile.js should already be loaded at this point to handle edit/save/cancel toggles and other ajax requests related to profile sections
 * font-awesome css should be loaded already
 */

$user = elgg_get_page_owner_entity();

$profile_fields = elgg_get_config('profile_fields');

// display the username, title, phone, mobile, email, website
// fa classes are the font-awesome icons
//echo '<div id="profile-details" class="pll">';
echo '<div class="panel-heading clearfix"><div class="pull-right clearfix">';
echo '<div class="gcconnex-profile-name">';
//edit button
if ($user->canEdit()) {
    echo '<button type="button" class="btn btn-primary gcconnex-edit-profile" data-toggle="modal" data-target="#editProfile" data-colorbox-opts = \'{"inline":true, "href":"#editProfile", "innerWidth": 800, "maxHeight": "80%"}\'>' . elgg_echo('gcconnex_profile:edit_profile') . '</button>';
    echo '<!-- Modal -->
<div class="modal" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog dialog-box">
        <div class="panel panel-custom">
            <div class="panel-heading">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    echo '<h2>' . elgg_echo('gcconnex_profile:basic:header') . '</h2>';
    echo '</div>';
    echo '<div class="panel-body">';
    $editAvatar = elgg_get_site_url(). 'avatar/edit/' . $user->username;
    echo '<div><a href='.$editAvatar.' class="btn btn-primary">'. elgg_echo('gcconnex_profile:profile:edit_avatar') .'</a></div>';
    echo '<div class="basic-profile-standard-field-wrapper col-sm-6 col-xs-12">'; // container for css styling, used to group profile content and display them seperately from other fields
   
    $fields = array('Name', 'Job', 'Department', 'Location', 'Phone', 'Mobile', 'Email', 'Website');

    foreach ($fields as $field) { // create a label and input box for each field on the basic profile (see $fields above)
        echo '<div class="basic-profile-field-wrapper col-xs-12">'; // field wrapper for css styling

        $field = strtolower($field);
        echo '<label for="' . $field . '" class="basic-profile-label ' . $field . '-label">' . elgg_echo('gcconnex_profile:basic:' . $field) . '</label>'; // field label

        $value = $user->get($field);
        // setup the input for this field
        $params = array(
            'name' => $field,
            'id' => $field,
            'class' => 'gcconnex-basic-' . $field,
            'value' => $value,
        );

        if ($field == 'department') {
            echo '<div id="bloodhound" class="basic-profile-field">'; // field wrapper for css styling
        }
        else {
            echo '<div class="basic-profile-field">'; // field wrapper for css styling
        }
        echo elgg_view("input/text", $params); // input field
        echo '</div>'; //close div class = basic-profile-field

        echo '</div>'; //close div class = basic-profile-field-wrapper

    }

    echo '</div>'; // close div class="basic-profile-standard-field-wrapper"
    echo '<div class="basic-profile-social-media-wrapper col-sm-6 col-xs-12">'; // container for css styling, used to group profile content and display them seperately from other fields

// pre-populate the social media fields and their prepended link for user profiles
    


    $fields = array('Facebook' => "http://www.facebook.com/",
    'Google Plus' => "http://www.google.com/",
    'GitHub' => "https://github.com/",
    'Twitter' => "https://twitter.com/",
    'Linkedin' => "http://ca.linkedin.com/in/",
    'Pinterest' => "http://www.pinterest.com/",
    'Tumblr' => "https://www.tumblr.com/blog/",
    'Instagram' => "http://instagram.com/",
    'Flickr' => "http://flickr.com/",
    'Youtube' => "http://www.youtube.com/");
     

    foreach ($fields as $field => $field_link) { // create a label and input box for each social media field on the basic profile

        echo '<div class="basic-profile-field-wrapper social-media-field-wrapper">'; //field wrapper for css styling

        //echo '<div class="basic-profile-label social-media-label ' . $field . '-label">' . $field . ': </div>';
        $field = str_replace(' ', '-', $field); // create a css friendly version of the section name

        $field = strtolower($field);
        if ($field == "google-plus") { $field = "google"; }
        $value = $user->get($field);

        echo '<div class="input-group">'; // input wrapper for prepended link and input box, excludes the input label

        echo '<label for="' . $field . 'Input" class="input-group-addon clearfix">' . $field_link . "</label>"; // prepended link

        // setup the input for this field
        $placeholder = "test";
        if ($field == "facebook") { $placeholder = "User.Name"; }
        if ($field == "google") { $placeholder = "############"; }
        if ($field == "github") { $placeholder = "User"; }
        if ($field == "twitter") { $placeholder = "@user"; }
        if ($field == "linkedin") { $placeholder = "CustomURL"; }
        if ($field == "pinterest") { $placeholder = "Username"; }
        if ($field == "tumblr") { $placeholder = "Username"; }
        if ($field == "instagram") { $placeholder = "@user"; }
        if ($field == "flickr") { $placeholder = "Username"; }
        if ($field == "youtube") { $placeholder = "Username"; }

        $params = array(
            'name' => $field,
            'id' => $field . 'Input',
            'class' => 'editProfileFields gcconnex-basic-field gcconnex-social-media gcconnex-basic-' . $field,
            'placeholder' => $placeholder,
            'value' => $value
        );
       
        echo elgg_view("input/text", $params); // input field

        echo '</div>'; // close div class="input-group"

        echo '</div>'; // close div class = basic-profile-field-wrapper
    }

    echo '</div>'; // close div class="basic-profile-social-media-wrapper"


    echo '

    </div>
            <div class="panel-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">' . elgg_echo('gcconnex_profile:cancel') . '</button>
                <button type="button" class="btn btn-primary save-profile">' . elgg_echo('gcconnex_profile:basic:save') . '</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->';
/*
    $content = elgg_view('output/url', array(
        'href' => 'ajax/view/b_extended_profile/edit_basic',
        'class' => 'elgg-lightbox gcconnex-basic-profile-edit elgg-button',
        'text' => elgg_echo('gcconnex_profile:edit_profile')
    ));

    echo $content;
*/
}
echo '</div>'; // close div class="gcconnex-profile-name"
//actions dropdown
if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
    $menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
    $builder = new ElggMenuBuilder($menu);
    $menu = $builder->getMenu();
    $actions = elgg_extract('action', $menu, array());
    $admin = elgg_extract('admin', $menu, array());

    $profile_actions = '';
    if (elgg_is_logged_in() && $actions) {
        
        foreach ($actions as $action) {
            
            //remove add/remove actions when they are not needed
            if($user->isFriend() && strpos($action->getContent(), "Add colleague") == true){
                
            } else if(!$user->isFriend() && strpos($action->getContent(), "Remove colleague") == true){
                
            } else {
                $profile_actions .= '<li>' . $action->getContent(array('class' => 'gcconnex-basic-profile-actions')) . '</li>';
            }
        }
        
    }
    if(elgg_is_logged_in()){
        echo '<div class="btn-group"><button type="button" class="btn btn-custom mrgn-rght-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ' . elgg_echo('profile:actions') . ' <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right clearfix">';
        echo $profile_actions;
        echo '</ul></div>';
    }
}

// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
    $text = elgg_echo('admin:options');

    //$admin_links = '<ul class="profile-admin-menu-wrapper">';
    //$admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a>";
    //$admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
    foreach ($admin as $menu_item) {
        $admin_links .= '<li>' . elgg_view('navigation/menu/elements/item', array('item' => $menu_item)) . '</li>';
    }
    //$admin_links .= '</ul>';
    //$admin_links .= '</li>';
    //$admin_links .= '</ul>';
    
    echo '<div class="pull-right btn-group"><button type="button" class="btn btn-custom pull-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
                $text .  '<span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right clearfix">' . $admin_links . '</ul></div>';
}



echo '</div>'; //closes btn-group





echo '<h1 class="pull-left">' . $user->name . '</h1>';
echo '</div>'; // close div class="panel-heading"





echo '<div class="row mrgn-lft-md mrgn-rght-sm">';
echo elgg_view('profile/owner_block');
echo '<div class="col-xs-9 col-md-8 clearfix"><div class="mrgn-lft-md">';
echo '<h3 class="mrgn-tp-0">' . $user->job . '</h3>';
echo '<div class="gcconnex-profile-dept">' . $user->department . '</div>';
echo '<div class="gcconnex-profile-location">' . $user->location . '</div>';
echo '<div class="gcconnex-profile-contact-info">';

if ($user->phone != null) {
    echo '<p class="mrgn-bttm-sm"><i class="fa fa-phone fa-lg"></i> ' . $user->phone . '</p>';
}

if ($user->mobile != null) {
    echo '<p class="mrgn-bttm-sm"><i class="fa fa-mobile fa-lg"></i> ' . $user->mobile . '</p>';
}

if ($user->email != null) {
    echo '<p class="mrgn-bttm-sm"><i class="fa fa-envelope fa-lg"></i> <a href="mailto:' . $user->email . '">' . $user->email . '</a></p>';
}

if ($user->website != null) {
    echo '<p class="mrgn-bttm-sm"><i class="fa fa-globe fa-lg"></i> ';
    echo elgg_view('output/url', array(
        'href' => $user->website,
        'text' => $user->website
    ));
    echo '</p>';
}

echo '</div></div>'; // close div class="gcconnex-profile-contact-info"



// pre-populate the social media links that we may or may not display depending on whether the user has entered anything for each one..
$social = array('facebook', 'google', 'github', 'twitter', 'linkedin', 'pinterest', 'tumblr', 'instagram', 'flickr', 'youtube');

echo '<div class="gcconnex-profile-social-media-links mrgn-bttm-sm mrgn-lft-md">';
foreach ($social as $media) {

    if ($link = $user->get($media)) {

        if ($media == 'facebook') { $link = "http://www.facebook.com/" . $link; $class = "fa-facebook";}
        if ($media == 'google') { $link = "http://plus.google.com/" . $link; $class = "fa-google-plus";}
        if ($media == 'github') { $link = "https://github.com/" . $link; $class = "fa-github";}
        if ($media == 'twitter') { $link = "https://twitter.com/" . $link; $class = "fa-twitter";}
        if ($media == 'linkedin') { $link = "http://ca.linkedin.com/in/" . $link; $class = "fa-linkedin";}
        if ($media == 'pinterest') { $link = "http://www.pinterest.com/" . $link; $class = "fa-pinterest";}
        if ($media == 'tumblr') { $link = "https://www.tumblr.com/blog/" . $link; $class = "fa-tumblr";}
        if ($media == 'instagram') { $link = "http://instagram.com/" . $link; $class = "fa-instagram";}
        if ($media == 'flickr') { $link = "http://flickr.com/" . $link; $class = "fa-flickr"; }
        if ($media == 'youtube') { $link = "http://www.youtube.com/" . $link; $class = "fa-youtube";}
        
        
        echo '<a href="' . $link . '" target="_blank"><i class="socialMediaIcons fa ' . $class . ' fa-2x"></i></a>';
        
    }
}
echo '</div>'; // close div class="gcconnex-profile-social-media-links"
echo '</div>';
echo '</div>'; //closes row class




$user = elgg_get_page_owner_entity();

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
    $profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
    foreach ($actions as $action) {
        $profile_actions .= '<li>' . $action->getContent(array('class' => 'elgg-button elgg-button-action')) . '</li>';
    }
    $profile_actions .= '</ul>';
}

// content links
$content_menu_title = elgg_echo('gcconnex_profile:user_content');
$content_menu = elgg_view_menu('owner_block', array(
    'entity' => elgg_get_page_owner_entity(),
    'class' => 'profile-content-menu',
));

//echo '</div>';

//echo '<div class="b-user-menu"><div class="b-user-menu-title">' . $content_menu_title . '</div>' . $content_menu . '</div>';

