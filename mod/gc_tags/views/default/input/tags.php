<?php
/**
 * Elgg tag input
 * Displays a tag input field
 *
 * @uses $vars['disabled']
 * @uses $vars['class']    Additional CSS class
 * @uses $vars['value']    Array of tags or a string
 * @uses $vars['entity']   Optional. Entity whose tags are being displayed (metadata ->tags)
 *
 * GC_MODIFICATION
 * Description: Adding wet classes, added placeholder text, custom classes for selectize.js, added input label and helper text right to the input
 * Author: GCTools Team
 */

$vars['class'] = (array) elgg_extract('class', $vars, []);
$vars['class'][] = 'elgg-input-tags form-control';

$defaults = array(
    'id' => 'tags',
	'value' => '',
	'disabled' => false,
	'autocapitalize' => 'off',
	'type' => 'text',
    'placeholder' => elgg_echo('gctags:placeholder:tags'),  
);

if (isset($vars['entity'])) {
	$defaults['value'] = $vars['entity']->tags;
	unset($vars['entity']);
}

$vars = array_merge($defaults, $vars);

if (is_array($vars['value'])) {
	$tags = array();

	foreach ($vars['value'] as $tag) {
		if (is_string($tag)) {
			$tags[] = $tag;
		} else {
			$tags[] = $tag->value;
		}
	}

	$vars['value'] = implode(", ", $tags);
}
echo '<div class="tag-wrapper">';
echo elgg_format_element('div', array('class' => 'timeStamp'), elgg_echo('gctags:helpertext:tags'));
echo elgg_format_element('input', $vars);
echo '</div>';