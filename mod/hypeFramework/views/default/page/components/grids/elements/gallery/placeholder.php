<?php

$vars['rel'] = 'placeholder';
$attributes = elgg_format_attributes(elgg_clean_vars($vars));
$item_view = elgg_echo("hj:framework:list:empty");

echo "<li $attributes>$item_view</li>";
