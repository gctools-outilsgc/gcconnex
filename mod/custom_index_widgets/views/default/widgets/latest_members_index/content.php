<?php 
  
  $num_items = $vars['entity']->num_items;
  if (!isset($num_items)) $num_items = 10;
  $display_avatar = $vars['entity']->display_avatar;
  if (!isset($display_avatar)) $display_avatar = 'yes';
  
  $widget_datas = elgg_list_entities_from_metadata(array(
		'metadata_names' => 'icontime',
		'types' => 'user',
		// 'offset' => 0, //GCChange - set to 0 in order to ignore pagination of activity index widget
		'limit' => $num_items,
		'full_view' => false,
		'pagination' => false,
		'list_type' => 'gallery', //GCChange - added 'list_type' => 'gallery' because otherwise, takes too much space
		'size' => 'small',
	));

echo $widget_datas;
?>        


