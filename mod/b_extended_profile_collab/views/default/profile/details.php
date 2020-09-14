<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the profile details for the user profile in question.
 * Requires: gcconnex-profile.js should already be loaded at this point to handle edit/save/cancel toggles and other ajax requests related to profile sections
 * font-awesome css should be loaded already
 */

echo '<style>#editProfile header { background-color: #46246A; }
.gcconnex-endorsements-count { background-color: #46246A; }</style>';

$user = elgg_get_page_owner_entity();
$profile_fields = elgg_get_config('profile_fields');
setlocale(LC_ALL, 'en_US.utf8');

// display the username, title, phone, mobile, email, website
// fa classes are the font-awesome icons

echo '<div class="panel-heading clearfix">';
echo '<h1 class="pull-left group-title">' . $user->name . '</h1>';
echo '<div class="pull-right clearfix">';
echo '<div class="gcconnex-profile-name">';
//edit button
if ($user->canEdit()) {
    echo '<a role="button" class="btn btn-primary gcconnex-edit-profile overlay-lnk" href="#editProfile">' . elgg_echo('gcconnex_profile:edit_profile') . ' <span class="wb-inv">' . elgg_echo('profile:contactinfo') . '</span></a><script>$(".gcconnex-edit-profile").on("click", function(){ $("#editProfile").focus(); });</script>';
    echo '<!-- Modal -->
<div id="editProfile" class="wb-overlay modal-content overlay-def wb-popup-mid" tabindex="-1">
    <div class="">
        <div class="">
            <header class="modal-header profile-edit-header">';
    echo '<h2 class="modal-title">' . elgg_echo('gcconnex_profile:basic:header') . '</h2>';
    echo '</header>';
    echo '<div class="panel-body overflow-body" style="padding-top: 15px; padding-bottom: 0;">';
    echo '<div class="basic-profile-standard-field-wrapper col-md-12 col-xs-12">'; // container for css styling, used to group profile content and display them seperately from other fields

    $fields = array('user_type', 'Federal', 'Provincial', 'Institution', 'University', 'College', 'Highschool', 'Municipal', 'International', 'NGO', 'Community', 'Business', 'Media', 'Retired', 'Other', 'Website');

    $fields_test = array('Name', 'Job', 'JobFr', 'Phone', 'Mobile');
    $new_address = array('streetAddress', 'city', 'province', 'postalcode', 'country');

    echo '<div class="row mrgn-bttm-md"><div class="col-sm-6"><h4 class="mrgn-tp-0">WIP DIRECTORY INFO</h4></div><div class="col-sm-6"><div class="pull-right"><span class="text-muted mrgn-rght-md">In sync with Directory </span><a href="#" role="button" class="btn btn-primary" target="_blank">Edit Profile in Directory</a></div></div></div>';

    $icon = elgg_view_entity_icon($user, $size, array(
        'use_hover' => false,
        'use_link' => false,
        'class' => 'pro-avatar',
        'force_size' => true,
    ));

    echo '<div class="row">';
    echo '<div class="col-xs-2">'.$icon.'<a href="'.elgg_get_site_url(). 'avatar/edit/' . $user->username.'" class="btn btn-primary btn-block mrgn-tp-md">'. elgg_echo('gcconnex_profile:profile:edit_avatar') .'</a></div>';
    echo '<div class="col-xs-5">';
    foreach($fields_test as $field) {
        $field = strtolower($field);
        $value = htmlspecialchars_decode($user->get($field));

        echo "<div class='form-group col-xs-12 {$field}'>";

        if($field == 'phone' || $field == 'mobile') {
            $params = array(
                'name' => $field,
                'id' => $field,
                'class' => 'gcconnex-basic-'.$field,
                'value' => $value,
                'type' => 'tel',
                'pattern' => "^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$",
            );
        } else {
            $params = array(
                'name' => $field,
                'id' => $field,
                'class' => 'gcconnex-basic-'.$field,
                'value' => $value,
            );
        }
        
        // set up label and input field for the basic profile stuff
        echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
        echo '<div class="col-sm-8">'; // field wrapper for css styling
        echo '<div class="input-group">';
        echo '<span class="input-group-addon" style="float:none;">S</span>';
        echo elgg_view("input/text", $params);
        echo '</div></div></div>';
    }
    echo '</div>';
    echo '<div class="col-xs-5">';

    foreach ($fields as $field) {

        // create a label and input box for each field on the basic profile (see $fields above)
        $field = strtolower($field);
        $value = htmlspecialchars_decode($user->get($field));
        
        if(in_array($field, array("federal", "institution", "provincial", "municipal", "international", "ngo", "community", "business", "media", "retired", "other"))) {
            echo "<div class='form-group col-xs-12 occupation-choices' id='{$field}-wrapper'>";
        } else if(in_array($field, array("university", "college", "highschool"))) {
            echo "<div class='form-group col-xs-12 occupation-choices student-choices' id='{$field}-wrapper'>";
        } else {
            echo "<div class='form-group col-xs-12 {$field}'>";
        }

        // occupation input
        if (strcmp($field, 'user_type') == 0) {
            
            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';
            echo '<div class="input-group">';
            echo '<span class="input-group-addon" style="float:none;">S</span>';
            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'options_values' => array(
                    'academic' => elgg_echo('gcconnex-profile-card:academic'),
                    'student' => elgg_echo('gcconnex-profile-card:student'),
                    'federal' => elgg_echo('gcconnex-profile-card:federal'),
                    'provincial' => elgg_echo('gcconnex-profile-card:provincial'),
                    'municipal' => elgg_echo('gcconnex-profile-card:municipal'),
                    'international' => elgg_echo('gcconnex-profile-card:international'),
                    'ngo' => elgg_echo('gcconnex-profile-card:ngo'),
                    'community' => elgg_echo('gcconnex-profile-card:community'),
                    'business' => elgg_echo('gcconnex-profile-card:business'),
                    'media' => elgg_echo('gcconnex-profile-card:media'),
                    'retired' => elgg_echo('gcconnex-profile-card:retired'),
                    'other' => elgg_echo('gcconnex-profile-card:other')
                ),
            ));
            echo '</div>';
            // jquery for the occupation dropdown - institution
    ?>

        <script>
            $(document).ready(function () {

                var user_type = $("#user_type").val();
                $('.occupation-choices').hide();
                if (user_type == 'federal') {
                    $('#federal-wrapper').fadeIn();
                } else if (user_type == 'academic' || user_type == 'student') {
                    $('#institution-wrapper').fadeIn();
                    var institution = $('#institution').val();
                    $('#' + institution + '-wrapper').fadeIn();
                } else if (user_type == 'provincial') {
                    $('#provincial-wrapper').fadeIn();
                    var province = $('#provincial').val();
                    province = province.replace(/\s+/g, '-').toLowerCase();
                    $('#' + province + '-wrapper').fadeIn();
                } else if (user_type == 'municipal') {
                    $('#provincial-wrapper').fadeIn();
                    var province = $('#provincial').val();
                    province = province.replace(/\s+/g, '-').toLowerCase();
                    $('#municipal').attr('list', 'municipal-'+province+'-list');
                    $('#municipal-wrapper').fadeIn();
                } else {
                    $('#' + user_type + '-wrapper').fadeIn();
                }

                $("#user_type").change(function() {
                    var type = $(this).val();
                    $('.occupation-choices').hide();

                    if (type == 'federal') {
                        $('#federal-wrapper').fadeIn();
                    } else if (type == 'academic' || type == 'student') {
                        if( type == 'academic' ){
                            if( $("#institution").val() == 'highschool' ){ $("#institution").prop('selectedIndex', 0); }
                            $("#institution option[value='highschool']").hide();
                        } else {
                            $("#institution option[value='highschool']").show();
                        }
                        $('#institution-wrapper').fadeIn();
                        var institution = $('#institution').val();
                        $('#' + institution + '-wrapper').fadeIn();
                    } else if (type == 'provincial') {
                        $('#provincial-wrapper').fadeIn();
                        var province = $('#provincial').val();
                        province = province.replace(/\s+/g, '-').toLowerCase();
                        $('#' + province + '-wrapper').fadeIn();
                    } else if (type == 'municipal') {
                        $('#provincial-wrapper').fadeIn();
                        var province = $('#provincial').val();
                        province = province.replace(/\s+/g, '-').toLowerCase();
                        $('#municipal').attr('list', 'municipal-'+province+'-list');
                        $('#municipal-wrapper').fadeIn();
                    } else {
                        $('#' + type + '-wrapper').fadeIn();
                    }
                });

                $("#institution").change(function() {
                    var type = $(this).val();
                    $('.student-choices').hide();
                    $('#' + type + '-wrapper').fadeIn();
                });

                $("#provincial").change(function() {
                    var type = $("#user_type").val();
                    var province = $(this).val();
                    province = province.replace(/\s+/g, '-').toLowerCase();
                    if( type == 'provincial' ){
                        $('.provincial-choices').hide();
                        $('#' + province + '-wrapper').fadeIn();
                    } else if( type == 'municipal' ){
                        $('.provincial-choices').hide();
                        $('#municipal').attr('list', 'municipal-'+province+'-list');
                    }
                });
            });
        </script>

    <?php

        // federal input field
        } else if ($field == 'federal') {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $obj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'federal_departments',
            ));
            if ( $departments = get_entity($obj[0]->guid) ){
                $federal_departments = array();
                if (get_current_language() == 'en'){
                    $federal_departments = json_decode($departments->federal_departments_en, true);
                } else {
                    $federal_departments = json_decode($departments->federal_departments_fr, true);
                }
                uasort($federal_departments, 'strcoll');
            }
            else
                $federal_departments = array('No federal departments loaded','-----','You might want to do something about that');

            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => ' gcconnex-basic-' . $field,
                'value' => $value,
                'options_values' => $federal_departments,
            ));
        
        } else if (strcmp($field, 'institution') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $institution_list = array("university" => elgg_echo('gcconnex-profile-card:university'), "college" => elgg_echo('gcconnex-profile-card:college'), "highschool" => elgg_echo('gcconnex-profile-card:highschool'));
            uasort($institution_list, 'strcoll');

            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'options_values' => $institution_list, 
            ));

        } else if (strcmp($field, 'university') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $uniObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'universities',
            ));
            if ($unis = get_entity($uniObj[0]->guid) ){
                $universities = array();
                if (get_current_language() == 'en'){
                    $universities = json_decode($unis->universities_en, true);
                } else {
                    $universities = json_decode($unis->universities_fr, true);
                }
                uasort($universities, 'strcoll');
            }
            else
                $universities = array('No universities loaded','-----','You might want to do something about that');

            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'options_values' => $universities, 
            ));       

        } else if (strcmp($field, 'college') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $colObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'colleges',
            ));
            if ($cols = get_entity($colObj[0]->guid)){
                $colleges = array();
                if (get_current_language() == 'en'){
                    $colleges = json_decode($cols->colleges_en, true);
                } else {
                    $colleges = json_decode($cols->colleges_fr, true);
                }
                uasort($colleges, 'strcoll');
            }
            else
                $colleges = array('No colleges loaded','-----','You might want to do something about that');

            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'options_values' => $colleges, 
            ));       

        // provincial input field
        } else if ($field == 'provincial') {

            echo "<label for='{$field}' class='col-sm-4 {$field}'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $provObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'provinces',
            ));
            if ($provs = get_entity($provObj[0]->guid)){
                $provincial_departments = array();
                if (get_current_language() == 'en'){
                    $provincial_departments = json_decode($provs->provinces_en, true);
                } else {
                    $provincial_departments = json_decode($provs->provinces_fr, true);
                }
                uasort($provincial_departments, 'strcoll');
                $provincial_departments_loaded = true;
            }
            else
                $provincial_departments = array('No provincial departments loaded','-----','You might want to do something about that');

            echo elgg_view('input/select', array(
                'name' => $field,
                'id' => $field,
                'class' => ' gcconnex-basic-' . $field,
                'value' => $value,
                'options_values' => $provincial_departments,
            ));

            echo "</div></div>";

            $minObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'ministries',
            ));
            if ($mins = get_entity($minObj[0]->guid)){
                $ministries = array();
                if (get_current_language() == 'en'){
                    $ministries = json_decode($mins->ministries_en, true);
                } else {
                    $ministries = json_decode($mins->ministries_fr, true);
                }
                uasort($ministries, 'strcoll');
            }
            else
                $ministries = array('No ministries loaded','-----','You might want to do something about that');

            foreach($provincial_departments as $province => $name){
                $prov_value = ($user->get('provincial') == $province) ? $user->get('ministry'): "";
                $prov_id = str_replace(" ", "-", strtolower($province));
                echo '<div class="form-group col-xs-6 occupation-choices provincial-choices" id="' . $prov_id . '-wrapper"><label for="' . $prov_id . '-choices" class="col-sm-4">' . elgg_echo('gcconnex_profile:basic:ministry') . '</label><div class="col-sm-8">';
                echo elgg_view('input/select', array(
                    'name' => 'ministry',
                    'id' => $prov_id . '-choices',
                    'class' => 'form-control gcconnex-basic-ministry',
                    'value' => $prov_value,
                    'options_values' => $ministries[$province],
                ));
                if($province != "Yukon"){ echo '</div></div>'; }
            }
            
        } else if (strcmp($field, 'municipal') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $munObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'municipal',
            ));
            $municipals = get_entity($munObj[0]->guid);
			
            echo elgg_view('input/text', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'list' => ''
            ));

            if( $provincial_departments_loaded && !empty($provincial_departments) ){
                foreach($provincial_departments as $province => $province_name){
                    $municipal = json_decode($municipals->get($province), true);
                    $prov_id = str_replace(" ", "-", strtolower($province));

                    echo '<datalist id="municipal-'.$prov_id.'-list">';
                            if( !empty($municipal) ){
                                asort($municipal);
                                
                                foreach($municipal as $municipal_name => $value){
                                    echo '<option value="' . $municipal_name . '">' . $value . '</option>';
                                }
                            }
                    echo '</datalist>';
                }
            }

        } else if (strcmp($field, 'retired') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $deptObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'federal_departments',
            ));
            if ($depts = get_entity($deptObj[0]->guid)){
                $federal_departments = array();
                if (get_current_language() == 'en'){
                    $federal_departments = json_decode($depts->federal_departments_en, true);
                } else {
                    $federal_departments = json_decode($depts->federal_departments_fr, true);
                }
                uasort($federal_departments, 'strcoll');
            }
            else
                $federal_departments = array('No federal departments loaded','-----','You might want to do something about that');

            echo elgg_view('input/text', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'list' => $field . '-list'
            ));

            echo '<datalist id="retired-list">';
                if( !empty($federal_departments) ){
                    foreach($federal_departments as $federal_name => $value){
                        echo '<option value="' . $federal_name . '">' . $value . '</option>';
                    }
                }
            echo '</datalist>';

        } else if (strcmp($field, 'other') == 0) {

            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">';

            $otherObj = elgg_get_entities(array(
                'type' => 'object',
                'subtype' => 'other',
            ));
            if ($others = get_entity($otherObj[0]->guid)){
                $other = array();
                if (get_current_language() == 'en'){
                    $other = json_decode($others->other_en, true);
                } else {
                    $other = json_decode($others->other_fr, true);
                }
                uasort($other, 'strcoll');
            }
            else
                $other = array('No other choices loaded','-----','You might want to do something about that');

            echo elgg_view('input/text', array(
                'name' => $field,
                'id' => $field,
                'class' => "gcconnex-basic-{$field}",
                'value' => $value,
                'list' => $field . '-list'
            ));

            echo '<datalist id="other-list">';
                if( !empty($other) ){
                    foreach($other as $other_name => $value){
                        echo '<option value="' . $other_name . '">' . $value . '</option>';
                    }
                }
            echo '</datalist>';

        } else {

            $params = array(
                'name' => $field,
                'id' => $field,
                'class' => 'gcconnex-basic-'.$field,
                'value' => $value,
            );

            // set up label and input field for the basic profile stuff
            echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
            echo '<div class="col-sm-8">'; // field wrapper for css styling
            echo elgg_view("input/text", $params);

        } // input field

        echo '</div>'; //close div class = basic-profile-field
        echo '</div>'; //close div class = basic-profile-field-wrapper

    } // end for-loop

    echo '</div></div>'; // close div class="basic-profile-standard-field-wrapper"
    echo '<div class="row mrgn-tp-md">';
    echo '<div class="col-sm-10 col-sm-offset-2">';
    foreach($new_address as $field) {
        $field = strtolower($field);
        $value = htmlspecialchars_decode($user->get($field));

        echo "<div class='form-group col-xs-6 {$field}'>";
        
        if ($field == 'postalcode') {
            $params = array(
                'name' => $field,
                'id' => $field,
                'class' => 'gcconnex-basic-'.$field,
                'value' => $value,
                'pattern' => '[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]',
            );
        } else {
            $params = array(
                'name' => $field,
                'id' => $field,
                'class' => 'gcconnex-basic-'.$field,
                'value' => $value,
            );
        }

        // set up label and input field for the basic profile stuff
        echo "<label for='{$field}' class='col-sm-4'>" . elgg_echo("gcconnex_profile:basic:{$field}")."</label>";
        echo '<div class="col-sm-8">'; // field wrapper for css styling
        echo '<div class="input-group">';
        echo '<span class="input-group-addon" style="float:none;">S</span>';
        echo elgg_view("input/text", $params);
        echo '</div>';
        echo '</div></div>';
    }
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5 col-sm-offset-2">';
    echo '<label for="location" class="col-sm-4">' . elgg_echo("gcconnex_profile:basic:location") .'</label>';
    echo '<div class="col-sm-8">';
    echo elgg_view("input/text", array(
        'name'=> 'location',
        'id' => 'location',
        'class' => 'gcconnex-basic-location',
        'value' => htmlspecialchars_decode($user->get('location')),
    ));
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<h3>WIP SOCIALS</h3>';
    echo '<div class="basic-profile-social-media-wrapper col-md-12 col-xs-12">'; // container for css styling, used to group profile content and display them seperately from other fields

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

        echo '<div class="basic-profile-field-wrapper social-media-field-wrapper col-md-6">'; //field wrapper for css styling

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
            <div class="panel-footer text-right profile-edit-footer">
                <button type="button" class="btn btn-default overlay-close" style="background-color: #eaebed;">' . elgg_echo('gcconnex_profile:cancel') . '</button>
                <button type="button" class="btn btn-primary save-profile">' . elgg_echo('gcconnex_profile:basic:save') . '</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->';

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

    $dbprefix = elgg_get_config("dbprefix");
    $guid = (int) $user->guid;

    $result = get_data_row("SELECT pleio_guid FROM {$dbprefix}users_entity WHERE guid = $guid");
    if ($result->pleio_guid) {
        $pleio_guid = $result->pleio_guid;
    } else {
        $pleio_guid = 'No ID';
    }


    // cyu - GCCON-151 : Add colleague in FR not there (inconsistent FR and EN menu layout) & other issues
    if (elgg_is_logged_in() && $actions) {
        $btn_friend_request = '';
        foreach ($actions as $action) {

            if (strcmp($action->getName(),'add_friend') == 0 || strcmp($action->getName(),'remove_friend') == 0) {
                if (!check_entity_relationship(elgg_get_logged_in_user_guid(),'friendrequest',$user->getGUID())) {
                    if ($user->isFriend() && strcmp($action->getName(),'remove_friend') == 0) {
                        $btn_friend_request = $action->getContent();
                        $btn_friend_request_link = $action->getHref();
                    }
                    if (!$user->isFriend() && strcmp($action->getName(),'add_friend') == 0) {
                        $btn_friend_request = $action->getContent(array('class' => 'asdfasdasfad'));
                        $btn_friend_request_link = $action->getHref();
                    }
                }
            } else {

                if (check_entity_relationship(elgg_get_logged_in_user_guid(),'friendrequest',$user->getGUID()) && strcmp($action->getName(),'friend_request') == 0) {
                    $btn_friend_request_link = $action->getHref();
                    $btn_friend_request = $action->getContent();
                } else
                    $profile_actions .= '<li>' . $action->getContent(array('class' => 'gcconnex-basic-profile-actions')) . '</li>';
            }
        }
    }
    if(elgg_is_logged_in()){
        echo "<button type='button' class='btn btn-primary' onclick='location.href=\"{$btn_friend_request_link}\"'>{$btn_friend_request}</button>"; // cyu - added button and removed from actions toggle

        echo $add . '<div class="btn-group"><button type="button" class="btn btn-custom mrgn-rght-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    foreach ($admin as $menu_item) {
        $admin_links .= '<li>' . elgg_view('navigation/menu/elements/item', array('item' => $menu_item)) . '</li>';
    }
    $admin_links .= '<li style="padding: 3px 20px">Pleio_guid: '.$pleio_guid.'</li>';

    echo '<div class="pull-right btn-group"><button type="button" class="btn btn-custom pull-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' .
    $text .  '<span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right clearfix">' . $admin_links . '</ul></div>';
}

echo '</div>'; //closes btn-group

echo '</div>'; // close div class="panel-heading"

echo '<div class="row mrgn-lft-md mrgn-rght-sm">';
echo elgg_view('profile/owner_block');
echo '<div class="col-xs-9 col-md-8 clearfix"><div class="mrgn-lft-md">';

// if user is public servant
if(strcmp($user->user_type, 'federal') == 0 ) {
    $deptObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'federal_departments',
    ));
    $depts = get_entity($deptObj[0]->guid);

    $federal_departments = array();
    if (get_current_language() == 'en'){
        $federal_departments = json_decode($depts->federal_departments_en, true);
    } else {
        $federal_departments = json_decode($depts->federal_departments_fr, true);
    }

    echo '<h3 class="mrgn-tp-0">' . $user->job . '</h3>';
    echo '<div class="gcconnex-profile-dept">' . $federal_departments[$user->federal] . '</div>';

// otherwise if user is student or academic
} else if (strcmp($user->user_type, 'student') == 0 || strcmp($user->user_type, 'academic') == 0 ) {
    echo '<h3 class="mrgn-tp-0">'.elgg_echo("gcconnex-profile-card:{$user->user_type}", array($user->user_type)).'</h3>';
    $institution = ($user->institution == 'university') ? $user->university : ($user->institution == 'college' ? $user->college : $user->highschool);
    $job = ($user->job != "") ? $user->job : "";
    echo '<div class="gcconnex-profile-dept">' . ($institution != "default_invalid_value" ? $institution : $job) . '</div>';

// otherwise if user is provincial employee
} else if (strcmp($user->user_type, 'provincial') == 0 ) {
    $provObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'provinces',
    ));
    $provs = get_entity($provObj[0]->guid);

    $provinces = array();
    if (get_current_language() == 'en'){
        $provinces = json_decode($provs->provinces_en, true);
    } else {
        $provinces = json_decode($provs->provinces_fr, true);
    }

    $minObj = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => 'ministries',
    ));
    $mins = get_entity($minObj[0]->guid);

    $ministries = array();
    if (get_current_language() == 'en'){
        $ministries = json_decode($mins->ministries_en, true);
    } else {
        $ministries = json_decode($mins->ministries_fr, true);
    }

    echo '<h3 class="mrgn-tp-0">' . elgg_echo("gcconnex-profile-card:{$user->user_type}") . '</h3>';
    echo '<div class="gcconnex-profile-job">' . $user->job . '</div>';
    $provString = $provinces[$user->provincial];
    if($user->ministry && $user->ministry !== "default_invalid_value"){ $provString .= ' / ' . $ministries[$user->provincial][$user->ministry]; }
    echo '<div class="gcconnex-profile-dept">' . $provString . '</div>';

// otherwise if user is municipal employee
} else if (strcmp($user->user_type, 'municipal') == 0 ) {
    echo '<h3 class="mrgn-tp-0">' . elgg_echo("gcconnex-profile-card:{$user->user_type}") . '</h3>';
    echo '<div class="gcconnex-profile-dept">' . $user->{$user->user_type} . ', ' . $user->provincial . '</div>';
    echo '<div class="gcconnex-profile-job">' . $user->job . '</div>';
// otherwise show basic info
} else {
    $user_type = $user->user_type != "" ? "gcconnex-profile-card:" . $user->user_type : "unknown";
    echo '<h3 class="mrgn-tp-0">' . elgg_echo($user_type) . '</h3>';
    echo '<div class="gcconnex-profile-job">' . $user->job . '</div>';
    echo '<div class="gcconnex-profile-dept">' . $user->{$user->user_type} . '</div>';
}

echo '<div class="gcconnex-profile-location">' . $user->location . '</div>';
echo '<div class="gcconnex-profile-contact-info">';

if ($user->phone != null) {
    echo '<p class="mrgn-bttm-sm"><span class="fa fa-phone fa-lg"></span> ' . $user->phone . '</p>';
}

if ($user->mobile != null) {
    echo '<p class="mrgn-bttm-sm"><span class="fa fa-mobile fa-lg"></span> ' . $user->mobile . '</p>';
}

if ($user->email != null) {
    echo '<p class="mrgn-bttm-sm"><span class="fa fa-envelope fa-lg"></span> <a href="mailto:' . $user->email . '">' . $user->email . '</a></p>';
}

if ($user->website != null) {
    echo '<p class="mrgn-bttm-sm"><span class="fa fa-globe fa-lg"></span> ';
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

        echo '<a href="' . $link . '" target="_blank"><span class="socialMediaIcons fa ' . $class . ' fa-2x"></span></a>';

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
