<?php

    /*
     * Error logging
     * 
     * */
function gc_err_logging($errMess,$errStack,$applName,$errType)
{
    $DBprefix=elgg_get_config('dbprefix');
    $errDate=date("Y-m-d H:i:s");
    $servername=gethostname();
    $username=elgg_get_logged_in_user_entity()->username;
    $user_guid=elgg_get_logged_in_user_entity()->guid;
    $serverip=$_SERVER['REMOTE_ADDR'];

    $sql='INSERT INTO '.$DBprefix.'elmah_log (appl_name,error_type,server_name,server_ip,user_guid,time_created,username,error_messages,error_stacktrace) VALUES ("'.$applName.'","'.$errType.'","'.$servername.'","'.$serverip.'","'.$user_guid.'","'.$errDate.'","'.$username.'","'.$errMess.'","'.$errStack.'")';
    insert_data($sql);
}
