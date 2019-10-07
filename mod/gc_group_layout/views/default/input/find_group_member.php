<?php
/**
 * 
 */
$owner_guid = elgg_extract('guid', $vars);
$group = get_entity($guid);
$members[$owner_guid] = get_entity($owner_guid)->name ."  (@". get_entity($owner_guid)->username .")";
if (elgg_is_logged_in() && elgg_get_page_owner_entity()->canEdit()) {
  $add_class = "YES-YOU-CAN";
} else {
  $add_class = "NOPE-CHIEF";
}

echo elgg_format_element('label',['for'=>'groups-owner-guid'], elgg_echo('search'));

echo elgg_view("input/text", array(
  "id" => "groups-owner-guid",
  "class" => "mrgn-bttm-md group-member-finder-".$owner_guid ." ".$add_class,
  "value" =>  "",
  "data-group-guid" => $owner_guid,
));

echo elgg_view("input/select", array(
  "name" => "owner_guid",
  "id" => "groups-owner-guid-select",
  "value" =>  $owner_guid,
  "options_values" => $members,
  "class" => "groups-owner-input hidden",
));

$vars = array(
  'class' => 'mentions-popup hidden',
  'id' => 'find-groupmems-popup',
);

echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);
?>