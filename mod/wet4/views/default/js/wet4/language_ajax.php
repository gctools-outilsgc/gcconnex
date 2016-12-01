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

alert('hello2');

function change_fr(e,f){
    var label = f;
    $(".blog-post").html('<div id="loading-image"  class="wet-ajax-loader"><img src="../../../mod/wet4/graphics/loading.gif" alt="loading content"/></div>');
 alert('First: '+e+' Second: '+f);
    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(".blog-post").html(label);
        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_en(e,f);
};

function change_en(e,f){
    var label = e;

    alert('First: '+e+' Second: '+f);
    $(".blog-post").html('<div id="loading-image"  class="wet-ajax-loader"><img src="../../../mod/wet4/graphics/loading.gif" alt="loading content"/></div>');

    $.ajax(
    {
        type : "post",
        dataType: "html",
        cache: false,
        success : function(response)
        {
            $(".blog-post").html(label);
        },
        complete: function(){
        $('#loading-image').hide(); 
      }
    });
    change_title_fr(e,f);
};

function change_title_fr(e,f){

    var link_available = '<a id="indicator_language_fr"  onclick=\'change_fr("'+e+'", "'+f+'")\'  href="#"><label class="testClass hidden" ><?php echo $blog->description2; ?></label><span id="indicator_text">Contenu disponible en français</span></a>';
    $("#change_language").html(link_available)
}

function change_title_en(e,f){

     var link_available = '<a id="indicator_language_en" onclick=\'change_en("'+e+'", "'+f+'")\' href="#"><label class="testClass hidden" ><?php echo $blog->description; ?></label><span id="indicator_text">Content available in english</span></a>';
    $("#change_language").html(link_available)
}

