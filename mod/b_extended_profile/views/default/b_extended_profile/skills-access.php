<?php 
//error_log($_GET["guid"]);
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    // allow the user to edit the access settings for work experience entries
    echo '<div id=skillsAccessContainer>';
    echo '<label for="skillsAccess">' . elgg_echo('gcconnex_profile:gc_skill:access') . '</label>';

    $access_id = $user->skill_access;
    $params = array(
        'name' => "accesslevel['skills']",
        'id' => "skillsAccess",
        'class' => "gcconnex-skills-access",
        'value' => $access_id
    );

    echo elgg_view('input/access', $params);
    echo '</div>';