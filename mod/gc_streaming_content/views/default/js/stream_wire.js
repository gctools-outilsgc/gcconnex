/*
* stream_wire.js
*
* Streaming Wire JS - Listens on the wire page for new wire posts. It then loads the new wire posts to the DOM
*
* @author Nick github.com/piet0024
*/

$(document).ready(function(){
    
    //Setting an interval to time when the ajax calls should be made
    // TODO Test if we are on the newsfeed or wire
    var sitePage = window.location.href;
    var theWireUrl = elgg.normalize_url() + 'thewire/all';
    var newsFeedUrl = elgg.normalize_url() + 'newsfeed';
    if(sitePage == theWireUrl || sitePage == newsFeedUrl ||sitePage == theWireUrl+'#' ||sitePage == newsFeedUrl+'#'){
       stream_count(); 
    }
});

//This function counts 2 minutes while a streaming page is loaded
var interval = null;
function stream_count(){
    
   interval =  window.setInterval(check_for_posts(),10000);
}



//Stop the timer and add a call to action to the DOM
function stop_stream_count(){
    window.clearInterval(interval);
    //Animate in a div button 
    $('.new-wire-holder').prepend('<div class="stream-new-wire" style="display:none;">'+elgg.echo('stream:new_wire')+'</div>');
    $('.stream-new-wire').show('slow');
    $('.stream-new-wire').on('click', function(){
        loadNewPosts();
    })
}

// Checking to see if there are any new wire posts
function check_for_posts(){
    //What are the posts currently loaded on the page?
    //Get the guid from the post id
    var firstPostOnPage = $('.elgg-item-object-thewire .elgg-content').first().parent().parent().parent().attr('id');
    if (firstPostOnPage) {
        var postGUID = firstPostOnPage.split("-");
        postGUID = postGUID.slice(2);
    
        var site = elgg.normalize_url();
        var first_post ='';
        //Ping the api to see what the latest wire post. This will only grab one post
        $.ajax({
            type: 'GET',
            contentType: "application/json",
            url: site+'services/api/rest/json/?method=get.wire&limit=1',
            dataType: 'json',
            success: function(feed){
                //Get the latest post and compare that post to the post that is on the page.
               var test_array = feed.result.posts.post_0.guid;
               
                if(comparePosts(test_array, postGUID)){
                    //True - Keep looking for posts
                    setTimeout(stream_count, 10000);
                    
                }else{
                    //False - there is a new post. We can stop looking now.
                    stop_stream_count();
                
                }
            },
            error: function(request, status, error) { 
               console.log('error');

            }
        });
    }
}
    

 function comparePosts(post, onPage){
     //This compares the guids
         if(post == onPage){
             //Same wire post
             return true;
        }else{
            //a new post was made
            return false;
        }

 }

function loadNewPosts(){
    //Goes through how 
    //Spinner
    $('.stream-new-wire').html('<i class="fa fa-refresh fa-spin fa-1g fa-fw"></i><span class="sr-only">Loading...</span>');
    //get all of the wire posts currently loaded on the page.
    var postsOnPage = $('.elgg-item-object-thewire .elgg-content');
    var existingArray =[];
    var queryArray = [];
    for (i=0; i < postsOnPage.length; i++){
        //Push the existing posts to an array to compare with
        
        var post_ = $(postsOnPage[i]).parent().parent().parent().attr('id');
        var postGUID = post_.split("-");
        postGUID = postGUID.slice(2);
        //This needs to be an int not a string
        postGUID = parseInt(postGUID.toString());
        existingArray.push(postGUID);
    
    }
  
    var site = elgg.normalize_url();
        $.ajax({
            //get the latest wire posts from the API
                type: 'GET',
                contentType: "application/json",
                url: site+'services/api/rest/json/?method=get.wire',
                dataType: 'json',
                success: function(feed){
                    //Put the latest posts in an array
                    var postArray = feed.result.posts;
                    for (var num in postArray){
                        queryArray.push(postArray[num].guid);
                        
                    }
                    //What is different from what is on the page and what is in the db?
                    var diff = $(queryArray).not(existingArray).get();
                    
                    //Loggin this to see we're getting back on preprod
                    
                    ajax_path = 'ajax/view/ajax/wire_posts'; //here is my ajax view :3
                    //Bring back the latests posts and add them to the page
                    elgg.get(ajax_path, {
                        data: {'limit': diff.length},
                        dataType: 'html',
                        success: function (data) {
                        $('.posts-holder').prepend(data);
                        $('.stream-new-wire').remove();
                            stream_count();
                    }
                        
                    });
                },
                error: function(request, status, error) { 
                   console.log('error');

                }
            });

}

    
    
