<?php
/*
 * Includes code to display popup for profile nudge
 */

//create hidden link
$content = elgg_view('output/url', array(
    'href' => 'ajax/view/gc_profile_nudge/profile_nudge',
    'id' => 'nudge',
    'aria-hidden' => 'true',
    'class' => 'elgg-lightbox hidden'
));

//after page is loaded click link
$content .= '<script>$(function() { setTimeout(function(){ $("#nudge").click(); }, 2500); });</script>';

echo $content;
