<?php

$maintype = "object";
$subtype = $vars["entity"]->widget_subtype;

if ($subtype == 'user') {$maintype='user'; $subtype='';}
if ($subtype == 'group') {$maintype='group'; $subtype='';}

$num_items = $vars['entity']->num_items;
if (!isset($num_items))
    $num_items = 20;
	
$metadata_name = $vars['entity']->metadata_name;
if (!isset($metadata_name))
    $metadata_name = "";

$threshold = $vars['entity']->threshold;
if (!isset($threshold))
    $threshold = 1;
	
$widget_group = $vars["entity"]->widget_group;
if (!isset($widget_group)) $widget_group = "";


$body = elgg_view_tagcloud( array("threshold"=>$threshold, "limit"=>$num_items, "type"=>$maintype, "subtypes"=>$subtype, "container_guids"=>$widget_group ));
echo $body;
	
?>
