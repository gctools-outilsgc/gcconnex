<?php

gatekeeper();

$content = "<div style=\"padding: 25px;\">";

// create the form
// parameters for form generation - enctype must be 'multipart/form-data' for file uploads
$explanation = elgg_echo('member_selfdelete:explain' . elgg_get_plugin_setting('method', PLUGIN_ID));

$content .= elgg_view('output/longtext', array(
    'value' => $explanation,
    'class' => 'deactivate-group-holder row',
)); 
$content .= elgg_view('member_selfdelete/group_owner_change');
$content .=  elgg_view_form('selfdelete');

$content .= "</div>";

// place the form into the elgg layout
$body = elgg_view_layout('one_column', array('title'=>elgg_echo('member_selfdelete:delete:account'),'content' => $content));

echo elgg_view_page(elgg_echo('member_selfdelete:account:delete'), $body);