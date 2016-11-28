<?php
/**
 * Offer the ability to limit the logon widget to only show one SAML/CAS source
 */

// prevent crashes in the plugin is not yet configured
if (!is_callable("simplesaml_get_enabled_sources")) {
	return true;
}

$sources = simplesaml_get_enabled_sources();
if (!empty($source)) {
	$widget = elgg_extract("entity", $vars);
	
	$options_values = array(
		"all" => elgg_echo("all")
	);
	
	foreach ($sources as $source) {
		$options_values[$source] = simplesaml_get_source_label($source);
	}
	
	echo "<div>";
	echo elgg_echo("simplesaml:widget:select_source");
	echo elgg_view("input/dropdown", array("name" => "params[samlsource]", "value" => $widget->samlsource, "options_values" => $options_values, "class" => "mls"));
	echo "</div>";
} else {
	echo elgg_echo("simplesaml:settings:warning:configuration:sources");
}
