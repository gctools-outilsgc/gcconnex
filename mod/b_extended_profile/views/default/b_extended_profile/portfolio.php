<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 23/03/15
 * Time: 2:02 PM
 */

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$portfolio_guid = $user->portfolio;

echo '<div class="gcconnex-profile-portfolio-display">';

if ($user->canEdit() && ($portfolio_guid == NULL || empty($portfolio_guid))) {
    echo elgg_echo('gcconnex_profile:portfolio:empty');
}
else {
    if (!(is_array($portfolio_guid))) {
        $portfolio_guid = array($portfolio_guid);
    }

    foreach ($portfolio_guid as $guid) {

        if ($entry = get_entity($guid)) {
            echo '<div class="gcconnex-profile-portfolio-display gcconnex-portfolio-' . $entry->guid . '">';
            echo '<div class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:title') . '</div><div class="portfolio-title">' . $entry->title . '</div>';
            echo '<br><div class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:link') . '</div><div class="portfolio-link">';
            echo elgg_view('output/url', array(
                'href' => $entry->link,
                'text' => $entry->link
            ));
            echo '</div>';
            if ( $entry->datestamped == true ) {
                echo '<br><div class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:publication_date') . '</div><div class="portfolio-publicationdate">' . $entry->pubdate . '</div>';
            }
            echo '<br><div class="gcconnex-profile-field-title">' . elgg_echo('gcconnex_profile:portfolio:description') . '</div><div class="portfolio-description">' . $entry->description . '</div>';
            echo '</div>'; // close div class="gcconnex-profile-portfolio-display gcconnex-portfolio-'...
        }
    }
}




echo '</div>'; // close div class="gcconnex-profile-portfolio-display"
//echo '</div>'; // close div class="gcconnex-profile-section-wrapper gcconnex-portfolio
