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

    $maxid = get_data("select max(guid)+1 as start from {$dbprefix}entities")[0]->start;  // get the max id to start from
    for ($i=$maxid; $i < $maxid + $N; $i++) {
        $vals[] = "('{$i}','object',$subtype,$ownerid,1,$ownerid,2,1506567954,1506567954,1506567954,'yes',NULL)";
    }
    $entityvals = implode(',', $vals);
    $entities = "INSERT INTO {$dbprefix}entities values {$entityvals}";
    //echo $entities . "<br />\n<hr />";
    echo insert_data($entities);

    // objects
    $vals = array();
    for ($i=$maxid; $i < $maxid + $N; $i++) {
        $vals[] = "('{$i}','Super Blog ($i)','HI! TEST BLOG {$i} HERE! There are Literally {$N} of us!!!1!')";
    }
    $objectvals = implode(',', $vals);
    $objects = "INSERT INTO {$dbprefix}objects_entity values {$objectvals}";
    //echo $objects . "<br />\n<hr />";
    echo insert_data($objects);

    // metadata, if needed
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

    $maxid = get_data("select max(guid)+1 as start from {$dbprefix}entities")[0]->start;  // get the max id to start from
    for ($i=$maxid; $i < $maxid + $N; $i++) {
        $vals[] = "('{$i}','object',$subtype,$ownerid,1,$ownerid,2,1506567954,1506567954,1506567954,'yes',NULL)";
    }
    $entityvals = implode(',', $vals);
    $entities = "INSERT INTO {$dbprefix}entities values {$entityvals}";
    //echo $entities . "<br />\n<hr />";
    echo insert_data($entities);

    // objects
    $vals = array();
    for ($i=$maxid; $i < $maxid + $N; $i++) {
        $vals[] = "('{$i}','Super Wire post ($i)','HI! TEST WIRE POST {$i} HERE! There are Literally {$N} of us!!!1!')";
    }
    $objectvals = implode(',', $vals);
    $objects = "INSERT INTO {$dbprefix}objects_entity values {$objectvals}";
    //echo $objects . "<br />\n<hr />";
    echo insert_data($objects);

    // metadata, if needed
}