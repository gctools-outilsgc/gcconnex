<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Ajax view for editing the about-me entry for user profiles
 * Requires: tinyMCE (which is loaded as a plugin in the prod GCconnex environment)
 */

if (elgg_is_xhr()) {  //This is an Ajax call!

    // load the user entity
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    //$profile_fields = elgg_get_config('profile_fields');
    // allow the user to edit the access settings for education entries
    echo '<label for="aboutAccess">' . elgg_echo('gcconnex_profile:about_me:access') . '</label>';

    $metadata = elgg_get_metadata(array(
        'guid' => $user_guid,
        'metadata_name' => 'description',
        'limit' => false
    ));

    // access is granted the same as the rest of the user profile
    $params = array(
        'name' => "accesslevel['aboutme']",
        'id' => "aboutAccess",
        'value' => $metadata[0]['access_id'],
        'class' => 'gcconnex-about-me-access'
    );

    echo elgg_view('input/access', $params);


    // get the about-me text (saved in ->description)
    $value = $user->description;

    // setup the about-me longtext input
    $params = array(
        'name' => 'description',
        'id' => 'aboutme',
        'class' => 'mceContentBody about-me-longtext',
        'value' => $value,
    );

    echo '<label class="mrgn-tp-sm" for="aboutme">' . elgg_echo('description') . ':</label>';

    // about-me longtext input
    echo elgg_view("input/longtext", $params);

    $access_id = ACCESS_DEFAULT; // @todo: set this access based on user settings

}

else {  // In case this view will be called via elgg_view()
    echo 'ERROR: Tell sys admin to grep for: AFJ367FAXB'; // random alphanumeric string to grep later if needed
}
?>
<!-- initialize and load the longtext wysiwyg editor 
<script type="text/javascript">
    tinyMCE.init({
        mode : "exact",
        elements: "aboutme"
    });
</script>-->