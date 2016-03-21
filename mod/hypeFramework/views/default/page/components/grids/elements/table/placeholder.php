<?php

$vars['rel'] = 'placeholder';
$attributes = elgg_format_attributes(elgg_clean_vars($vars));
$item_view = elgg_echo("hj:framework:list:empty");

$colspan = ($vars['colspan'] > 1) ? "colspan={$vars['colspan']}" : '';

echo "<tr $attributes><td $colspan>$item_view</td></tr>";
