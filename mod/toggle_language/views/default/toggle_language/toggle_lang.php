<div>
	<?php
		global $SESSION;
	?>

	<div class="lang_toggle">
	<script type="text/javascript">
		function form_submit(language_selected) {
			//document.getElementById('formtoggle').submit();

			var c_name = "connex_lang";
			var c_value = document.cookie;
			var c_start = c_value.indexOf(" " + c_name + "=");
			
			//alert("check1");
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

			//alert("language is:" + c_value);
			//set_cookie('cclang')

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

				parent.location.reload(true);
			} else {

				if (c_value == "en"){
					set_cookie(c_name,"fr");
				} else {
					set_cookie(c_name, "en");
				}
				parent.location.reload(true);
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
		<form action="<?php echo $vars['url']; ?>action/toggle_language/toggle" method="post" id="formtoggle">
			
		<?php
		// security tokens.
		echo elgg_view('input/securitytoken');
		?>
		</form>
		
		<?php
			//$log = fopen(dirname( __FILE__ ) . "/cyu - session conditional statement.txt", 'w');
			//fwrite($log, "start logging - session language" . "\r\n" );

			if ($SESSION['language'] == 'en') { 
			//if ($_COOKIE["cc_lang"] == 'en'){
				//fwrite($log, "session is in english" . "\r\n" );

		?>
				<span class="active"><lan=en>English</span>
				<a class="not_active" href="javascript:form_submit('French')"><lan=fr>Fran&ccedil;ais<lan=en></a>


		<?php
			} else { //if ($SESSION['language'] == 'fr') {
				//fwrite($log, "session is in french" . "\r\n" );
		?>
				<a class="not_active" href="javascript:form_submit('English')"><lan=en>English</a>
				<span class="active"><lan=fr>Fran&ccedil;ais</span>

		<?php
			}

			//fwrite($log, "end logging - session language" . "\r\n" );
			//fclose($log);
		?>
	</div>

</div>