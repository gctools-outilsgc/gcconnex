<?php
/**
 * gcProfilePictureBadges Enable Badge form
 *
 * @package gcProfilePictureBadges
 *
 * Gives control of the badge to groups
 */

require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
global $initbadges;

$group = elgg_get_page_owner_entity();

//get name of badge
$badge = $initbadges[$group->name];

$noyes_options = array(
  "no" => elgg_echo("option:no"),
  "yes" => elgg_echo("option:yes")
);

//enable dropdown
$form_body .= "<label for='enable_badge'>".elgg_echo('gcProfilePictureBadges:form', array(elgg_echo('gcProfilePictureBadges:badge:'.$badge)))."</label>";
$form_body .= elgg_view("input/dropdown", array(
  "name" => "enable_badge",
  "id" => 'enable_badge',
  "options_values" => $noyes_options,
  "value" => $group->getPrivateSetting("group:badge:".$badge),
  "class" => "mls"
));

//enable widget dropdown
$form_body .= "<label for='display_widget'>Display pledge widget in sidebar</label>";
$form_body .= elgg_view("input/dropdown", array(
  "name" => "display_widget",
  "id" => "display_widget",
  "options_values" => $noyes_options,
  "value" => $group->getPrivateSetting("group:badge:".$badge.":display_widget"),
  "class" => "mls mrgn-bttm-sm"
));

$form_body .= elgg_view("input/hidden", array("name" => "group_guid", "value" => $group->getGUID()));
$form_body .= elgg_view("input/hidden", array("name" => "badge", "value" => $badge));
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));

echo elgg_view("input/form", array("action" => "action/group/enable_badge",
                    "body" => $form_body));
?>
