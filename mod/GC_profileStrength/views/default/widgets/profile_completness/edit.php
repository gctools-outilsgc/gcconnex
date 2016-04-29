<?php
//$vars['entity']->access_id = 1;

//$access_id = $vars['entity']->guid;
$access_id = $vars['access_id']->access_id;
if (!isset($access_id)) $access_id = 1;
////$show_access = elgg_extract('show_access', $vars, true);
////$access_id = elgg_extract('access_id', $vars, ACCESS_FRIENDS);

//echo elgg_echo('ps:access');
///*echo elgg_view('input/dropdown', array('name'=>'params[show_access]',
//                                              'options_values'=>array('yes'=>'yes', 'no'=>'no'),
//                                               'value'=>$show_access));*/
echo elgg_view('input/access', array('name' => 'params[access_id]', 'value' => $access_id));
?>