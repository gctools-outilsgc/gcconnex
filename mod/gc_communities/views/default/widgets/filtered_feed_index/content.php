<?php

/**
 * Community page widgets
 */
 
 	$widget = $vars['entity'];
	$object_types = array('object');
	$object_subtypes = array('blog','groupforumtopic','event_calendar','file');

	$widget->title = ( get_current_language() == "fr" ) ? $widget->widget_title_fr : $widget->widget_title_en;
	
	$num_items = $widget->num_items;
	if ( !isset($num_items) ) $num_items = 10;

	$widget_tags = trim($widget->widget_tags);
  	if( $widget_tags ) $widget_tags = explode(',', $widget_tags);
	
	$widget_tag_logic = $widget->widget_tag_logic;

	$options = array(
		'types' => $object_types,
		'subtypes' => $object_subtypes,
		'limit' => $num_items,
		'full_view' => false,
		'list_type_toggle' => false,
		'pagination' => true
	);

	if( !empty($widget_tags) ){
		if( $widget_tag_logic == "and" ){
			foreach( $widget_tags as $tag ){
	    		$options['metadata_name_value_pairs'][] = array('name' => 'tags', 'value' => $tag, 'operand' => '=');
	    		$options['metadata_name_value_pairs_operator'] = 'AND';
			}
		} else {
			$options['metadata_name'] = 'tags';
	    	$options['metadata_values'] = $widget_tags;
		}
	}

  	$widget_datas = ( isset($options['metadata_name']) || isset($options['metadata_name_value_pairs']) ) ?  elgg_list_entities_from_metadata($options) : elgg_list_entities($options);
	
	echo $widget_datas;
?>
