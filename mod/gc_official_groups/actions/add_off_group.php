<?php

/*
* This action adds the official group meta data to a group.
*
* @version 1.0
* @author Nick
*/

$guid = (int) get_input('guid');

$group = get_entity($guid);

if($group->official_group){
    if($group->official_group == true){
       echo json_encode([
        'confirm' =>'I am already official',
           'color'=>'red',
       ]); 
    }else if($group->official_group == false){
        echo json_encode([
        'confirm' =>'At one point I was official and then my status was removed but now i am official again',
            'color'=>'green',
       ]); 
    }
}else{
    $group->official_group = true;
    echo json_encode([
        'confirm' =>'This group is now official',
        'color'=>'green',
    ]);
}
/*
echo json_encode([
    'confirm' =>$guid,
]);*/