<?php
/**
 * River entry for new questions
 */

$lang = get_current_language();

$item = elgg_extract('item', $vars);
$question = $item->getObjectEntity();
if (!($question instanceof ElggQuestion)) {
	return;
}

$vars['message'] = elgg_get_excerpt(gc_explode_translation($question->description,$lang));

echo elgg_view('river/elements/layout', $vars);
