<?php
/*
* community_wire.php
*
* Returns updated community wire for streaming content
*/

$wire_limit = elgg_get_plugin_setting('wire_limit', 'gc_communities', 10);
$communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);

$limit = get_input('limit');
$latest = get_input('latest');

$url = get_input('url');
foreach( $communities as $community ){
    if( $community['community_url'] == $url ){
        $community_en = $community['community_en'];
        $community_fr = $community['community_fr'];
        $community_tags = $community['community_tags'];
        $community_animator = $community['community_animator'];
    }
}

if( $limit ){
	$wire_limit = $limit;
}

if( strpos($community_tags, ',') !== false ){
    $community_tags = explode(',', $community_tags);
}

elgg_set_context('search');
            
$dbprefix = elgg_get_config('dbprefix');
$typeid = get_subtype_id('object', 'thewire');
$query = "SELECT wi.guid FROM {$dbprefix}objects_entity wi LEFT JOIN {$dbprefix}entities en ON en.guid = wi.guid WHERE en.type = 'object' AND en.subtype = {$typeid} ";

if( is_array($community_tags) ){
    $all_tags = implode("|", $community_tags);
    $query .= " AND wi.description REGEXP '{$all_tags}'";
} else {
    $query .= " AND wi.description LIKE '%{$community_tags}%'";
}
            
$wire_ids = array();
$wires = get_data($query);
foreach($wires as $wire){
    $wire_ids[] = $wire->guid;
}

$options = array(
    'type' => 'object',
    'subtype' => 'thewire',
    'limit' => $wire_limit,
    'full_view' => false,
    'list_type_toggle' => false,
    'pagination' => true,
    'guids' => $wire_ids
);

if( $latest ){
	$options['wheres'] = array("e.guid > {$latest}");
}

if( $limit ){
	echo json_encode(elgg_get_entities($options)[0]->guid);
} else {
	echo elgg_list_entities($options);
}

?>