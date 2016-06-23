<?php

/**
 * group_ajax - this extends the JS to add a function that will run when group tabs are clicked. 
 *
 * group_ajax - When on a group, a user can click a tab and this will perform an ajax call to grp_ajax_content view. This will pass it the sub type (ex: discussion, file, blog etc) and group guid so we know what content to fetch. Each tab has a class that contains it's subtype, when clicked the subtype is cut up and tested if it is a single word, or the word more or active. If what was clicked on is an acutal subtype it will fetch a list of that subtype, add a hidden loading message for screen readers, append it to an empty div, and focus on the add content button.
 *
 * @version 1.0
 * @author Owner
 */
 //get the group guid to pass through to ajax
 //it doesn't like this
//$current_group_guid = elgg_get_page_owner_entity()->getGUID();
 
?>


$(document).ready(function() {
    $('.tabMenuGroup li').data("hasLoaded", 'false'); //set data on tabs that say they have not loaded
    //Document is ready, Click on the tabs
    $('.wet-group-tabs li').on('click', function () {
        var tabName = $(this).attr('class'); // get the tab class
        var sub_type_array = tabName.split('-');
        var sub_type = sub_type_array.pop(); //the last word of the class is the subtype
        var ajax_path; //declare the view path var
        var params; //declare the params var
        var base_url; //declare base url var
        var group_guid = elgg.get_page_owner_guid();

        
        //alert(sub_type);
        ajax_path = 'ajax/view/ajax/grp_ajax_content'; //here is my ajax view :3

        if (sub_type == 'discussion') {//modify certain subtypes so elgg knows what we want 
            sub_type = 'groupforumtopic';
           
        } else if(sub_type == 'pages'){
            sub_type = 'page_top';
        } else if (sub_type =='groups'){
            sub_type ='related';
            //alert(sub_type);
        }

        else if(sub_type =='search' || sub_type == 'about' || sub_type=='gcforums'){
            sub_type ='not going to work'; //make the string many words to it won't run the ajax call
        }

        //$('#' + sub_type).children('.wet-ajax-loader').attr('aria-hidden', 'false');
        
         $('.elgg-page-messages ul').append('<li class="wb-inv" aria-live="assertive"><?php echo elgg_echo('wet:groupLoading');?></li>')
        params = { 'group_guid': group_guid, 'sub_type': sub_type }; //put the guid and subtype in var
       // alert(sub_type.indexOf(' '));
        if(sub_type.indexOf(' ') == -1 && $(this).data("hasLoaded")== 'false'){
            //sometimes when you click on tabs like 'morehasLoaded' sub_type becomes a long string and might query for data that won't exist.
            //I only want it to pass single words like 'blog' and not 'more tab active' which it not a subtype
            //We also test if the user has loaded this tab so it will not perform the ajax call again 
           //alert('might work');
            
            elgg.get(ajax_path, {
                data: params,
                dataType: 'html',
                success: function (data) {
                    //Do the Ajax call and show me the money
                    //alert(data);

                    $('#' + sub_type).append(data); //add the list from the view
                    $('#' + sub_type).children('.wet-ajax-loader').remove();
                    if(sub_type == 'groupforumtopic'){
                        $('#' + sub_type + ' .quick-discuss-action-btn').focus();
                    }else{
                        $('#' + sub_type + ' .btn-primary').focus();
                    }
                    
                   
                    
                }
            });
        } 

        $(this).data("hasLoaded", 'true'); //we loaded content here so we won't do it again :3
    });

    
    });

    

