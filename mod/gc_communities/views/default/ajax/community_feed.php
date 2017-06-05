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
    'metadata_name' => 'tags',
    'metadata_values' => explode(',', $community_tags),
    'full_view' => false,
    'list_type_toggle' => false,
    'pagination' => true
);

if( $latest ){
	$options['wheres'] = array("e.guid > {$latest}");
}

if( $limit ){
	echo json_encode(elgg_get_entities_from_metadata($options)[0]->guid);
} else {
	echo elgg_list_entities_from_metadata($options);
}

?>