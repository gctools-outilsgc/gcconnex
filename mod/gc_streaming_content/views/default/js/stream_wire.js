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
    
    $('.elgg-item-object-thewire').parent().prepend('<div class="stream-new-wire">There are new posts. Click to load.</div>');
}


//Empty global array to hold the first two wire posts
var holder =[];
// Checking to see if there are any new wire posts
function check_for_posts(){
        var site = elgg.normalize_url();
        var first_post ='';
            $.ajax({
                type: 'GET',
                contentType: "application/json",
                url: site+'services/api/rest/json/?method=get.wire',
                dataType: 'json',
                success: function(feed){
                    
                   var test_array = feed.result.posts.post_0.text;
                    if(comparePosts(test_array)){
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
    

 function comparePosts(post){
     holder.push(post);
     if(holder.length >2){
         holder.splice(0,1);
         if(holder[0] == holder[1]){
             //Same wire post
             return true;
            
        }else{
            //a new post was made
            return false;
        }
     }
     
     return true;
 }


    
    
