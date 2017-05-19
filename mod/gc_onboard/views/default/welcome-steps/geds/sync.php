<?php
/*
* sync.php
*
* This file adds the geds sync button to the onboarding module
* Two external javascript libraries are used. bootstrap table (bsTable) is the library used to create the data table. http://wenzhixin.net.cn/p/bootstrap-table/docs/index.html
*
*/
$owner = elgg_get_logged_in_user_entity();
//only shows if user is able to edit page
if (!$owner->canEdit()){
    return;
}

$obj = elgg_get_entities(array(
         'type' => 'object',
         'subtype' => 'gcpedia_account',
         'owner_guid' => $owner->guid
        ));
$gcpuser = $obj[0]->title;
$loading = elgg_view('output/img', array(
                'src' => 'mod/wet4/graphics/loading.gif',
                'alt' => 'loading'
            ));
?>

<div class="text-center" id="syncError" style="min-height:46px;">
    <button type="button" id="onboard-info" class="btn btn-primary btn-lg">
        <?php echo elgg_echo("geds:button"); ?>
    </button>
</div>



<script type="text/javascript">
		var spinner;
        // a number of global js variables are declared here for use later
        //var authID;

        //auth id obtained from geds
        var authIDsetting = "<?php echo elgg_get_plugin_setting('auth_key','geds_sync'); ?>";

        //url for GEDS service
        var gedsURL = "<?php echo elgg_get_plugin_setting('geds_url','geds_sync'); ?>";

        // searcchVal - the page owners email
        var searchVal = "<?php echo $owner->email; ?> ";
        //syncTarget - not used
        //var syncTarget;
        //personFeed - global object that will eventually contain the user information from GEDS
        var personFeed;
        //frenchFeed - stores french object used for french job title, address, and department
        var frenchFeed;
        //Stores Job title for use in building bi-lingual job title
        var jobTitle = [];
        //Stores department for use in building departmental department string
        var dep = [];
        // Stores the french organizational structure string to be saved as profile metadata
        var orgStructFrString;
        //the bilingual job title (en / fr or fr / en)
        var langJobTitle;
        //the constructed bilingual department string (en/fr or fr/en)
        var langDept;
        //the french address information of the user
        var locationFr;
        //loading spinner attributes
        var spinneropts = {
            lines: 13 // The number of lines to draw
          , length: 7 // The length of each line
          , width: 2 // The line thickness
          , radius: 8 // The radius of the inner circle
          , scale: 1 // Scales overall size of the spinner
            , corners: 1 // Corner roundness (0..1)
            , color: '#000' // #rgb or #rrggbb or array of colors
            , opacity: 0.25 // Opacity of the lines
            , rotate: 0 // The rotation offset
            , direction: 1 // 1: clockwise, -1: counterclockwise
            , speed: 1 // Rounds per second
            , trail: 60 // Afterglow percentage
            , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
            , zIndex: 2e9 // The z-index (defaults to 2000000000)
            , className: 'spinner' // The CSS class to assign to the spinner
            , top: '23px' // Top position relative to parent
            //, left: '50%' // Left position relative to parent
            , shadow: false // Whether to render a shadow
            , hwaccel: false // Whether to use hardware acceleration
            , position: 'relative' // Element positioning
            };
        //the loading spinner
       //var spinner = new Spinner(spinneropts).spin();
		require({
    		packages: [{ name: "spin", location: '<?php echo elgg_get_site_url(); ?>'+'mod/geds_sync/vendors', main: 'spin'}]
  			},
  			['spin'],
  			function(Spinner) {
    			spinner = new Spinner(spinneropts).spin()
  			}
		)
        /*
        * On page load
        */
        $(document).ready(function () {
            //the button is added to the page here.
            //$('.gcconnex-profile-name').append('<button type="button" class="elgg-button btn gcconnex-edit-profile" data-toggle="modal" data-target="#gedsProfile"> <?php //echo elgg_echo("geds:button"); ?></button>')

            //action listener for the modal. When the modal is shown it begins the ajax call to geds
            $('#gedsProfile').on('click', function (e) {
                $(this).remove();
               $("#test").empty();
                getFrGEDS();

            });

        });

        /*
        * function getFrGEDS(id)
        * id - authoriseation id returned from GEDS. used for subsequent GEDS API calls
        * purpose: This function makes a call to geds French language API to get the french job title, department name, org string, and address details
        *           for use later in the file
        *
        */
        function getFrGEDS(){
            //request string to be passed to GEDS
            var searchObj = "{\"requestID\" : \"S02\", \"authorizationID\" : \""+authIDsetting+"\", \"requestSettings\" : {\"searchValue\" : \""+searchVal+"\", \"searchField\":\"7\", \"searchCriterion\":\"2\"} }";
            //ajax call to GEDS API to search for user based on email
            $.ajax({
                beforeSend: function (){
                    $("#syncError").append('<div class="text-center" style="margin: 0 auto;display:block;"><?php echo $loading; ?></div>'); //add spinner animation
				},//$("#test").spin(); $("#test").spin('show');},//this starts the loading spinner
                complete: function(){
                    //not being used
                },
                type: 'POST',
                contentType: "application/json",
                url: gedsURL+'/fr/GAPI/',//call to french api
                data: searchObj,
                dataType: 'json',
                success: function (frfeed) { //frfreed - result returned from geds. JavaScript object

                    //count to make sure at least one person was returned
                    var count = frfeed.requestResults.listEntryCount.personListEntries;
                    for (personCount in frfeed.requestResults.personList){
                        //store attributes to be used later
                        jobTitle[personCount] = frfeed.requestResults.personList[personCount].title;
                        dep[personCount] = frfeed.requestResults.personList[personCount].department;
                        orgStructFrString = frfeed.requestResults.personList[personCount].orgStructure;
                        //build a JS object describing the users address
                        locationFr = {
                            street : frfeed.requestResults.personList[personCount].address,
                            city : frfeed.requestResults.personList[personCount].city,
                            province : frfeed.requestResults.personList[personCount].province,
                            country : frfeed.requestResults.personList[personCount].country,
                            pc : frfeed.requestResults.personList[personCount].pc,
                            building : frfeed.requestResults.personList[personCount].building,
                            floor : frfeed.requestResults.personList[personCount].floor
                        };
                    }
                    //all french attributes are saved in global variables so only the GEDS auth id is needed to be passed
                    searchGEDS();
                },
                error: function(request, status, error) {
                    //do nothing - could be used for debugging
                }
            });
        }

        function searchGEDS(){
           //GEDS search string
            var searchObj = "{\"requestID\" : \"S02\", \"authorizationID\" : \""+authIDsetting+"\", \"requestSettings\" : {\"searchValue\" : \""+searchVal+"\", \"searchField\":\"7\", \"searchCriterion\":\"2\"} }";
            //call to geds english to build remaining english informaiton about the suer
            $.ajax({
                beforeSend: function (){
                   //do nothing
                 },
                complete: function(){spinner.stop();},//$("#test").spin('hide');}, //spinner.stop();}, //stop(hide) the loading spinner
                type: 'POST',
                contentType: "application/json",
                url: gedsURL,
                data: searchObj,
                dataType: 'json',
                success: function (feed) { // feed - JS object - GEDS result
                    //get number of people found. - should only be one in most situations.
                    //alert(JSON.stringify(feed.requestResults.personList));
                    //alert(feed.requestResults.personList);
                    var count = feed.requestResults.listEntryCount.personListEntries;
                   //if noone is found show message
                    if (count == 0 || count == null) {
                        $("#syncError").empty(); //remove spinner animation
                        $("#syncError").append("<?php echo elgg_echo('geds:searchfail'); ?>",searchVal, "<br/><?php echo elgg_echo('geds:searchfail2'); ?>" ).addClass('alert alert-warning mrgn-bttm-sm');
                    }
                    //if one or more user is found...
                    if (count >= 1){
                        for (personCount in feed.requestResults.personList){//cycle through people found
                            //just makes code cleaner
                            personObj = feed.requestResults.personList[personCount];
                                //get language page is being viewed in.
                                var lang = '<?php echo $_SESSION["language"]; ?>';

                                if (lang=='fr'){//build french title and department
                                    if(jobTitle[personCount]||personObj.title){ // some people dont have a job titles in GEDS
                                        langJobTitle = jobTitle[personCount]+" / "+personObj.title;
                                    }else{
                                        langJobTitle = '';//if blank leave blank not _/_
                                    }

                                    if(dep[personCount]||personObj.department){
                                        langDept = dep[personCount]+" / "+personObj.department;
                                    }else{
                                        langDept = '';
                                    }

                                }else{ //assume that if language is not french than english must be the case
                                    if(jobTitle[personCount]||personObj.title){
                                        langJobTitle = personObj.title+" / "+jobTitle[personCount];
                                    }else{
                                        langJobTitle = '';
                                    }

                                    if(dep[personCount]||personObj.department){
                                       langDept = personObj.department+" / "+dep[personCount];

                                    }else{
                                        langDept = '';
                                    }


                                }

                            // combine first and last names
                            var fullName = personObj.gn+" "+personObj.sn;
                            //add GEDS contact "card"
                            $("#syncError").empty(); //remove spinner animation
                            $("#syncError").append("<div id='geds-avatar' style='float:left;'><img src='"+personObj.imageURL+"' height=75px width=75px/></div>").removeClass('text-center');
                            $("#syncError").append("<div id='test_inner' style='float:right;width:75%;'></div>");
                            $("#test_inner").append("<b><?php echo elgg_echo('geds:personsel:name'); ?></b>", fullName, "<br/>");
                            if(langJobTitle){//make sure job title is not blank
                                $("#test_inner").append("<b><?php echo elgg_echo('geds:personsel:job'); ?></b>",langJobTitle, "<br/>");
                            }
                            if(langDept){//make sure department is not blank
                                $("#test_inner").append("<b><?php echo elgg_echo('geds:personsel:department'); ?></b>",langDept, "<br/>");
                            }


                            $("#test_inner").append("<b><?php echo elgg_echo('geds:personsel:phone'); ?></b>",personObj.tn , "<br/><br/>");
                            $("#test_inner").append("<?php echo elgg_echo('geds:personsel:isthisyou'); ?>");
                            $("#test_inner").append("<button type='button' onclick='noGedsMatch()' class='btn btn-danger'><?php echo elgg_echo('geds:personsel:no'); ?> </button>", " ");
                            $("#test_inner").append("<button type='button' onclick='setProfile(personObj,jobTitle[personCount],dep[personCount])' class='btn btn-success' > <?php echo elgg_echo('geds:personsel:yes'); ?> </button>");
                            //data-dismiss='modal' data-toggle='modal' data-target='#gedsSync'
                        }

                    }
                    //var pushObj = "{\"requestID\" : \"X03\", \"authorizationID\" : \"X4GCCONNEX\", \"requestSettings\" : {\"DN\" : \""+feed.requestResults.personList[0].dn+"\", \"searchField\":\"7\", \"searchCriterion\":\"2\"} }";

                },
                error: function() {
                    //do nothing - debug here
                }
            });
        }
        /*
        * noGedsMatch()
        * purpose: If user doesnt match returned GEDS person show message
        */
        function noGedsMatch(){
            $("#syncError").empty();
            $("#syncError").append("<?php echo elgg_echo('geds:noMatch'); ?>").addClass('alert alert-warning mrgn-bttm-sm');
        }
        /*
        * setProfile (feed, job, dep)
        * feed - person object
        * job - not used, should be removed
        * dep - not used, shoudl be removed.
        * purpose: builds data table where user can select which items to update their profile with
        *
        */
    function setProfile(feed, job, dep) {

        //clear profile display
        $("#syncError").empty();
        //remove profile fields
        $("#onboard-table").empty();

        //
        $('#stepOneButtons').empty();
        $('#stepOneButtons').append('<a id="skip" class="mrgn-lft-sm btn btn-default" onclick="skipStep()" href="#"><?php echo elgg_echo('onboard:welcome:one:skip'); ?></a>');
        $('#stepOneButtons').append('<button type="button" id="onboard-geds" class="btn btn-primary mrgn-lft-sm" onclick="saveData()"> <?php echo elgg_echo('geds:save'); ?> </button>');

            personFeed = feed;
            //JSON object for data table
            var feedData = [{
                item : '<?php echo elgg_echo("geds:sync:table:field:display"); ?>',
                property : 'name',
                gcc : "<?php echo $owner->name; ?>",
                geds : feed.gn+" "+feed.sn,
            },{
                item : '<?php echo elgg_echo("geds:sync:table:field:job"); ?>',
                property : 'job',
                gcc : "<?php echo $owner->job; ?>",
                geds : langJobTitle,
            },{
                item : '<?php echo elgg_echo("geds:sync:table:field:department"); ?>',
                property : 'department',
                gcc : '<?php echo $owner->department; ?>',
                geds : langDept,
            },{
                item : '<?php echo elgg_echo("geds:sync:table:field:telephone"); ?>',
                property : 'phone',
                gcc : '<?php echo $owner->phone; ?>',
                geds : feed.tn,
            },{
                item : '<?php echo elgg_echo("geds:sync:table:field:mobile"); ?>',
                property : 'mobile',
                gcc : '<?php echo $owner->mobile; ?>',
                geds : feed.tn,
            }];
           //data table setup
        $('#onboard-table').bootstrapTable({
                //headers
                columns: [{
                    field: 'state',
                    checkbox: true,
                }, {
                    field: 'item',
                    title: '<?php echo elgg_echo("geds:sync:table:field"); ?>'
                },/*{
                    field: 'gcc',
                    title: '<?php echo elgg_echo("geds:sync:table:current"); ?>'
                },*/ {
                    field: 'geds',
                    title: '<?php echo elgg_echo("geds:sync:table:ingeds"); ?>'
                }],
                //data set above
                data: feedData
            });

           	var gccUname = '<?php echo $owner->username;?>';
           	var gcpUname = '<?php echo $gcpuser; ?>';
           	if (!gcpUname){
           		var pushObj = {
            		requestID: 'X03',
            		authorizationID: authIDsetting,
            		requestSettings:{
            			DN: feed.dn,
            			//GCpediaUsername: gcpUname,
            			GCconnexUsername: gccUname
            		}
            	};
           	}else{
           		var pushObj = {
            		requestID: 'X03',
            		authorizationID: authIDsetting,
            		requestSettings:{
            			DN: feed.dn,
            			GCpediaUsername: gcpUname,
            			GCconnexUsername: gccUname
            		}
            	};
           	}
           	//alert(feed.dn);

            //alert(JSON.stringify(pushObj2));
            $.ajax({
            	type: 'POST',
                contentType: "application/json",
                url: gedsURL,
                data: JSON.stringify(pushObj),
                dataType: 'json',
                success: function (feed) {
                	//alert(JSON.stringify(feed));
                }
            });

            $('#onboard-table').prepend("<p class='mrgn-bttm-sm'>" + "<?php echo elgg_echo("onboard:geds:select"); ?>" + "</p>");
            $('#onboard-table').append("<div class='mrgn-tp-md'>" + "<?php echo str_replace("\n", "", str_replace("\r\n", "", elgg_echo("geds:sync:info"))); ?>" + "</div>");

        //reset height of display
            $('#syncError').css('min-height', '0px')
        }
        /************************************************************************
        * saveData()
        * purpose: Grabs selected data from data table and addational data including
        *          department accronym, location and org data. Passes data to
        *          saveGEDSProfile action file to be saved as metadata
        *************************************************************************/
        function saveData(){
            //var i = 0;
            //grabs selections from table
            var data = $('#onboard-table').bootstrapTable('getSelections');
            //builds location js object
            var location = {
                street : personFeed.address,
                city : personFeed.city,
                province : personFeed.province,
                country : personFeed.country,
                pc : personFeed.pc,
                building : personFeed.building,
                floor : personFeed.floor
            };
            //elgg ajax action call
            elgg.action('geds_sync/saveGEDSProfile', { //target
                data: {
                    'guid': '<?php echo $owner->guid; ?>', //page owner guid
                    'data': JSON.stringify(data), //selections from table
                    'depAcc' : personFeed.departmentAcronym, // departmental acroynm. (eg: TBS). not being used but may come in handy someday
                    'orgStruct' : JSON.stringify(personFeed.orgStructure), //JSON string rep org tree
                    'orgStructFr' : JSON.stringify(orgStructFrString), // french org tree string
                    'address' : JSON.stringify(location), //JSON string of address details
                    'addressFr' : JSON.stringify(locationFr), //french.
                    'gedsDN': personFeed.dn,
                },
                success: function() {
                    //close the modal
                    //window.location.replace(window.location.href); //reload page so user can see changes

                    //update profile strength widget if in profile-onboard
                    if ('<?php echo elgg_get_context() ?>' == 'profile-onboard') {
                        //update profile strength percent
                        elgg.get('ajax/view/profileStrength/info', {
                            success: function (output) {

                                $('#profileInfo').html(output);

                            }
                        });
                    }

                    //move to next step
                    elgg.get('ajax/view/welcome-steps/stepTwo', {
                        data: {
                            geds: true // querystring
                        },
                        success: function (output) {

                            $('#welcome-step').html(output);

                        }
                    });

                    skipStep();
                }
            });

        }


    //skip button code
    //skip to next step
    function skipStep() {


        if( '<?php echo elgg_get_context() ?>' == 'profile-onboard' ){ //profile onboard
            elgg.get('ajax/view/profile-steps/stepTwo', {
                success: function (output) {
                    changeStepProgress(3);
                    $('#step').html(output);

                    elgg.get('ajax/view/profileStrength/info', {
                        success: function (output) {

                            $('#profileInfo').html(output);
                        }
                    });
                }
            });
        } else {                                            //welcome onboard
            $('#skip').on('click', function () {
                elgg.get('ajax/view/welcome-steps/stepTwo', {
                    success: function (output) {

                        $('#welcome-step').html(output);

                    }
                });
            });
        }
    };


</script>
<style>
    #onboard-table thead {
        background: #567784;
        color: white;
    }

    .geds-use {
        padding: 5px;
        border: 1px solid #ddd;
        height: 100px;
        width:100%;
        overflow-y: scroll;
    }
</style>
