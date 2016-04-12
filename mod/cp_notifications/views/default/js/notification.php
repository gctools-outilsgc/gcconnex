<?php

/**
 * notification short summary.
 *
 * notification description.
 *
 * @version 1.0
 * @author Owner
 */

?>

 $(document).ready(function() {
    //alert('Im registered');
//function to unsub from content from user settings page
    $('.unsub-button').on('click', function(){
        var this_thing = $(this);
        var guid = parseInt($(this_thing).attr('id'));
        
        elgg.action('cp_notify/unsubscribe', { //perform the unsub action
                data: {'guid':guid},
                success: function(data){
                    //alert($(this_thing).attr('id'));
                  $(this_thing).closest('.list-break').fadeOut();
                }
            })
    })
})