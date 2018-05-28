<?php
/**
  * gc_splash_page pages/splash.php
  *
  * Creates a splash page for GCconnex for users to check language.
  * It then forwards them to login
  *
  * @version 1.0
  * @author Nick Pietrantonio    github.com/piet0024
 */

$site_url = elgg_get_site_url();
$jsLocation = $site_url . "mod/wet4/views/default/js/wet-boew.js";
$termsLink = $site_url .'terms';
$frenchLink = $site_url .'login';
$toggle_lang = $site_url .'mod/toggle_language/action/toggle_language/toggle';
$CONFIG->splashLanguage ="false";
$gcconnex_text = elgg_echo('wet:login_welcome');
$clean_domain = str_replace(array('https://', 'http://', '/', 'www.'), '', elgg_get_site_url());
$domain = '.' . $clean_domain;

$securitytoken = elgg_view('input/securitytoken');

// PLEASE CHANGE IF THIS DOES NOT WORK ON YOUR LOCALHOST
$site_url = elgg_get_site_url();
$site_url = preg_replace("(^https?://)", "", $site_url);
$site_url = explode("/", $site_url);

if (preg_match("/localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $site_url[0])) {
	$domain = $site_url[0];
}

$cookie_name = "lang";

//Create The body of the splash
//Add the toggle language JS to the page to set lang
//Page forwards to login with users selected language

// see the module named toggle_language for documentation comments for the javascripts
$body .= <<<__BODY
<div class="splash">
<div id="bg">
</div>
<main role="main">


<script type="text/javascript">
		
		function form_submit(language_selected) {
			var cookie_name = "$cookie_name";
			var cookie_value = getCookie(cookie_name);
			var url_string = window.location.href;
			var language_param = getParams("language");

			if (language_param != null) cookie_value = language_param;

			if (cookie_value == "")
			{
				var cookie_language = (language_selected == "French") ? "fr" : "en";
				set_cookie(cookie_name, cookie_language);
				parent.location.href= "$frenchLink";

			} else {

				var cookie_language = (cookie_value == "en") ? "fr" : "en";
				set_cookie(cookie_name, cookie_language);

				if (language_param == null)
					parent.location.href= "$frenchLink";
				
				else 
					window.location.href = url_string.replace("language=" + cookie_value, "language=" + cookie_language);
			}
		}
		
		function set_cookie(name,value) {
			var today = new Date();
			today.setTime( today.getTime() );
			expires = 1000 * 60 * 60 * 24;
			var expires_date = new Date( today.getTime() + (expires) );
			var domain = "$domain";
			document.cookie = name + "=" +escape( value ) + ";path=/" + ";expires=" + expires_date.toGMTString() + ";domain=" + domain + ";";
		}

		function getCookie(cname) {
		    var name = cname + "=";
		    var decodedCookie = decodeURIComponent(document.cookie);
		    var ca = decodedCookie.split(';');
		    
		    for (var i = 0; i < ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0) == ' ') {
		            c = c.substring(1);
		        }
		        if (c.indexOf(name) == 0) {
		            return c.substring(name.length, c.length);
		        }
		    }
		    return "";
		}
		
		// url.searchParams() is not compatible with Internet Explorer
		function getParams(name) {
		    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		    if (results==null){
		       return null;
		    }
		    else{
		       return decodeURI(results[1]) || 0;
		    }
		}

	</script>



	

<div class="sp-hb">
<div class="sp-bx col-xs-12">
<h1 property="name" class="wb-inv">$gcconnex_text</h1>
<div class="row">
<div class="col-xs-11 col-md-8">
<object type="image/svg+xml" tabindex="-1" role="img" data="$site_url/mod/wet4/graphics/sig-blk-en.svg" width="283" aria-label="Government of Canada / Gouvernement du Canada"></object>
</div>
</div>
<div class="row">
<section class="col-xs-6 text-right">
<h2 class="wb-inv">GCconnex English</h2>
<p><a href="javascript:form_submit('English')" class="btn btn-primary">English</a></p>
</section>
<section class="col-xs-6" lang="fr">
<h2 class="wb-inv">GCconnex Français</h2>
<p><a href="javascript:form_submit('French')" class="btn btn-primary">Français</a></p>
</section>

<form action="$toggle_lang" method="post" id="formtoggle">$securitytoken</form>
</div>
</div>
<div class="sp-bx-bt col-xs-12">
<div class="row">
<div class="col-xs-7 col-md-8">
<a href="$termsLink " class="sp-lk">Terms & Conditions of Use</a> <span class="glyphicon glyphicon-asterisk"></span> <a href="$termsLink " class="sp-lk" lang="fr">Conditions d'utilisation</a>
</div>
<div class="col-xs-5 col-md-4 text-right mrgn-bttm-md">
<object type="image/svg+xml" tabindex="-1" role="img" data="$site_url/mod/wet4/graphics/wmms-blk.svg" width="127" aria-label="Symbol of the Government of Canada / Symbole du gouvernement du Canada"></object>
</div>
</div>
</div>
</div>
    <div class="splash_identifier wb-inv"><span class="bold-gc">GC</span>connex</div>
</main>
<div>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src=" $jsLocation "></script>


</div>
__BODY;

$body .= elgg_view('page/elements/foot');
$headparams = array(
    'title' => 'GCconnex',
    );
$head = elgg_view('page/elements/head', $headparams);

$params = array(

	'head' => $head,
	'body' => $body,
);
//Create Page
echo elgg_view("page/elements/html", $params);
?>
