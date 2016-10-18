<?php
/*
 * Author: Bryden Arndt
 * Date: January 26, 2015
 * Purpose: Provide search results to skills auto-suggest
 */

$skills = file('skills.txt');
$query = htmlspecialchars($_GET['query']);
$result = array();
foreach ($skills as $s) {
    if (strpos(strtolower($s), strtolower($query)) !== FALSE) {
        $result[] = array('value' => $s);
    }
}

$vars["output"] = $result;

echo json_encode($result);