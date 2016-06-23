<?php
/**
 * Elgg JSONP Support (basically the same as the JSON interface at this point)
 */

$items = $vars['items'];

if (is_array($items) && sizeof($items) > 0) {
	foreach ($items as $item) {
		elgg_view_list_item($item, $vars);
	}
}