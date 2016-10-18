<?php
$group = elgg_get_page_owner_entity();

//only display for logged in user who is a member of the group
if(elgg_is_logged_in() && $group->isMember()){

    $user = elgg_get_logged_in_user_entity();

    require_once( elgg_get_plugins_path() . "gcProfilePictureBadges/badge_map.php" );	// get array of groups with badges
    global $initbadges;

    //see if group is in the list
    foreach ( $initbadges as $name => $badge ){
        if($name == $group->name){
            //grab badge name
            $pledge = $badge;
        }
    }

    //display if group has a badge and the user does not have it active
    if($pledge && $pledge != $user->init_badge){
        
?>
<div class="pledge-holder clearfix">
    <?php   
        //know more link
        echo '<span class="pull-right"><a title="' . elgg_echo('badge:knowmore') . '" target="_blank" href="' . elgg_echo('badge:knowmorelink') . '""><i class="fa fa-lg fa-info-circle icon-sel mrgn-lft-sm"><span class="wb-invisible">' . elgg_echo('badge:knowmore') . '</span></i></a></span>';

        //pledge description
        echo '<p>'.elgg_echo('gcProfilePictureBadges:pledgeSell', array($pledge)).'</p>';
        
        //display badge
        echo elgg_view('output/img', array(
            'src' => 'mod/gcProfilePictureBadges/graphics/'.$pledge.'.png',
            'class' => 'center-block',
            'title' => $pledge,
        ));

        //add to avatar button
        echo elgg_view('output/url', array(
               'href'=> elgg_add_action_tokens_to_url("/action/badge/pledge?init={$pledge}"),
               'class'=>'btn btn-primary pull-right',
               'text' => elgg_echo('gcProfilePictureBadges:addtoavatar'),
               'id' => 'Pledge',
               'is_action' => true,
               'is_trusted' => true,

           ));
    ?>
</div>
<style>
    .pledge-holder {
        border: solid 2px #269abc;
        width: 100%;
        background-color: rgba(215, 250, 255, 0.25);
        padding: 5px;
        margin: 6px 0px;
        box-shadow: 1px 1px 4px #CCC;
        border-radius: 5px;
    }

</style>
<?php
    } else {

        //check if it is ambassador group

        global $badgemap;
        foreach ( $badgemap as $name => $badge ){
            if($name == $group->name){
                //grab badge name
                $pledge = $name;
            }
        }

        //display if group has a badge and the user does not have it active
        if($pledge && $pledge != $user->active_badge && array_key_exists($group->name, $badgemap)){ //662668

?>
<div class="amb-holder clearfix">
    <?php
            //know more link
            //echo '<span class="pull-right"><a title="' . elgg_echo('badge:knowmore') . '" target="_blank" href="' . elgg_echo('badge:knowmorelink') . '""><i class="fa fa-lg fa-info-circle icon-sel mrgn-lft-sm"><span class="wb-invisible">' . elgg_echo('badge:knowmore') . '</span></i></a></span>';

            //display badge
            echo elgg_view('output/img', array(
                'src' => 'mod/gcProfilePictureBadges/graphics/amb_badge_v1_5.png',
                'class' => 'pull-left mrgn-rght-md',
                'title' => $pledge,
            ));

            //pledge description
            echo '<p class="">'.elgg_echo('gcProfilePictureBadges:ambassadorSell', array($pledge)).'</p>';

            

            //add to avatar button
            echo elgg_view('output/url', array(
                   'href'=> elgg_add_action_tokens_to_url("/action/badge/pledge?init={$pledge}&active=true"),
                   'class'=>'btn btn-primary pull-right mrgn-tp-md',
                   'text' => elgg_echo('gcProfilePictureBadges:addtoavatar'),
                   'id' => 'Pledge',
                   'is_action' => true,
                   'is_trusted' => true,

               ));
    ?>
</div>
<style>
    .amb-holder {
        border: solid 2px #f5db84; /* f5db84 */
        width: 100%;
        /*background-color: #f9e9b5;  f9e9b5*/
        background-color: rgba(249, 233, 181, 0.35);
        padding: 5px; 
        margin: 6px 0px;
        box-shadow: 1px 1px 4px #CCC;
        border-radius: 5px;
    }

</style>
<?php
        }
    }
}
