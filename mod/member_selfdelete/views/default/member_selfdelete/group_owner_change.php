<?php
/*
If this user is the owner of any group we would like them to transfer ownership before they deactivate
*/

$dbprefix = elgg_get_config('dbprefix');
$owned_groups = elgg_get_entities(array(
		'type' => 'group',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
		'order_by' => 'ge.name ASC',
		'full_view' => false,
		'no_results' => elgg_echo('groups:none'),
		'distinct' => false,
));


if($owned_groups){
    echo '<div class="row clearfix deactivate-group-holder">';
    echo elgg_format_element('div',array(), elgg_echo('member_selfdelete:gc:group:owner:change'));
    foreach($owned_groups as $group){

        echo '<div class="list-break clearfix">';
        echo '<div class="col-md-8 ">';
        echo elgg_view('group/default', array('entity' => $group));
        echo '</div><div class="col-md-4 mrgn-tp-md"><div>';
        echo elgg_view('forms/changegroupowner', array('entity' => $group));


        echo '</div></div></div>';
    }
    echo '</div>';
}