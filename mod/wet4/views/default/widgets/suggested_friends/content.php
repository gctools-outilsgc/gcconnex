<?php
    /***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * MBlondin 	2016-02-14 		Creation of widget
 * Nick P       2016-03-16      Changed connect to add colleage action. You can now click profile image to view profile

 ***********************************************************************/


try{
    $user_guid = elgg_get_logged_in_user_guid();
    $site_url = elgg_get_site_url();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        //connect to database  , "3306"
        $db_config = new \Elgg\Database\Config($CONFIG);
        if ($db_config->isDatabaseSplit()) {
            $read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ);
        } else {    
            $read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
        }
        $connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"]);
        $result = mysqli_query($connection, "call GET_suggestedFriends({$user_guid}, 4);");

        /*
         * echo '<div class="panel panel-custom elgg-module-aside"><div class="panel-heading"><h2 class="">'.elgg_echo('ps:profilestrength').'</h2></div><div class="panel-body clearfix">'.elgg_view('widgets/profile_completness/content').'</div></div>';
         * 
         * */
        
        if(intval($result->num_rows)>0){
            $count=0;
            $htmloutput='<div class="panel clearfix panel-custom elgg-module-aside">';
            
            $htmloutput=$htmloutput.'<div class="panel-heading">';
            $htmloutput=$htmloutput.'<h3 class="panel-title">'.elgg_echo('sf:suggcolleagues').'</h3>';
            $htmloutput=$htmloutput.'</div><div class="panel-body clearfix">';
            while ($row = $result->fetch_assoc()) {
                if($count==0 || $count==2)
                {
                    $htmloutput=$htmloutput.'<div class="row mrgn-tp-sm">';
                }
                $userGUID=$row['guid_two'];
		if (elgg_get_user_validation_status($userGUID)){
                	$job=get_user($userGUID)->job;
                	$htmloutput=$htmloutput.'<div class="col-xs-6 text-center">';
                	$htmloutput .= '<a href="'.  $site_url. 'profile/'. get_user($row['guid_two'])->username.'" class="">';
                	$htmloutput=$htmloutput.'<img src="'.get_user($row['guid_two'])->getIcon('small') . '" class="avatar-profile-page img-responsive center-block img-circle " alt="'.elgg_echo('sf:alttext').' '.get_user($row['guid_two'])->getDisplayName().'">';
                	$htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-0"><span class="text-primary">'.get_user($row['guid_two'])->getDisplayName().'</span></h4></a>';
                	$htmloutput=$htmloutput.'<p class="small mrgn-tp-0">'.$job.'</p>';
                	$htmloutput=$htmloutput.'<a href="'.elgg_add_action_tokens_to_url("action/friends/add?friend={$userGUID}"). '" class="btn btn-primary btn-sm mrgn-tp-sm">'.elgg_echo('friend:add').'</a>';
                	$htmloutput=$htmloutput.'</div>';
                	if($count==1 || $count==3)
                	{
                	    $htmloutput=$htmloutput.'</div>';
                	}
                	$count++;
               		// $htmloutput=$htmloutput. $row['guid_two'].'-';
            	}
	    }
            $htmloutput=$htmloutput.'</div></div>';
            $htmloutput=$htmloutput.'<div class="clearfix"></div>';
            //$htmloutput=$htmloutput.'</div>';
            echo $htmloutput;
        }
        $connection->close();
}
catch (Exception $e)
{
    $errMess=$e->getMessage();
    $errStack=$e->getTraceAsString();
    $errType=$e->getCode();
    gc_err_logging($errMess,$errStack,'Suggested Friends Widget',$errType);

    $connection->close();
    echo "<div class='alert alert-danger'><h3>Oops!</h3>".elgg_echo('ps:psErr')."</div>";
}
?>
