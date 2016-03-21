<?php
	
$widget_context = get_input("widget_context");

if (!empty($widget_context)) {
	$error_count = 0;
	
	if ($widgets = elgg_get_widget_types($widget_context)) {
		$toggle_settings = array("can_add", "hide");
		
		foreach ($widgets as $handler => $widget) {
			
			foreach ($toggle_settings as $setting) {
				$input_name = $widget_context . "_" . $handler . "_" . $setting;
				$value = get_input($input_name, "no");
				
				if (!widget_manager_set_widget_setting($handler, $setting, $widget_context, $value)) {
					$error_count++;
					register_error(elgg_echo("widget_manager:action:manage:error:save_setting", array($setting, $widget->name)));
				}
			}
		}
		
		elgg_get_system_cache()->delete("widget_manager_widget_settings");
	}
	
	if ($error_count == 0) {
		system_message(elgg_echo("widget_manager:action:manage:success"));
	}
} else {
	register_error(elgg_echo("widget_manager:action:manage:error:context"));
}

forward(REFERER);
