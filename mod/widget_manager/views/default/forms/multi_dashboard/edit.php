<?php

	$dashboard_type_options = array(
		"widgets" => elgg_echo("widget_manager:multi_dashboard:types:widgets"),
		"iframe" => elgg_echo("widget_manager:multi_dashboard:types:iframe")
	);

	if($entity = elgg_extract("entity", $vars)){
		$edit = true;
		$guid = $entity->getGUID();
		$title = $entity->title;
		
		$dashboard_type = $entity->getDashboardType();
		
		$internal_url = $entity->getInternalUrl();
		
		$num_columns = $entity->getNumColumns();
		
		$iframe_url = $entity->getIframeUrl();
		$iframe_height = $entity->getIframeHeight();
		
		$submit_text = elgg_echo("update");
	} else {
		$edit = false;
		$title = get_input("title", "");
		if(!empty($title)){
			$title = str_replace(elgg_get_site_entity()->name . ": ", "", $title);
		}
		
		if($internal_url = get_input("internal_url")){
			$dashboard_type = "internal";
		} else {
			$dashboard_type = "widgets";
		}
		
		$num_columns = 3;
		
		$iframe_url = "http://";
		$iframe_height = 450;
		
		$submit_text = elgg_echo("save");
	}
	
	switch($dashboard_type){
		case "iframe":
			$iframe_class = "";
			$widgets_class = "hidden";
			break;
		case "widgets":
		default:
			$iframe_class = "hidden";
			$widgets_class = "";
			break;
	}
	
	$form_data = "<div>";
	$form_data .= "<label>" . elgg_echo("title") . "*</label>";
	$form_data .= elgg_view("input/text", array("name" => "title", "value" => $title));
	$form_data .= "</div>";
	
	if($dashboard_type != "internal"){
		$form_data .= "<div>";
		$form_data .= "<label>" . elgg_echo("widget_manager:multi_dashboard:types:title") . "</label>";
		$form_data .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "dashboard_type", "options_values" => $dashboard_type_options, "value" => $dashboard_type, "onchange" => "widget_manager_change_dashboard_type(this);"));
		$form_data .= "</div>";
	
		$form_data .= "<div class='widget-manager-multi-dashboard-types-widgets " . $widgets_class . "'>";
		$form_data .= "<label>" . elgg_echo("widget_manager:multi_dashboard:num_columns:title") . "</label>";
		$form_data .= "&nbsp;" . elgg_view("input/dropdown", array("name" => "num_columns", "options" => range(1, 6), "value" => $num_columns));
		$form_data .= "</div>";
		
		$form_data .= "<div class='widget-manager-multi-dashboard-types-iframe " . $iframe_class . "'>";
		$form_data .= "<label>" . elgg_echo("widget_manager:multi_dashboard:iframe_url:title") . "</label>";
		$form_data .= elgg_view("input/url", array("name" => "iframe_url", "value" => $iframe_url));
		$form_data .= "<div class='elgg-subtext'>" . elgg_echo("widget_manager:multi_dashboard:iframe_url:description") . "</div>";
		$form_data .= "</div>";
		
		$form_data .= "<div class='widget-manager-multi-dashboard-types-iframe " . $iframe_class . "'>";
		$form_data .= "<label>" . elgg_echo("widget_manager:multi_dashboard:iframe_height:title") . "</label>";
		$form_data .= elgg_view("input/text", array("name" => "iframe_height", "value" => $iframe_height, "size" => "5", "maxlength" => "6", "style" => "width: 100px;")) . "px";
		$form_data .= "</div>";
	} else {
		$form_data .= elgg_view("input/hidden", array("name" => "internal_url", "value" => urlencode($internal_url)));
		$form_data .= elgg_view("input/hidden", array("name" => "dashboard_type", "value" => "internal"));
	}
	
	$form_data .= "<div class='elgg-foot'>";
	$form_data .= "<div class='elgg-subtext'>" . elgg_echo("widget_manager:multi_dashboard:required") . "</div>";
	
	$form_data .= elgg_view("input/submit", array("value" => $submit_text));
	
	if($edit){
		$form_data .= elgg_view("input/hidden", array("name" => "guid", "value" => $guid));
		$form_data .= elgg_view("output/confirmlink", array("href" => elgg_get_site_url() . "action/multi_dashboard/delete?guid=" . $guid, "text" => elgg_echo("delete"), "class" => "elgg-button elgg-button-delete"));
	}
	
	$form_data .= "</div>";
	
	echo $form_data;
?>
<script type="text/javascript">
	function widget_manager_change_dashboard_type(elem){

		switch($(elem).val()){
			case "iframe":
				$('#widget_manager_multi_dashboard_edit .widget-manager-multi-dashboard-types-widgets').addClass("hidden");
				$('#widget_manager_multi_dashboard_edit .widget-manager-multi-dashboard-types-iframe').removeClass("hidden");

				break;
			case "widgets":
			default:
				$('#widget_manager_multi_dashboard_edit .widget-manager-multi-dashboard-types-iframe').addClass("hidden");
				$('#widget_manager_multi_dashboard_edit .widget-manager-multi-dashboard-types-widgets').removeClass("hidden");
			
				break;
		}
	}
</script>