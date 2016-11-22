  <?php

  /**
 * Custom index widgets
 * 
 * @author Fx NION
 */

	$num_items = $vars['entity']->num_items;
	if (!isset($num_items)) $num_items = 10;
	
	$widget_group = $vars["entity"]->widget_group;
  	if (!isset($widget_group)) $widget_group = 0;
	
  	
	$widget_title = $vars['entity']->widget_title;
	$widget_album = $vars["entity"]->widget_album;
	
	$guest_only = $vars['entity']->guest_only;
	if (!isset($guest_only)) $guest_only = "no";
	
	$box_style = $vars['entity']->box_style;
	if (!isset($box_style)) $box_style = "collapsable";
  ?>
  <p>
      <?php echo elgg_echo('custom_index_widgets:widget_title'); ?>
      :
      <?php
      echo elgg_view('input/text', array('name'=>'params[widget_title]', 'value'=>$widget_title));
      ?>
  </p>
  <p>
      <?php echo elgg_echo('group'); ?>
      : 
      <?php
      $groups = elgg_get_entities(array("type"=>'group','limit'=>100));
      $group_list = array();
      $group_list[0] = elgg_echo('custom_index_widgets:widget_all_groups');
      if ($groups) {
          foreach ($groups as $group) {
              $group_list[$group->getGUID()] = $group->name;
          }
      }
      echo elgg_view('input/dropdown', array('name'=>'params[widget_group]', 'options_values'=>$group_list, 'value'=>$widget_group));
      ?>
  </p>
  <p>
      <?php echo elgg_echo('album'); ?>
      : 
      <?php
		$albums = elgg_get_entities(array( "types"=>"object", "subtypes"=>"album"));
		$containers = array();
		$containers[0] = elgg_echo('all');
		if ($albums) {
			foreach($albums as $album){
				$containers[$album->getGUID()] = $album->getTitle();
			}
		}
      echo elgg_view('input/dropdown', array('name'=>'params[widget_album]', 'options_values'=>$containers, 'value'=>$widget_album));
      ?>
  </p>
  <p>
      <?php echo elgg_echo('custom_index_widgets:num_items'); ?>
      :
      <?php
      echo elgg_view('input/dropdown', array('name'=>'params[num_items]', 'options_values'=>array('1'=>'1', '3'=>'3', '5'=>'5', '8'=>'8', '10'=>'10', '12'=>'12', '15'=>'15', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '100'=>'100', ), 'value'=>$num_items));
      ?>
  </p>
  <p>
      <?php echo elgg_echo('custom_index_widgets:box_style'); ?>
      :
      <?php
      echo elgg_view('input/dropdown', array('name'=>'params[box_style]', 
      										 'options_values'=>array('plain'=>'Plain', 'plain collapsable'=>'Plain and collapsable', 'collapsable'=>'Collapsable', 'standard' => 'No Collapsable'),
       										 'value'=>$box_style));
      ?>
  </p>
  <p>
      <?php echo elgg_echo('custom_index_widgets:guest_only'); ?>
      :
      <?php
      echo elgg_view('input/dropdown', array('name'=>'params[guest_only]', 
      										 'options_values'=>array('yes'=>'yes', 'no'=>'no'),
       										 'value'=>$guest_only));
      ?>
  </p>