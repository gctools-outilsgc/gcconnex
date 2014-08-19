<?php
/**
 * Alternativly show a logo if its in the graphics folder
 * 
 * @var unknown_type
 */
$logo_filename = 'logo.png';

$filename = elgg_get_plugins_path() . "glee_theme_draft_one/graphics/$logo_filename";

if (!file_exists($filename) || !is_file($filename)) {
    return true;
}

$alt = elgg_get_site_entity()->name . ' Logo';
$data_uri = phloor_get_data_uri($filename, 'image/png');

$image = <<<HTML
<img src="$data_uri" alt="$alt" />
HTML;

$url = elgg_view('output/url', array(
    'href' => elgg_get_site_url(),
    'text' => $image,
));

echo $url;

