<?php
/*
 * Author: Bryden Arndt
 * Date: January 26, 2015
 * Purpose: Provide search results to skills auto-suggest
 */

$file = file_get_contents('departments.json');
$departments = json_decode($file, true); // decode the JSON into an associative array

$query = htmlspecialchars($_GET['query']);
$result = array();

/*
foreach ($skills as $s) {
    if (strpos(strtolower($s), strtolower($query)) !== FALSE) {
        $result[] = array('value' => $s);
    }
}

*/


foreach ($departments as $d) {
error_log(print_r('$d[title_en] = ' . $d['title_en'], true));
    // full word at start of skill title
    if (strpos(strtolower(' ' . $d['title_en']) . ' ', ' ' . strtolower($query) . ' ') === 0 ||
        strpos(strtolower(' ' . $d['title_fr']) . ' ', ' ' . strtolower($query) . ' ') === 0 ) {
        $result[] = array(
            'value' => $d['title_en'] . ' / ' . $d['title_fr'],
            'pos' => 0
        );
    }

    // full word somewhere in skill title
    elseif (strpos(strtolower(' ' . $d['title_en']) . ' ', ' ' . strtolower($query) . ' ') !== FALSE ||
        strpos(strtolower(' ' . $d['title_fr']) . ' ', ' ' . strtolower($query) . ' ') !== FALSE ) {
        $result[] = array(
            'value' => $d['title_en'] . ' / ' . $d['title_fr'],
            'pos' => 1
        );
    }

    // partial word at start of skill title
    elseif (strpos(strtolower(' ' . $d['title_en']), ' ' . strtolower($query)) === 0 ||
        strpos(strtolower(' ' . $d['title_fr']), ' ' . strtolower($query)) === 0 ) {
        $result[] = array(
            'value' => $d['title_en'] . ' / ' . $d['title_fr'],
            'pos' => 2
        );
    }

    //partial word somewhere in skill title
    elseif (strpos(strtolower(' ' . $d['title_en']), ' ' . strtolower($query)) !== FALSE ||
        strpos(strtolower(' ' . $d['title_fr']), ' ' . strtolower($query)) !== FALSE ) {
        $result[] = array(
            'value' => $d['title_en'] . ' / ' . $d['title_fr'],
            'pos' => 3
        );
    }

    elseif (strpos(strtolower($d['title_en']), strtolower($query)) !== FALSE ||
        strpos(strtolower($d['title_fr']), strtolower($query)) !== FALSE ) {
        $result[] = array(
            'value' => $d['title_en'] . ' / ' . $d['title_fr'],
            'pos' => 4
        );
    }
}

$highest_relevance = array();
$high_relevance = array();
$med_relevance = array();
$low_relevance = array();
$lowest_relevance = array();

foreach ( $result as $r ) {
    if ( $r['pos'] == 0 ) {
        $highest_relevance[] = $r;
    }
    elseif ( $r['pos'] == 1 ) {
        $high_relevance[] = $r;
    }
    elseif ( $r['pos'] == 2 ) {
        $med_relevance[] = $r;
    }
    elseif ( $r['pos'] == 3 ) {
        $low_relevance[] = $r;
    }
    elseif ( $r['pos'] == 4 ) {
        $lowest_relevance[] = $r;
    }
}

$result = array_merge($highest_relevance, $high_relevance, $med_relevance, $low_relevance, $lowest_relevance);

echo json_encode($result);

