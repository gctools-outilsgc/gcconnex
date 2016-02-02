<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			GC Changes
 * CYu 			March 5 2014 	Second Email field for verification & code clean up & validate email addresses
 * CYu 			July 16 2014	clearer messages & code cleanup						
 * CYu 			Sept 19 2014 	adjusted textfield rules (no spaces for emails)
 ***********************************************************************/

$password = $password2 = '';
$username = get_input('e');
$email = get_input('e');
$name = get_input('n');
$site_url = elgg_get_site_url();

$lostpassword = '<a href="'.$site_url .'forgotpassword'.'">Get Password';
if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

?>

<style>
	#submit:disabled {
		background-color: grey;
	}
	.c_table { 
		border:1px solid #ccc;
		background-color:;
	}
	.table th,td {
		padding:10px;
	}
	.c_tr2, .c_td2 {
		padding:10px;
		text-align: center;
	}
</style>

<!-- +++ jquery/javascript stuff +++++++++++++++++++++++++++++++++++++++++++ -->
<script type="text/javascript">

	$(document).ready(function() {
		enable_submit(false);
	});

	function check_fields2()
	{
		var invalid_email = document.getElementById('email_initial_error').innerHTML;
		var email1 = document.getElementById('email_initial').value;
		var email2 = document.getElementById('email').value;
		var password1 = $('.password_test').val();
		var password2 = $('.password2_test').val();
		var d_name = document.getElementById('name').value;
		var toc_val = $('#toc2 input:checkbox:checked').val();
		
		//console.log('cyu - '+ toc_val);
		var is_valid = false;
		var pop_up_msg = "";

		$('font').each(function() {
			if ( $(this).attr('id') !== undefined ) {
				var font_id = $(this).attr('id');

				if ( document.getElementById(font_id).innerHTML === '' ) {
					is_valid = true;
				} else {
					is_valid = false;
					return is_valid;
				}
			}
		});

		if (invalid_email != "")
		{
			pop_up_msg += "- "+invalid_email+"\n";
			is_valid = false;
		}

		if (email1 != email2)
		{
			pop_up_msg += "<?php echo elgg_echo('gcRegister:email_mismatch'); ?>\n";
			is_valid = false;
		}

		if (password1 != password2)
		{
			pop_up_msg += "<?php echo elgg_echo('gcRegister:password_mismatch'); ?>\n";
			is_valid = false;
		}

		if (password1 == password2 && password1.length < 6)
		{
			pop_up_msg += "<?php echo elgg_echo('gcRegister:password_too_short'); ?>\n";
			is_valid = false;
		}
		
		if (d_name == "")
		{
			pop_up_msg += "<?php echo elgg_echo('gcRegister:display_name_is_empty'); ?>\n";
			is_valid = false;
		}

		if (toc_val != 1)
		{
			pop_up_msg += "<?php echo elgg_echo('gcRegister:toc_error'); ?>"+"\n";
			is_valid = false;
		}

		if (!is_valid || pop_up_msg != "")
		{
			alert(pop_up_msg);
			return false;
		} else {
			return true;
		}
	}

	function validateEmail(email) { 
	    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
	    return re.test(email);
	}

	function endsWith(str, suffix) {
    	return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}

	// auto fill function; will auto generate for display name
	function fieldFill()
	{
		var dName = document.getElementById('email').value;
		if(dName.indexOf("@")!= false) {
			dName = dName.substring(0, dName.indexOf("@"));
		}
		if(dName.indexOf(".")!= false) {
			dName = dName.replace(/\./g,' ');
		}

		// gcchange - format display name (ie Mc'Larry John-Dean instead of mclarry john-dean)
		// gcchange - translated from php to javascript [php source is a note on the manual page of the ucfirst() function on php.net]
		function toProperCase(str){
			var delim = new Array("'","-"," ");
			var append = '';
			var splitup = new Array();
			str = str.toLowerCase();
			for(var i = 0; i < delim.length; i++){
				if(str.search(delim[i]) != -1){
					append = '';
					splitup = str.split(delim[i]);
					for(var j = 0; j < splitup.length; j++){
						append += splitup[j].charAt(0).toUpperCase() + splitup[j].substr(1) + delim[i];
					}
					str = append.substring(0, append.length - 1);
				}
			}
			return str.charAt(0).toUpperCase() + str.substr(1);
		}
		
		document.getElementById('name').value = toProperCase(dName);
		name.value = dName;
	}

	function enable_submit(the_state)
	{/*
		// we want to enable
		if (the_state)
		{
		    if ($(".submit_test").prop('disabled', true))
		        $(".submit_test").prop('disabled', false);
		// we don't want to enable
		} else {

		    if ($(".submit_test").prop('disabled', false))
		        $(".submit_test").prop('disabled', true);
		}
	*/}

	function validForm()
	{
		var is_valid = false;
		
		$('input').each(function() {
			if ( $(this).attr('id') == "email_initial" || $(this).attr('id') == "email" || $(this).attr('id') == "username" || $(this).attr('id') == "password" || $(this).attr('id') == "password2" || $(this).attr('id') == "name") {
				var val = $(this).attr('value');

				if ( $(this).attr('value').length == 0) {
					is_valid = false;
					return is_valid;
				} else {
					is_valid = true;
				}
			}
		});
		return is_valid;
	}

</script>

<!-- +++ jquery/javascript stuff +++++++++++++++++++++++++++++++++++++++++++ -->

<!-- check if browser is IE7 -->
<?php 
	$isIE7 = false;
	$u = $_SERVER['HTTP_USER_AGENT'];
	$isIE7 = (bool)preg_match('/msie 7./i', $u);

	if (!$isIE7) $isIE7 = 0;
?>

<!-- check if browser has javascript enabled -->
<script type="text/javascript">
var usingIE7 = <?php echo $isIE7; ?>;

	$(document).ready (function() {
		if (!usingIE7) {
			document.getElementById('retired_version').style.display="none";
			document.getElementById('form_type').value = "standard"; 
		}
		else {
			document.getElementById('standard_version').style.display="none"; 
			document.getElementById('form_type').value = "retired"; 
		}
	});
</script>

<!-- check if browser has javascript disabled -->
<noscript>
	<style>
		#standard_version { display:none; }
	</style>
	<input type="hidden" name="noscript" value="retired"></input>
</noscript>

<!-- hidden field that determines whether we should use standard/retired -->
<input type="hidden" name="form_type" id="form_type" value=""></input>

<!-- form that doesn't require javascript or IE7 -->
<div id="retired_version">
<div>
	<label><?php echo elgg_echo('gcRegister:email_initial'); ?></label><br />
	<?php
		echo elgg_view('input/text', array(
			'name' => 'c_email',
			'value' => $email,
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('gcRegister:email_secondary'); ?></label><br />
	<?php
		echo elgg_view('input/text', array(
			'name' => 'c_email2',
			'value' => $email,
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label><br />
	<?php
		echo elgg_view('input/password', array(
			'name' => 'c_password',
			'value' => $password,
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('passwordagain'); ?></label><br />
	<?php
		echo elgg_view('input/password', array(
			'name' => 'c_password2',
			'value' => $password2,
		));
	?>
</div>


<?php
echo elgg_view('input/checkboxes', array(
	'name' => 'toc1',
	'id' => 'toc1',
	'options' => array(elgg_echo('gcRegister:terms_and_conditions') => 1)));
?>

<br/>
<?php
	// view to extend to add more fields to the registration form
	echo elgg_view('register/extend', $vars);

	// Add captcha hook
	echo elgg_view('input/captcha', $vars);
	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
	echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
	echo elgg_view('input/submit', array('name' => 'submit2', 'value' => elgg_echo('register')));
	echo '</div>';
	
	echo '<center>'.elgg_echo('gcRegister:tutorials_notice').'</center>';
	echo '<br/>';
?>

<?php
	echo '<center><table class="c_table"><tr class="c_tr2"><td class="c_td2">';
	echo '<div>'. '<font size="5">This page is compatible with/Cette page est compatible avec : <br/><font color="blue"> Internet Explorer 7 | Javascript disabled/désactivé</font></font>' .'</div>';
	echo '</td></tr></table></center>';
?>

</div>
<!-- end of "retired form" -->



<!-- start of standard form -->
<div id="standard_version">

<div>
<?php
	echo '<center><table class="c_table"><tr><td>';
	echo '<div>'. elgg_echo('gcRegister:email_notice') .'</div>';
	echo '</td></tr></table></center>';
	echo '<br/>';

	$js_disabled = false;
?>

</div>

<div>
	<label for="email_initial"><?php echo elgg_echo('gcRegister:email_initial'); ?></label>
	<font id="email_initial_error" color="red"></font><br />	
	<input type="text" name="email_initial" id="email_initial" value='<?php echo $email ?>' class="form-control"/>
</div>

<div>
	<label for="email"><?php echo elgg_echo('gcRegister:email_secondary'); ?></label>
	<font id="email_secondary_error" color="red"></font><br />

	<input id="email" class="elgg-input-text form-control" type="text" value='<?php echo $email ?>' name="email" 
	onBlur="elgg.action( 'register/ajax', {
		data: {
			args: document.getElementById('email').value 
		}, 
		success: function( x ) {
				//document.getElementById('username').value = 'wow' + x.output;
		    $('.username_test').val(x.output);
				//$('.return_message').append(x.output);
				
    
		    
				fieldFill();
				if(x.output == '> invalid email'){
                $('.return_message').html(x.output);
           $('.return_message').addClass('alert alert-error');
				}else if(x.output == '> This email address has already been registered'){
				    var link = '';
           $('.return_message').html(x.output);
           $('.return_message').addClass('alert alert-error');
}else{
           $('.return_message').html('');
           $('.return_message').removeClass('alert alert-error');
}   
			}
	});">
</div>

    <div class="return_message">


    </div>

<div>
	<label for="username"><?php echo elgg_echo('gcRegister:username'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'username',
		'id' => 'username',
        'class' => 'username_test',
		'readonly' => 'readonly',
		'value' => $username,
	));
	?>
</div>

<div>
	<label for="password"><?php echo elgg_echo('gcRegister:password_initial'); ?></label>
	<font id="password_initial_error" color="red"></font><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password',
		'id' => 'password',
        'class'=>'password_test',
		'value' => $password,
	));
	?>
</div>

<div>
	<label for="password2"><?php echo elgg_echo('gcRegister:password_secondary'); ?></label>
	<font id="password_secondary_error" color="red"></font><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password2',
		'value' => $password2,
		'id' => 'password2',
        'class'=>'password2_test',
	));
	?>
</div>


<div class="mtm">
	<label for="name"><?php echo elgg_echo('gcRegister:display_name'); ?> *</label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'name',
		'id' => 'name',
		'value' => $name,
	));
	?>
	<i>* <?php echo elgg_echo('gcRegister:display_name_notice'); ?></i>
</div>
<br/>
<?php
echo elgg_view('input/checkboxes', array(
	'name' => 'toc2',
	'id' => 'toc2',
	'options' => array(elgg_echo('gcRegister:terms_and_conditions') => 1)));
?>
<br/><br/>
<?php
	// view to extend to add more fields to the registration form
	echo elgg_view('register/extend', $vars);

	// Add captcha hook
	echo elgg_view('input/captcha', $vars);

	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
	echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));

	// note: disable
	echo elgg_view('input/submit', array(
		'name' => 'submit', 
		'value' => elgg_echo('gcRegister:register'),
		'id' => 'submit',
        'class'=>'submit_test btn-primary',
		'onclick' => 'return check_fields2();'));

	echo '</div>';
	
	echo '<center>'.elgg_echo('gcRegister:tutorials_notice').'</center>';
	
	echo '<br/>';
?>

<?php
	echo '<center><table class="c_table"><tr class="c_tr2"><td class="c_td2">';
	echo '<div>'. '<font size="5">This page is compatible with/Cette page est compatible avec : <br/><font color="blue">Mozilla Firefox | Google Chrome | Internet Explorer 8+</font></font>' .'</div>';
?>
	<!-- don't use this anymore, just tells users that their javascript is disabled -->
	<noscript><div><font color="red">Warning/Avertissement : Javascript disabled/désactivé</font></div></noscript>
<?php
	echo '</td></tr></table></center>';
	echo '<br/>';
?>
<script>
	//$("<input>").on("focus", function() {
		$('#email_initial').on("keydown",function(e) {
			return e.which !== 32;
		});

		$('#email').on("keydown",function(e) {
			return e.which !== 32;
		});
	//});


	//$('<input>').on("focus", function() {
	    $('#email_initial').on("keyup", function() {
	    	enable_submit(validForm());
	    	var val = $(this).attr('value');
	        if ( val === '' ) {
	        	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
	            document.getElementById('email_initial_error').innerHTML = c_err_msg;
	        }
	        else if ( val !== '' ) {
	            document.getElementById('email_initial_error').innerHTML = '';

	            if (!validateEmail(val)) {
	            	var c_err_msg = "<?php echo elgg_echo('gcRegister:invalid_email') ?>";
	            	document.getElementById('email_initial_error').innerHTML = c_err_msg;
	            }
	        }
	    });
	
		$('#toc2').click(function() {
	    	if ($('#toc2:checked').val() == 1)
	    	{
	    		enable_submit(validForm());
	    	}
	    });

	    $('#email').on("keyup", function() {
	    	enable_submit(validForm());
	    	var val = $(this).attr('value');
		    if ( val === '' ) {
		    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
		        document.getElementById('email_secondary_error').innerHTML = c_err_msg;
		    }
		    else if ( val !== '' ) {
		        document.getElementById('email_secondary_error').innerHTML = '';

		        var val2 = $('#email_initial').attr('value');
		        if (val2.toLowerCase() != val.toLowerCase())
		        {
		        	var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
		        	document.getElementById('email_secondary_error').innerHTML = c_err_msg;
		        }
		    }
		});

	    $('#password').on("keyup", function() {
	    	enable_submit(validForm());
	    	var val = $(this).val();
		    if ( val === '' ) {
		    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
		        document.getElementById('password_initial_error').innerHTML = c_err_msg;
		    }
		    else if ( val !== '' ) {
		        document.getElementById('password_initial_error').innerHTML = '';
		    }
		});	
	    
	    $('#password2').on("keyup", function() {
	    	enable_submit(validForm());
	    	var val = $(this).val();
		    if ( val === '' ) {
		    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
		        document.getElementById('password_secondary_error').innerHTML = c_err_msg;
		    }
		    else if ( val !== '' ) {
		        document.getElementById('password_secondary_error').innerHTML = '';
		        
		        var val2 = $('.password_test').val();
		        if (val2 != val)
		        {
		        	var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
		        	document.getElementById('password_secondary_error').innerHTML = c_err_msg + val2 + ' ' + val;
		        }
		    }
		});

	    $('#department_name').on("keyup", function() {
	    	enable_submit(validForm());
	    	var val = $(this).val();
		    if ( val === '' ) {
		    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
		        document.getElementById('department_error').innerHTML = c_err_msg;
		    }
		    else if ( val !== '' ) {
		        document.getElementById('department_error').innerHTML = '';
		    }
		});
	//});

</script>
</div>