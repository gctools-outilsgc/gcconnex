<?php

/**
 * gallery.php
 * Gallery view
 *
 * Implemented as an unorder list
 *
 * @uses $vars['items']         Array of ElggEntity, ElggAnnotation or ElggRiverItem objects
 * @uses $vars['offset']        Index of the first list item in complete list
 * @uses $vars['limit']         Number of items per page
 * @uses $vars['count']         Number of items in the complete list
 * @uses $vars['pagination']    Show pagination? (default: true)
 * @uses $vars['position']      Position of the pagination: before, after, or both
 * @uses $vars['full_view']     Show the full view of the items (default: false)
 * @uses $vars['gallery_class'] Additional CSS class for the <ul> element
 * @uses $vars['item_class']    Additional CSS class for the <li> elements
 * @uses $vars['item_view']     Alternative view to render list items
 * @uses $vars['no_results']    Message to display if no results (string|Closure)
 *
 * @package wet4
 * @author GCTools Team
 */
$items = $vars['items'];
$count = elgg_extract('count', $vars);
$pagination = elgg_extract('pagination', $vars, true);
$position = elgg_extract('position', $vars, 'after');
$no_results = elgg_extract('no_results', $vars, '');
$item_class = elgg_extract('item_class', $vars, '');
$photoContext = false; //check for the photo context

if (!$items && $no_results) {
	if ($no_results instanceof Closure) {
		echo $no_results();
		return;
	}
	echo "<p class='elgg-no-results'>$no_results</p>";
	return;
}

if (!is_array($items) || count($items) == 0) {
	return;
}
//check photo context before gallery context is forced
if((elgg_get_context() == 'photos')){
  $photoContext = true;  
}
if ((elgg_get_context() != 'event_calendar')){

	elgg_push_context('gallery');
}

echo $items->getType;
$list_classes = ['list-unstyled clearfix'];
if (isset($vars['gallery_class'])) {
	$list_classes = $vars['gallery_class'];
}

//if the boolean is false (not photo context) stack them normally
if(!$photoContext){
	if(elgg_get_context() != 'event_calendar'){
   $item_classes = ['pull-left elgg-item clearfix '];
   }
}else if($photoContext){
 //if the boolean is true (is photo context) add col class :)
    $item_classes = ['  elgg-item clearfix col-xs-6 col-sm-3 hght-inhrt'];
        $list_classes = 'clearfix wb-eqht';
}

if (isset($vars['item_class'])) {
	$item_classes[] = $vars['item_class'];
}

$nav = ($pagination) ? elgg_view('navigation/pagination', $vars) : '';

$list_items = '';
foreach ($items as $item) {
	$item_view = elgg_view_list_item($item, $vars);
	if (!$item_view) {
		continue;
	}

	$li_attrs = ['class' => $item_classes];

	if ($item instanceof \ElggEntity) {
		$li_attrs['id'] = "elgg-{$item->getType()}-{$item->getGUID()}";
	} else if (is_callable(array($item, 'getType'))) {
		$li_attrs['id'] = "item-{$item->getType()}-{$item->id}";
	}

	$list_items .= elgg_format_element('li', $li_attrs, $item_view);
}

if ($position == 'before' || $position == 'both') {
	echo $nav;
}

echo elgg_format_element('ul', ['class' => $list_classes .' list-unstyled gallery-padding'], $list_items);

if ($position == 'after' || $position == 'both') {
	echo $nav;
}

elgg_pop_context();
