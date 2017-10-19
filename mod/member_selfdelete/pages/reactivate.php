<?php
/*

*/

$content = "<div style=\"padding: 25px; width:60%; margin:0 auto;\">";
$content .= elgg_view('member_selfdelete/reactivate');


$content .= "</div>";

// place the form into the elgg layout
$body = elgg_view_layout('one_column', array('title'=>elgg_echo('memeber_selfdelete:gc:reactivate:title'),'content' => $content));

echo elgg_view_page(elgg_echo('welcome back bb'), $body);