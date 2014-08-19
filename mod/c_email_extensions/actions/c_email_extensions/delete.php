<?php
elgg_load_library('c_ext_lib');

//elgg_log('cyu - id:'.$_GET['id'], 'NOTICE');
deleteExtension($_GET['id']);

