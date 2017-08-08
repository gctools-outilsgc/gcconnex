<?php
/**
 * The settings for an identity provider
 */

$plugin = elgg_extract('plugin', $vars);
$idp = elgg_extract('idp', $vars);

if (!($plugin instanceof ElggPlugin) || !($idp instanceof SimpleSAML_Auth_Source)) {
	return;
}

$idp_auth_id = $idp->getAuthId();
$label = simplesaml_get_idp_label($idp_auth_id);

$field_config = $plugin->getSetting("idp_{$idp_auth_id}_attributes");
if (!empty($field_config)) {
	$field_config = json_decode($field_config, true);
} else {
	$field_config = [];
}

$title = elgg_echo('simplesaml:settings:idp', [$label]);

$content = elgg_view('output/longtext', [
	'value' => elgg_echo('simplesaml:settings:idp:description'),
]);

$content .= elgg_view('output/url', [
	'text' => elgg_echo('simplesaml:settings:idp:show_attributes'),
	'href' => "#simplesaml-settings-idp-{$idp_auth_id}-attributes",
	'rel' => 'toggle',
]);

$content .= "<div id='simplesaml-settings-idp-{$idp_auth_id}-attributes' class='hidden mtm'>";
$content .= '<table class="elgg-table">';
$content .= '<tr>';
$content .= '<th>' . elgg_echo('simplesaml:settings:idp:profile_field') . '</th>';
$content .= '<th>' . elgg_echo('simplesaml:settings:idp:attribute') . '*</th>';
$content .= '</tr>';

// guid
$content .= '<tr>';
$content .= '<td>' . elgg_echo('guid') . ' (guid)</td>';
$content .= '<td>' . elgg_view('input/text', [
	'name' => "params[idp_{$idp_auth_id}_attributes][guid]",
	'value' => elgg_extract('guid', $field_config),
]) . '</td>';
$content .= '</tr>';

// (display)name
$content .= '<tr>';
$content .= '<td>' . elgg_echo('name') . ' (name)</td>';
$content .= '<td>' . elgg_view('input/text', [
	'name' => "params[idp_{$idp_auth_id}_attributes][name]",
	'value' => elgg_extract('name', $field_config),
]) . '</td>';
$content .= '</tr>';

// username
$content .= '<tr>';
$content .= '<td>' . elgg_echo('username') . ' (username)</td>';
$content .= '<td>' . elgg_view('input/text', [
	'name' => "params[idp_{$idp_auth_id}_attributes][username]",
	'value' => elgg_extract('username', $field_config),
]) . '</td>';
$content .= '</tr>';

// email
$content .= '<tr>';
$content .= '<td>' . elgg_echo('email') . ' (email)</td>';
$content .= '<td>' . elgg_view('input/text', [
	'name' => "params[idp_{$idp_auth_id}_attributes][email]",
	'value' => elgg_extract('email', $field_config),
]) . '</td>';
$content .= '</tr>';

// profile field config
$profile_fields = elgg_get_config('profile_fields');
if (!empty($profile_fields)) {
	
	foreach ($profile_fields as $metadata_name => $type) {
		$profile_label = $metadata_name;
		
		if (elgg_language_key_exists("profile:{$metadata_name}")) {
			$profile_label = elgg_echo("profile:{$metadata_name}");
		}

		$content .= '<tr>';
		$content .= '<td>' . $profile_label . ' (' . $metadata_name . ')</td>';
		$content .= '<td>' . elgg_view('input/text', [
			'name' => "params[idp_{$idp_auth_id}_attributes][{$metadata_name}]",
			'value' => elgg_extract($metadata_name, $field_config),
		]) . '</td>';
		$content .= '</tr>';
	}
}

$content .= '</table>';

$content .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_view('output/longtext', [
	'value' => '*: ' . elgg_echo('simplesaml:settings:idp:attribute:description'),
]));

$content .= '</div>';

echo elgg_view_module('inline', $title, $content);
