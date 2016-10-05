<?php

/**
 *
 * Wet 4 Splash page.
 *
 * Creates a splash page for GCconnex for users to check language.
 * It then forwards them to login
 *
 * @version 1.0
 * @author Nick P
 */
$site_url = elgg_get_site_url();
$jsLocation = $site_url . "mod/wet4/views/default/js/wet-boew.js";
$termsLink = $site_url .'terms';
$frenchLink = $site_url .'login';
$toggle_lang = $site_url .'action/toggle_language/toggle';
$CONFIG->splashLanguage ="false";
$gcconnex_text = elgg_echo('wet:login_welcome');
//Create The body of the splash
//Add the toggle language JS to the page to set lang
//Page forwards to login with users selected language
$body .= <<<__BODY
<div class="splash">
<div id="bg">
</div>
<main role="main">
	<script type="text/javascript">
		function form_submit(language_selected) {
			//document.getElementById('formtoggle').submit();

			var c_name = "connex_lang";
			var c_value = document.cookie;
			var c_start = c_value.indexOf(" " + c_name + "=");

			if (c_start == -1){
				c_start = c_value.indexOf(c_name + "=");
			}

			if (c_start == -1)
			{
				c_value = null;
			} else {

				c_start = c_value.indexOf("=", c_start) + 1;
				var c_end = c_value.indexOf(";", c_start);
				if (c_end == -1) {
					c_end = c_value.length;
				}
				c_value = unescape(c_value.substring(c_start,c_end));
			}

			// modified by cyu - oct 1 2013
			// first time you visit the site.. the cookie language is set to null
			if (c_value == null)
			{
				//alert("null is caught..");
				// we need to check what the user selected...
				if (language_selected == "English")
				{
					set_cookie(c_name, "en");

				} else
				if (language_selected == "French")
				{
					set_cookie(c_name,"fr");
				}

				parent.location.href= "$frenchLink";
			} else {
//Just force language on splash

if (language_selected == "English")
				{
					set_cookie(c_name, "en");

				} else
				if (language_selected == "French")
				{
					set_cookie(c_name,"fr");
				}
				parent.location.href= "$frenchLink";
			}
		}
		function set_cookie(name,value) {
			var today = new Date();
			today.setTime( today.getTime() );
			expires = 1000 * 60 * 60 * 24;
			var expires_date = new Date( today.getTime() + (expires) );
			document.cookie = name + "=" +escape( value ) + ";path=/" + ";expires=" + expires_date.toGMTString();

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

<form action="$toggle_lang" method="post" id="formtoggle">

		<?php
		// security tokens.
		echo elgg_view('input/securitytoken');
		?>
		</form>
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
