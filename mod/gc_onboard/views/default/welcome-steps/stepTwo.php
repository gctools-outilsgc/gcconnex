<?php
/*
 * stepTwo.php - Welcome
 *
 * Second step of welcome module. Matches colleagues based on department from ambassador group and popular members.
 */
?>

<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:two:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>3, 'total_steps'=>5));?>

    </div>
</div>
<div class="panel-body">
    <p>
        <?php echo elgg_echo('onboard:welcome:two:description'); ?>
    </p>
    <div class="clearfix wb-eqht" style="">
        <?php

        $geds = get_input('geds');

        if($geds == true){
            if(get_current_language()=='fr'){
                $orgString = elgg_get_logged_in_user_entity()->orgStructFr; //French
            }else{
                $orgString = elgg_get_logged_in_user_entity()->orgStruct; //English
            }

            $orgs = json_decode($orgString);

            $org = end($orgs);

            $loading = elgg_view('output/img', array(
                'src' => 'mod/wet4/graphics/loading.gif',
                'alt' => 'loading'
            ));
	        echo '<div id="orgPeople" style="width: 100%;">
                    <div class="text-center" style="margin: 0 auto;display:block;">
                        <h3>'.elgg_echo('onboard:geds:loading').'</h3>
                        '.$loading.'

                    </div>
                </div>';

        } else {
            //get user's department
            $depart = elgg_get_logged_in_user_entity()->department;

            //explode to look for opposite version (e.g. english / french, french / english)
            $departSeperate = explode(' / ', $depart);

            $depart1 = $departSeperate[0]  . ' / ' . $departSeperate[1];
            $depart2 = $departSeperate[1]  . ' / ' . $departSeperate[0];



            /////////////////
            /// We have to do a weird thing right here
            /// To avoid grabbing nothing from a department that doesnt have any users we see how many are on the system and build the offset based on that
            ////////////////

            $deptCount = elgg_get_entities_from_metadata(array(
                'types' => 'user',
                'metadata_names' => array('department'),
                'metadata_values' => array($depart1, $depart2),
                'count' => true
                ));

            if($deptCount >= 60){
                $offset = rand(0, $deptCount - 20);
                $limit = 20;
            } else {
                $offset = 0;
                $limit = 0;
            }

            ////////////////

            //members in the ambassador group from same department
            $groupMemb = elgg_get_entities_from_relationship(array(
                'relationship' => 'member',
                'relationship_guid' => 112,  //662668
                'inverse_relationship' => true,
                'type' => 'user',
                'limit' => $limit,
                'offset' => $offset,
                'pagination' => false,
                'metadata_name'  => 'department',
                'metadata_values'  => array($depart1, $depart2),
                ));

            //popular members in department
            $poMemb = elgg_get_entities_from_relationship(array(
                'relationship' => 'friend',
                'inverse_relationship' => false,
                'type' => 'user',
                'limit' => $limit,
                'offset' => $offset,
                'pagination' => false,
                'metadata_name'  => 'department',
                'metadata_values'  => array($depart1, $depart2),
                ));

            //set guids as key for each array items
            foreach($groupMemb as $f => $l){ $f = $l->guid; }
            foreach($poMemb as $f => $l){ $f = $l->guid;}

            $finalList = array_merge($groupMemb, $poMemb);
            //remove duplicate users
            $finalList = array_unique($finalList, SORT_REGULAR);
            shuffle($finalList);

            //only want to display the first six colleagues
            $colleagueCount = 0;

            //if the search does not find anyone, grb 6 random ambassadors for the user
            if(empty($finalList)){

                $finalList  = elgg_get_entities_from_relationship(array(
                'relationship' => 'member',
                'relationship_guid' => 662668,  //662668
                'inverse_relationship' => true,
                'type' => 'user',
                'limit' => 10,
                'offset' => rand(0, 250),
                'pagination' => false,
                ));

            }

            foreach($finalList as $f => $l){



                //user should not appear here but dont display them if they do
                if($l->guid == elgg_get_logged_in_user_guid() || check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $l->guid)){

                }else if($colleagueCount <= 5){ //only display six options

                    $htmloutput = '';
                    $site_url = elgg_get_site_url();
                    $userGUID=$l->guid;
                    $job=$l->job;

                    $htmloutput=$htmloutput.'<div style="height:200px; margin-top:25px;" class="col-xs-4 text-center hght-inhrt  onboard-coll">'; // suggested friend link to profile

                    //EW - change to render icon so new ambassador badges can be shown
                    $htmloutput.= elgg_view_entity_icon($l, 'medium', array('use_hover' => false, 'use_link' => false, 'class' => 'elgg-avatar-wet4-sf'));

                    $htmloutput=$htmloutput.'<h4 class="h4 mrgn-tp-sm mrgn-bttm-sm"><span class="text-primary">'.$l->getDisplayName().'</span></h4>';
                    if($job){ // Nick - Adding department if no job, if none add a space
                        $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 job-length">'.$job.'</p>';
                    }else{
                        $htmloutput=$htmloutput.'<p class="small mrgn-tp-0 min-height-cs"></p>';
                    }

                    //changed connect button to send a friend request we should change the wording
                    $htmloutput=$htmloutput.'<a href="#" class="add-friend btn btn-primary mrgn-tp-sm" onclick="addFriendOnboard('.$userGUID.')" id="'.$userGUID.'">'.elgg_echo('friend:add').'</a>';
                    $htmloutput=$htmloutput.'</div>';

                    echo $htmloutput . '';

                    $colleagueCount += 1;
                }





            }
        }
            ?>
    </div>

    <div class="mrgn-bttm-md mrgn-tp-lg pull-right">

        <?php
        echo elgg_view('input/submit', array(
                'value' => elgg_echo('onboard:welcome:next'),
                'id' => 'next',
            ));
        ?>

    </div>

    <script>



        function addFriendOnboard(guid) {
            var button = $('#' + guid);
            //check if button has id
            if (button.attr('id') != '') {

                //change to loading spinner
                button.html('<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i><span class="sr-only">Loading...</span>').removeClass('btn-primary add-friend').addClass('btn-default');
                var id = $(this).attr('id');

                //do the elgg friend request action
                elgg.action('friends/add', {
                    data: {
                        friend: guid,
                    },
                    success: function (wrapper) {
                        if (wrapper.output) {
                            //alert(wrapper.output.sum);
                        } else {
                            // the system prevented the action from running
                        }

                        //show that the request was sent
                        button.html("<?php echo elgg_echo('friend_request:friend:add:pending'); ?>");
                        //remove id to disabe sending request again
                        button.attr('id', '');
                    }
                });
            }
        }


    //skip to next step
    $('#next').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepThree', {
            success: function (output) {
               // var oldHeight = $('#welcome-step').css('height');
                $('#welcome-step').html(output);
               // var newHeight = $('#welcome-step').children().css('height');
                //console.log('new:' + newHeight + ' old:' + oldHeight);
                //animateStep(oldHeight, newHeight);
            }
        });
    });

        /*
        Copied from geds_sync mod
            -changed view to local version of org-people

        * function browseOrg(authId, orgDN)
        * authId - authentication id obtained in function authSearchOrg. Used to make calls against GEDS
        * orgDN - Domain name of org to search.
        * Purpose: Function searches GEDS for orgDN and builds new content of profile organizations tab.
        *          Results will contain new Org tree as well as list of people in that level of the org tree.
        */
		function browseOrg(orgDN){

			//search string. Searches uses auth id and organization dmomain name pased in as arguments
			var searchObj = "{\"requestID\" : \"B02\", \"authorizationID\" : \"X4GCCONNEX\", \"requestSettings\" : {\"baseDN\" : \""+orgDN+"\"} }";

            $.ajax({
                type: 'POST',
                contentType: "application/json",
                url: 'https://api.sage-geds.gc.ca/<?php echo get_current_language(); ?>/GAPI/',//uses 2 letter language code for url
                data: searchObj, //search string
                dataType: 'json',
                success: function (feed) {
                	//alert("I am an alert box! orgDN: "+orgDN+"</br>"+JSON.stringify(feed.requestResults));
                    //start with getting the list of people in the selected org
                    //number of people found in org search
                	var count = feed.requestResults.listEntryCount.personListEntries;
                    //alert("I am an alert box! Count "+count);
                    //if people are found
                	if (count != 0 && count != null){
                		//alert("I am an alert box! Count not zero");
                       //empty div, so each search does not include previous list
                		$("#orgPeople").empty();
                        //remove title from box. gets added again below
                        $('#peopleContainer').find('.profile-heading').remove();

                        //elgg ajax call. this is a ajax call within another ajax call
                        elgg.post('ajax/view/welcome-steps/geds/org-people', { //ajax view to call org-people. builds the people list //Changed to local view
                            data: {
                                orgPeopleData: JSON.stringify(feed.requestResults.personList) // the list of people found passed to view
                            },
                            success: function (output) {
                                //build the box to contain the people list
                                $('#peopleContainer').addClass('panel panel-custom');
                                $('#peopleContainer').prepend('<div class="panel-heading profile-heading clearfix"><h3 class="profile-info-head pull-left clearfix"><?php echo elgg_echo("geds:org:orgPeopleTitle"); ?><h3></div>');
                                //add output returned from org-people view
                                $('#orgPeople').append(output);
                            },
                            error: function(xhr, status, error) {
                                // do nothing - debug code could be placed here.
                            }
                        });

                	}



                },
                error: function(request, status, error) {
                   //do nothing - debug code could go here
                }
            });
		}

        browseOrg(" <?php echo $org->DN; ?> ");

    </script>
    <style>
        .min-height-cs {
            min-height: 20px;
        }

        .job-length {
            white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
        }

        .onboard-coll {

            max-width:285px;

        }
    </style>


</div>
