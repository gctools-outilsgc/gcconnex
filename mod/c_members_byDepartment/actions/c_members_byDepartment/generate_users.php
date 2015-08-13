<?php

global $CONFIG;
$data_directory = $CONFIG->dataroot.'gc_dept'.DIRECTORY_SEPARATOR;
$dbprefix = elgg_get_config("dbprefix");


create_user_list_from_database();

forward(REFERER);