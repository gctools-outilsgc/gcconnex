<?php
//elgg_log('cyu - ' . elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", 'NOTICE' );
$log = fopen(elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", 'w');
fwrite($log, ''. "\r\n" );
fclose($log);

forward(REFERER);