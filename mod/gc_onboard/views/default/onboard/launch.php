<?php
/*
 * launch.php
 *
 * Launches onboarding module from the newsfeed widget
 *
 * @package gc_onboard
 * @author Ethan Wallace <>
 */

//Onboarding
if(elgg_is_logged_in()){

    $helpLaunch = get_input('welcome');

    $user = elgg_get_logged_in_user_entity();

    //$user->onboardcta = time();

    //grab times from settings
    $time = elgg_get_plugin_setting("wait_time", "gc_onboard");
    if(!$time){
        $time = 1458259200;
    }

    //check if user has interacted with the module already
    if(!isset($user->onboardcta) || (is_numeric($user->onboardcta) && (time() - $user->onboardcta) > $time)){ //1458259200

        $onboard = elgg_view('welcome-steps/modal');
        $onboard .= '<script> window.onload = function () { document.getElementById("onboardPopup").click(); $("#welcome-step .feed-filter").remove(); } </script>';

    } else if($helpLaunch){

      $onboard = elgg_view('welcome-steps/modal');
      $onboard .= '<script> window.onload = function () { document.getElementById("onboardPopup").click(); $("#welcome-step .feed-filter").remove(); } </script>';

    }

}
//display modal
echo $onboard;
 ?>
