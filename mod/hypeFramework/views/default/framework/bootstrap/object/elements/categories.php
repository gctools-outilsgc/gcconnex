<?php

echo '<div class="elgg-entity-categories">';
if (elgg_view_exists('output/categories')) {
	echo elgg_view('output/categories', $vars);
} else {
	echo elgg_view('output/tags', array(
		'value' => string_to_tag_array($vars['entity']->categories)
	));
}
echo '</div>';
