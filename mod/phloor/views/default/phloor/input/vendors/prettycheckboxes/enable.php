<?php


// get the name of the variable
$name        = elgg_extract('name',        $vars, '');
$value       = elgg_extract('value',       $vars, '');
$label       = elgg_extract('label',       $vars, '###');
$description = elgg_extract('description', $vars, '');
$image       = elgg_extract('image',       $vars, '');


// add image to label if it exists
if(!empty($image)) {
   $label .= "<div class=\"checkbox-image-container\">$image</div>";
}

$options = array(
	'name' => $name,
	'value' => 'true', // the "enable" buttons value is 'true'
);

if(strcmp('true', $value) == 0) {
	$options['checked'] = 'checked';
}

$checkbox = elgg_view('input/checkbox', $options);

$enable  = elgg_echo('phloor:enable');
$disable = elgg_echo('phloor:disable');

// output

$content = "";

$content .= $checkbox;
$content .= "<label for=\"$name\">$label</label>";

if (!empty($description)) {
    $content .= "<div class=\"checkbox-description\">$description</div>";
}

$content .=  "<a class=\"checkbox-select\" href=\"#\">$enable</a>";
$content .=  "<a class=\"checkbox-deselect\" href=\"#\">$disable</a>";

echo $content;
