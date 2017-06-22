<?php
/*
 * tutorials.php
 *
 * Displays links to the onboard modules and information for the user.
 *
 * @package gc_onboard
 * @author Ethan Wallace <>
 */

 $content = elgg_view('onboard/module_links');

 // draw page
 echo elgg_view_page(elgg_echo('onboard:helpHeader'), $content);
