<?php 
	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 10;
	elgg_set_context('custom_index_widgets');
 	
	$widget_datas = elgg_list_entities(array(
		'type'=>'object',
		'subtype'=>'thewire',
		'limit'=>$num_items,
		'full_view' => false,
		'list_type_toggle' => false,
		'pagination' => false));
	
	echo $widget_datas;

$all_link = elgg_view('output/url', array(
	'href' => 'thewire/all',
	'text' => elgg_echo('View The Wire') . $groupCount,
	'is_trusted' => true,
));
echo "<div class='text-right mrgn-tp-sm'>$all_link</div>";

?>


