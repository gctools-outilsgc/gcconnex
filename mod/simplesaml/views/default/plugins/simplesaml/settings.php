<?php

$plugin = elgg_extract("entity", $vars);

echo "<div>";
echo elgg_echo("simplesaml:settings:simplesamlphp_path");
echo elgg_view("input/text", array("name" => "params[simplesamlphp_path]", "value" => $plugin->simplesamlphp_path));
echo "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:simplesamlphp_path:description") . "</div>";
echo "</div>";

echo "<div>";
echo elgg_echo("simplesaml:settings:simplesamlphp_directory");
echo elgg_view("input/text", array("name" => "params[simplesamlphp_directory]", "value" => $plugin->simplesamlphp_directory));
echo "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:simplesamlphp_directory:description", array(elgg_get_site_entity()->url)) . "</div>";
echo "</div>";

if (is_callable("simplesaml_get_configured_sources")) {
	
	// list all the configured service provider configs
	$sources = simplesaml_get_configured_sources();
	$souces_title = elgg_echo("simplesaml:settings:sources");
	
	if (!empty($sources)) {
		$enabled_sources = array();
		$first_source = true;
		
		$content = "<table class='elgg-table mbm' id='simplesaml-settings-sources'>";
		
		$content .= "<tr>";
		$content .= "<th class='center'>" . elgg_echo("enable") . "</th>";
		$content .= "<th>" . elgg_echo("simplesaml:settings:sources:name") . "</th>";
		$content .= "<th>" . elgg_echo("simplesaml:settings:sources:type") . "</th>";
		$content .= "<th class='center'>" . elgg_echo("simplesaml:settings:sources:allow_registration") . "</th>";
		$content .= "<th class='center'>" . elgg_echo("simplesaml:settings:sources:auto_create_accounts") . "</th>";
		$content .= "<th class='center'>" . elgg_echo("simplesaml:settings:sources:save_attributes") . "</th>";
		$content .= "<th class='center'>" . elgg_echo("simplesaml:settings:sources:force_authentication") . "</th>";
		$content .= "</tr>";
		
		foreach ($sources as $source) {
			$source_auth_id = $source->getAuthId();
			$enabled = array();
			$registration = array();
			$auto_create_accounts = array();
			$save_attributes = array();
			$force_authentication = array();
			
			if (!$first_source) {
				// no default value after the first force checkbox
				$force_authentication["default"] = false;
			}
			
			switch (get_class($source)) {
				case "sspmod_saml_Auth_Source_SP":
					$source_type = "saml";
					$source_type_label = elgg_echo("simplesaml:source:type:saml");
					break;
				case "sspmod_cas_Auth_Source_CAS":
					$source_type = "cas";
					$source_type_label = elgg_echo("simplesaml:source:type:cas");
					break;
				default:
					$source_type = false;
					$source_type_label = elgg_echo("simplesaml:source:type:unknown");
					break;
			}
			
			if ($plugin->getSetting($source_auth_id . "_enabled")) {
				$enabled = array("checked" => "checked");
				
				if ($source_type) {
					if (!isset($enabled_sources[$source_type])) {
						$enabled_sources[$source_type] = array();
					}
					
					$enabled_sources[$source_type][] = $source_auth_id;
				}
			}
			
			if ($plugin->getSetting($source_auth_id . "_allow_registration")) {
				$registration = array("checked" => "checked");
			}
			
			if ($plugin->getSetting($source_auth_id . "_auto_create_accounts")) {
				$auto_create_accounts = array("checked" => "checked");
			}
			
			if ($plugin->getSetting($source_auth_id . "_save_attributes")) {
				$save_attributes = array("checked" => "checked");
			}
			
			if ($plugin->getSetting("force_authentication") == $source_auth_id) {
				$force_authentication["checked"] = "checked";
			}
			
			$content .= "<tr>";
			$content .= "<td class='center'>" . elgg_view("input/checkbox", array("name" => "params[" . $source_auth_id . "_enabled]", "value" => "1") + $enabled) . "</td>";
			$content .= "<td>" . $source_auth_id . "</td>";
			$content .= "<td>" . $source_type_label . "</td>";
			$content .= "<td class='center'>" . elgg_view("input/checkbox", array("name" => "params[" . $source_auth_id . "_allow_registration]", "value" => "1") + $registration) . "</td>";
			$content .= "<td class='center'>" . elgg_view("input/checkbox", array("name" => "params[" . $source_auth_id . "_auto_create_accounts]", "value" => "1") + $auto_create_accounts) . "</td>";
			$content .= "<td class='center'>" . elgg_view("input/checkbox", array("name" => "params[" . $source_auth_id . "_save_attributes]", "value" => "1") + $save_attributes) . "</td>";
			$content .= "<td class='center'>" . elgg_view("input/checkbox", array("name" => "params[force_authentication]", "value" => $source_auth_id) + $force_authentication) . "</td>";
			$content .= "</tr>";
			
			// set a flag so we know we had at least 1 source
			$first_source = false;
		}
		
		$content .= "</table>";
		
		echo elgg_view_module("inline", $souces_title, $content);
		
		// settings for enabled sources
		if (!empty($enabled_sources)) {
			// build options to automaticly link accounts based on profile information
			$auto_link_options = array(
				"0" => elgg_echo("simplesaml:settings:sources:configuration:auto_link:none"),
				"username" => elgg_echo("username"),
				"email" => elgg_echo("email")
			);
			// add profile fields
			$profile_fields = elgg_get_config("profile_fields");
			if (!empty($profile_fields) && is_array($profile_fields)) {
				foreach ($profile_fields as $name => $type) {
					$profile_label = $name;
					$profile_translation = elgg_echo("profile:" . $name);
					
					if ($profile_translation != $profile_label) {
						$profile_label = $profile_translation;
					}
					
					$auto_link_options[$name] = $profile_label;
				}
			}
			
			// enabled sources are grouped by type
			foreach ($enabled_sources as $source_type => $sources) {
				// make sure we have sources of this type
				if (!empty($sources) && is_array($sources)) {
					// go through all sources of this type
					foreach ($sources as $source) {
						$label = simplesaml_get_source_label($source);
						$title = elgg_echo("simplesaml:settings:sources:configuration:title", array($label));
						
						$body = "<div>";
						$body .= elgg_echo("simplesaml:settings:sources:configuration:icon");
						$body .= elgg_view("input/url", array("name" => "params[" . $source . "_icon_url]", "value" => $plugin->getSetting($source . "_icon_url")));
						$body .= "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:sources:configuration:icon:description") . "</div>";
						$body .= "</div>";
						
						$body .= "<div>";
						$body .= elgg_echo("simplesaml:settings:sources:configuration:auto_link") . "<br />";
						$body .= elgg_view("input/dropdown", array("name" => "params[" . $source . "_auto_link]", "value" => $plugin->getSetting($source . "_auto_link"), "options_values" => $auto_link_options));
						$body .= "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:sources:configuration:auto_link:description") . "</div>";
						$body .= "</div>";
						
						if ($source_type == "saml") {
							// only SAML sources have this information
							$body .= "<div>";
							$body .= elgg_echo("simplesaml:settings:sources:configuration:external_id");
							$body .= elgg_view("input/text", array("name" => "params[" . $source . "_external_id]", "value" => $plugin->getSetting($source . "_external_id")));
							$body .= "<div class='elgg-subtext'>" . elgg_echo("simplesaml:settings:sources:configuration:external_id:description") . "</div>";
							$body .= "</div>";
						}
						
						echo elgg_view_module("inline", $title, $body);
					}
				}
			}
		}
	} else {
		// SimpleSAMLPHP is not yet configured for service providers
		$content = elgg_view("output/longtext", array("value" => elgg_echo("simplesaml:settings:warning:configuration:sources")));
		
		echo elgg_view_module("inline", $souces_title, $content);
	}
	
	// list all the IDP configurations
	$idp_configurations = simplesaml_get_configured_idp_sources();
	
	if (!empty($idp_configurations)) {
		$profile_fields = elgg_get_config("profile_fields");
		
		foreach ($idp_configurations as $idp) {
			$idp_auth_id = $idp->getAuthId();
			$label = simplesaml_get_idp_label($idp_auth_id);
			
			$field_config = $plugin->getSetting("idp_" . $idp_auth_id . "_attributes");
			if (!empty($field_config)) {
				$field_config = json_decode($field_config, true);
			} else {
				$field_config = array();
			}
			
			$title = elgg_echo("simplesaml:settings:idp", array($label));
			
			$content = elgg_view("output/longtext", array("value" => elgg_echo("simplesaml:settings:idp:description")));
			
			$content .= elgg_view("output/url", array("text" => elgg_echo("simplesaml:settings:idp:show_attributes"), "href" => "#simplesaml-settings-idp-" . $idp_auth_id . "-attributes", "rel" => "toggle"));
			
			$content .= "<div id='simplesaml-settings-idp-" . $idp_auth_id . "-attributes' class='hidden mtm'>";
			$content .= "<table class='elgg-table'>";
			$content .= "<tr>";
			$content .= "<th>" . elgg_echo("simplesaml:settings:idp:profile_field") . "</th>";
			$content .= "<th>" . elgg_echo("simplesaml:settings:idp:attribute") . "*</th>";
			$content .= "</tr>";
			
			$content .= "<tr>";
			$content .= "<td>" . elgg_echo("guid") . " (guid)</td>";
			$content .= "<td>" . elgg_view("input/text", array("name" => "params[idp_" . $idp_auth_id . "_attributes][guid]", "value" => elgg_extract("guid", $field_config))) . "</td>";
			$content .= "</tr>";
			
			$content .= "<tr>";
			$content .= "<td>" . elgg_echo("name") . " (name)</td>";
			$content .= "<td>" . elgg_view("input/text", array("name" => "params[idp_" . $idp_auth_id . "_attributes][name]", "value" => elgg_extract("name", $field_config))) . "</td>";
			$content .= "</tr>";
			
			$content .= "<tr>";
			$content .= "<td>" . elgg_echo("username") . " (username)</td>";
			$content .= "<td>" . elgg_view("input/text", array("name" => "params[idp_" . $idp_auth_id . "_attributes][username]", "value" => elgg_extract("username", $field_config))) . "</td>";
			$content .= "</tr>";
			
			$content .= "<tr>";
			$content .= "<td>" . elgg_echo("email") . " (email)</td>";
			$content .= "<td>" . elgg_view("input/text", array("name" => "params[idp_" . $idp_auth_id . "_attributes][email]", "value" => elgg_extract("email", $field_config))) . "</td>";
			$content .= "</tr>";
			
			
			if (!empty($profile_fields)) {
				foreach ($profile_fields as $metadata_name => $type) {
					$profile_label = $metadata_name;
					$lan_key = "profile:" . $metadata_name;
					if (elgg_echo($lan_key) != $lan_key) {
						$profile_label = elgg_echo($lan_key);
					}
					
					$content .= "<tr>";
					$content .= "<td>" . $profile_label . " (" . $metadata_name . ")</td>";
					$content .= "<td>" . elgg_view("input/text", array("name" => "params[idp_" . $idp_auth_id . "_attributes][" . $metadata_name . "]", "value" => elgg_extract($metadata_name, $field_config))) . "</td>";
					$content .= "</tr>";
				}
			}
			
			$content .= "</table>";
			
			$content .= "<div class='elgg-subtext'>" . elgg_view("output/longtext", array("value" => "*: " . elgg_echo("simplesaml:settings:idp:attribute:description"))) . "</div>";
			$content .= "</div>";
			
			echo elgg_view_module("inline", $title, $content);
		}
	}
} else {
	// SimpleSAMLPHP is not yet loaded
	echo "<div>";
	echo elgg_echo("simplesaml:settings:warning:configuration:simplesamlphp");
	echo "</div>";
}
