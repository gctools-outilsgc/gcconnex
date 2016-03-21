<?php
// Load Elgg engine
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// make sure only logged in users can see this page, if configured
$loginreq=elgg_get_plugin_setting('loginreq','contactform');
if( $loginreq == "yes" ) { gatekeeper(); }

// set the title
$title = elgg_echo('contactform:help_menu_item');
elgg_push_breadcrumb($title);
// start building the main column of the page
$title2 = elgg_view_title($title);

// Add the form to this section
$content .= elgg_view("contactform/contactform");
$sidebar = elgg_view("contactform/form");

// layout the page
		$body = elgg_view_layout('two_column', array(
                'title' => $title2,
   				'content' => $content,
   				'sidebar' => $sidebar,
   				
				));

// draw the page
echo elgg_view_page($title, $body);
?>
