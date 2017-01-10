<?php


$guid = (int) get_input('guid');
$post = get_entity($guid)->time_created;
echo json_encode([
    'sum' => $post,
]); 

