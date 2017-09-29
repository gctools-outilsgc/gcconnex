<?php

gatekeeper();

$content = "<div style=\"padding: 25px;\">";

// create the form
// parameters for form generation - enctype must be 'multipart/form-data' for file uploads 
$content .=  elgg_view_form('selfdelete');

$content .= "</div>";

// place the form into the elgg layout
$body = elgg_view_layout('one_column', array('content' => $content));

echo elgg_view_page(elgg_echo('member_selfdelete:account:delete'), $body);