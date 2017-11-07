<?php
/*
This view creates a little form that will appear next to a group that the user owns when they are 
*/

$group = elgg_extract('entity', $vars, FALSE);
$owner_guid = $group->owner_guid;
$members[$owner_guid] = get_entity($owner_guid)->name ."  (@". get_entity($owner_guid)->username .")";
$action = elgg_get_site_url() .'action/selfdelete/changegroupowner';

echo '<form method="post" action="'.$action.'" class="elgg-form self-deactivate-memember-form" novalidate="novalidate">'; 
echo elgg_view('input/securitytoken');
echo elgg_view("input/text", array(
    "id" => "",
    'class' => 'self-groups-owner-guid',
    "value" =>  get_entity($owner_guid)->name,
));
echo elgg_view('input/hidden',array('name'=>'group_guid','value'=>$group->guid));
echo elgg_view("input/select", array(
    "name" => "owner_guid",
    "id" => "",
    "value" =>  $owner_guid,
    "options_values" => $members,
    "class" => "self-groups-owner-guid-select groups-owner-input hidden",
));

$vars = array(
    'class' => 'self-groupmems-popup mentions-popup hidden',
    'id' => '',
);

echo elgg_view_module('popup', '', elgg_view('graphics/ajax_loader', array('hidden' => false)), $vars);
echo elgg_view('input/submit', array('value' => elgg_echo('member_selfdelete:gc:group:submit')));
        
echo '</form>';          