<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Create the ajax view for editing the languages entries.
 * Requires: gcconnex-profile.js in order to handle the add more and delete buttons which are triggered by js calls
 */

if (elgg_is_xhr()) {  //This is an Ajax call!
    // allow the user to edit the access settings for languages entries
    echo elgg_echo('gcconnex_profile:languages:access');

    $access_id = $user->languages_access;
    //echo 'Access: ';
    //var_dump($access_id);
    $params = array(
        'name' => "accesslevel['languages']",
        'value' => $access_id,
        'class' => 'gcconnex-languages-access'
    );

    echo elgg_view('input/access', $params);
    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    //get the array of user languages entities
    //$languages_guid = $user->langs;
    $english = $user->english;
    $french = $user->french;

    // first official language
    echo "<label for='first_official_language'>First official language</label>";
    $params = array(
        'name' => 'first_official_language',
        'class' => 'gcconnex-first-official-language',
        'options' => array('-', 'ENG', 'FRA'),
        'value' => $user->officialLanguage
    );
    echo elgg_view("input/pulldown", $params);

    echo '<table class="gcconnex-profile-language-official-languages table table-bordered">';
        echo '<thead>';
            echo '<tr>';
                echo '<th class="first-col"></th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:english') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:expiry') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:french') . '</th>';
                echo '<th>' . elgg_echo('gcconnex_profile:languages:expiry') . '</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtencomp') . '</td>';
                // English level
                $params = array(
                    'name' => 'english_writtencomp',
                    'class' => 'gcconnex-languages-english-writtencomp gcconnex-languages-english-writtencomp-' . $english->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $english[0]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // English expiry
                $params = array(
                    'name' => 'english_expiry_writtencomp',
                    'class' => 'gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[3]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
                // French level
                $params = array(
                    'name' => 'french_writtencomp',
                    'class' => 'gcconnex-languages-french-writtencomp gcconnex-languages-french-writtencomp-' . $french->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $french[0]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // French expiry
                $params = array(
                    'name' => 'french_expiry_writtencomp',
                    'class' => 'gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $english->guid,
                    'value' => $french[3]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:writtenexp') . '</td>';
                // English level
                $params = array(
                    'name' => 'english_writtenexp',
                    'class' => 'gcconnex-languages-english-writtenexp gcconnex-languages-english-writtenexp-' . $english->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $english[1]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // English expiry
                $params = array(
                    'name' => 'english_expiry_writtenexp',
                    'class' => 'gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[4]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
                // French level
                $params = array(
                    'name' => 'french_writtenexp',
                    'class' => 'gcconnex-languages-french-writtenexp gcconnex-languages-french-writtenexp-' . $french->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $french[1]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // French expiry
                $params = array(
                    'name' => 'french_expiry_writtenexp',
                    'class' => 'gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $english->guid,
                    'value' => $french[4]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
            echo '</tr>';

            echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:oral') . '</td>';
                // English level
                $params = array(
                    'name' => 'english_oral',
                    'class' => 'gcconnex-languages-english-oral gcconnex-languages-english-oral-' . $english->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $english[2]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // English expiry
                $params = array(
                    'name' => 'english_expiry_oral',
                    'class' => 'gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[5]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
                // French level
                $params = array(
                    'name' => 'french_oral',
                    'class' => 'gcconnex-languages-french-oral gcconnex-languages-french-oral-' . $french->guid,
                    'options' => array('-', 'A', 'B', 'C', 'E', 'X', 'P'),
                    'value' => $french[2]
                );
                echo '<td>' . elgg_view("input/pulldown", $params) . '</td>';
                // French expiry
                $params = array(
                    'name' => 'french_expiry_oral',
                    'class' => 'gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $english->guid,
                    'value' => $french[5]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
            echo '</tr>';

            // removed in lanugage section redesign
            /*echo '<tr>';
                echo '<td class="left-col">' . elgg_echo('gcconnex_profile:languages:expiry') . '</td>';
                $params = array(
                    'name' => 'english_expiry',
                    'class' => 'gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[3]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
                $params = array(
                    'name' => 'french_expiry',
                    'class' => 'gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $english->guid,
                    'value' => $french[3]
                );
                echo '<td>' . elgg_view("input/datepicker_popup", $params) . '</td>';
            echo '</tr>';*/

        echo '</tbody>';
    echo '</table>'; // close table class="gcconnex-profile-language-official-languages table-bordered"


/*
    echo '<div class="gcconnex-languages-other">';

    // handle $education_guid differently depending on whether it's an array or not
    if (is_array($languages_guid)) {
        foreach ($languages_guid as $guid) { // display the input/education view for each education entry
            echo elgg_view('input/languages', array('guid' => $guid));
        }
    }
    else {
        echo elgg_view('input/languages', array('guid' => $languages_guid));
    }


    echo '</div>';

    // create an "add more" button at the bottom of the education input fields so that the user can continue to add more education entries as needed
    echo '<div class="gcconnex-languages-add-another elgg-button elgg-button-action btn" data-type="languages" onclick="addMore(this)">' . elgg_echo('gcconnex_profile:languages:add') . '</div>';
*/
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: DZFSAFHHJ662277';
}

?>