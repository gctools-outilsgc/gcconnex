<?php
 
  $num_items = $vars['entity']->num_items;
  if (!isset($num_items)) $num_items = 10;
 
  $widget_context_mode = $vars['entity']->widget_context_mode;
  if (!isset($widget_context_mode)) $widget_context_mode = 'custom_index_widgets';
  elgg_set_context($widget_context_mode);

 $owner = elgg_get_logged_in_user_entity();

  $widget_datas = elgg_get_entities_from_relationship(array(
      'size' => 'small',
      'relationship' => 'member',
      'relationship_guid' => $owner->guid,
      'inverse_relationship'=> FALSE, 
		'type'=>'group',
		'limit'=>$num_items,
		'full_view' => false,
		'list_type_toggle' => false,
		'pagination' => false));
	

 $options = array(
            'full_view' => false,
            'list_type' => 'list',
            'pagination' => false,
        );

$content = elgg_view_entity_list($widget_datas, $options);


$all_link = elgg_view('output/url', array(
	'href' => 'groups/member/' . $owner->username,
	'text' => elgg_echo('View My Groups') . $groupCount,
	'is_trusted' => true,
));

echo $content;

echo "<div class='text-right mrgn-tp-sm'>$all_link</div>";
?>       

