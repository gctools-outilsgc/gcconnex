<div class="contentWrapper"> 
<?php

	$num_items = $vars['entity']->num_items;
  	if (!isset($num_items)) $num_items = 10;
  
  	$widget_group = $vars["entity"]->widget_group;
  	if (!isset($widget_group)) $widget_group = ELGG_ENTITIES_ANY_VALUE;
	
	$widget_album = $vars["entity"]->widget_album;
	if (!isset($widget_album)) $widget_album = ELGG_ENTITIES_ANY_VALUE;
	
	if ($widget_album != 0){
		
		$prev_context = elgg_get_context();
        $widgetdatas = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'image',
			'container_guids' => array($widget_album),
			'limit' => $num_items,
			'full_view' => false,
			'list_type_toggle' => false,
			'list_type' => 'gallery',
			'pagination' => false,
			'gallery_class' => '',
        ));
        elgg_set_context($prev_context);

	}elseif($widget_group != 0){
		
		$albums = elgg_get_entities(array( "types"=>"object", "subtypes"=>"album", "container_guid"=>$widget_group));
		$containers = array();
		foreach($albums as $album){
			$containers[] = $album->getGUID();
		}
		
		$prev_context = elgg_get_context();
        $widgetdatas = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'image',
			'container_guids' => $containers,
			'limit' => $num_items,
			'full_view' => false,
			'list_type_toggle' => false,
			'list_type' => 'gallery',
			'pagination' => false,
			'gallery_class' => '',
        ));
        elgg_set_context($prev_context);
		
	}else{
		$widgetdatas = tp_get_latest_photos($num_items);
	}

	echo '<div class="icon_latest">';
	echo $widgetdatas;
	echo '</div>';

?>
</div>
