<?php
/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * MBlondin 	2016-03-11 		Creation of widget

 ***********************************************************************/
     $vars['entity']->widget_title='';
$access_id = $vars['access_id']->access_id;
if (!isset($access_id)) $access_id = 1;
echo elgg_view('input/access', array('name' => 'params[access_id]', 'value' => $access_id));
     
     ?>