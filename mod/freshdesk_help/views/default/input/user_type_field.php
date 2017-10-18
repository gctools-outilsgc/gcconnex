<?php

$user = elgg_get_logged_in_user_entity();

$fields = array('user_type', 'Federal', 'Provincial', 'Institution', 'University', 'College', 'Highschool', 'Municipal', 'International', 'NGO', 'Community', 'Business', 'Media', 'Retired', 'Other');

//add validation option
$none = array();
$none['None'] = '...';

foreach ($fields as $field) {

    // create a label and input box for each field on the basic profile (see $fields above)
    $field = strtolower($field);
    if(elgg_is_logged_in()){
      $value = htmlspecialchars_decode($user->get($field));
    }
    if(in_array($field, array("federal", "institution", "provincial", "municipal", "international", "ngo", "community", "business", "media", "retired", "other"))) {
        echo "<div class='form-group occupation-choices' id='{$field}-wrapper'>";
    } else if(in_array($field, array("university", "college", "highschool"))) {
        echo "<div class='form-group occupation-choices student-choices' id='{$field}-wrapper'>";
    } else {
        echo "<div class='form-group {$field}'>";
    }

    // occupation input
    if (strcmp($field, 'user_type') == 0) {

        echo "<label for='{$field}' >" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';
        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => "gcconnex-basic-{$field}",
            'value' => $value,
            'options_values' => array(
                'None' => '...',
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
                var province = $(this).val();
                province = province.replace(/\s+/g, '-').toLowerCase();
                $('.provincial-choices').hide();
                $('#' + province + '-wrapper').fadeIn();
            });
        });
    </script>

<?php

    // federal input field
    } else if ($field == 'federal') {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $obj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'federal_departments',
        ));
        $departments = get_entity($obj[0]->guid);

        $federal_departments = array();
        if (get_current_language() == 'en'){
            $federal_departments = json_decode($departments->federal_departments_en, true);
        } else {
            $federal_departments = json_decode($departments->federal_departments_fr, true);
        }

        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => ' gcconnex-basic-' . $field,
            'value' => $value,
            'options_values' => array_merge($none, $federal_departments),
        ));

    } else if (strcmp($field, 'institution') == 0) {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $institution_list = array("university" => elgg_echo('gcconnex-profile-card:university'), "college" => elgg_echo('gcconnex-profile-card:college'), "highschool" => elgg_echo('gcconnex-profile-card:highschool'));

        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => "gcconnex-basic-{$field}",
            'value' => $value,
            'options_values' => array_merge($none, $institution_list),
        ));

    } else if (strcmp($field, 'university') == 0) {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $uniObj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'universities',
        ));
        $unis = get_entity($uniObj[0]->guid);

        $universities = array();
        if (get_current_language() == 'en'){
            $universities = json_decode($unis->universities_en, true);
        } else {
            $universities = json_decode($unis->universities_fr, true);
        }

        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => "gcconnex-basic-{$field}",
            'value' => $value,
            'options_values' => array_merge($none, $universities),
        ));

    } else if (strcmp($field, 'college') == 0) {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $colObj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'colleges',
        ));
        $cols = get_entity($colObj[0]->guid);

        $colleges = array();
        if (get_current_language() == 'en'){
            $colleges = json_decode($cols->colleges_en, true);
        } else {
            $colleges = json_decode($cols->colleges_fr, true);
        }

        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => "gcconnex-basic-{$field}",
            'value' => $value,
            'options_values' => array_merge($none, $colleges),
        ));

    // provincial input field
    } else if ($field == 'provincial') {

        echo "<label for='{$field}' class=' {$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $provObj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'provinces',
        ));
        $provs = get_entity($provObj[0]->guid);

        $provincial_departments = array();
        if (get_current_language() == 'en'){
            $provincial_departments = json_decode($provs->provinces_en, true);
        } else {
            $provincial_departments = json_decode($provs->provinces_fr, true);
        }

        echo elgg_view('input/select', array(
            'name' => $field,
            'id' => $field,
            'class' => ' gcconnex-basic-' . $field,
            'value' => $value,
            'options_values' => array_merge($none, $provincial_departments),
        ));

        echo "</div></div>";

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

        foreach($provincial_departments as $province => $name){
            if(elgg_is_admin_logged_in()){
              $prov_value = ($user->get('provincial') == $province) ? $user->get('ministry'): "";
            }
            $prov_id = str_replace(" ", "-", strtolower($province));
            echo '<div class="form-group col-xs-12 occupation-choices provincial-choices" id="' . $prov_id . '-wrapper"><label for="' . $prov_id . '-choices">' . elgg_echo('freshdesk:ticket:basic:ministry') . '</label><div>';
            echo elgg_view('input/select', array(
                'name' => 'ministry',
                'id' => $prov_id . '-choices',
                'class' => 'form-control gcconnex-basic-ministry',
                'value' => $prov_value,
                'options_values' => array_merge($none, $ministries[$province]),
            ));
            if($province != "Yukon"){ echo '</div></div>'; }
        }

    } else if (strcmp($field, 'municipal') == 0) {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $munObj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'municipal',
        ));
        $municipals = get_entity($munObj[0]->guid);

        $municipal = array();
        if (get_current_language() == 'en'){
            $municipal = json_decode($municipals->other_en, true);
        } else {
            $municipal = json_decode($municipals->other_fr, true);
        }

        echo elgg_view('input/text', array(
            'name' => $field,
            'id' => $field,
            'class' => "gcconnex-basic-{$field}",
            'value' => $value,
            'list' => $field . '-list'
        ));

        echo '<datalist id="municipal-list">';
            if( !empty($municipal) ){
                foreach($municipal as $municipal_name => $value){
                    echo '<option value="' . $municipal_name . '">' . $value . '</option>';
                }
            }
        echo '</datalist>';

    } else if (strcmp($field, 'retired') == 0) {

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

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

        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>';

        $otherObj = elgg_get_entities(array(
            'type' => 'object',
            'subtype' => 'other',
        ));
        $others = get_entity($otherObj[0]->guid);

        $other = array();
        if (get_current_language() == 'en'){
            $other = json_decode($others->other_en, true);
        } else {
            $other = json_decode($others->other_fr, true);
        }

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
        echo "<label for='{$field}'>" . elgg_echo("freshdesk:ticket:basic:{$field}")."</label>";
        echo '<div>'; // field wrapper for css styling
        echo elgg_view("input/text", $params);

    } // input field

    echo '</div>'; //close div class = basic-profile-field
    echo '</div>'; //close div class = basic-profile-field-wrapper

} // end for-loop
