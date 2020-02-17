<?php


$page = "<H1> GCconnex - GCaccount migration </H1>";

$page .= "<label for='gcconnex-email'>Email you use on GCconnex</label>";
$page .= elgg_view('input/text', array('name' => 'email', 'id' => 'gcconnex-email'));;

$page .= elgg_view('output/url', array(
    'text' => elgg_echo('Migrate Stuff'),
    'href' => 'http://localhost:8000/login/?email=',
    'class' => 'btn btn-primary',
    'title' => 'Migrate Stuff',     
));

echo elgg_view_page("GCconnex - GCaccount migration", $page);