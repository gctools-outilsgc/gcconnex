<?php
$site_url = elgg_get_site_url();
$french = array(
	// labels
'gcRegister:form' => "Formulaire d'inscription",
'gcRegister:email_initial' => 'Adresse de courriel',
'gcRegister:email_secondary' => 'Confirmation du courriel',
'gcRegister:username' => 'Nom d\'utilisateur (généré automatiquement)',
'gcRegister:password_initial' => 'Mot de passe',
'gcRegister:password_secondary' => 'Confirmation du mot de passe',
'gcRegister:display_name' => 'Nom à afficher',
'gcRegister:display_name_notice' => "Veuillez écrire votre prénom et votre nom de famille, tel que l’on vous connaît au travail. Conformément aux Conditions d’utilisation, le nom affiché doit correspondre à votre vrai nom. Il n’est pas permis d’utiliser un pseudonyme.",
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
			
'gcRegister:email_notice' => '<h2 class="h2">Veuillez créer votre compte.</h2>
<ol>
<li>Votre compte GCconnex doit être lié à une <b>adresse de courriel valide du gouvernement du
Canada</b> se terminant par gc.ca ou Canada.ca.</li>
<li>Vous devez <b>valider</b> votre nouveau compte avant de pouvoir ouvrir une séance pour la première
fois. Un courriel de validation sera envoyé à votre adresse de courriel. Cliquez sur le lien figurant
dans le courriel (ou copiez-collez- le dans votre navigateur) pour valider votre compte. Si vous ne
recevez pas de courriel de validation, soumettez un billet au <a href="https://gcconnex.gc.ca/help/knowledgebase">bureau d’aide.</a>
<i>(Remarque : Il faudra peut-être plusieurs minutes avant que vous receviez le courriel de
validation en raison de votre pare-feu ministériel. Assurez-vous de vérifier votre dossier de
pourriels.)</i></li>
<li><b>Vous avez déjà un compte?</b> <a href="https://gcconnex.gc.ca/forgotpassword">Demandez la réinitialisation du mot de passe.</a> Si vous ne recevez
pas le courriel de réinitialisation du mot de passe, soumettez un billet au <a href="https://gcconnex.gc.ca/help/knowledgebase">bureau d’aide</a>.
<i>(Remarque : Il faudra peut-être plusieurs minutes avant que vous receviez le courriel de mot de
passe oublié en raison de votre pare-feu ministériel. Assurez-vous de vérifier votre dossier de
pourriels.)</i></li>
<li><b>Vous avez changé de ministère ou d’adresse de courriel? Pas besoin de créer un nouveau
compte.</b> Veuillez soumettre un billet au <a href="https://gcconnex.gc.ca/help/knowledgebase">bureau d’aide.</a> Nous apporterons les changements
nécessaires à votre compte existant et nous vous aiderons à y accéder de nouveau. Assurez-
vous d’inclure votre ancienne adresse de courriel ainsi que la nouvelle.</li>
<li><b>Vous éprouvez encore de la difficulté à créer un compte?</b> Soumettez un billet au <a href="https://gcconnex.gc.ca/help/knowledgebase">bureau d’aide</a>,
et nous nous ferons un plaisir de vous aider.</li>
</ol>',
			
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

    'registration:userexists' => 'That username already exists. <a href=forgotpassword>Retrieve your password</a>(translate me)',
    'gcRegister:department' => 'Ministère',
    'gcRegister:required' => 'Obligatoires',
);
 
add_translation("fr", $french);
