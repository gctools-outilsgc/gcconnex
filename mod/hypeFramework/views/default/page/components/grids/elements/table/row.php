<?php

$item = elgg_extract('entity', $vars);
$class = elgg_extract('class', $vars);

if (!$item) {
	return true;
}

$type = $item->getType();
$subtype = $item->getSubtype();

$view = "object/$type/$subtype/grids/table";

if (elgg_view_exists($view)) {
	echo elgg_view($view, $vars);
	return true;
}

$class = "elgg-item hj-framework-table-row elgg-$type elgg-$type-$subtype";

$id = false;

if (elgg_instanceof($item)) {
	$id = "elgg-entity-$item->guid";
	$uid = $item->guid;
	$ts = max(array($item->time_created, $item->time_updated, $item->last_action));
} elseif ($item instanceof ElggRiverItem) {
	$id = "elgg-river-{$item->id}";
	$uid = $item->id;
	$ts = $item->posted;
} elseif ($item instanceof ElggAnnotation) { // Thanks to Matt Beckett for the fix
	$id = "item-{$item->name}-{$item->id}";
	$uid = $item->id;
	$ts = $item->time_created;
}

if (!$id) {
	return true;
}

$attr = array(
	'id' => $id,
	'class' => $class,
	'data-uid' => $uid,
	'data-ts' => $ts
);

$attributes = elgg_format_attributes($attr);


$headers = $vars['list_options']['list_view_options']['table']['head'];

if ($headers) {
	$item_view = '';
	foreach ($headers as $header => $options) {

		if (!$options)
			continue;

		$colspan = '';
		if (isset($options['override_view']) && elgg_view_exists($options['override_view'])) {
			$cell = elgg_view($options['override_view'], $vars);
		} else if (elgg_view_exists("$type/$subtype/elements/$header")) {
			$cell = elgg_view("$type/$subtype/elements/$header", $vars);
		} else if (elgg_view_exists("framework/bootstrap/$type/elements/$header")) {
			$cell = elgg_view("framework/bootstrap/$type/elements/$header", $vars);
		} else if (isset($options['colspan'])) {
			$cell = '';
			foreach ($options['colspan'] as $col_header => $col_options) {
				if (!$col_options)
					continue;
				if (isset($col_options['override_view']) && elgg_view_exists($col_options['override_view'])) {
					$cell = elgg_view($col_options['override_view'], $vars);
				} else if (elgg_view_exists("$type/$subtype/elements/$col_header")) {
					$cell .= elgg_view("$type/$subtype/elements/$col_header", $vars);
				} else if (elgg_view_exists("framework/bootstrap/$type/elements/$col_header")) {
					$cell .= elgg_view("framework/bootstrap/$type/elements/$col_header", $vars);
				} else {
					$cell .= '<div>' . $item->$col_header . '</div>';
				}
			}
			//$colspan = ' colspan="' . count($options['colspan']) . '"';
		} else {
			$cell = '<div>' . $item->$header . '</div>';
		}
		$header_ns = preg_replace('/[^a-z0-9\-]/i', '-', $header);
		$item_view .= "<td $colspan class=\"table-cell-$header_ns\">$cell</td>";
	}
} else {
	$item_view .= elgg_view_list_item($entity, $vars);
}

echo "<tr $attributes>$item_view</tr>";

