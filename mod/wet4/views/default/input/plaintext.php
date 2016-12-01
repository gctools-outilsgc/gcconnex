<?php
/**
 * Elgg long text input (plaintext)
 * Displays a long text input field that should not be overridden by wysiwyg editors.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['value']    The current value, if any
 * @uses $vars['name']     The name of the input field
 * @uses $vars['class']    Additional CSS class
 * @uses $vars['disabled']
 *
 * GC_MODIFICATION
 * Description: Added wet classes
 * Author: GCTools Team
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-plaintext form-control';

$defaults = array(
	'value' => '',
	'rows' => '10',
	'cols' => '50',
	'disabled' => false,
);

$vars = array_merge($defaults, $vars);

$value = htmlspecialchars($vars['value'], ENT_QUOTES, 'UTF-8');
unset($vars['value']);

echo elgg_format_element('textarea', $vars, $value);
