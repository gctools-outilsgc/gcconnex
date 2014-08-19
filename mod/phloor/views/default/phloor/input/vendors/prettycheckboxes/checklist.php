<?php

$options   = elgg_extract('options',   $vars, array());
if(empty($options)) {
    return true;
}

// extend the foot element only one time
if(!phloor_is_view_extended('page/elements/foot', 'phloor/vendors/prettycheckboxes/prettycheckboxes-js')) {
    elgg_extend_view('page/elements/foot', 'phloor/vendors/prettycheckboxes/prettycheckboxes-js');
}

$list_type = elgg_extract('list_type', $vars, 'list');

if(!in_array($list_type, array("list", "container"))) {
    $list_type = "list";
}

$view_path = "phloor/input/vendors/prettycheckboxes/checklist";
$content = "";
switch($list_type) {
    case "container":
        $content = elgg_view("$view_path/container", $vars);
        break;
    case "list":
    default:
        $content = elgg_view("$view_path/list", $vars);
}

echo $content;