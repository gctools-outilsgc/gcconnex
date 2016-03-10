<?php

/*

do all calculations here to send to layout.php to display

*/

//get owner
$user = elgg_get_page_owner_entity();

$name = 'complete';

//get badge images
$badges[0] = 'mod/achievement_badges/graphics/completeBadgeLvl00.png';
$badges[1] = 'mod/achievement_badges/graphics/completeBadgeLvl01.png';

//set current badge
$currentBadge = $badges[0];

//set level to zero
$level = '1';

//static
$title = 'Profile Complete Badge';
$description = '100%';

//set goals for badge
$goals[0] = 100;


$currentGoal = $goals[0];

//current count
$count = '0';

try{
   $user_guid = elgg_get_page_owner_guid();
$userEnt = get_user ( $user_guid );
$site_url = elgg_get_site_url();
$userName = get_loggedin_user()->username;
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

$count = $getResult['@total'];

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



if($count < $goals[0]){ //no badge
    
    $user->completeBadge = 0;
    $currentBadge = $badges[0];
    $currentGoal = $goals[0];
    $level = '1';

} else if($count == $goals[0]){ //100% Complete
    
    $user->completeBadge = 1;
    $currentBadge = $badges[1];
    $currentGoal = $goals[0];
    $level = 'Completed';

} 

$title = elgg_echo('badge:' . $name . ':name');
$description =  elgg_echo('badge:' . $name . ':objective', array($currentGoal));

if(elgg_is_logged_in() && elgg_get_logged_in_user_guid() == $user->getGUID()){

    //create progress
    $options = array(
        'title' => $title,
        'desc' => $description,
        'src' => $currentBadge,
        'goal' => $currentGoal,
        'count' => $count,
        'level' => $level,
    );

    echo elgg_view('badges/layout/layout', $options);
}