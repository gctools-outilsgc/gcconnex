<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Create the ajax view for editing the languages entries.
 * Requires: gcconnex-profile.js in order to handle the add more and delete buttons which are triggered by js calls
 */

if (elgg_is_xhr()) {  //This is an Ajax call!
    // allow the user to edit the access settings for languages entries
    echo '<label for="langAccess">' . elgg_echo('gcconnex_profile:languages:access') . '</label>';

    $access_id = $user->languages_access;
    //echo 'Access: ';
    //var_dump($access_id);
    $params = array(
        'name' => "accesslevel['languages']",
        'value' => $access_id,
        'id' => 'langAccess',
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
        'id' => 'first_official_language',
        'class' => 'gcconnex-first-official-language',
        'options' => array('-', 'ENG', 'FRA'),
        'onchange' => 'hideLanguage()',
        'value' => $user->officialLanguage
    );
    echo elgg_view("input/pulldown", $params);


    
    
    
    
    
    echo '<div class="gcconnex-profile-language-official-languages">';
    echo '<div id="engCred" class="gcconnex-work-experience-entry">';
    
        echo '<h3 class="mrgn-tp-0">' . elgg_echo('gcconnex_profile:languages:english') . '</h3>';
        
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:writtencomp') . '</h4>';
    
            // English level
                echo '<div class="col-xs-6"><label for="english_writtencomp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'english_writtencomp',
                    'id' => 'english_writtencomp',
                    'class' => 'gcconnex-languages-english-writtencomp gcconnex-languages-english-writtencomp-' . $english->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $english[0]
                );
                echo elgg_view("input/pulldown", $params);
        echo '</div>';
            // English expiry
            echo '<div class="col-xs-6"><label for="english_expiry_writtencomp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'english_expiry_writtencomp',
                    'id' => 'english_expiry_writtencomp',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[3]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
        
    
    
    
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:writtenexp') . '</h4>';
    
            // English level
    echo '<div class="col-xs-6"><label for="english_writtenexp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'english_writtenexp',
                    'id' => 'english_writtenexp',
                    'class' => 'gcconnex-languages-english-writtenexp gcconnex-languages-english-writtenexp-' . $english->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $english[1]
                );
                echo elgg_view("input/pulldown", $params);
    echo '</div>';
                // English expiry
    echo '<div class="col-xs-6"><label for="english_expiry_writtenexp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'english_expiry_writtenexp',
                    'id' => 'english_expiry_writtenexp',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[4]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
    
    
    
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:oral') . '</h4>';
    
                // English level
    echo '<div class="col-xs-6"><label for="english_oral" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'english_oral',
                    'id' => 'english_oral',
                    'class' => 'gcconnex-languages-english-oral gcconnex-languages-english-oral-' . $english->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $english[2]
                );
                echo elgg_view("input/pulldown", $params);
        echo '</div>';
                // English expiry
    echo '<div class="col-xs-6"><label for="english_expiry_oral" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'english_expiry_oral',
                    'id' => 'english_expiry_oral',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-english-expiry gcconnex-languages-english-expiry-' . $english->guid,
                    'value' => $english[5]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
    
    echo '</div>'; //closes gcconnex-work-experience-entry
    
    
        
    echo '<div id="fraCred" class="gcconnex-work-experience-entry">';
    
        echo '<h3 class="mrgn-tp-0">' . elgg_echo('gcconnex_profile:languages:french') . '</h3>';
        
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:writtencomp') . '</h4>';
    
            // french level
                echo '<div class="col-xs-6"><label for="french_writtencomp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'french_writtencomp',
                    'id' => 'french_writtencomp',
                    'class' => 'gcconnex-languages-french-writtencomp gcconnex-languages-french-writtencomp-' . $french->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $french[0]
                );
                echo elgg_view("input/pulldown", $params);
        echo '</div>';
            // french expiry
            echo '<div class="col-xs-6"><label for="french_expiry_writtencomp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'french_expiry_writtencomp',
                    'id' => 'french_expiry_writtencomp',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $french->guid,
                    'value' => $french[3]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
        
    
    
    
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:writtenexp') . '</h4>';
    
            // french level
    echo '<div class="col-xs-6"><label for="french_writtenexp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'french_writtenexp',
                    'id' => 'french_writtenexp',
                    'class' => 'gcconnex-languages-french-writtenexp gcconnex-languages-french-writtenexp-' . $french->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $french[1]
                );
                echo elgg_view("input/pulldown", $params);
    echo '</div>';
                // french expiry
    echo '<div class="col-xs-6"><label for="french_expiry_writtenexp" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'french_expiry_writtenexp',
                    'id' => 'french_expiry_writtenexp',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $french->guid,
                    'value' => $french[4]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
    
    
    
        echo '<div class="clearfix">';
            echo '<h4 class="mrgn-tp-md mrgn-bttm-sm">' . elgg_echo('gcconnex_profile:languages:oral') . '</h4>';
    
                // french level
    echo '<div class="col-xs-6"><label for="french_oral" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:level') .  ':</label>';
                $params = array(
                    'name' => 'french_oral',
                    'id' => 'french_oral',
                    'class' => 'gcconnex-languages-french-oral gcconnex-languages-french-oral-' . $french->guid,
                    'options' => array('-', 'X', 'A', 'B', 'C', 'E', 'P'),
                    'value' => $french[2]
                );
                echo elgg_view("input/pulldown", $params);
        echo '</div>';
                // french expiry
    echo '<div class="col-xs-6"><label for="french_expiry_oral" class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:languages:expiry') .  ':</label>';
                $params = array(
                    'name' => 'french_expiry_oral',
                    'id' => 'french_expiry_oral',
                    'placeholder' => 'yyyy-mm-dd',
                    'style' => 'display:block;padding-left:3px;',
                    'class' => 'language-expiry gcconnex-languages-french-expiry gcconnex-languages-french-expiry-' . $french->guid,
                    'value' => $french[5]
                );
                echo elgg_view("input/date", $params);
        echo '</div>';
    echo '</div>';
    
    echo '</div>'; //closes gcconnex-work-experience-entry
    echo '</div>'; //closes gcconnex-work-experience-entry
    
    
    
    
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: DZFSAFHHJ662277';
}

?>