<?php

/**
 * set_no_notification
 *
 * @author Gustavo Bellino
 * @link http://community.elgg.org/pg/profile/gushbellino
 * @copyright (c) Keetup 2010
 * @link http://www.keetup.com/
 * @license GNU General Public License (GPL) version 2
 *
 * updated and modified for Elgg 1.8 and newer by iionly
 * (c) iionly
 */

$prefix = "notification:method:email";
// quantity of users
$users_count = elgg_get_entities(array('type' => 'user', 'count' => true));

// users with set notifications disabled
$users_count_true = elgg_get_entities_from_metadata(array('metadata_name' => $prefix, 'metadata_value' => true, 'count' => true));
$user_count_true_percentage = $users_count_true * 100 / $users_count;

// users with set notifications enabled
$users_count_false = $users_count - $users_count_true;
$user_count_false_percentage = 100 - $user_count_true_percentage;


if (!isset($vars['entity']->setNoNotif_type)) {
	$vars['entity']->setNoNotif_type = 'a';
	$vars['entity']->setNoNotif_time = mktime(0,0,0,0,0,1900);
}

if ($vars['entity']->setNoNotif_type == 'a') {
	$vars['entity']->setNoNotif_time = mktime(0,0,0,0,0,1900);
} else {
	$vars['entity']->setNoNotif_time = time();
}

echo "<div><label>" . elgg_echo('set_no_notifications:choose:type') . "</label><br>";
echo elgg_view('input/radio', array(
	'name' => 'params[setNoNotif_type]',
	'value' => $vars['entity']->setNoNotif_type,
	'options' => array(
		elgg_echo('set_no_notifications:choose:type:a') => 'a',
		elgg_echo('set_no_notifications:choose:type:b') => 'b'
	),
	'class' => 'mbs'
));
echo elgg_view("output/longtext", array("value" => elgg_echo('set_no_notifications:description'), "class" => "elgg-subtext")) . "</div>";

echo "<div><label>" . elgg_echo('set_no_notifications:statistics') . "</label><br>";
echo elgg_echo('set_no_notifications:enabled') . $users_count_true . ' (' . round($user_count_true_percentage, 2) . '%)' . "<br>";
echo elgg_echo('set_no_notifications:disabled') . $users_count_false . ' (' . round($user_count_false_percentage, 2) . '%)' . "</div>";

echo elgg_view('input/hidden',array('name'=>'params[setNoNotif_time]','value' => $vars['entity']->setNoNotif_time));
