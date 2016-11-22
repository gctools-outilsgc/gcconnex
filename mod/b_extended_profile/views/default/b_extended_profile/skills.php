<?php
/***************************************************************************************
 * Modifications:					
 * Name 	Modification date 	Description
 * Nick P	2016-11-04		    github #309 - Making it so this message can only be viewed by the page owner
 ****************************************************************************************/

$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

// if skills isn't empty, display them so that the user can use them as a guide
if ($user->skills != NULL && $user->skillsupgraded == NULL) {
    if(elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()){
        echo '<div class="gcconnex-old-skills">';
        echo '<div class="gcconnex-old-skills-message">' . elgg_echo('gcconnex_profile:gc_skill:leftover') . '</div>';
        echo '<div class="gcconnex-old-skills-display">';

        if (is_array($user->skills)) {
            foreach ($user->skills as $oldskill)
                echo $oldskill . '<br>';
        }

        echo '</div><br>'; // close div class="gcconnex-old-skills-display
        echo '<span class="gcconnex-old-skills-stop-showing gcconnex-profile-button" onclick="removeOldSkills()">Stop showing me this message.</span>';
        echo '</div>'; // close div class="gcconnex-old-skills"
    
    }

}

$skill_guids = $user->gc_skills;

echo '<div class="gcconnex-profile-skills-display">';
echo '<div class="gcconnex-skills-skills-list-wrapper">';

if ( elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid() ) {
    echo '<div class="gcconnex-skill-limit">' . elgg_echo('gcconnex_profile:gc_skill:click') . '</div>';
}

if ($user->canEdit() && ($skill_guids == NULL || empty($skill_guids))) {
    echo elgg_echo('gcconnex_profile:gc_skill:empty');
}
else {
    echo '<div class="gcconnex-skill-limit hidden">' . elgg_echo('gcconnex_profile:gc_skill:limit') . '</div>';
    if (!(is_array($skill_guids))) {
        $skill_guids = array($skill_guids);
    }
// if the skill list isn't empty, and a logged-in user is viewing this page... show skills
    if (elgg_is_logged_in()) {
        for ($i=0; $i<20; $i++) {
            $skill_guid = $skill_guids[$i];
            if ($skill = get_entity($skill_guid)) {
                $skill_class = str_replace(' ', '-', strtolower($skill->title));
                $endorsements = $skill->endorsements;

                if (!(is_array($endorsements))) {
                    $endorsements = array($endorsements);
                }

                if ( elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid() ) {
                    if (in_array(elgg_get_logged_in_user_guid(), $endorsements) == false || empty($endorsements)) {
                        // user has not yet endorsed this skill for this user.. present the option to endorse

                        echo '<div class="gcconnex-skill-entry clearfix" data-guid="' . $skill_guid . '">        <div class="skill-container pointer  gcconnex-endorsement-add clearfix" tabIndex="0" onclick="addEndorsement(this)" title="Endorse / Valider" style="display:inline-block" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">';
                        echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

                    } else {
                        // user has endorsed this skill for this user.. present the option to retract endorsement

                        echo '<div class="gcconnex-skill-entry clearfix" data-guid="' . $skill_guid . '">        <div class="skill-container pointer gcconnex-endorsement-retract clearfix" tabIndex="0" onclick="retractEndorsement(this)" title="Retract"  style="display:inline-block" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">';
                        echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';
                    }
                } else {
                    echo '<div class="gcconnex-skill-entry clearfix" data-guid="' . $skill_guid . '"><div class="skill-container clearfix" style="display:inline-block">';
                    echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';
                }
                echo '</div><div class="gcconnex-skill-endorsements clearfix" style="display:inline-block">';
                    echo list_avatars(array(
                        'guids' => $skill->endorsements,
                        'size' => 'tiny',
                        'limit' => 4,
                        'id' => "myModal" . $i,
                        'skill_guid' => $skill_guid
                    ));

                    echo '</div>'; // close div class="gcconnex-skill-endorsements"
                echo '</div>'; // close div class=gcconnex-skill-entry
            }
        }
    }
}

echo '</div>';
echo '</div>';