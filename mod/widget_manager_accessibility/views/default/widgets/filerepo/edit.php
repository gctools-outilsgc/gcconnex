<?php

$widget = elgg_extract("entity", $vars);
$widgetId = $widget->getGUID();
// number of files to display
$num_display = sanitise_int($widget->num_display, false);
if (empty($num_display)) {
	$num_display = 4;
}

// show only featured files
$noyes_options = array(
	"no" => elgg_echo("option:no"),
	"yes" => elgg_echo("option:yes")
);

// listing options
$listing_options = array(
	1 => elgg_echo("file:list"),
	2 => elgg_echo("file:gallery")
);

?>
<div>
	<?php
		echo '<label for="num_display-'.$widgetId.'">'.elgg_echo("file:num_files").'</label>';
		echo ":&nbsp;";
		echo elgg_view("input/dropdown", array("name" => "params[num_display]", "options" => array(1,2,3,4,5,6,7,8,9,10,15,20), "value" => $num_display, 'id'=>'num_display-'.$widgetId,));
	?>
</div>

<div>
	<?php
    echo '<label for="featured_only-'.$widgetId.'">'.elgg_echo("widget:file:edit:show_only_featured").'</label>';
		echo ":&nbsp;";
		echo elgg_view("input/dropdown", array("name" => "params[featured_only]", "options_values" => $noyes_options, "value" => $widget->featured_only, 'id'=>'featured_only-'.$widgetId,));
	?>
</div>

<div>
    <?php
    echo '<label for="gallery_list-'.$widgetId.'">'.elgg_echo("file:gallery_list").'</label>';
		echo ":&nbsp;";
		echo elgg_view("input/dropdown", array("name" => "params[gallery_list]", "options_values" => $listing_options, "value" => $widget->gallery_list, 'id'=>'gallery_list-'.$widgetId,));
	?>
</div>