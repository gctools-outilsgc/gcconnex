<?php
/**
 * Elgg single tag output. Accepts all output/url options
 *
 * @uses $vars['value']    String
 * @uses $vars['type']     The entity type, optional
 * @uses $vars['subtype']  The entity subtype, optional
 * @uses $vars['base_url'] Base URL for tag link, optional, defaults to search URL
 *
 * GC MODIFICATION
 *	christine yu 	redirects core functionality to GSA search interface (views/default/output/tags.php)
 */

if (empty($vars['value']) && $vars['value'] !== 0 && $vars['value'] !== '0') {
	return;
}
 
$gsa_tags_key = elgg_get_plugin_setting('gsa_param_key','gc_fedsearch_gsa');
$gsa_tags_value = elgg_get_plugin_setting('gsa_param_value','gc_fedsearch_gsa');

$query_params = array();
$query_params["q"] = $vars['value'];
$query_params["search_type"] = "tags";
$query_params["a"] = "s";
$query_params["s"] = "3";

if ($gsa_tags_key && $gsa_tags_value)
	$query_params[$gsa_tags_key] = $gsa_tags_value;

$current_language = get_current_language();
$gsa_language = (strcmp($current_language,'en') == 0) ? 'eng' : 'fra';
$url = "http://intranet.canada.ca/search-recherche/query-recherche-{$gsa_language}.aspx?".http_build_query($query_params); 

$params = array(
	'href' => $url,
	'text' => $vars['value'],
	'encode_text' => true,
	'rel' => 'tag',
);

$params = $params + $vars;

echo elgg_view('output/url', $params);
