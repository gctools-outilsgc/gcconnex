<?php
/**
 * Create a reset input button
 *
 * @package Elgg
 * @subpackage Core
 * 
 * @uses $vars['class'] CSS class that replaces elgg-button-cancel
 */

$vars['type'] = 'reset';
$vars['class'] = elgg_extract('class', $vars, 'btn-inverse elgg-button-cancel');

echo elgg_view('input/button', $vars);