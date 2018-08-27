
	<?php
		global $SESSION;
		$clean_domain = str_replace(array('https://', 'http://', '/', 'www.'), '', elgg_get_site_url());
		$domain ='.' . $clean_domain;

		// PLEASE CHANGE IF THIS DOES NOT WORK ON YOUR LOCALHOST
		$site_url = elgg_get_site_url();
		$site_url = preg_replace("(^https?://)", "", $site_url);
		$site_url = explode("/", $site_url);

		if (preg_match("/localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $site_url[0])) {
			$domain = $site_url[0];
		}

		$cookie_name = "lang";

		if (isset($SESSION['language']) ){
			$SESSION['language'] = 'en';
		}

	?>

	<script type="text/javascript">
		
		function form_submit(language_selected) {
			var cookie_name = "<?php echo $cookie_name; ?>";
			var cookie_value = getCookie(cookie_name);

			<?php // get the language parameter ?>
			var url_string = window.location.href;
			var language_param = getParams("language");

			if (language_param != null) cookie_value = language_param;

			<?php // first time you visit the site.. the cookie language is set to null ?>
			if (cookie_value == "")
			{
				<?php // check what the user selected ?>
				var cookie_language = (language_selected == "French") ? "en" : "fr";
				set_cookie(cookie_name, cookie_language);
				parent.location.reload(true);

			} else {

				<?php // if the cookie was set to english, the user selected french ?>
				var cookie_language = (cookie_value == "en") ? "fr" : "en";
				set_cookie(cookie_name, cookie_language);

				<?php // if the language parameter in the url is set, emulate user clicking on link to change language ?>
				if (language_param == null)
					parent.location.reload(true);
				
				else 
					window.location.href = url_string.replace("language=" + cookie_value, "language=" + cookie_language);
			}
		}
		
		function set_cookie(name,value) {
			var today = new Date();
			today.setTime( today.getTime() );
			expires = 1000 * 60 * 60 * 24;
			var expires_date = new Date( today.getTime() + (expires) );
			var domain = "<?php echo $domain; ?>";
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
		

	<div>
		<div class="lang_toggle">
	
			<form action="<?php echo $vars['url']; ?>action/toggle_language/toggle" method="post" id="formtoggle">
				<?php echo elgg_view('input/securitytoken'); ?>
			</form>
			
			<?php if ($SESSION['language'] == 'en') { ?>
					<span class="active">English</span>
					<a class="not_active" href="javascript:form_submit('French')"><span lang="fr">Fran&ccedil;ais</span></a>

			<?php } else { ?>
					<a class="not_active" href="javascript:form_submit('English')"><span lang="en">English</span></a>
					<span class="active">Fran&ccedil;ais</span>

			<?php } ?>

		</div>
	</div>

