<?php

/**
 * language_ajax.php
 *
 * Ajax for toogle language. Switch the content of a section when user click on the link in the indicator box of the page.
 *
 * @author steph4104
 */
 
?>
alert('Hello everyone');


function rotate(){

alert('Bonjour le monde2');
var f = 'test';

    $('.test').html('<div id="loading-image"  class="wet-ajax-loader"><img src="../../../mod/wet4/graphics/loading.gif" alt="loading content"/></div>');

    $.ajax(
    {
        type : "post",
        data: {action: 'test'},
        success : function(output) {
                      
                      $('.tidypics-photo').html($(output).find(".tidypics-photo"));
                      $('.tidypics-photo').attr('src', 'http://localhost/gcconnex/photos/thumbnail/588/large/largethumb1481811100minions.jpg' + '?' + new Date().getTime());
        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });

};

<?php

function insert() {
    echo "The insert function is called.";
    exit;
}