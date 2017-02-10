<?php
//HELLO WORLD
echo elgg_view('cp_notifications/admin_nav');
$title = elgg_echo('elgg_solr:settings:title:adapter_options');
echo elgg_view_module('main', $title, $body);

echo "HEY WORLD";