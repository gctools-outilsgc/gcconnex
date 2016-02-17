<?php
/**
 * Layout of a river item
 *
 * @uses $vars['item'] ElggRiverItem
 */

$item = $vars['item'];

/*If this is the 3rd item in the River, lets call for suggestions*/

$_SESSION['Suggested_friends']=intval($_SESSION['Suggested_friends'])+1;

if(intval($_SESSION['Suggested_friends'])==5 && elgg_is_logged_in())
{
    try{
        $user_guid = elgg_get_logged_in_user_guid();
        $site_url = elgg_get_site_url();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        //connect to database  , "3306"
        $connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
        $result = mysqli_query($connection, "call GET_suggestedFriends({$user_guid}, 3);");

        if(intval($result->num_rows)>0){
            $htmloutput='<div class="col-xs-12 mrgn-tp-sm  col-xs-12 panel panel-river clearfix mrgn-bttm-xs">';
            
            $htmloutput=$htmloutput.'<div class="elgg-body clearfix edit-comment">';
            $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-0 text-primary">'.elgg_echo('sf:title').'</h3>';
            while ($row = $result->fetch_assoc()) {
                 $userGUID=$row['guid_two'];
                $job=get_user($userGUID)->job;
                $htmloutput=$htmloutput.'<div class="col-xs-4 text-center">';
                $htmloutput=$htmloutput.'<img src="'.get_user($row['guid_two'])->getIcon('medium') . '" class="avatar-profile-page img-responsive center-block " alt="'.elgg_echo('sf:alttext').' '.get_user($row['guid_two'])->getDisplayName().'">';
                $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm"><span class="text-primary">'.get_user($row['guid_two'])->getDisplayName().'</span></h4>';
                $htmloutput=$htmloutput.'<p class="small mrgn-tp-0">'.$job.'</p>';
                $htmloutput=$htmloutput.'<a href="'.  $site_url. 'profile/'. get_user($row['guid_two'])->username.'" class="btn btn-primary mrgn-tp-sm">'.elgg_echo('sf:connect').'</a>';
                $htmloutput=$htmloutput.'</div>';
               // $htmloutput=$htmloutput. $row['guid_two'].'-';
            }
            $htmloutput=$htmloutput.'</div>';
            $htmloutput=$htmloutput.'<div class="clearfix"></div>';
            $htmloutput=$htmloutput.'</div>';
            echo $htmloutput;
        }
        $connection->close();
    }
    catch (Exception $e)
    {
        $errMess=$e->getMessage();
        $errStack=$e->getTraceAsString();
        $errType=$e->getCode();
        gc_err_logging($errMess,$errStack,'Suggested Friends',$errType);

        $connection->close();
    }
}

echo elgg_view('page/components/image_block', array(
	'image' => elgg_view('river/elements/image', $vars),
	'body' => elgg_view('river/elements/body', $vars),
	'class' => 'col-xs-12  panel panel-river',
));