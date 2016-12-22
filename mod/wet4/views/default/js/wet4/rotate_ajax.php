<?php

/**
 * language_ajax.php
 *
 * Ajax for rotation image with php. Rotate image after a click action. Call rotation function from php to rotate image file.
 *
 * @author steph4104
 */
 
?>
alert('Hello everyone');


function rotate_ajax(image_src){

alert('Bonjour le monde2');
var f = 'test';

    $.ajax(
    {
        type : "post",
        data: {action: 'rotation'},
        success : function(output) {
                      
                      $('.tidypics-photo').html($(output).find(".tidypics-photo"));
                      $('.tidypics-photo').attr('src', image_src + '?' + new Date().getTime());
        },

    });

};

<?php
