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

//$result = elgg_get_logged_in_user_guid();

echo json_encode($result);


/*
<?php
/*
 * Author: Bryden Arndt
 * Date: February 9, 2015
 * Purpose: Provide search results to usernames auto-suggest
 */
/*

$user_entitities = elgg_get_entities(array(
    'types' => 'user',
    'callback' => 'my_get_entity_callback',
    'limit' => false,
));

$query = htmlspecialchars($_GET['query']);
$result = array();

foreach ($users as $u) {
    if (strpos(strtolower($u), strtolower($query)) !== FALSE) {
        $result[] = array('value' => $u);
    }
}

echo json_encode($result);
*/

