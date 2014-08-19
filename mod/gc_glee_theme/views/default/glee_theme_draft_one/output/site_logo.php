<?php
$site = elgg_get_site_entity();

/**
 * if the phloor_custom_logo plugin is active
 * show the content of the logo
 */
if (!elgg_is_active_plugin('phloor_custom_logo', $site->guid)) {
    echo elgg_view('glee_theme_draft_one/output/graphics_logo');
    return;
}

$params = phloor_custom_logo_prepare_vars($site);

$filename = elgg_extract('logo', $params, '');
$mime     = elgg_extract('mime', $params, '');

if (empty($filename) || empty($mime)) {
    return;
}

$logo_file = elgg_get_data_path() . "logo/$filename";

$alt = elgg_get_site_entity()->name . ' Logo';
$data_uri = phloor_get_data_uri($logo_file, $mime);

if ($data_uri === false || empty($data_uri)) {
    return;
}

$image = <<<HTML
    <img src="$data_uri" alt="$alt" />
HTML;

$url = elgg_view('output/url', array(
    'href' => elgg_get_site_url(),
    'text' => $image,
));

echo $url;


