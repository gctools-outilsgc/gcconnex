<?php
if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$work_experience_guid = $user->work;

echo '<div class="gcconnex-profile-work-experience-display pull-left clearfix">';

if ($user->canEdit() && ($work_experience_guid == NULL || empty($work_experience_guid))) {
    echo elgg_echo('gcconnex_profile:experience:empty');
}
else {
    if (!(is_array($work_experience_guid))) {
        $work_experience_guid = array($work_experience_guid);
    }

    usort($work_experience_guid, "sortDate");

    foreach ($work_experience_guid as $guid) {

        if ($experience = get_entity($guid)) {
            echo '<div class="gcconnex-profile-label work-experience-title">' . $experience->title . '</div>';
            echo '<div class="gcconnex-profile-label work-experience-organization">' . $experience->organization . '</div>';
            
            
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
            echo '<div class="gcconnex-profile-work-experience-display gcconnex-work-experience-' . $experience->guid . '">';
            echo '<div class="gcconnex-profile-label timeStamp mrgn-tp-sm">' . $cal_month[$experience->startdate] . ', ' . $experience->startyear . ' - ';

            if ($experience->ongoing == 'true') {
                echo elgg_echo('gcconnex_profile:experience:present');
            } else {
                echo $cal_month[$experience->enddate] . ', ' . $experience->endyear;
            }

            echo '</div>';
            
            echo '<div class="gcconnex-profile-label work-experience-responsibilities mrgn-tp-md">' . $experience->responsibilities . '</div>';

            echo '<div class="gcconnex-profile-label work-experience-colleagues">';
            $colleagues = $experience->colleagues;
            if (!(is_array($colleagues))) {
                $colleagues = array($colleagues);
            }
            echo list_avatars(array(
                'guids' => $colleagues,
                'size' => 'small',
                'limit' => 0,
            ));

            echo '</div>'; // close div class="gcconnex-profile-label work-experience-colleagues"

            echo '</div>';
        }
    }
}

echo '</div>'; // close div class="gcconnex-profile-work-experience-display
//echo '</div>'; // close div class=gcconnex-profile-section-wrapper
