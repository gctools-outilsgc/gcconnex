<?php
/**
 * Content filter for river
 *
 * @uses $vars[]
 *
 * GC_MODIFICATION
 * Description: Added wet styling and classes / Adding form labels
 * Author: GCTools Team
 */

// create selection array
$options = array();
$options['type=all'] = elgg_echo('river:select', array(elgg_echo('all')));
$registered_entities = elgg_get_config('registered_entities');

if (!empty($registered_entities)) {
	foreach ($registered_entities as $type => $subtypes) {
		// subtype will always be an array.
		if (!count($subtypes)) {
			$label = elgg_echo('river:select', array(elgg_echo("item:$type")));
			$options["type=$type"] = $label;
		} else {
			foreach ($subtypes as $subtype) {
				$label = elgg_echo('river:select', array(elgg_echo("item:$type:$subtype")));
				$options["type=$type&subtype=$subtype"] = $label;
			}
		}
	}
}

$params = array(
	'id' => 'elgg-river-selector',
	'options_values' => $options,
);
$selector = $vars['selector'];
if ($selector) {
	$params['value'] = $selector;
}
//adding a label to the filter dropdown to make that happy :)
echo '<label for="elgg-river-selector" class="mrgn-tp-md">'.elgg_echo('wet4:filterActivity').'</label>' . elgg_view('input/select', $params);

elgg_load_js('elgg.ui.river');
