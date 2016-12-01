<?php
/**
 * Create a submit input button
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['class'] CSS class that replaces elgg-button-submit
 *
 * GC_MODIFICATION
 * Description: Adding wet classes
 * Author: GCTools Team
 */

$vars['type'] = 'submit';
$vars['class'] = elgg_extract('class', $vars, 'elgg-button-submit btn btn-primary');

echo elgg_view('input/button', $vars);