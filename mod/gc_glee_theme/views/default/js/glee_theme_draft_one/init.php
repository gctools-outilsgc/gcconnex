<?php 
?>

elgg.provide('glee.draft_one');
elgg.require('glee');

glee.draft_one.init = function() {

    return false;

  	if ($(".registration_link").length) {
    	$(".registration_link").click(function (e) {
        	e.preventDefault();
        	
        	glee.createModal("gleeRegistrationModel", '/mod/glee/pages/glee/ajax/account/register.php');	               
  		});
    }
    
    if ($(".forgot_link").length) {
    	$("a.forgot_link").click(function (e) {
        	e.preventDefault();
            
            glee.createModal("gleeForgotModal", '/mod/glee/pages/glee/ajax/account/forgotten_password.php');	                                     
  		});
    }

	if ($(".login_link").length) {
    	$("a.login_link").click(function (e) {
        	e.preventDefault();
        	
            glee.createModal("gleeLoginModal", '/mod/glee/pages/glee/ajax/account/login.php');	                           
  		});
    }
    
 return true;
}

elgg.register_hook_handler('init', 'system', glee.draft_one.init);


