<?php

    /*
     * Redirect user to their preference of landing page
     * Users landingpage metadata
     */

if(elgg_is_logged_in()){
    $user = elgg_get_logged_in_user_entity();
    
    //set metadata if not set
    if(!isset($user->landingpage)){
        $user->landingpage = 'news';
    }


    //send to dashboard
    if($user->landingpage == 'dash'){
        $url = elgg_get_site_url()."dashboard/";
        forward($url);
    } else {
        //send to news feed
        $url = elgg_get_site_url()."newsfeed/";
        forward($url);
    }
    
}
else{

    //if not logged in go to splash
    $url = elgg_get_site_url()."splash/";
    forward($url);
    //Splash will forward them to login
    
}
    ?>