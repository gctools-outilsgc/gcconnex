<?php

/**
 * Profile Strength
 * 
 * @author Mathieu Blondin Ethan Wallace github.com/ethanWallace
 */

$user_guid = elgg_get_page_owner_guid();
$userEnt = get_user ( $user_guid );

//avatar
if($userEnt->getIconURL() !=  elgg_get_site_url() . '_graphics/icons/user/defaultmedium.gif'){
    $avIcon = '<i class="fa fa-check text-primary"></i>';
    $avTotal = 100;
}else{
    $avIcon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
    $avTotal = 0;
}

//About me
if($userEnt->description){
    $aboutIcon = '<i class="fa fa-check text-primary"></i>';
    $aboutTotal = 100;
}else{
    $aboutIcon = '<i class="fa fa-exclamation-triangle text-danger"></i>';
    $aboutTotal = 0;
}

//basic profile
$basicCount = 0;

if($userEnt->university || $userEnt->college || $userEnt->highschool || $userEnt->federal || $userEnt->ministry || $userEnt->municipal || $userEnt->international || $userEnt->ngo || $userEnt->community || $userEnt->business || $userEnt->media || $userEnt->retired || $userEnt->other){
    $basicCount += 20;
}
if($userEnt->job){
    $basicCount += 20;
}
if($userEnt->location || $userEnt->addressString || $userEnt->addressStringFr){
    $basicCount += 20;
}
if($userEnt->email){
    $basicCount += 20;
}
if($userEnt->phone || $userEnt->mobile){
    $basicCount += 20;
}

//education
if(count($userEnt->education) >= 1){
    $eduCount = 100;
} else {
    $eduCount = 0;
}

//work experience
if(count($userEnt->work) >= 1){
    $workCount = 100;
} else {
    $workCount = 0;
}

//skills
if(count($userEnt->gc_skills) >= 3){
    $skillCount = 100;
} else {
    $skillCount = round(count($userEnt->gc_skills)/3*100);
}

//overall total
$complete = round(($skillCount + $workCount + $eduCount + $basicCount + $aboutTotal + $avTotal)/6);

//set up profile strength metadata
$userEnt->profilestrength = $complete;

echo '<script src="'.elgg_get_site_url().'mod/GC_profileStrength/views/default/widgets/profile_completness/js/circliful.min.js"></script>';
echo '<link rel="stylesheet" href="'.elgg_get_site_url().'mod/GC_profileStrength/views/default/widgets/profile_completness/css/circliful.css">';
?>

<script>$(document).ready(function () {
    $('#complete').circliful({
        animation: 1,
        animationStep: 5,
        iconPosition: 'top',
        foregroundBorderWidth: 15,
        backgroundBorderWidth: 15,
        percent: <?php echo $complete;?>,
        fontColor: '#46246A',
        textSize: 28,
        percentageTextSize: 40,
        foregroundColor: "#46246A",
        iconColor: '#46246A',
        targetColor: '#46246A',
    });
});
</script>

<?php
//render results
if($userEnt->profilestrength != 100){
    echo '<div class="col-md-push-3 col-md-6"><div id="complete"></div></div>';
    echo '<div class="clearfix"></div>';
    echo '<details><summary class="bg-primary">'.elgg_echo('ps:details').'</summary>';

    //about me / Avatar

    echo '<ul class="list-unstyled colcount-sm-2 colcount-md-2 colcount-lg-2 mrgn-tp-sm">';
    echo '<li><strong>Avatar</strong>: ';
    echo $avIcon;
    echo '</li>';
    echo '<li><strong>'.elgg_echo('profile:aboutme').'</strong>:  ';
    echo $aboutIcon;
    echo '</li></ul>';

    //progress bars

    echo '<ul class="list-unstyled colcount-sm-1 colcount-md-1 colcount-lg-1">';
    echo '<li><strong>'. elgg_echo("ps:basicprofile").'</strong>:</li> <li><progress class="progress-bar-striped" max="100" value="'.$basicCount .'"></progress><span>' . $basicCount . '%</span></li>';
    echo '<li><strong>'. elgg_echo('profile:skills') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$skillCount .'"></progress><span>' . $skillCount . '%</span></li>';
    echo '<li><strong>'. elgg_echo('ps:education') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$eduCount .'"></progress><span>' . $eduCount . '%</span></li>';
    echo '<li><strong>'. elgg_echo('ps:work') .'</strong>:</li> <li> <progress class="progress-bar-striped" max="100" value="'.$workCount .'"></progress><span>' . $workCount . '%</span></li>';
    echo '</ul>';
    echo '<div class="clearfix"></div></details>';
} else {
    /*Strength is at 100%*/
    echo '<div class="text-center">';
    echo elgg_view('output/img', array(
            'src' => 'mod/GC_profileStrength/graphics/completeBadgeLvl01.png', 
            'alt' => elgg_echo('badge:complete:achieved:1', array($userEnt->name)), 
            'title' => elgg_echo('badge:complete:achieved:1', array($userEnt->name)), 
            'style' => 'width:125px;'
            ));
    echo '<p>'.elgg_echo('ps:all-star').'</p>';
    echo '</div>';

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
    if($userEnt->opt_in_casual_seek == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }
    if($userEnt->opt_in_casual_create == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }
    if($userEnt->opt_in_student_seek == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }
    if($userEnt->opt_in_student_create == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }
    if($userEnt->opt_in_collaboration_seek == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }
    if($userEnt->opt_in_collaboration_create == 'gcconnex_profile:opt:yes') {
        $OptedIn = true;
    }

    //focus onto the micromission section
    if(elgg_plugin_exists('missions') && elgg_is_active_plugin('missions') && $OptedIn==false){
        echo '<p class="pull-left" style="width: 70%;">'.elgg_echo('ps:optingin').'</p>';
        
        if(!strpos($currentPage,'profile')){
            echo '<a href="'.elgg_get_site_url().'profile/'.$userEnt->username.'#edit-opt-in" class="btn btn-primary mrgn-tp-sm pull-right">'. elgg_echo('ps:optin').'</a>';
        }else{
            echo '<a href="#edit-opt-in" class="btn btn-primary mrgn-tp-sm pull-right">'. elgg_echo('ps:optin').'</a>';
        }
    }
}

?>