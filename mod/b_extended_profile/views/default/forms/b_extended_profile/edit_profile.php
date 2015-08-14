<style>
    body {
        font-family: arial;
    }
    .c_table {
        border:1px solid #ccc;
        background-color: orangered;
    }

    h1 {
        padding: 0px;
        margin: 0px;
        color: #3c698e;
    }

    .basic-profile-label {
        margin: 5px;
        float: left;
        text-align: right;
        width: 120px;
        padding-top: 4px;
    }



    .basic-profile-field {
        margin: 3px;
        float: left;
    }



    .table th,td {
        padding: 10px;
    }


    .c_table {
        display: none;
    }



    .basic-profile-standard-field-wrapper,
    .basic-profile-social-media-wrapper,
    .basic-profile-micro-assignments {
        float: left;
    }

    .basic-profile-standard-field-wrapper,
    .basic-profile-social-media-wrapper {
        width: 375px;
    }



    p {
        padding-top: 5px;
    }

    .gcconnex-micro-checkbox {
        padding: 5px;
        font-weight: bold;
    }


</style>


<?php
echo '<div class="modal-header">';


$guid = elgg_get_logged_in_user_guid();
$user = get_user($guid);

// pre-populate which fields to display on the "edit basic profile" overlay


echo '<div class="gcconnex-b-extended-profile-edit-profile">';

echo '<div class="basic-profile">'; // outer container for all content (except the form title above) for css styling

/*
echo '<div class="basic-profile-field-wrapper">';
echo '<div class="basic-profile-label">Manager: </div><div class="basic-profile-field">';

$manager_id = $user->get('manager-id');
$manager = get_user($manager_id);

echo elgg_view("input/text", array(
    'id' => "manager",
    'name' => "manager",
    'class' => "manager typeahead",
    'value' => $manager->name
));



echo elgg_view("input/text", array(
    'id' => "manager-id",
    'name' => "manager-id",
    'class' => "manager-id",
    'value' => $user->get('manager-id')
));
echo '</div>';
echo '</div>';
*/
echo '</div>';


// THIS BLOCK COMMENTED OUT UNTIL MICRO-MISSIONS ARE ENABLED
/*
echo '<div class="basic-profile-micro-assignments">'; // container for css styling, used to group profile content and display them seperately from other fields

echo elgg_echo('gcconnex_profile:basic:micro_confirmation');
echo '<div class="gcconnex-micro-checkbox">';

echo elgg_view('input/checkbox', array(
    'name' => 'micro',
    'checked' => ($user->micro == "on") ? "on" : FALSE)); // elgg has a hard time saving checkbox status natively, so check the string value instead
echo elgg_echo('gcconnex_profile:basic:micro_checkbox') . '</div>'; // close div class="gcconnex-micro-checkbox"

*/


echo '<div class="submit-basic-profile">'; // container for css styling, used to group profile content and display them separately from other fields

// create the save button for saving user profile

echo '</div>'; // close div class="submit-basic-profile"

echo '</div>'; // close div class="basic-profile-micro-assignments

echo '</div>'; // close div class="basic-profile"

echo '</div>'; // cloase div class="gcconnex-b-extended-profile-edit-profile"
