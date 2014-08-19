<?php
/**
 * Button area for showing the add widgets panel
 */

?>
<div class="elgg-widget-add-control">
<?php
	$options = array(
			'id' => 'widgets-add-panel',
			'href' => '#widget_manager_widgets_select',
			'text' => elgg_echo('widgets:add'),
			'class' => 'elgg-button elgg-button-action',
			'is_trusted' => true,
		);
	
	if(elgg_in_context("iframe_dashboard")){
		$options["style"] = "visibility: hidden;";
	}
	echo elgg_view('output/url', $options);
	
?>
</div>