<?php 

/**
 * Custom index widgets
 * 
 * @author Fx NION
 */

  $num_items = $vars['entity']->num_items;
  if (!isset($num_items)) $num_items = 10;
 
  $widget_datas = elgg_list_river(array("limit"=>$num_items));
  
	echo $widget_datas;
?>        

