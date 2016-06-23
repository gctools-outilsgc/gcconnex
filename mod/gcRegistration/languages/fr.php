<?php
$site_url = elgg_get_site_url();
$french = array(
	// labels
'gcRegister:email_initial' => 'Adresse de courriel',
'gcRegister:email_secondary' => 'Confirmation du courriel',
'gcRegister:username' => 'Nom d\'utilisateur (généré automatiquement)',
'gcRegister:password_initial' => 'Mot de passe',
'gcRegister:password_secondary' => 'Confirmation du mot de passe',
'gcRegister:display_name' => 'Nom à afficher',
'gcRegister:display_name_notice' => 'Veuillez écrire votre prénom et votre nom de famille, tel que l’on vous connaît au travail. Conformément aux Conditions d’utilisation, le nom affiché doit correspondre à votre vrai nom. Il n’est pas permis d’utiliser un pseudonyme.',
'gcRegister:please_enter_email' => 'Veuillez inscrire votre adresse de courriel',
'gcRegister:department_name' => 'Inscrire le nom de votre ministère',
'gcRegister:register' => 'S\'inscrire',
			
// error messages on the form			// error messages on the form
			
'gcRegister:failedMySQLconnection' => 'Impossible de se connecter à la base de données',
'gcRegister:invalid_email' => '<a href="#email_initial">Adresse de courriel non valide</a>',
'gcRegister:invalid_email2' => 'Adresse de courriel non valide',
'gcRegister:empty_field' => 'champ vide',
'gcRegister:mismatch' => 'Erreur de correspondance',
			
// notice			// avis
			
'gcRegister:email_notice' => '<h2 class="h2">Veuillez créer votre compte.</h2><ol><li>Une adresse de courriel valide du gouvernement du Canada se terminant par gc.ca est requise pour créer un compte GCconnex. Si votre adresse de courriel du gouvernement est différente et que vous avez reçu un avis indiquant que votre adresse de courriel n\'est pas valide, veuillez écrire à <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a>.</li><li>Le système ne permet pas la création d’un deuxième compte au moyen de la même adresse de courriel. Si vous recevez un message vous indiquant que l’adresse de courriel est déjà inscrite, vous avez probablement déjà un compte GCconnex. Veuillez écrire à <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a> pour récupérer les données d’identification de votre compte GCconnex.</li><li>Avant de pouvoir ouvrir une première session dans GCconnex, vous devrez valider votre inscription en cliquant sur un lien de confirmation qui sera envoyé par courriel afin de valider votre compte. Si vous ne recevez pas ce courriel, veuillez écrire à <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a>.</li></ol>',
			
'gcRegister:terms_and_conditions' => 'J\'ai lu, j\'ai compris et j\accepte les <a target="_blank" href="http://gcconnex.gc.ca/terms">Conditions d\'utilisation</a>.',
'gcRegister:validation_notice' => '<b>Remarque :</b> Vous ne pourrez pas ouvrir une session sur Gcconnex avant d\'avoir reçu un courriel de validation.',
'gcRegister:tutorials_notice' => '<a href="http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex">Tutoriels de GCconnex</a>',
			
// error messages that pop up			// messages d'erreur qui apparaissent
			
'gcRegister:toc_error' => '<a href="#toc2">Vous devez accepter les condtions d\'utilisation</a>',
'gcRegister:email_in_use' => 'Cette adresse de courriel a déjà déjà été enregistrée',
'gcRegister:password_mismatch' => '<a href="#password">Les mots de passe ne sont pas identiques</a>',
'gcRegister:password_too_short' => '<a href="#password">Le mot de passe doit avoir au moins 6 caractères</a>',
'gcRegister:email_mismatch' => '<a href="#email_initial">Les adresses de courriel ne sont pas identitiques</a>',
'gcRegister:display_name_is_empty' => '<a href="#name">Le champ « Nom à afficher » ne peut pas être laissé vide</a>',

    'registration:userexists' => 'That username already exists. <a href="'.$site_url.'forgotpassword">Retrieve your password</a>(translate me)',
    'gcRegister:department' => 'Ministère',
);
 
add_translation("fr", $french);
