/*
 * filename: share-button.js
 * author: Troy T. Lawson
 * purpose: to build and inject the share button onto the source page.
 * example call to script:
 * <script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//gcconnex.tools.gc.ca/mod/gc_api/widget/en/share-button.js";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'gcconnex-jssdk'));</script>

	<div class="gcc-share-button" 
		data-href="http://gcpedia.tools.gc.ca/shareTest" 
		data-lang="en" >
		
	</div>
 * 
 * data-lang attribute in div determins button language
 */

(function() {

// Localize jQuery variable
var jQuery;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.4.2') {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src",
        "http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    if (script_tag.readyState) {
      script_tag.onreadystatechange = function () { // For old versions of IE
          if (this.readyState == 'complete' || this.readyState == 'loaded') {
              scriptLoadHandler();
          }
      };
    } else { // Other browsers
      script_tag.onload = scriptLoadHandler;
    }
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
    jQuery = window.jQuery;
    main();
}

/******** Called once jQuery has loaded ******/
function scriptLoadHandler() {
    // Restore $ and window.jQuery to their previous values and store the
    // new jQuery in our local jQuery variable
    jQuery = window.jQuery.noConflict(true);
    // Call our main function
    main(); 
}

/******** Our main function ********/
function main() { 
    jQuery(document).ready(function($) { 
        // We can use jQuery 1.4.2 here
        var site = 'https://gcconnex.gc.ca/';
        /******* Load CSS *******/
        var css_link = $("<link>", { 
            rel: "stylesheet", 
            type: "text/css", 
            href: site+"mod/gc_api/widget/en/shareWidget.css" 
        });
        css_link.appendTo('head'); //add css file to source 
       
       	//get share button dom object from source page
        var shareButton = $('.gcc-share-button');
        //create and add gcconnex image
        var buttonImg = document.createElement("IMG");
        buttonImg.src = site+'mod/wet4/graphics/gc_connex_icon.gif';
        //create div to contain button img
        var buttonSpan = document.createElement("DIV");
        buttonSpan.className = 'share-btn-icon share-float';
        //add image to container div
        buttonSpan.appendChild(buttonImg);
        //add image container to button
        shareButton.append(buttonSpan);
        
        //create div to contain button text
        var textSpan = document.createElement("DIV");
        textSpan.className = 'share-float';
        //english and french text nodes are created
        e = document.createTextNode("Share on GCconnex");
        f = document.createTextNode("Partager sur GCconnex");
        //append english and french text to proper button 
        $('.gcc-share-button[data-lang="en"]').append(textSpan.appendChild(e));
        $('.gcc-share-button[data-lang="fr"]').append(textSpan.appendChild(f));
        
        shareButton.attr('tabindex',"0");//add tabindex
        //add keyup on both buttons so user can tab to and hit enter
        $('.gcc-share-button[data-lang="en"]').keyup(function(event){
    		if(event.keyCode == 13){
        		$('.gcc-share-button[data-lang="en"]').click();
    		}
		});
		$('.gcc-share-button[data-lang="fr"]').keyup(function(event){
    		if(event.keyCode == 13){
        		$('.gcc-share-button[data-lang="fr"]').click();
    		}
		});
        //add onclick event to both buttons
        $('.gcc-share-button[data-lang="en"]').click(function (){
        	//build data object
        	var data = {
        		lang: 'en',
        		title: document.title,
        		url: window.location.href,
        	};
        	//open popup window to share form with title and address allready populated
        	window.open(site+"share_bookmarks/share?data="+JSON.stringify(data), 'save to gcconnex', 'width=545,height=618,scrollbars=yes,resizeable=no');
        });
		$('.gcc-share-button[data-lang="fr"]').click(function (){
        	var data = {
        		lang: 'fr',
        		title: document.title,
        		url: window.location.href,
        	};
        	window.open(site+"share_bookmarks/share?data="+JSON.stringify(data), 'Partager sur GCconnex', 'width=545,height=618,scrollbars=yes,resizeable=no');
        });

    }); 
    
}



})(); // We call our anonymous function immediately