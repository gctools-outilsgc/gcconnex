/**
* stream_newsfeed.js
*
* Streaming Newsfeed JS - Listens on the newsfeed page for new newsfeed items. It then loads the new newsfeed items to the DOM
*
* @author Nick github.com/piet0024
* @author Ilia github.com/phanoix
**/

$(document).ready(function(){
    
    //Setting an interval to time when the ajax calls should be made
    var sitePage = window.location.href;
    var newsFeedUrl = elgg.normalize_url() + 'newsfeed';
    if( sitePage == newsFeedUrl ||sitePage == newsFeedUrl+'/' ||sitePage == newsFeedUrl+'/#' ){
       newsfeed_stream_count(); 
    }
});

//This function counts 2 minutes while a streaming page is loaded
var interval = null;
function newsfeed_stream_count(){
    
   interval =  window.setInterval(check_for_newsfeed_items(),10000);
}



//Stop the timer and add a call to action to the DOM
function stop_stream_newsfeed_count(){
    window.clearInterval(interval);
    //Animate in a div button 
    $('.new-newsfeed-holder').prepend('<div class="stream-new-newsfeed" style="display:none;">'+elgg.echo('stream:new_newsfeed')+'</div>');
    $('.stream-new-newsfeed').show('slow');
    $('.stream-new-newsfeed').on('click', function(){
        loadNewNewsfeedItems();
    })
}

// Checking to see if there are any new newsfeed items
function check_for_newsfeed_items(){
    //What are the posts currently loaded on the page?
    //Get the guid from the post id
    var firstPostOnPage = $('#activity .elgg-list-river .elgg-item').first().attr('id');
    if (firstPostOnPage) {
        var postID = firstPostOnPage.split("-");
        postID = postID.slice(2);
    
        var site = elgg.normalize_url();
        var first_post ='';
        //Ping the api to see what the latest newsfeed item. This will only grab one post
        elgg.get('ajax/view/ajax/newsfeed_check', {
            data: {'userid': elgg.get_logged_in_user_guid, 'limit': 1},
            dataType: 'json',
            success: function(response){
                //Get the latest post and compare that post to the post that is on the page.
               //var test_array = response;
               
                if(comparePosts(response[0].id, postID[0])){
                    //True - Keep looking for posts
                    setTimeout(newsfeed_stream_count, 10000);
                    
                }else{
                    //False - there is a new post. We can stop looking now.
                    stop_stream_newsfeed_count();
                
                }
            },
            error: function(request, status, error) { 
               console.log('error');

            }
        });
    }
}

// is there a point to this?
 function comparePosts(post, onPage){
     //This compares the guids
         if(post == onPage){
             //Same newsfeed item
             return true;
        }else{
            //a new post was made
            return false;
        }

 }

function loadNewNewsfeedItems(){
    //Goes through how 
    //Spinner
    $('.stream-new-newsfeed').html('<i class="fa fa-refresh fa-spin fa-1g fa-fw"></i><span class="sr-only">Loading...</span>');

    //Get the guid from the post id
    var firstPostOnPage = $('#activity .elgg-list-river .elgg-item').first().attr('id');
    var postID = firstPostOnPage.split("-");
    postID = postID.slice(2);

    ajax_path = 'ajax/view/ajax/newsfeed_items'; //here is my ajax view :3
    //Bring back the latests posts and add them to the page
    elgg.get(ajax_path, {
        data: {'userid': elgg.get_logged_in_user_guid, 'latest': postID[0]},
        dataType: 'html',
        success: function (data) {
            $('.newsfeed-posts-holder').prepend(data);
            $('.stream-new-newsfeed').remove();
            newsfeed_stream_count();
        }
    });
}

    
    
