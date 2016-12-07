<?php

/**
 * language_ajax.php
 *
 * Ajax for toogle language. Switch the content of a section when user click on the link in the indicator box of the page.
 *
 * @author steph4104
 */
 
?>
<!-- d = id of the div where the content will be -->
function change_fr(d){

<!-- f = french content -->
var spanfr = document.getElementById('fr_content');
var f = spanfr.innerHTML || spanfr.textContent;

<!-- e = english content -->
var spanen = document.getElementById('en_content');
var e = spanen.innerHTML || spanen.textContent;;


    $(d).html('<div id="loading-image"  class="wet-ajax-loader"><img src="../../../mod/wet4/graphics/loading.gif" alt="loading content"/></div>');

    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(d).html(f);
        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_en(e,f,d);
};

function change_en(d){

var spanfr = document.getElementById('fr_content');
var f = spanfr.innerHTML || spanfr.textContent;

var spanen = document.getElementById('en_content');
var e = spanen.innerHTML || spanen.textContent;;


    $(d).html('<div id="loading-image"  class="wet-ajax-loader"><img src="../../../mod/wet4/graphics/loading.gif" alt="loading content"/></div>');

    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(d).html(e);
        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_fr(e,f,d);
};

function change_title_fr(e,f,d){

      var link_available ='<span id="indicator_language_fr" onclick="change_fr(\'' + d + '\');"><span id="en_content" class="testClass hidden" >'+e+'</span><span id="fr_content" class="testClass hidden" >'+f+'</span>Ce contenu est disponible en français. <span class="fake-link" id="fake-link-1">Cliquer ici pour voir</span></span>';
    
    $("#change_language").html(link_available)
}

function change_title_en(e,f,d){

    var link_available ='<span id="indicator_language_en" onclick=\"change_en(\'' + d + '\');\"><span id="en_content" class="testClass hidden" >'+e+'</span><span id="fr_content" class="testClass hidden" >'+f+'</span>This content is available in english. <span class="fake-link" id="fake-link-1">Click here to see</span></span>';

    $("#change_language").html(link_available)
}

