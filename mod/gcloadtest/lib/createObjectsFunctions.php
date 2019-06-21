<?php



function createBlogs($N) {
    if ($N < 1){
        echo "usage: .../gen-content/blogs/N  where N > 0  ... your N wasn't > 0 was it";
        return 1;
    }
    $dbprefix = elgg_get_config('dbprefix');
    // create N filler blogs quickly

    // entities
    $vals = array();
    $subtype = get_subtype_id('object', 'blog');
    $owner = get_data("select guid from {$dbprefix}users_entity limit 1");      // these will all belong to the first user we see
    $ownerid = $owner[0]->guid;
    $t_base = 150000000;

    $start_guid = get_data("select max(guid)+1 as start from {$dbprefix}entities")[0]->start;  // get the max id to start from
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $timestamp = $t_base + $i;
        $vals[] = "('{$i}','object',$subtype,$ownerid,1,$ownerid,2,$timestamp,$timestamp,$timestamp,'yes',NULL)";
    }
    $entityvals = implode(',', $vals);
    $entities = "INSERT INTO {$dbprefix}entities values {$entityvals}";
    //echo $entities . "<br />\n<hr />";
    echo insert_data($entities). "<br />\n<hr />";

    // objects
    $vals = array();
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $vals[] = "('{$i}','Super Blog ($i)','HI! TEST BLOG {$i} HERE! There are Literally {$N} of us!!!1!')";
    }
    $objectvals = implode(',', $vals);
    $objects = "INSERT INTO {$dbprefix}objects_entity values {$objectvals}";
    //echo $objects . "<br />\n<hr />";
    echo insert_data($objects). "<br />\n<hr />";

    // river
    $vals = array();
    $start_id = get_data("select max(id) as start from {$dbprefix}river")[0]->start + 1;  // get the max id to start from
    for ($i=$start_id; $i < $start_id + $N; $i++) {
        $guid = $i - $start_id + $start_guid;
        $timestamp = $t_base + $guid;  // try to keep it the same as the timestamps in the entities table
        $vals[] = "('{$i}','object','blog','create',2,'river/object/blog/create','{$ownerid}','{$guid}',0,0,{$timestamp},'yes')";
    }
    $rivervals = implode(',', $vals);
    $river = "INSERT INTO {$dbprefix}river values {$rivervals}";
    //echo $river . "<br />\n<hr />";
    echo insert_data($river). "<br />\n<hr />";
}

function createWire($N) {
    if ($N < 1){
        echo "usage: .../gen-content/wire/N  where N > 0  ... your N wasn't > 0 was it";
        return 1;
    }
    $dbprefix = elgg_get_config('dbprefix');
    // create N filler wire quickly

    // entities
    $vals = array();
    $subtype = get_subtype_id('object', 'thewire');
    $owner = get_data("select guid from {$dbprefix}users_entity limit 1");      // these will all belong to the first user we see
    $ownerid = $owner[0]->guid;
    $t_base = 150000000;

    $start_guid = get_data("select max(guid)+1 as start from {$dbprefix}entities")[0]->start;  // get the max id to start from
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $timestamp = $t_base + $i;
        $vals[] = "('{$i}','object',$subtype,$ownerid,1,$ownerid,2,$timestamp,$timestamp,$timestamp,'yes',NULL)";
    }
    $entityvals = implode(',', $vals);
    $entities = "INSERT INTO {$dbprefix}entities values {$entityvals}";
    //echo $entities . "<br />\n<hr />";
    echo insert_data($entities). "<br />\n<hr />";

    // objects
    $vals = array();
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $vals[] = "('{$i}','Super Wire post ($i)','HI! TEST WIRE POST {$i} HERE! There are Literally {$N} of us!!!1!')";
    }
    $objectvals = implode(',', $vals);
    $objects = "INSERT INTO {$dbprefix}objects_entity values {$objectvals}";
    //echo $objects . "<br />\n<hr />";
    echo insert_data($objects). "<br />\n<hr />";

    // river
    $vals = array();
    $start_id = get_data("select max(id) as start from {$dbprefix}river")[0]->start + 1;  // get the max id to start from
    for ($i=$start_id; $i < $start_id + $N; $i++) {
        $guid = $i - $start_id + $start_guid;
        $timestamp = $t_base + $guid;  // try to keep it the same as the timestamps in the entities table
        $vals[] = "('{$i}','object','thewire','create',2,'river/object/thewire/create','{$ownerid}','{$guid}',0,0,{$timestamp},'yes')";
    }
    $rivervals = implode(',', $vals);
    $river = "INSERT INTO {$dbprefix}river values {$rivervals}";
    //echo $river . "<br />\n<hr />";
    echo insert_data($river). "<br />\n<hr />";
}


function createGroups($N) {
    if ($N < 1){
        echo "usage: .../gen-content/groups/N  where N > 0  ... your N wasn't > 0 was it";
        return 1;
    }
    $dbprefix = elgg_get_config('dbprefix');
    // create N filler groups quickly

    // entities
    $vals = array();
    $owner = get_data("select guid from {$dbprefix}users_entity limit 1");      // these will all belong to the first user we see
    $ownerid = $owner[0]->guid;
    $t_base = 150000000;

    $start_guid = get_data("select max(guid)+1 as start from {$dbprefix}entities")[0]->start;  // get the max id to start from
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $timestamp = $t_base + $i;
        $vals[] = "('{$i}','group',0,$ownerid,1,$ownerid,2,$timestamp,$timestamp,$timestamp,'yes',NULL)";
    }
    $entityvals = implode(',', $vals);
    $entities = "INSERT INTO {$dbprefix}entities values {$entityvals}";
    //echo $entities . "<br />\n<hr />";
    echo insert_data($entities). "<br />\n<hr />";

    // group
    $vals = array();
    for ($i=$start_guid; $i < $start_guid + $N; $i++) {
        $vals[] = "('{$i}','Super group ($i)','HI! TEST group {$i} HERE! There are Literally {$N} of us!!!1!')";
    }
    $objectvals = implode(',', $vals);
    $objects = "INSERT INTO {$dbprefix}groups_entity values {$objectvals}";
    //echo $objects . "<br />\n<hr />";
    echo insert_data($objects). "<br />\n<hr />";

    // river
    $vals = array();
    $start_id = get_data("select max(id) as start from {$dbprefix}river")[0]->start + 1;  // get the max id to start from
    for ($i=$start_id; $i < $start_id + $N; $i++) {
        $guid = $i - $start_id + $start_guid;
        $timestamp = $t_base + $guid;  // try to keep it the same as the timestamps in the entities table
        $vals[] = "('{$i}','group','','create',2,'river/group/create','{$ownerid}','{$guid}',0,0,{$timestamp},'yes')";
    }
    $rivervals = implode(',', $vals);
    $river = "INSERT INTO {$dbprefix}river values {$rivervals}";
    //echo $river . "<br />\n<hr />";
    echo insert_data($river). "<br />\n<hr />";
}