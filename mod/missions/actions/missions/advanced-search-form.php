<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This action is for the advanced search functionality.
 * It takes in input from the variable fields in the advanced form and evaluates them generating database queries in the process.
 * After the evaluation, it queries the database and saves the returned information session variables.
 *
 * If Javascript is disabled then backup fields will be displayed.
 * These backup fields require different input then the regular fields when searching for language or time requirements.
 */
elgg_make_sticky_form('advancedfill');

// The maximum amount of possible search fields is set in the Administration panel.
$element_total = elgg_get_plugin_setting('advanced_element_limit', 'missions');

$err = '';
$advanced_form = elgg_get_sticky_values('advancedfill');

// Detects if backup fields are active or not. If they are then Javascript is disabled.
$noscript = false;
foreach ($advanced_form as $name => $value) {
    if (strpos($name, 'backup_') !== false) {
        if ($value != '') {
            $noscript = true;
        }
    }
}

// Currently no error checking is done but the support for it is set.
if ($err != '') {
    register_error($err);
    forward(REFERER);
} else {
    $query_clean = '';
    $array = array();
    
    /*
     * Runs through all the search fields and evaluates them.
     * Evaluation is different when Javascript is enabled or disabled.
     * Empty evaluations are discarded.
     */
    for ($i = 0; $i < $element_total; $i ++) {
        if ($noscript) {
            $query_clean = mm_analyze_backup($i, $advanced_form);
        } else {
            $query_clean = mm_analyze_selection($i, $advanced_form);
        }
        if (!empty($query_clean)) {
            $array[$i] = $query_clean;
        }
    }
    
    // These functions executes the query and returns true or false depending on how succesful that query was.
    switch($_SESSION['mission_search_switch']) {
        case 'candidate':
            // Function for candidate searching.
            $returned = mm_adv_search_candidate_database($array, 'AND');
            break;
        default:
            // Function for mission searching.
            $returned = mm_search_database($array, 'AND', false);
    }
    
    /*
     * If the $returned value is null then the user is sent back to the search page.
     * Otherwise they are sent to the search result.
     */
    if (! $returned) {
        forward(REFERER);
    } else {
        elgg_clear_sticky_form('advancedfill');
        forward(elgg_get_site_url() . 'missions/display-search-set');
    }
}