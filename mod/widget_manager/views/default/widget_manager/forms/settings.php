<?php 

	$widget_context = $vars["widget_context"];
	
	// get widgets
	$exact = false;
	if($widget_context == "groups"){
		$exact = true;
	}
	
	$widgets = elgg_get_widget_types($widget_context, $exact);
	widget_manager_sort_widgets($widgets); // sort alphabetically
	
	if(!empty($widgets)){
		
		$list = "<table class='elgg-table'>";
		
		$list .= "<tr>";
		$list .= "<th>" . elgg_echo("widget") . "</th>";
		$list .= "<th class='center'>" . elgg_echo("widget_manager:forms:settings:can_add") . "</th>";
		$list .= "<th class='center'>" . elgg_echo("widget_manager:forms:settings:hide") . "</th>";
		$list .= "</tr>";
		
		foreach($widgets as $handler => $widget){			
			$check_add = "";
			$check_hide = "";
			
			if(widget_manager_get_widget_setting($handler, "can_add", $widget_context)){
				$check_add = "checked='checked'";
			}
			
			if(widget_manager_get_widget_setting($handler, "hide", $widget_context)){
				$check_hide = "checked='checked'";
			}
			
			$list .= "<tr>";
			$list .= "<td><span title='[" . $handler . "] " . $widget->description . "'>" . $widget->name . "</span></td>";
			$list .= "<td class='center'><input type='checkbox' name='" . $widget_context . "_" . $handler . "_can_add' value='yes' " . $check_add . " /></td>";
			$list .= "<td class='center'><input type='checkbox' name='" . $widget_context . "_" . $handler . "_hide' value='yes' " . $check_hide . "/></td>";
			$list .= "</tr>";
		}
		
		$list .= "</table>";
		
		$form_body = $list;
		$form_body .= "<br />";
		$form_body .= elgg_view("input/hidden", array("value" => $widget_context, "name" => "widget_context"));
		$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		
		$body = elgg_view("input/form", array("body" => $form_body,
														"action" => $vars["url"] . "action/widget_manager/manage",
														"id" => "widget_manager_manage_form"
											));
		
	} else {
		$body = elgg_echo("widget_manager:forms:settings:no_widgets");
	}

	echo $body;