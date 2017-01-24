<?php
/*
* A quick form of an input and a button to put in the url of the group the site admin wants to make offical
*
* @version 1.0
* @author Nick
*/

$body = '<label for="group_url">Add Official Group</label>';
$body .= '<div>Add the url to the group profile and click Add Group - ex: https://gcconnex.gc.ca/groups/profile/1234567/group-name</div>';
$body .= '<div class="off-group-add-feedback"></div>';
$body .= elgg_view('input/text', array(
    'name'=>'group_url',
    'id' => 'group_url',
    'class'=>'group-url',
    'placeholder'=>'https://gcconnex.gc.ca/groups/profile/1234567/group-name',
));



$body .= elgg_view('output/url', array(
    'text'=>'Add Group',
    'href'=>'#',
    'id' => 'add_group_btn',
    'class'=>'btn elgg-button elgg-button-submit',
));
echo $body;