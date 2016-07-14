<?php

$user = elgg_get_logged_in_user_entity();

$value = $user->get(department);

$obj = elgg_get_entities(array(
       'type' => 'object',
       'subtype' => 'dept_list',
       'owner_guid' => 0
));
if (get_current_language()=='en'){
    //$metaname = "deptsEn";
    $departments = $obj[0]->deptsEn;
    $departments = json_decode($departments, true);
    $provinces['pov-alb'] = 'Government of Alberta';
    $provinces['pov-bc'] = 'Government of British Columbia';
    $provinces['pov-man'] = 'Government of Manitoba';
    $provinces['pov-nb'] = 'Government of New Brunswick';
    $provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
    $provinces['pov-ns'] = 'Government of Nova Scotia';
    $provinces['pov-nwt'] = 'Government of Northwest Territories';
    $provinces['pov-nun'] = 'Government of Nunavut';
    $provinces['pov-ont'] = 'Government of Ontario';
    $provinces['pov-pei'] = 'Government of Prince Edward Island';
    $provinces['pov-que'] = 'Government of Quebec';
    $provinces['pov-sask'] = 'Government of Saskatchewan';
    $provinces['pov-yuk'] = 'Government of Yukon';
    $departments = array_merge($departments,$provinces);
}else{
    //$metaname = "deptsFr";
    $departments = $obj[0]->deptsFr;
    $departments = json_decode($departments, true);
    $provinces['pov-alb'] = "Gouvernement de l'Alberta";
    $provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
    $provinces['pov-man'] = 'Gouvernement du Manitoba';
    $provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
    $provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
    $provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
    $provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
    $provinces['pov-nun'] = 'Gouvernement du Nunavut';
    $provinces['pov-ont'] = "Gouvernement de l'Ontario";
    $provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
    $provinces['pov-que'] = 'Gouvernement du Québec';
    $provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
    $provinces['pov-yuk'] = 'Gouvernement du Yukon';
    $departments = array_merge($departments,$provinces);
}

$value = explode(" / ", $value);
//error_log("test".array_search($value[0], json_decode($departments, true)));
$key = array_search($value[0], $departments);
if ($key === false){
    $key = array_search($value[1], $departments);
}


echo '<div class="verify-content" style="max-width:600px;">';

echo '<h1>'. elgg_echo('dept:confirm') .'</h1>';

echo '<p class="mrgn-tp-md">'. elgg_echo('dept:intro') .'</p>';

echo '<p class="mrgn-tp-md mrgn-bttm-md"><strong>' . elgg_echo('gcconnex_profile:basic:department') . '</strong>' .$user->department . '</p>';

//check if the department is part of the department dropdown
//if not, make them choose the department from dropdown
if($key){

    echo elgg_view('input/checkbox', array(
            'id' => 'change'
        ));
    echo '<label for="change" class="mrgn-lft-sm">'. elgg_echo('dept:not') .'</label><br>';


    echo '<div class="collapse" id="collapseExample">
  <div class="well" style="border-radius:0px">';


    //Department dropdown

    echo '<label for="department" class="mrgn-lft-sm">'. elgg_echo('dept:select') .'</label><br>';

    echo '<div class="">';

    //error_log('value: '.$key);
    //echo "lang".get_current_language();
    //$departments = $meta[0]->value;//array(1, 2, 3);
    echo elgg_view('input/select', array(
        'name' => 'department',
        'id' => 'department',
        //'disabled'=>'disabled',
        'value' => $key,
        'options_values' => $departments,

    ));

    echo '</div></div></div>';
} else {

    echo '<p class="alert alert-warning mrgn-bttm-md">'. elgg_echo('dept:notfound') .'</p>';

    echo elgg_view('input/select', array(
       'name' => 'department',
       'id' => 'department',
       //'disabled'=>'disabled',
       'value' => $key,
       'options_values' => $departments,
       'class' => 'mrgn-bttm-md'
   ));

}

//confirm button
echo elgg_view('output/url', array(
        'text' => elgg_echo('confirm'),
        'href' => '#',
        'id' => 'verifySubmit',
        'class' => 'btn btn-primary mrgn-tp-sm',
    ));
?>

<script>
    //expand lightbox and show department dropdown
    $('#change').click(function () {

        var Height = $('#colorbox').outerHeight();



        if ($('#collapseExample').hasClass('in')) {
            $('.collapse').collapse('toggle');
            $('#colorbox').height(Height - 100);
            $('#cboxWrapper').height(Height - 100);
            $('#cboxContent').height(Height - 100);
            $('#cboxLoadedContent').height(Height - 100);

        } else {
            $('.collapse').collapse('toggle');
            $('#colorbox').height(Height + 100);
            $('#cboxWrapper').height(Height + 100);
            $('#cboxContent').height(Height + 100);
            $('#cboxLoadedContent').height(Height + 100);

        }



    });


    //elgg action to save department and close lightbox
    $('#verifySubmit').click(function () {
        elgg.action('department/verify_department', {
            data: {
                department: $('#department').val(),
            },
            success: function () {
                document.getElementById("cboxClose").click();
            }
        });
    });


</script>

