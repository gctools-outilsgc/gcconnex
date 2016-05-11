<?php

/*
 * Javascript file for the Ajaxy display in the Notifications within the user settings
 * Author: Nicholas P
 */

?>

 $(document).ready(function() {
    //alert('Im registered');
    //function to unsub from content from user settings page
    $('.unsub-button').on('click', function() {
        var this_thing = $(this);
        var guid = parseInt($(this_thing).attr('id'));
        
        elgg.action('cp_notify/unsubscribe', { //perform the unsub action
                data: {'guid':guid},
                success: function(data) {
                    //alert($(this_thing).attr('id'));
                  $(this_thing).closest('.list-break').fadeOut();
                }
        })
    })
})