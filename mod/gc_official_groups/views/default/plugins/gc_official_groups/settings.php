<?php
/*
* Formats the admin setting page to add official groups. Script takes the url and gets the guid out of it, performs the action and returns the feedback
*
* @version 1.0
* @author Nick
*/

$body = elgg_view('page/elements/add_off_group');


echo $body;

?>

<script>
$(document).ready(function(){
    var group_url;
    $('#group_url').on('blur', function(){
        //This grabs the value of the text input
        group_url = $(this).val();
    })
    $('#add_group_btn').on('click', function(){
        //alert(group_url);
        
        var group_guid_array = group_url.split("/");
        var group_guid = group_guid_array.slice(0,-1);
        group_guid = parseInt(group_guid.slice(-1)[0]);
        console.log(group_guid);
        
        if(group_guid){
            //If we get a guid we can work with we'll send it to the action
            elgg.action('add_off_group',{
                data:{'guid':group_guid},
                success: function(data){
                    //Feedback gets sent back
                    $('.off-group-add-feedback').text(data.output.confirm);
                    $('.off-group-add-feedback').css({"color":data.output.color,});
                    console.log(data.output.confirm);
                }
            })
        }else{
            //This ain't no GUID I ere heard of
            console.log('aint no number i ever seen you dun goofed');
        }
        

    });
})
</script>