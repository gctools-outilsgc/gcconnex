<?php

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$education_guid = $user->education;

echo '<div class="gcconnex-profile-education-display ">';

if ($user->canEdit() && ($education_guid == NULL || empty($education_guid))) {
    echo elgg_echo('gcconnex_profile:education:empty');

}else {

    if (!(is_array($education_guid))) {
        $education_guid = array($education_guid);
    }
    usort($education_guid, "sortDate");

    foreach ($education_guid as $guid) {

        if ($education = get_entity($guid)) {

            echo '<div class="gcconnex-profile-education-display gcconnex-education-' . $education->guid . '">';
            echo '<div class="gcconnex-profile-label education-school">' . htmlspecialchars_decode($education->school) . '</div>';
            echo '<div class="gcconnex-profile-label education-degree">' . htmlspecialchars_decode($education->degree) . '<span aria-hidden="true"> - </span><span class="wb-invisible"> '.elgg_echo('profile:content:for').' </span>' . htmlspecialchars_decode($education->field) . '</div>';
            
            $cal_month = array(
                    1 => elgg_echo('gcconnex_profile:month:january'),
                    2 => elgg_echo('gcconnex_profile:month:february'),
                    3 => elgg_echo('gcconnex_profile:month:march'),
                    4 => elgg_echo('gcconnex_profile:month:april'),
                    5 => elgg_echo('gcconnex_profile:month:may'),
                    6 => elgg_echo('gcconnex_profile:month:june'),
                    7 => elgg_echo('gcconnex_profile:month:july'),
                    8 => elgg_echo('gcconnex_profile:month:august'),
                    9 => elgg_echo('gcconnex_profile:month:september'),
                    10 => elgg_echo('gcconnex_profile:month:october'),
                    11 => elgg_echo('gcconnex_profile:month:november'),
                    12 => elgg_echo('gcconnex_profile:month:december')
                );
            echo '<div class="gcconnex-profile-label timeStamp">' . $cal_month[$education->startdate] . ', ' . $education->startyear . '<span aria-hidden="true"> - </span><span class="wb-invisible"> '.elgg_echo('profile:content:to').' </span>';

            if ($education->ongoing == 'true') {
                echo elgg_echo('gcconnex_profile:education:present');
            } else {
                echo $cal_month[$education->enddate] . ', ' . $education->endyear;
            }
            echo '</div>';
            echo '</div>';
        }
    }
}

echo '</div>'; // close div class="gcconnex-profile-education-display"
