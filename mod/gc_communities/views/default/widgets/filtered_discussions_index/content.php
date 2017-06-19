<?php

/**
 * Community page widgets
 */
 
 	$widget = $vars['entity'];
	$object_type = 'groupforumtopic';

	$widget->title = ( get_current_language() == "fr" ) ? $widget->widget_title_fr : $widget->widget_title_en;
	
	$num_items = $widget->num_items;
	if ( !isset($num_items) ) $num_items = 10;

	$widget_groups = $widget->widget_groups;
	if ( !isset($widget_groups) ) $widget_groups = ELGG_ENTITIES_ANY_VALUE;

	$widget_tags = trim($widget->widget_tags);
  	if( $widget_tags ) $widget_tags = array_map('trim', explode(',', $widget_tags));
	
	$widget_tag_logic = $widget->widget_tag_logic;
	$widget_add_button = $widget->widget_add_button;

	$options = array(
		"type" => "object",
		"subtype" => $object_type,
		"limit" => $num_items,
		"order_by" => "e.last_action desc",
		"pagination" => false,
		"full_view" => false
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

	if( !empty($widget_groups) && $widget_groups[0] != 0 ){
	    $options['container_guids'] = $widget_groups;
	}

	if( $widget_add_button == "yes" ){
		$params = $vars;
		$params["embed"] = true;
		echo elgg_view("widgets/start_discussion/content", $params);
	}

	$widget_datas = ( isset($options['metadata_name']) || isset($options['metadata_name_value_pairs']) ) ?  elgg_list_entities_from_metadata($options) : elgg_list_entities($options);

	if( empty($widget_datas) ){
		$widget_datas = elgg_echo("grouptopic:notcreated");
	} else {
		$widget_datas .= "<div class='elgg-widget-more'>";
		$widget_datas .= elgg_view("output/url", array("text" => elgg_echo("widgets:discussion:more"), "href" => "discussion/all"));
		$widget_datas .= "</div>";
	}
	
	echo $widget_datas;
?>
