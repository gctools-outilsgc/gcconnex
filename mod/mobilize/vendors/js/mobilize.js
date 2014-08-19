// prevents links from apps from oppening in mobile safari
// Thanks to Nick Scott who provided this iOS 5 link fix
(function(document,navigator,standalone) {
	if ((standalone in navigator) && navigator[standalone]) {
		var curnode, location=document.location, stop=/^(a|html)$/i;
		document.addEventListener('click', function(e) {
			curnode=e.target;
			while (!(stop).test(curnode.nodeName)) {
				curnode=curnode.parentNode;
			}
			// Condidions to do this only on links to your own app
			// if you want all links, use if('href' in curnode) instead.
			if(
				'href' in curnode && // is a link
				(chref=curnode.href).replace(location.href,'').indexOf('#') && 
				(	!(/^[a-z\+\.\-]+:/i).test(chref) ||                       
					chref.indexOf(location.protocol+'//'+location.host)===0 ) 
			) {
				e.preventDefault();
				location.href = curnode.href;
			}
		},false);
	}
})(document,window.navigator,'standalone');

// we just need to attach a click event listener to provoke iPhone/iPod/iPad's hover event
if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
    $(".elgg-page").click(function(){
        // 
    });
}
