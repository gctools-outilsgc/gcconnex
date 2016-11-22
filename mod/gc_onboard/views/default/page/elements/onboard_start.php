<?php

/**
 * Calls elements/onboard_cta view with params. This view extends the layout to just above the main content.
 *
 * Perform all tests and create the call to action from this view.
 *
 * @version 1.0
 * @author Nick
 */

$grouponboard = get_input('onboard');

 if(elgg_is_logged_in()){

    //Test For going to User Profile
     if(elgg_in_context('profile')){
         if(elgg_get_logged_in_user_guid() == elgg_get_page_owner_guid()){
             //Test for profile strength less than 50
             if(elgg_get_logged_in_user_entity()->profilestrength <50 && !elgg_get_logged_in_user_entity()->profilecta){
                 //Meta data not set and profile strength less than 50
                 $profile_link = elgg_get_site_url().'profileonboard';
                 echo elgg_view('page/elements/onboard_cta', array('title'=>elgg_echo('onboard:profileCtaTitle'),'desc'=>elgg_echo('onboard:profileCtaDesc'),'btntxt'=>elgg_echo('onboard:profileCtaBtntxt'),'href'=>$profile_link, 'type'=>'profile', 'close_count'=>'1'));
             }else if(elgg_get_logged_in_user_entity()->profilestrength <50 && elgg_get_logged_in_user_entity()->profilecta ==1){
                 //Meta data has 1 count and profile strength is low
                 $profile_link = elgg_get_site_url().'profileonboard';
                 echo elgg_view('page/elements/onboard_cta', array('title'=>elgg_echo('onboard:profileCtaTitle'),'desc'=>elgg_echo('onboard:profileCtaDesc'),'btntxt'=>elgg_echo('onboard:profileCtaBtntxt'),'href'=>$profile_link, 'type'=>'profile', 'close_count'=>'2'));
             }else if(elgg_get_logged_in_user_entity()->profilecta == 2){
                 //If they close 2 times we don't show
                 echo '';
             }
         }
     }

    //Test for going to group page
    if(elgg_in_context('groups') && !elgg_in_context('group_profile')){
        $group_link = elgg_get_site_url().'groupsonboard';
        $count = elgg_get_entities_from_relationship(array(
            'relationship'=> 'member',
            'relationship_guid'=> elgg_get_logged_in_user_guid(),
            'inverse_relationship'=> FALSE,
            'type'=> 'group',
            'limit'=> 4,
            'count'=>true,
        ));
        //Test for less than 3 groups
        if($count <= 2){
            echo elgg_view('page/elements/onboard_cta', array('title'=>elgg_echo('onboard:groupCtaTitle'),'desc'=>elgg_echo('onboard:groupCtaDesc'),'btntxt'=>elgg_echo('onboard:groupCtaBtntxt'),'href'=>$group_link,));
        }
        
    }

    //test for group profile during group onboarding
    if(elgg_in_context('group_profile') && $grouponboard){

        //check groups joined
        $groupsJoined = elgg_get_entities_from_relationship(array(
            'relationship'=> 'member',
            'relationship_guid'=> elgg_get_logged_in_user_entity()->guid,
            'inverse_relationship'=> FALSE,
            'type'=> 'group',
            'limit'=> false,
            'count'=>true,
        ));

        //check group membership requests
        $groupsRequest = elgg_get_entities_from_relationship(array(
            'relationship'=> 'membership_request',
            'relationship_guid'=> elgg_get_logged_in_user_entity()->guid,
            'inverse_relationship'=> FALSE,
            'type'=> 'group',
            'limit'=> false,
            'count'=>true,
        ));

        $groups = $groupsJoined + $groupsRequest;
        $count = 3 - $groups;

        if($count > 0){                             //if user has not joined 3 groups
            if($count == 1){
                $title = elgg_echo('onboard:groups:tracker1', array($count));
            } else {
                $title = elgg_echo('onboard:groups:tracker', array($count));
            }
            //$desc = 'Add Additional Groups';
            $btntxt =  elgg_echo('onboard:groups:trackerButtonProgress');
            $href = 'groupsonboard';
        } else {                             //if user has joined 3 groups
            $title = elgg_echo('onboard:groups:trackerHead');
            $desc = elgg_echo('onboard:groups:trackerDesc');
            $btntxt = elgg_echo('onboard:groups:trackerButton');
            $href = 'newsfeed';
        }

        //display cta
        echo elgg_view('page/elements/onboard_grouptracker', array('title'=>$title,'desc'=>$desc,'btntxt'=>$btntxt,'href'=>$href,));


    }

    //Test for going to NewsFeed
    

 }




