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
            href: site+"mod/gc_api/widget/fr/widget.css" 
        });
        css_link.appendTo('head');   
       
        var limit = 15;
        var q =  $( "#wire-external-widget-container" ).text();
        var originalQ = q;
        if (q.charAt(0) == '#'){
            q = q.substring(1);
        }
        if (q.charAt(0) == '@'){
            var nameq = q.substring(1);
        }
        $( "#wire-external-widget-container" ).empty();
        
        
        $( "#wire-external-widget-container" ).append("<div class='wire-widget-container' id='container'></div>");
        if (originalQ != ''){
            //$( "#container" ).append("<div class='wire-widget-header' id='widget-head'><h3>The Wire</h3>search for "+originalQ+"</div>");
            $( "#container" ).append("<div class='wire-widget-header' id='widget-head'><h3>Le fil de GCconnex</h3></div>");
            $( "#widget-head" ).append('<div class="wire-widget-filter-text">Publier les messages avec :</div>');
            if (!nameq){
                $( "#widget-head" ).append('<div><a href="'+site+'thewire/tag/'+q+'">'+originalQ+'</a></div>');
            }else{
                $( "#widget-head" ).append('<div><a href="'+site+'profile/'+nameq+'">'+originalQ+'</a></div>');
            }
                
        }
        else{
            $( "#container" ).append("<div class='wire-widget-header' id='widget-head'><h3>Le fil</h3></div>");
        }
        $( "#container" ).append("<div class='wire-widget-body' id='widget-body'><ul class='wire-widget-list'></ul></div>");
        $( "#container" ).append("<div class='wire-widget-footer' id='widget-footer'><div class='gcconnex-link'><a href='"+site+"'>Visitez GCconnex</a></div></div>");
        doAjax();

       function doAjax(){
            $.ajax({
                type: 'GET',
                contentType: "application/json",
                url: site+'services/api/rest/jsonp/?method=get.wire&query='+q+'&limit='+limit,
                dataType: 'jsonp',
                success: function(feed){
                  
                   var postArray = feed.result.posts;
                   $( "#widget-body" ).find('ul').empty();
                   
                   if (typeof postArray === "undefined"){
                   		var moreButton = document.createElement("BUTTON");
                        moreButton.className = "wire-widget-load-more";
                        moreButton.innerHTML = "Aucun message à afficher";
                        moreButton.onclick = function(){doAjax();};
                        var listItem = document.createElement("LI");
                        listItem.appendChild(moreButton);
                        $( "#widget-body" ).find('ul').append(listItem);	
                   }else{
                   		for (var num in postArray){
                        	var postCard = document.createElement("DIV");
                        	postCard.className = "wire-widget-element";
                        
                        	var cardImageBlock = document.createElement("DIV");
                        	cardImageBlock.className = "wire-widget-avatar";
                        	cardImageBlock.innerHTML = '<a href="'+postArray[num].user.profileURL+'"><img class="wire-widget-img" src="'+ postArray[num].user.iconURL+'"/></a>';
                       
                        	var postContent = document.createElement("DIV");
                        	postContent.className = "wire-widget-content";

                        	var metadataBlock = document.createElement("DIV");
                        	metadataBlock.className = "wire-widget-user";
                        	metadataBlock.innerHTML = '<a href="'+postArray[num].user.profileURL+'">'+postArray[num].user.dispalyName+'</a> <span class="timeStamp">'+postArray[num].time_since+'</span>';
                        
                        	postContent.appendChild(metadataBlock);

                        	var cardText = document.createElement("DIV");
                        	cardText.innerHTML = postArray[num].text;

                        	postContent.appendChild(cardText);
                        
                        	postCard.appendChild(cardImageBlock);
                        	postCard.appendChild(postContent);
                     
                        	var listItem = document.createElement("LI");
                        	listItem.className = 'widget-li clearfix';
                        	listItem.appendChild(postCard);
                        	$( "#widget-body" ).find('ul').append(listItem);
                       
                        
                    	}
                    
                    	if ($( "#widget-body ul li" ).length==limit){
                       
                        	var moreButton = document.createElement("BUTTON");
                        	moreButton.className = "wire-widget-load-more";
                        	moreButton.innerHTML = "Afficher plus de messages";
                        	moreButton.onclick = function(){limit = limit+5; doAjax();};
                        	var listItem = document.createElement("LI");
                        	listItem.appendChild(moreButton);
                       		 $( "#widget-body" ).find('ul').append(listItem);
                    	}
                    	setTimeout(doAjax,15000);
                   }
                
                },
                error: function(request, status, error) { 
                    
                   $( "#wire-external-widget-container" ).html('error');

                }
            });
        }

    }); 
    
}



})(); // We call our anonymous function immediately