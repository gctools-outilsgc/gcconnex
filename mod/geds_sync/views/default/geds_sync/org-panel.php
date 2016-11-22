<?php
/*
* This is an AJAX view that builds the dynamic content the appears under a user's organization tab.
* Though this is itself a AJAX, it makes its own AJAX calls to build the Org and people divs
* Not sure if daisy chaining ajax calls is the best this to do or not, but i couldnt think of how else to do it. 
*
* GETs input from geds_org view as JSON string of organization. Echo's are returned as output to geds_org view.
*/

//Make sure this is xhr request
if (elgg_is_xhr()) {
    //get JSON string of org data
	$orgString = get_input('orgData');
    //transform JSON string to PHP object
	$orgs = json_decode($orgString);
	//$baseDn;
   
    //Build the div to display the organization list
    echo "<div class='panel panel-custom'>";
    echo "<div class='panel-heading profile-heading clearfix'>";
    echo "<h3 class='profile-info-head pull-left clearfix'>".elgg_echo("geds:org:orgTitle")."</h3>"; // <h3> title
    echo "</div>"; //close 'elgg-head'
	echo "<div class='elgg-body' id='orgTree'>";

    $x = 10; //used for indentation.
	foreach ($orgs as $org) {
		?>
            <div style="padding-left:<?php echo 2*$x; ?>px;"> <!-- adds indentation for each successive item in org tree -->
                <img  height='10px' width='10px' src='<?php echo elgg_get_site_url(); ?>/mod/geds_sync/vendors/musicplayer14.png' /> <!-- arrow icon -->
			    <a href='javascript:void(0)' onclick='browseOrg("<?php echo $org->DN; ?>");'> <?php echo $org->name; ?></a></br> <!-- link triggers authSearchOrg() function -->
            </div>
		<?php
        $x+=5; //increase indent
		
		//$baseDn = $org->DN;
	}
	
	//echo "</div></br>";
	echo "</div></div>"; //close <div class='elgg-body' id='orgTree'> // close <div class='elgg-module-featured'>

    //builds empty divs for display of people in selected org
    echo "<div id='peopleContainer'>";
   	echo "<div id='orgPeople'></div>";
    echo "</div>";
    echo "</br></br></br></br></br>"; //extra space on bottom of page - ie scroll bar fix

?>
	<script type="text/javascript">
       // var dn= []; //global domain name array
        //var auth;

        //plugin setting for auth key
        var authIDsetting = "<?php echo elgg_get_plugin_setting('auth_key','geds_sync'); ?>";

        //url for GEDS service
        var gedsURL = "<?php echo elgg_get_plugin_setting('geds_url','geds_sync'); ?>";



        /*
        * function authSearchOrg(orgDN)
        * orgDN - the domain name string for the organizational unit. Used by GEDS as a unique identifier and as a search key.
        * function takes organization domain name passed from link and uses it to search GEDS for list of organizations under it and people in it.
        *
        * !!!!!!!!!!!!!!!!!!!not used any longer!!!!!!!!!!!!!!!!!!!!!!
        * 
        */
		function authSearchOrg(orgDN){
			
            //login connection string to be passed to GEDS for authentication
			$.ajax({
                type: 'POST',
                contentType: "application/json",
                data: loginObj, //login JSON string set above
                dataType: 'json',
                success: function (feed) { 
                   	browseOrg(feed.authorizationID, orgDN); // pass returned id and org Domain name to browseOrg function
                },
                error: function() { 
                    //do nothing. coudl be used for debugging
                }
            });
		}

        /*
        * function browseOrg(authId, orgDN)
        * authId - authentication id obtained in function authSearchOrg. Used to make calls against GEDS
        * orgDN - Domain name of org to search.
        * Purpose: Function searches GEDS for orgDN and builds new content of profile organizations tab. 
        *          Results will contain new Org tree as well as list of people in that level of the org tree.
        */
		function browseOrg(orgDN){
            
			//search string. Searches uses auth id and organization dmomain name pased in as arguments
			var searchObj = "{\"requestID\" : \"B02\", \"authorizationID\" : \""+authIDsetting+"\", \"requestSettings\" : {\"baseDN\" : \""+orgDN+"\"} }";
            
            $.ajax({
                type: 'POST',
                contentType: "application/json",
                url: gedsURL+'/<?php echo get_current_language(); ?>/GAPI/',//uses 2 letter language code for url
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
                        elgg.post('ajax/view/geds_sync/org-people', { //ajax view to call org-people. builds the people list
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

                    //get the count of organizations in tree - includes orgs contained within the org being searched
                	count = feed.requestResults.listEntryCount.organizationListEntries;
                	//make sure there are orgs to pass in
                    if (count != 0 && count != null){
                    	//alert("I am an alert box!");
                		$("#orgTree").empty();//empty view before adding new information
                        elgg.post('ajax/view/geds_sync/org-orgs', { //elgg ajax call. Builds org list
                            data: {
                                orgTreeData: JSON.stringify(feed.requestResults.organizationList) // list of organizations found passed to view
                            },
                            success: function (output) {
                                $('#orgTree').append(output); //output returned from orgs-orgs ajax call
                            },
                            error: function(xhr, status, error) { 
                                //do nothing - debug code could go here
                            }
                        });                        
                		
                	}
                	
                },
                error: function(request, status, error) { 
                   //do nothing - debug code could go here
                }
            });
		}
	</script> <!--end script -->
<?php // end if xhr
    }
