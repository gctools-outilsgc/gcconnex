<?php
$french = array(
	// general stuff
'simplesaml:error:loggedin' => "Cette action ne peut être effectuée lorsque vous avez ouvert une session",
'simplesaml:no_linked_account:title' => "Aucun compte liés à la source d'authentifications : %s",
'simplesaml:no_linked_account:description' => "Nous n'avons pas pu trouver le compte lié à votre compte externe de %s. Vous pouvez lier votre compte du site avec votre compte externe lorsque vous ouvrez une session ou une vois que vous êtes inscrits.",		
'simplesaml:forms:register:description' => "Si vous ne disposez pas d'un compte sur ce site, vous pouvez créer un compte en cliquant sur le bouton d'inscription. Il est possible que des informations supplémentaires soient nécessaires.",		
'simplesaml:no_linked_account:login' => "Cliquez ici si vous avez déjà un compte sur ce site",
'simplesaml:settings:sources:allow_registration' => "Autoriser l'inscription",
'simplesaml:settings:sources:auto_create_accounts' => "Créer automatiquement les comptes",
'simplesaml:settings:sources:remember_me' => "Se souvenir de moi",
'simplesaml:settings:sources:configuration:auto_link' => "Lier automatiquement les comptes existant  en se basant sur les informations du profil (en option)",
'simplesaml:usersettings:link_url' => "Cliquez ici afin de lié les deux comptes",
'simplesaml:widget:logged_in' =>  "<b>%s</b> bienvenue à la communauté de <b>%s</b> ",
'simplesaml:login:title' => "Portail de connexion des Outils GC2.0",
'simplesaml:login:body' => "Utilisez vos données de compte GCconnex pour vous connecter.</br>",
'simplesaml:login:body:other' => "Vous n’avez pas de compte GCconnex? Créez-en un en cliquant sur le lien « S'enregistrer » ci-dessous..</br></br>",
'simplesaml:register-password' => "<a href ='".elgg_get_site_url()."register'>S'enregister</a> | <a href ='".elgg_get_site_url()."forgotpassword'>Mot de passe perdu?</a>",

	
);

add_translation("fr", $french);