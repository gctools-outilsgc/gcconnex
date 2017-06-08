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
 * Description: Adding wet classes
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

$help_link = elgg_view('output/url', array(
    'text' => '[?] <span class="wb-invisible">Tell me about tags?</span>',
    'href' => '#',
    'title' => 'Tell me about tags!'
));

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
echo elgg_format_element('label', array('for' => 'tags'), elgg_echo('tags'));
echo elgg_format_element('span',array('class' => 'mrgn-lft-sm'),$help_link);
echo elgg_format_element('div', array('class' => 'timeStamp'), elgg_echo('gctags:helpertext:tags'));
echo elgg_format_element('input', $vars);