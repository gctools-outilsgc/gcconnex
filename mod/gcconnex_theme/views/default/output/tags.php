<?php
/**
 * Elgg tags
 * Tags can be a single string (for one tag) or an array of strings. Accepts all output/tag options
 *
 * @uses $vars['value']      Array of tags or a string
 * @uses $vars['entity']     Optional. Entity whose tags are being displayed (metadata ->tags)
 * @uses $vars['list_class'] Optional. Additional classes to be passed to <ul> element
 * @uses $vars['item_class'] Optional. Additional classes to be passed to <li> elements
 * @uses $vars['icon_class'] Optional. Additional classes to be passed to tags icon image
 */
 /*
 * GC_MODIFICATION
 * Description: Added font awesome icon for start of tags list. Custom styling to tags. Tags now link to the GSA
 * Author: GCTools Team
 */
if (isset($vars['entity'])) {
	$vars['tags'] = $vars['entity']->tags;
	unset($vars['entity']);
}

$value = elgg_extract('value', $vars);
unset($vars['value']);
if (empty($vars['tags']) && (!empty($value) || $value === 0 || $value === '0')) {
	$vars['tags'] = $value;
}

if (empty($vars['tags']) && $value !== 0 && $value !== '0') {
	return;
}

$tags = $vars['tags'];
unset($vars['tags']);

if (!is_array($tags)) {
	$tags = array($tags);
}

$list_class = "list-inline tags mrgn-lft-sm mrgn-tp-sm";
if (isset($vars['list_class'])) {
	$list_class = "$list_class {$vars['list_class']}";
	unset($vars['list_class']);
}

$item_class = "elgg-tag";
if (isset($vars['item_class'])) {
	$item_class = "$item_class {$vars['item_class']}";
	unset($vars['item_class']);
}

$icon_class = elgg_extract('icon_class', $vars);
unset($vars['icon_class']);

$list_items = '';

foreach($tags as $tag) {
	if (is_string($tag) && strlen($tag) > 0) {
        //Adding GSA query to tags
        if(get_current_language() == 'en'){
            $lang_string ='eng';
        }else{
           $lang_string = 'fra';
        }
        $query = '?q='.$tag.'&a=s&s=3&chk4=on';
        $url = "http://intranet.canada.ca/search-recherche/query-recherche-" .$lang_string. ".aspx" .$query;
		$list_items .= "<li class=\"$item_class\">";
		$list_items .= '<a href="'.$url.'">'.$tag.'</a>';
		$list_items .= '</li>';
	}
}

$icon = "<span class=\"fa fa-tags fa-lg\"></span>";

echo <<<___HTML
	<div class="clearfix">
		<ul class="$list_class">
			<li>$icon</li>
			$list_items
		</ul>
	</div>
___HTML;

