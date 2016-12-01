<?php
/**
 * Elgg email input
 * Displays an email input field
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['class'] Additional CSS class
 *
 * GC_MODIFICATION
 * Description: adding form control class 
 * Author: GCTools Team
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-email form-control';

$defaults = array(
	'disabled' => false,
	'autocapitalize' => 'off',
	'autocorrect' => 'off',
	'type' => 'email'
);

$vars = array_merge($defaults, $vars);

echo elgg_format_element('input', $vars);
