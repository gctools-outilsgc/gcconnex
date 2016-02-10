<?php
if (elgg_is_logged_in()) { 
try{
$user_guid = elgg_get_logged_in_user_guid();
$userEnt = get_user ( $user_guid );
$site_url = elgg_get_site_url();
$user = get_loggedin_user()->username;
$currentPage=$_SERVER[ "REQUEST_URI" ];
$OptedIn=FALSE;

//echo $user_guid;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  //connect to database  , "3306"
  $connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);

  //run the store proc
  //call GET_Completness(152, @total, @SkillsPerc, @BasicProfPerc, @AboutPerc, @EduPerc, @WorkPerc, @AvatarPerc);
  $result = mysqli_query($connection, "CALL GET_Completness(" . $user_guid . ", @total,@SkillsPerc,@BasicProfPerc,@AboutPerc,@EduPerc,@WorkPerc,@AvatarPerc);", MYSQLI_USE_RESULT);// or die("Query fail: " . mysqli_error($connection));
    // echo print_r($result);
  
//select @total, @SkillsPerc, @BasicProfPerc, @AboutPerc, @EduPerc, @WorkPerc, @AvatarPerc;

  if (!($res = $connection->query("select @total, @SkillsPerc, @BasicProfPerc, @AboutPerc, @EduPerc, @WorkPerc, @AvatarPerc;"))) {
      
    //echo "SELECT failed: (" . $connection->errno . ") " . $connection->error;
      throw new Exception($connection->errno);
}
$getResult = mysqli_fetch_assoc($res);


echo "<script>$(document).ready(function() {
    var progressbar = $('#progressbar'),
        max = progressbar.attr('value'),
        //max=80,
        time = (150/max)*5,    
        value = 1;
        //value=0;
 
    var loading = function() {
        value += 1;
        addValue = progressbar.val(value);
         
        $('.progress-value').html(value + '%');
 
        if (value == max) {
            clearInterval(animate);                    
        }
    };
 
    var animate = setInterval(function() {
        loading();
    }, time);
});</script>";

echo '<p class="center progress-value pc-large-text">'.$getResult['@total'].'</p>';

echo '<meter id="progressbar" class="progress-bar-striped col-xs-12 col-sm-12 col-md-12 col-lg-12 mrgn-bttm-sm" low="45" high="75" optimum="85" value="'.$getResult['@total'].'" max="100"></meter>';
echo '<div class="clearfix"></div>';
if(intval($getResult['@total'])<100){
    echo '<details><summary class="bg-primary">'.elgg_echo('ps:details').'</summary>';
    echo '<ul class="list-unstyled colcount-sm-2 colcount-md-2 colcount-lg-2">';
    echo '<li><strong>Avatar</strong>: ';
    if($getResult["@AvatarPerc"]==100){
        echo '<i class="fa fa-check text-primary"></i>';
    }else{
        echo '<i class="fa fa-exclamation-triangle text-danger"></i>';
    }
    echo '</li>';
    echo '<li><strong>'.elgg_echo('profile:aboutme').'</strong>:  ';
    if($getResult["@AboutPerc"]==100){
        echo '<i class="fa fa-check text-primary"></i>';
    }else{
        echo '<i class="fa fa-exclamation-triangle text-danger"></i>';
    }
    echo '</li>';
    echo '</ul><ul class="list-unstyled colcount-sm-1 colcount-md-1 colcount-lg-1">';
    echo '<li><strong>'. elgg_echo("ps:basicprofile").'</strong>:</li> <li><progress class="progress-bar-striped" max="100" value="'.$getResult['@BasicProfPerc'] .'"></progress><span>' . $getResult['@BasicProfPerc'] . '%</span></li>';
    echo '<li><strong>'. elgg_echo('profile:skills') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$getResult['@SkillsPerc'] .'"></progress><span>' . $getResult['@SkillsPerc'] . '%</span></li>';
    echo '<li><strong>'. elgg_echo('ps:education') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$getResult['@EduPerc'] .'"></progress><span>' . $getResult['@EduPerc'] . '%</span></li>';
    echo '<li><strong>'. elgg_echo('ps:work') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$getResult['@WorkPerc'] .'"></progress><span>' . $getResult['@WorkPerc'] . '%</span></li>';
    echo '</ul>';
    if(!strpos($currentPage,'profile')){
        echo '<a href="'.  $site_url. 'profile/'. $user.'" class="btn btn-primary mrgn-tp-sm pull-right">'. elgg_echo('userMenu:profile').'</a>';
    }
    echo '<div class="clearfix"></div></details>';
}
else
{
/*Strength is at 100%*/
    echo '<p>'.elgg_echo('ps:all-star').'</p>';
    if($userEnt->opt_in_missions == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}
	if($userEnt->opt_in_swap == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}
	if($userEnt->opt_in_mentored == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}
	if($userEnt->opt_in_mentoring == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
	}
	if($userEnt->opt_in_shadowed == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}
	if($userEnt->opt_in_shadowing == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
	}
	if($userEnt->opt_in_peer_coached == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}
	if($userEnt->opt_in_peer_coaching == 'gcconnex_profile:opt:yes') {
	    $OptedIn = true;
	}

    if(elgg_plugin_exists('missions') && elgg_is_active_plugin('missions') && $OptedIn==false)
    {
        echo '<p>'.elgg_echo('ps:optingin').'</p>';
        if(!strpos($currentPage,'profile')){
            echo '<a href="'.  $site_url. 'profile/'. $user.'#edit-opt-in" class="btn btn-primary mrgn-tp-sm pull-right">'. elgg_echo('ps:optin').'</a>';
        }
        else
        {
            echo '<a href="#edit-opt-in" class="btn btn-primary mrgn-tp-sm pull-right">'. elgg_echo('ps:optin').'</a>';
        }

        
    }
    
    
    
}

$connection->close();
}
catch (Exception $e)
{
    $errMess=$e->getMessage();
    $errStack=$e->getTraceAsString();
    $errType=$e->getCode();
    gc_err_logging($errMess,$errStack,'Profile Strength',$errType);

    $connection->close();
    echo "<div class='alert alert-danger'><h3>Oops!</h3>".elgg_echo('ps:psErr')."</div>";
}

} 

?>