<?php


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
    echo '<div class="row clearfix">';
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