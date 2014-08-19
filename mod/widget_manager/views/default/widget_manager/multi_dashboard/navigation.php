<?php

	$max_tab_title_length = 10;
	
	$md_entities = elgg_extract("entities", $vars);
	$selected_guid = (int) get_input("multi_dashboard_guid", 0);
	
	$tabs = array();
	
	// add the default tab
	$default_tab = array(
				"text" => elgg_echo("dashboard"),
				"href" => "dashboard",
				"title" => elgg_echo("dashboard"),
				"class" => "widget-manager-multi-dashboard-tab-widgets"
	);
	
	if(empty($selected_guid)){
		$default_tab["selected"] = true;
	}
	
	$tabs[0] = $default_tab;
	
	if(!empty($md_entities)){
		foreach($md_entities as $key => $entity){
			
			$selected = false;
			if($entity->getGUID() == $selected_guid){
				$selected = true;
			} 
			$tab_title = $entity->title;
			if(strlen($tab_title) > $max_tab_title_length){
				$tab_title = substr($tab_title, 0, $max_tab_title_length);
			}
			
			$order = $entity->order ? $entity->order : $entity->time_created;
			
			$tabs[$order] = array(
				"text" => $tab_title . elgg_view_icon("settings-alt", "widget-manager-multi-dashboard-tabs-edit"),
				"href" => $entity->getURL(),
				"title" => $entity->title,
				"selected" => $selected,
				"rel" => $entity->getGUID(),
				"id" => $entity->getGUID(),
				"class" => "widget-manager-multi-dashboard-tab widget-manager-multi-dashboard-tab-" . $entity->getDashboardType()
			);
		}
	}
	
	ksort($tabs);
	
	// add tab tab
	if(is_array($md_entities) && count($md_entities) < MULTI_DASHBOARD_MAX_TABS){
		$tabs[] = array(
			"text" => elgg_view_icon("round-plus", "widget-manager-multi-dashboard-tabs-add"),
			"href" => "multi_dashboard/edit",
			"title" => elgg_echo('widget_manager:multi_dashboard:add'),
			"id" => "widget-manager-multi-dashboard"
		);
	}
	
	echo elgg_view("navigation/tabs", array("id" => "widget-manager-multi-dashboard-tabs", "tabs" => $tabs));
?>
<script type="text/javascript">
	var widget_manger_multi_dashboard_dropped = false;

	$(document).ready(function(){
		$("#widget-manager-multi-dashboard a").fancybox({ 
			autoDimensions: false, 
			width: 400, 
			height: 360,
			titleShow: false
		});	
		
		$("#widget-manager-multi-dashboard-tabs .widget-manager-multi-dashboard-tabs-edit").click(function(event){
			var id = $(this).parent().attr("rel");
			$.fancybox({
				"href" : elgg.get_site_url() + "multi_dashboard/edit/" + id,
				"autoDimensions" : false,
				"width": 400,
				"height": 360
				});
			event.preventDefault();
		});

		$("#widget-manager-multi-dashboard-tabs .widget-manager-multi-dashboard-tab-widgets").not(".elgg-state-selected").droppable({
			accept: ".elgg-module-widget",
			activeClass: "widget-manager-multi-dashboard-tab-active",
			hoverClass: "widget-manager-multi-dashboard-tab-hover",
			tolerance: "pointer",
			drop: function(event, ui){
				// prevent the widget from being moved
				widget_manger_multi_dashboard_dropped = true;
				
				// elgg-widget-<guid>
				var guidString = ui.draggable.attr('id');
				guidString = guidString.substr(guidString.indexOf('elgg-widget-') + "elgg-widget-" . length);

				// tab guid
				var tabGuid = $(this).find("a:first").attr("rel");
				if(tabGuid == "nofollow"){
					tabGuid = 0;
				}

				ui.draggable.hide();
				
				elgg.action("multi_dashboard/drop", {
					data: {
						widget_guid: guidString,
						multi_dashboard_guid: tabGuid
					},
					success: function(){
						ui.draggable.remove();
					},
					error: function(){
						ui.draggable.show();
					}
				});
			} 
		});

		// function to prevent the widget move action when dropped on a multi dashboard tab
		$(".elgg-widgets").ajaxSend(function(event, jqXHR, ajaxOptions){
			var ajax_url = ajaxOptions.url;

			if(ajax_url == elgg.get_site_url() + "action/widgets/move"){
				if(widget_manger_multi_dashboard_dropped !== false){
					jqXHR.abort();

					widget_manger_multi_dashboard_dropped = false;
				}
			}
		});

		$("#widget-manager-multi-dashboard-tabs").sortable({
			items: "li.widget-manager-multi-dashboard-tab",
			tolerance: "pointer",
			axis: "x",
			cursor: "move",
			distance: 5,
			delay: 15,
			forcePlaceholderSize: true,
			update: function(event, ui){
				$order = $(this).sortable('toArray');
				
				elgg.action("multi_dashboard/reorder", {
					data: {
						order: $order
					}
				});
			}
		});
	});
</script>