<?php
/*
* community_feed.php
*
* Returns updated community feed for streaming content
*/

$newsfeed_limit = elgg_get_plugin_setting('newsfeed_limit', 'gc_communities', 10);
$communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);
$subtypes = json_decode(elgg_get_plugin_setting('subtypes', 'gc_communities'));

$limit = get_input('limit');
$latest = get_input('latest');

$url = get_input('url');
foreach( $communities as $community ){
    if( $community['community_url'] == $url ){
        $community_en = $community['community_en'];
        $community_fr = $community['community_fr'];
        $community_tags = $community['community_tags'];
        $community_audience = $community['community_audience'];
        $community_animator = $community['community_animator'];
        break;
    }
}

if( $limit ){
	$newsfeed_limit = $limit;
}

$options = array(
    'type' => 'object',
    'subtypes' => $subtypes,
    'limit' => $newsfeed_limit,
    'full_view' => false,
    'list_type_toggle' => false,
    'pagination' => true
);

$tags_values = '';
if( strpos($community_tags, ',') !== false ){ // if multiple tags
    $community_tags_array = array_map('trim', explode(',', $community_tags));
    foreach($community_tags_array as $tag_val){
        $tags_values .= ' OR md.value_id = ' . elgg_get_metastring_id($tag_val);
    }
} else {
   $tags_values = ' OR md.value_id = ' .elgg_get_metastring_id($community_tags);
}

//get the metastring id
$audience_name = elgg_get_metastring_id('audience');
$audience_value = elgg_get_metastring_id($community_audience);
$tags_name = elgg_get_metastring_id('tags');

//Query grabs content with audience or tags
$dbprefix = elgg_get_config('dbprefix');
$options['joins'][] = "JOIN {$dbprefix}metadata md ON (e.guid = md.entity_guid)";
$options['wheres'][] = "(md.name_id = {$audience_name} OR md.name_id = {$tags_name}) AND (md.value_id = {$audience_value}{$tags_values})";

if( $latest ){
	$options['wheres'][] = "e.guid > {$latest}";
}

if( $limit ){
	echo json_encode(elgg_get_entities_from_metadata($options)[0]->guid);
} else {
	echo elgg_list_entities_from_metadata($options);
}

?>