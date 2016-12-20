/*
* stream_wire.js
*
* Streaming Wire JS - Does things
*
* @author Nick github.com/piet0024
*/

$(document).ready(function(){
    
    //Setting an interval to time when the ajax calls should be made
    // TODO Test if we are on the newsfeed or wire
    
    stream_count();
});

//This function counts 2 minutes while a streaming page is loaded
var interval = null;
function stream_count(){
    
   interval =  window.setInterval(check_for_posts(),10000);
}

//Stop the timer and add a call to action to the DOM
function stop_stream_count(){
    window.clearInterval(interval);
    //Animate in a div
    $('.new-wire-holder').prepend('<div class="stream-new-wire" style="display:none;">There are new posts. Click here to load.</div>');
    $('.stream-new-wire').show('slow');
    $('.stream-new-wire').on('click', function(){
        loadNewPosts();
    })
}

// Checking to see if there are any new wire posts
function check_for_posts(){
        var firstPostOnPage = $('.elgg-item-object-thewire .elgg-content').first().text();
        var site = elgg.normalize_url();
        var first_post ='';
            $.ajax({
                type: 'GET',
                contentType: "application/json",
                url: site+'services/api/rest/json/?method=get.wire',
                dataType: 'json',
                success: function(feed){
                    
                   var test_array = feed.result.posts.post_0.text;
                    if(comparePosts(test_array, firstPostOnPage)){
                        //True - Keep looking for posts
                        stream_count();
                        console.log('true - keep going');
                    }else{
                        //False - there is a new post. We can stop looking now.
                        stop_stream_count();
                        console.log('false - stopping now');
                    }
                },
                error: function(request, status, error) { 
                   console.log('error');

                }
            });
        }
    

 function comparePosts(post, onPage){

         if(post == onPage){
             //Same wire post
             return true;
        }else{
            //a new post was made
            return false;
        }

 }

function loadNewPosts(){
    $('.stream-new-wire').html('<i class="fa fa-refresh fa-spin fa-1g fa-fw"></i><span class="sr-only">Loading...</span>');
    var postsOnPage = $('.elgg-item-object-thewire .elgg-content');
    var existingArray =[];
    var queryArray = [];
    for (i=0; i < postsOnPage.length; i++){
        //Push the existing posts to an array to compare with 
        existingArray.push($(postsOnPage[i]).text());
    }
    
    var site = elgg.normalize_url();
        $.ajax({
                type: 'GET',
                contentType: "application/json",
                url: site+'services/api/rest/json/?method=get.wire',
                dataType: 'json',
                success: function(feed){
                    var postArray = feed.result.posts;
                    for (var num in postArray){
                        queryArray.push(postArray[num].text);
                        
                    }
                    var diff = $(queryArray).not(existingArray).get();
                    
                    
                    ajax_path = 'ajax/view/ajax/wire_posts'; //here is my ajax view :3
                        //console.log(diff.length);
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
    

    //console.log(postsOnPage.length);
}

    
    
