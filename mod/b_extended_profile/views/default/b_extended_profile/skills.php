<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

// if skills isn't empty, display them so that the user can use them as a guide
if ($user->skills != NULL && $user->skillsupgraded == NULL) {
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

$skill_guids = $user->gc_skills;

echo '<div class="gcconnex-profile-skills-display">';
echo '<div class="gcconnex-skills-skills-list-wrapper">';

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
                echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guid . '">';
                echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

                $endorsements = $skill->endorsements;
                if (!(is_array($endorsements))) {
                    $endorsements = array($endorsements);
                }

                if ( elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid() ) {
                    if (in_array(elgg_get_logged_in_user_guid(), $endorsements) == false || empty($endorsements)) {
                        // user has not yet endorsed this skill for this user.. present the option to endorse

                        echo '<button class="gcconnex-endorsement-add btn-endorse" onclick="addEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">' . elgg_echo('gcconnex_profile:gc_skill:endorse') . '</button>';
                    } else {
                        // user has endorsed this skill for this user.. present the option to retract endorsement
                        echo '<button class="gcconnex-endorsement-retract btn-endorse" onclick="retractEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">Retract</button>';

                    }
                }
                echo '<div class="gcconnex-skill-endorsements">';
                    echo list_avatars(array(
                        'guids' => $skill->endorsements,
                        'size' => 'tiny',
                        'limit' => 10,
                        'id' => "myModal" . $i
                    ));
                    /*echo '<div class="modal" id="myModal' . $i . '">
                          <div class="modal-header">
                            <button class="close" data-dismiss="modal">×</button>
                            <h3>Endorsements</h3>
                          </div>
                          <div class="modal-body">
                            <p>';
                    echo list_avatars(array(
                        'guids' => $skill->endorsements,
                        'size' => 'medium',
                        'limit' => 0
                    ));
                    echo '</p>
                          </div>
                          <div class="modal-footer">
                            <a href="#" class="btn" data-dismiss="modal">Close</a>
                          </div>
                        </div>';*/
                    echo '</div>'; // close div class="gcconnex-skill-endorsements"
                echo '</div>'; // close div class=gcconnex-skill-entry
            }
        }
    }
}

//echo '</div></div><div class="endorsements-message"></div>';
echo '</div>';
echo '</div>';
//echo '</div>'; // close div class=gcconnex-profile-section-wrapper
