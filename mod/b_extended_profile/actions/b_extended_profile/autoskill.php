<?php
/*
 * Author: Bryden Arndt
 * Date: January 26, 2015
 * Purpose: Provide search results to skills auto-suggest
 */

$skills = file('skills.txt');

$query = htmlspecialchars($_GET['query']);
$result = array();

/*
foreach ($skills as $s) {
    if (strpos(strtolower($s), strtolower($query)) !== FALSE) {
        $result[] = array('value' => $s);
    }
}

*/


foreach ($skills as $s) {

    // full word at start of skill title
    if (strpos(strtolower(' ' . $s) . ' ', ' ' . strtolower($query) . ' ') === 0 ) {
        $result[] = array(
            'value' => $s,
            'pos' => 0
        );
    }

    // full word somewhere in skill title
    elseif (strpos(strtolower(' ' . $s) . ' ', ' ' . strtolower($query) . ' ') !== FALSE) {
        $result[] = array(
            'value' => $s,
            'pos' => 1
        );
    }

    // partial word at start of skill title
    elseif (strpos(strtolower(' ' . $s), ' ' . strtolower($query)) === 0 ) {
        $result[] = array(
            'value' => $s,
            'pos' => 2
        );
    }

    //partial word somewhere in skill title
    elseif (strpos(strtolower(' ' . $s), ' ' . strtolower($query)) !== FALSE) {
        $result[] = array(
            'value' => $s,
            'pos' => 3
        );
    }

    elseif (strpos(strtolower($s), strtolower($query)) !== FALSE) {
        $result[] = array(
            'value' => $s,
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

