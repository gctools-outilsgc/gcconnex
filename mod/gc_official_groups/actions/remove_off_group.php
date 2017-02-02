<?php

/*
* This action removes the official group meta data to a group.
*
* @version 1.0
* @author Nick
*/


$guid = (int) get_input('guid');

$group = get_entity($guid);

if($group->official_group){
    $group->official_group = false;
   system_message('Official Status Removed');
}