<?php
/*
* This builds the page view to edit access on location org chart metadata
* Shows brief message and form.
*
*/

// make sure only logged in users can see this page
gatekeeper();

// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo("geds:org:edit:title");

// start building the main column of the page
$content = elgg_view_title($title);

//Short info message.
$content .= elgg_echo("geds:org:edit:body")."</br>";

// add the form to this section
$content .= elgg_view_form("geds_sync/edit");

// optionally, add the content for the sidebar
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_sidebar', array(
   'content' => $content,
   'sidebar' => $sidebar
));

// draw the page
echo elgg_view_page($title, $body);