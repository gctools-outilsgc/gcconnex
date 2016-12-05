<?php

/**
 * group_ajax - this extends the JS to add a function that will run when group tabs are clicked. 
 *
 * group_ajax - When on a group, a user can click a tab and this will perform an ajax call to grp_ajax_content view. This will pass it the sub type (ex: discussion, file, blog etc) and group guid so we know what content to fetch. Each tab has a class that contains it's subtype, when clicked the subtype is cut up and tested if it is a single word, or the word more or active. If what was clicked on is an acutal subtype it will fetch a list of that subtype, add a hidden loading message for screen readers, append it to an empty div, and focus on the add content button.
 *
 * @version 1.0
 * @author Owner
 */
 //get the group guid to pass through to ajax
 //it doesn't like this
//$current_group_guid = elgg_get_page_owner_entity()->getGUID();
 
?>

function change_fr(d){

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

