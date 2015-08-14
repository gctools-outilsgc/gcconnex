<?php
/*
 * Author: Bryden Arndt
 * Date: 15/12/14
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for education (designed to be entered for a user's profile).
 */


$portfolio = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($portfolio != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry

echo '<div class="gcconnex-portfolio-entry well" data-guid="' . $guid . '">'; // education entry wrapper for css styling

    // enter title for portfolio entry
    echo '<span class="gcconnex-profile-field-title">';
    echo elgg_echo('gcconnex_profile:portfolio:title') . '</span>';
    echo elgg_view("input/text", array(
            'name' => 'portfolio',
            'class' => 'gcconnex-portfolio-title',
            'value' => $portfolio->title));

    echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:link') . '</span>';
    echo elgg_view("input/url", array(
        'name' => 'portfolio-link',
        'class' => 'gcconnex-portfolio-link',
        'value' => $portfolio->link));

    // enter publication date
    echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:publication_date') . '</span>';

    echo elgg_view("input/datepicker_popup", array(
            'name' => 'pubdate-' . $portfolio->guid,
            'class' => 'gcconnex-portfolio-pubdate',
            'value' => $portfolio->pubdate
    ));

    unset($params);

    $params = array(
        'name' => 'datestamped',
        'class' => 'gcconnex-portfolio-datestamped',
        'onclick' => 'toggleEndDate("portfolio", this)',
    );

    if ($portfolio->datestamped == 'true') {
        $params['checked'] = $portfolio->datestamped;
    }

    echo  '<br><label class="gcconnex-portfolio-label-datestamped">' . elgg_view('input/checkbox', $params);
    echo elgg_echo('gcconnex_profile:portfolio:datestamp') . '</label>';

    // enter a description
    echo '<br><span class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:description') . '</span>';
    echo elgg_view("input/textarea", array(
            'name' => 'description',
            'class' => 'gcconnex-portfolio-description',
            'value' => $portfolio->description));

    // create a delete button for each education entry
    echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEntry(this)" data-type="portfolio">' . elgg_echo('gcconnex_profile:portfolio:delete') . '</div>';

echo '</div>'; // close div class="gcconnex-education-entry"