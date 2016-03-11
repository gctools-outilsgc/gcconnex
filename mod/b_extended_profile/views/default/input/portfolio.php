<?php
/*
 * Author: Bryden Arndt
 * Date: 15/12/14
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for education (designed to be entered for a user's profile).
 */


$portfolio = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($portfolio != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry

echo '<div class="gcconnex-portfolio-entry" data-guid="' . $guid . '">'; // education entry wrapper for css styling

    // enter title for portfolio entry
echo '<label for="portfolioTitle-' . $portfolio->guid .'" class="">';
    echo elgg_echo('gcconnex_profile:portfolio:title') . '</label>';
    echo elgg_view("input/text", array(
            'name' => 'portfolio',
            'id' => 'portfolioTitle-' . $portfolio->guid,
            'class' => 'gcconnex-portfolio-title',
            'value' => $portfolio->title));

    echo '<br><label for="portfolio-link-' . $portfolio->guid .'" class="">' . elgg_echo('gcconnex_profile:portfolio:link') . '</label><br>';
    echo elgg_view("input/url", array(
        'name' => 'portfolio-link',
        'id' => 'portfolio-link-' . $portfolio->guid,
        'class' => 'gcconnex-portfolio-link  mrgn-bttm-md',
        'value' => $portfolio->link));

    // enter publication date
    echo '<br><label for="pubdate-' . $portfolio->guid .'">' . elgg_echo('gcconnex_profile:portfolio:publication_date') . '</label>';

    echo elgg_view("input/datepicker_popup", array(
            'name' => 'pubdate-' . $portfolio->guid,
            'id' => 'pubdate-' . $portfolio->guid,
            'class' => 'gcconnex-portfolio-pubdate mrgn-btmm-sm',
            'value' => $portfolio->pubdate
    ));

    unset($params);

    $params = array(
        'name' => 'datestamped',
        'id' => 'datestamped-' . $portfolio->guid,
        'class' => 'gcconnex-portfolio-datestamped',
        'onclick' => 'toggleEndDate("portfolio", this)',
    );

    if ($portfolio->datestamped == 'true') {
        $params['checked'] = $portfolio->datestamped;
    }

    echo  '<br><label for="datestamped-' . $portfolio->guid .'" class="">' . elgg_view('input/checkbox', $params);
    echo elgg_echo('gcconnex_profile:portfolio:datestamp') . '</label>';

    // enter a description
    echo '<br><label for="description-' . $portfolio->guid .'" class="">' . elgg_echo('gcconnex_profile:portfolio:description') . '</label><br>';
    echo elgg_view("input/textarea", array(
            'name' => 'description',
            'id' => 'description-' . $portfolio->guid,
            'class' => 'gcconnex-portfolio-description',
            'value' => $portfolio->description));

    // create a delete button for each education entry
    echo '<br><button class="elgg-button elgg-button-action btn btn-danger mrgn-tp-md" onclick="deleteEntry(this)" data-type="portfolio">' . elgg_echo('gcconnex_profile:portfolio:delete') . '</button>';

echo '</div>'; // close div class="gcconnex-education-entry"