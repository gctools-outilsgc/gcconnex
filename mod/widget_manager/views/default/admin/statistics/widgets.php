<?php
	
	global $CONFIG;
	
	$stats_context = array("profile", "dashboard", "groups", "index", "admin");
	$context_totals = array("profile" => 0, "dashboard" => 0, "groups" => 0, "index" => 0, "admin" => 0);
	
	$list = "<table class='elgg-table'>";
		
	$list .= "<tr>";
	$list .= "<th>" . elgg_echo("widget") . "</th>";
	foreach($stats_context as $context){
		$list .= "<th class='center'>" . elgg_echo($context) . "</th>";
	}
	$list .= "<th class='center'>" . elgg_echo("total") . "</th>";
	$list .= "</tr>";
	
	$widgets = $CONFIG->widgets->handlers;
	widget_manager_sort_widgets($widgets);
	
	foreach($widgets as $handler => $widget){
		$widget_counts = array();
		
		$widget_options = array(
				"type" => "object",
				"subtype" => "widget",
				"count" => true,
				"private_setting_name_value_pairs" => array(
					"handler" => $handler,
					)
			);
		
		foreach($stats_context as $context){
			$widget_options["private_setting_name_value_pairs"]["context"] = $context;
			$widget_total = elgg_get_entities_from_private_settings($widget_options);
			$widget_counts[$context] = $widget_total;
			
			// keep track of context totals
			$context_totals[$context] += $widget_total;
		}
		
		$widget_counts["total"] = array_sum($widget_counts);
				
		$list .= "<tr>";
		$list .= "<td><span title='[" . $handler . "] " . $widget->description . "'>" . $widget->name . "</span></td>";
		foreach($stats_context as $context){
			$list .= "<td class='center'>";
			if($widget_counts[$context] === 0){
				$list .= "&nbsp;";
			} else {
				$list .= $widget_counts["total"];
			}
			$list .= "</td>";
		}
		
		$list .= "<td class='center'>";
		if($widget_counts["total"] === 0){
			$list .= "&nbsp;";
		} else {
			$list .= $widget_counts["total"];
		}
		
		$list .= "</td>";
		$list .= "</tr>";
	}
	
	// totals
	$list .= "<tr>";
	$list .= "<th><i>" . elgg_echo("total") . "</i></th>";
	foreach($stats_context as $context){
		$list .= "<th class='center'>" .  $context_totals[$context] . "</th>";
	}
	$list .= "<th class='center'>" . array_sum($context_totals) . "</th>";
	$list .= "</tr>";
	
	$list .= "</table>";
	
	echo $list;