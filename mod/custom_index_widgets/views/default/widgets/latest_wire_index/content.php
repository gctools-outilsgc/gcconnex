<?php
	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 10;

	elgg_set_context('search');

	$widget_datas = elgg_list_entities(array(
		'type'=>'object',
		'subtype'=>'thewire',
		// 'offset' => 0, //GCChange - set offset to 0 instead of getting it through GET data from the url [this way, it only displays the latest and doesn't paginate along with the activity]
		'limit'=> $num_items,
		'full_view' => false,
		'view_type_toggle' => false,
		'pagination' => false
	));

	echo $widget_datas;
?>
