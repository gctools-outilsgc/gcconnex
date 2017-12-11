<?php

/**
 * language_ajax.php
 *
 * Ajax for toogle language. Switch the content of a section when user click on the link in the indicator box of the page.
 *
 * @author steph4104
 */
 
?>

// d = id of the div where the content will be -->
function change_fr(d,t,s){

// f = french content -->
var spanfr = document.getElementById('fr_content');
var f = spanfr.innerHTML || spanfr.textContent;

var spanfr_title = document.getElementById('fr_title');
var f_title = spanfr_title.innerHTML || spanfr_title.textContent;

// e = english content -->
var spanen = document.getElementById('en_content');
var e = spanen.innerHTML || spanen.textContent;

var spanen_title = document.getElementById('en_title');
var e_title = spanen_title.innerHTML || spanen_title.textContent;



    $(d).html('<div id="loading-image"  class="wet-ajax-loader"><img src="' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif" /></div>');
    $(t).html('<div id="loading-image"  class="wet-ajax-loader"><img src= "' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif"/></div>');
    $(s).html('<div id="loading-image"  class="wet-ajax-loader"><img src= "' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif"/></div>');

    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(d).html(f);
            $(t).html(f_title);
            $(s).html(f_title);

        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_en(e,e_title,f_title,f,d,t,s);
};

function change_en(d,t,s){

var spanfr = document.getElementById('fr_content');
var f = spanfr.innerHTML || spanfr.textContent;

var spanfr_title = document.getElementById('fr_title');
var f_title = spanfr_title.innerHTML || spanfr_title.textContent;

var spanen = document.getElementById('en_content');
var e = spanen.innerHTML || spanen.textContent;

var spanen_title = document.getElementById('en_title');
var e_title = spanen_title.innerHTML || spanen_title.textContent;


    $(d).html('<div id="loading-image"  class="wet-ajax-loader"><img src= "' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif" alt="loading content"/></div>');
    $(t).html('<div id="loading-image"  class="wet-ajax-loader"><img src= "' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif" alt="loading content"/></div>');
    $(s).html('<div id="loading-image"  class="wet-ajax-loader"><img src= "' + elgg.get_site_url() + 'mod/wet4/graphics/loading.gif" alt="loading content"/></div>');

    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(d).html(e);
            $(t).html(e_title);
            $(s).html(e_title);

        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_fr(e,e_title,f_title,f,d,t,s);
};

function change_title_fr(e,e_title,f_title,f,d,t,s){

      var link_available ='<span id="indicator_language_fr" onclick=\"change_fr(\'' + d + '\',\'' + t + '\',\'' + s + '\');\"><span id="en_title" class="testClass hidden" >'+e_title+'</span><span id="fr_title" class="testClass hidden" >'+f_title+'</span><span id="en_content" class="testClass hidden" >'+e+'</span><span id="fr_content" class="testClass hidden" >'+f+'</span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>';
        
      
    $("#change_language").html(link_available)
}

function change_title_en(e,e_title,f_title,f,d,t,s){

    var link_available ='<span id="indicator_language_en" onclick=\"change_en(\'' + d + '\',\'' + t + '\',\'' + s + '\');\"><span id="en_title" class="testClass hidden" >'+e_title+'</span><span id="fr_title" class="testClass hidden" >'+f_title+'</span><span id="en_content" class="testClass hidden" >'+e+'</span><span id="fr_content" class="testClass hidden" >'+f+'</span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>';

    $("#change_language").html(link_available)
}

