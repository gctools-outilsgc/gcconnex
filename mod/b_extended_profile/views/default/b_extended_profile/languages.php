<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 26/03/15
 * Time: 10:30 AM
 */

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$english = $user->english;
$french = $user->french;
$languages_guid = $user->languages;

echo '<div class="gcconnex-profile-languages-display">';

if ($user->canEdit() && ($languages_guid == NULL || empty($languages_guid))) {
    if ( $english == NULL || empty($english) ) {
        // no english entered
        if ( $french == NULL || empty($french) )  {
            // no french entered
            // no official languages entered
            echo elgg_echo('gcconnex_profile:languages:empty');
        }
    }
}

else {
    if ( !(is_array($languages_guid)) ) {
        $languages_guid = array($languages_guid);
    }
}

//if english
if($user->officialLanguage == 'ENG') {
    
    //display french form
    echo elgg_echo('gcconnex_profile:fol') . ': ' . elgg_echo( "gcconnex_profile:languages:".$user->officialLanguage);
    
    echo '<table id="fraTable" class="gcconnex-profile-language-official-languages table table-bordered">';
        echo '<thead>';
            echo '<tr>';
                echo '<th class="first-col text-right">' . elgg_echo('gcconnex_profile:languages:french') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:level') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:expiry') . '</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtencomp') . '</td>';
                echo '<td>' . $french[0] . '</td>';
                echo '<td>' . $french[3] . '</td>';
            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtenexp') . '</td>';
                echo '<td>' . $french[1] . '</td>';
                echo '<td>' . $french[4] . '</td>';
            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:oral') . '</td>';
                echo '<td>' . $french[2] . '</td>';
                echo '<td>' . $french[5] . '</td>';
            echo '</tr>';

            /*echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:expiry') . '</td>';
                echo '<td>' . $english[3] . '</td>';
                echo '<td>' . $french[3] . '</td>';
            echo '</tr>';*/

        echo '</tbody>';
    echo '</table>'; // close table class="gcconnex-profile-language-official-languages table-bordered"
    
    //if french
} else if($user->officialLanguage == 'FRA') {
    
    //display english form
    echo elgg_echo('gcconnex_profile:fol') . ': ' . elgg_echo( "gcconnex_profile:languages:".$user->officialLanguage);
    
    echo '<table id="engTable" class="gcconnex-profile-language-official-languages table table-bordered">';
        echo '<thead>';
            echo '<tr>';
                echo '<th class="first-col text-right">' . elgg_echo('gcconnex_profile:languages:english') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:level') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:expiry') . '</th>';

            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtencomp') . '</td>';
                echo '<td>' . $english[0] . '</td>';
                echo '<td>' . $english[3] . '</td>';

            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtenexp') . '</td>';
                echo '<td>' . $english[1] . '</td>';
                echo '<td>' . $english[4] . '</td>';

            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:oral') . '</td>';
                echo '<td>' . $english[2] . '</td>';
                echo '<td>' . $english[5] . '</td>';

            echo '</tr>';

            /*echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:expiry') . '</td>';
                echo '<td>' . $english[3] . '</td>';
                echo '<td>' . $french[3] . '</td>';
            echo '</tr>';*/

        echo '</tbody>';
    echo '</table>'; // close table class="gcconnex-profile-language-official-languages table-bordered"
    
} else {
    
   // echo elgg_echo('gcconnex_profile:fol') . ': ' . elgg_echo( "gcconnex_profile:languages:".$user->officialLanguage);
    
}

//echo elgg_echo('gcconnex_profile:fol') . ': ' . ( isset( $user->officialLanguage ) ? elgg_echo( "gcconnex_profile:languages:".$user->officialLanguage ) : '' ) . "<br />";


if (is_array($languages_guid)) {

    foreach ($languages_guid as $guid) {

        $language = get_entity($guid);


    }
}

echo '</div>'; // close div class="gcconnex-profile-languages-display"
//echo '</div>'; // close div class=gcconnex-profile-section-wrapper
