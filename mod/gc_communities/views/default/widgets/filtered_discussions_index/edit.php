<?php

/**
 * Community page widgets
 */
  
  $widget = $vars['entity'];

	$num_items = $widget->num_items;
	if ( !isset($num_items) ) $num_items = 5;
	
	$widget_groups = $widget->widget_groups;
	if ( !isset($widget_groups) ) $widget_groups = ELGG_ENTITIES_ANY_VALUE;

	$widget_title_en = $widget->widget_title_en;
  $widget_title_fr = $widget->widget_title_fr;
	$widget_tags = $widget->widget_tags;
	$widget_tag_logic = $widget->widget_tag_logic;
	$widget_add_button = $widget->widget_add_button;
?>
<p>
  <?php echo elgg_echo('widget_manager:widgets:edit:custom_title'); ?> (EN):
  <?php
    echo elgg_view('input/text', array(
      'name' => 'params[widget_title_en]',                       
      'value' => $widget_title_en
    ));
  ?>
</p>
<p>
  <?php echo elgg_echo('widget_manager:widgets:edit:custom_title'); ?> (FR):
  <?php
    echo elgg_view('input/text', array(
      'name' => 'params[widget_title_fr]',                       
      'value' => $widget_title_fr
    ));
  ?>
</p>
<p>
  <?php echo elgg_echo('groups'); ?>: 
  <?php
    $groups = elgg_get_entities(array("type" => 'group', 'limit' => 100));
    $group_list = array();
    $group_list[0] = elgg_echo('custom_index_widgets:widget_all_groups');
    if( $groups ){
      foreach( $groups as $group ){
        $group_list[$group->getGUID()] = $group->name;
      }
    }
    echo elgg_view('input/dropdown', array('name' => 'params[widget_groups]', 'options_values' => $group_list, 'value' => $widget_groups, 'multiple' => true, 'style' => 'width: 100%; display: block;'));
  ?>
</p>
<p>
  <?php echo elgg_echo('tags'); ?>:
  <?php
    echo elgg_view('input/text', array(
      'name' => 'params[widget_tags]',                       
      'value' => $widget_tags
    ));
  ?>
</p>
<p>
  <?php echo elgg_echo('Tag Logic'); ?>: 
  <?php
    echo elgg_view('input/dropdown', array('name' => 'params[widget_tag_logic]', 'options_values' => array('or' => 'OR', 'and' => 'AND'), 'value' => $widget_tag_logic));
  ?>
</p>
<p>
  <?php echo elgg_echo('widget:numbertodisplay'); ?>:
  <?php
    echo elgg_view('input/dropdown', array('name' => 'params[num_items]', 'value' => $num_items, 'options' => range(1, 10)));
  ?>
</p>
<p>
  <?php echo elgg_echo('Show "Add discussion topic" button'); ?>:
  <?php
    echo elgg_view('input/dropdown', array('name' => 'params[widget_add_button]', 'options_values' => array('yes' => 'Yes', 'no' => 'No'), 'value' => $widget_add_button));
  ?>
</p>
