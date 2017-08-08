<?php
/**
 * The view for the user settings of this plugin.
 *
 */

// prevent crashes in the plugin is not yet configured
if (!is_callable('simplesaml_get_enabled_sources')) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('simplesaml:error:not_configured'),
	]);
	return true;
}

$plugin = elgg_extract('entity', $vars);
$page_owner = elgg_get_page_owner_entity();

$sources = simplesaml_get_enabled_sources();
if (empty($sources)) {
	// no enabled sources
	echo elgg_format_element('div', [], elgg_echo('simplesaml:usersettings:no_sources'));
	return;
}

foreach ($sources as $source) {
	$label = simplesaml_get_source_label($source);
	
	$icon = '';
	$icon_url = simplesaml_get_source_icon_url($source);
	if (!empty($icon_url)) {
		$icon = elgg_view('output/img', [
			'src' => $icon_url,
			'alt' => $label,
		]);
	}
	
	$body = elgg_format_element('label', [], $label);
	$body .= '<br />';
	
	if ($plugin->getUserSetting("{$source}_uid", $page_owner->getGUID())) {
		// user is connected, offer the option to disconnect
		$body .= elgg_format_element('div', [], elgg_echo('simplesaml:usersettings:connected', [$label]));
		
		$body .= elgg_format_element('div', [], elgg_view('output/url', [
			'text' => elgg_echo('simplesaml:usersettings:unlink_url'),
			'confirm' => elgg_echo('simplesaml:usersettings:unlink_confirm', [$label]),
			'href' => "action/simplesaml/unlink?user_guid={$page_owner->getGUID()}&source={$source}",
		]));
		
		// for an admin show saved attributes
		if (elgg_is_admin_logged_in()) {
			$attributes = simplesaml_get_authentication_user_attribute($source, false, $page_owner->getGUID());
			if (!empty($attributes)) {
				$body .= elgg_format_element('div', ['class' => 'mtm'], elgg_view('output/url', [
					'text' => elgg_echo('simplesaml:usersettings:toggle_attributes'),
					'href' => "#simplesaml-usersettings-{$source}-attibutes",
					'rel' => 'toggle',
				]));
				
				// build table with stored attributes
				$table = '<table class="elgg-table">';
				
				// header
				$table .= '<thead>';
				$table .= '<tr>';
				$table .= elgg_format_element('th', [], elgg_echo('simplesaml:usersettings:attributes:name'));
				$table .= elgg_format_element('th', [], elgg_echo('simplesaml:usersettings:attributes:value'));
				$table .= '</tr>';
				$table .= '</thead>';
				
				// saved fields
				$table .= '<tbody>';
				foreach ($attributes as $name => $value) {
					$table .= '<tr>';
					$table .= elgg_format_element('td', [], $name);
					if (count($value) > 1) {
						$table .= '<td><ul>';
						foreach ($value as $v) {
							$table .= elgg_format_element('li', [], $v);
						}
						$table .= '</ul></td>';
					} else {
						$table .= elgg_format_element('td', [], $value[0]);
					}
					$table .= '</tr>';
				}
				$table .= '</tbody>';
				
				$table .= '</table>';
				
				$body .= elgg_format_element('div', [
					'id' => "simplesaml-usersettings-{$source}-attibutes",
					'class' => 'hidden mts'
				], $table);
			}
		}
	} else {
		// user is not connected, offer the option to connect
		$body .= elgg_format_element('div', [], elgg_echo('simplesaml:usersettings:not_connected', [$label]));
		
		if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
			$body .= elgg_view('output/url', [
				'text' => elgg_echo('simplesaml:usersettings:link_url'),
				'href' => "saml/authorize/{$source}",
			]);
		}
	}
	
	echo elgg_view_image_block($icon, $body);
}
