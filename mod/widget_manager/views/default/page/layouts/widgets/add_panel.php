<?php
elgg_load_js('lightbox');
elgg_load_css('lightbox');

$context = $vars["context"];

if($md_guid = get_input("multi_dashboard_guid")){
	$params = array(
				'name' => 'widget_context',
				'value' => $context . "_" . $md_guid
	);
} else {
	$params = array(
			'name' => 'widget_context',
			'value' => $context
	);
}
echo elgg_view('input/hidden', $params);

?>
<script type="text/javascript">

	$(document).ready(function(){
		$("#widgets-add-panel").fancybox({ 
			autoDimensions: false, 
			width: 600, 
			height: "80%"
		});	
	});

	function widget_manager_widget_add_init(){
		
		$("#elgg-widget-col-1").ajaxSuccess(function(e, xhr, settings) {
			
			if (settings.url == elgg.normalize_url('/action/widgets/add')) {
				// move new widget to a new position if needed
				if($(this).find('.elgg-state-fixed').size() > 0){
					$widget = $(this).find('.elgg-module-widget:first');
					$widget.insertAfter($(this).find('.elgg-state-fixed:last'));
					
					// first item is the recently moved widget, because fixed widgets are not part of the sortable
					var index = $(this).find('.elgg-module-widget').index($widget);
					var guidString = $widget.attr('id');
					guidString = guidString.substr(guidString.indexOf('elgg-widget-') + "elgg-widget-".length);

					elgg.action('widgets/move', {
						data: {
							widget_guid: guidString,
							column: 1,
							position: index
						}
					});
					
				}
			}
		});
	}

	elgg.register_hook_handler('init', 'system', widget_manager_widget_add_init);

</script>
<?php 
	
	$widget_context = str_replace("default_", "", $context);
	
	$available_widgets_context = elgg_trigger_plugin_hook("available_widgets_context", "widget_manager", array(), $widget_context);
	
	$widgets = elgg_get_widget_types($available_widgets_context, $vars["exact_match"]);
	widget_manager_sort_widgets($widgets);

	$current_handlers = array();
	if(!empty($vars["widgets"])){
		// check for already used widgets
		foreach ($vars["widgets"] as $column_widgets) {
			// foreach column
			foreach ($column_widgets as $widget) {
				// for each widgets
				$current_handlers[] = $widget->handler;
			}
		}
	}
	
	$title = "<div id='widget_manager_widgets_search'>";
	$title .= "<input title='" . elgg_echo("search") . "' type='text' value='" . elgg_echo("search") . "' onfocus='if($(this).val() == \"" . elgg_echo("search") .  "\"){ $(this).val(\"\"); }' onkeyup='widget_manager_widgets_search($(this).val());'></input>";
	$title .= "</div>";
	$title .= elgg_echo("widget_manager:widgets:lightbox:title:" . $context);
	
	$body = "";
	if(!empty($widgets)){
		
		foreach($widgets as $handler => $widget){
			$can_add = widget_manager_get_widget_setting($handler, "can_add", $widget_context);
			$allow_multiple = $widget->multiple;
			$hide = widget_manager_get_widget_setting($handler, "hide", $widget_context);
			
			if($can_add && !$hide){
				$body .= "<div class='widget_manager_widgets_lightbox_wrapper'>";
				
				if(!$allow_multiple && in_array($handler, $current_handlers)){
					$class = 'elgg-state-unavailable';
				} else {
					$class = 'elgg-state-available';
				} 
				
				if ($allow_multiple) {
					$class .= ' elgg-widget-multiple';
				} else {
					$class .= ' elgg-widget-single';
				}
				
				$body .= "<span class='widget_manager_widgets_lightbox_actions'>";
				$body .= '<ul><li class="' . $class . '" id="elgg-widget-type-'. $handler . '">';
				$body .= "<span class='elgg-quiet'>" . elgg_echo('widget:unavailable') . "</span>";
				$body .= elgg_view("input/button", array("class" => "elgg-button-submit", "value" => elgg_echo("widget_manager:button:add")));
				$body .= "</li></ul>";
				$body .= "</span>";
				
				$description = $widget->description;
				if(empty($description)){
					$description = "&nbsp;"; // need to fill up for correct layout
				}
				
				$body .= "<div><b>" . $widget->name . "</b></div>";
				$body .= "<div class='elgg-quiet'>" . $description . "</div>";
				
				$body .= "</div>";
			}
		}		
	} else {
		$body = elgg_echo("notfound");
	}
	
	$module_type = "info";
	if(elgg_in_context("admin")){
		$module_type = "inline";
	} 

	echo "<div class='elgg-widgets-add-panel hidden'>" . elgg_view_module($module_type, $title, $body, array("id" => "widget_manager_widgets_select")) . "</div>";