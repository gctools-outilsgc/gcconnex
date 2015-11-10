<?php
/*
 * Author: Bryden Arndt
 * Date: 04/27/2015
 * Purpose: Create the ajax view for editing the portfolio entries.
 * Requires: gcconnex-profile.js in order to handle the add more and delete buttons which are triggered by js calls
 */

if (elgg_is_xhr()) {  //This is an Ajax call!
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    // allow the user to edit the access settings for portfolio entries
    echo elgg_echo('gcconnex_profile:portfolio:access');

    $access_id = $user->portfolio_access;

    $params = array(
        'name' => "accesslevel['portfolio']",
        'value' => $access_id,
        'class' => 'gcconnex-portfolio-access'
    );

    echo elgg_view('input/access', $params);

    //get the array of user portfolio entities
    $portfolio_guid = $user->portfolio;

    echo '<div class="gcconnex-portfolio-all">';

    // handle $education_guid differently depending on whether it's an array or not
    if (is_array($portfolio_guid)) {
        foreach ($portfolio_guid as $guid) { // display the input/education view for each education entry
            if ( $guid != null ) {
                echo elgg_view('input/portfolio', array('guid' => $guid));
            }
        }
    }
    else {
        if ($portfolio_guid != null && !empty($portfolio_guid)) {
            echo elgg_view('input/portfolio', array('guid' => $portfolio_guid));
        }
    }


    echo '</div>';

    // create an "add more" button at the bottom of the education input fields so that the user can continue to add more education entries as needed
    echo '<button class="gcconnex-portfolio-add-another elgg-button elgg-button-action btn mrgn-tp-sm" data-type="portfolio" onclick="addMore(this)">' . elgg_echo('gcconnex_profile:portfolio:add') . '</button>';
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: DZZZNFDSAGHHS261177';
}

?>