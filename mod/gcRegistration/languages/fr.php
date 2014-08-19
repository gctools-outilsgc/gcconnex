<?php
$english = array(
	// labels
	'gcRegister:email_initial' => 'Addresse courriel',
	'gcRegister:email_secondary' => 'Confirmation du courriel',
	'gcRegister:username' => 'Nom d\'utilisateur (généré automatiquement)',
	'gcRegister:password_initial' => 'Mot de passe',
	'gcRegister:password_secondary' => 'Confirmation du mot de passe',
	'gcRegister:display_name' => 'Nom à afficher<br/>Veuillez écrire votre prénom et votre nom de famille, tel que l’on vous connaît au travail. Conformément aux Conditions d’utilisation, le nom affiché doit correspondre à votre vrai nom. Il n’est pas permis d’utiliser un pseudonyme.',
	'gcRegister:please_enter_email' => 'Veuillez inscrire votre courriel',
	'gcRegister:department_name' => 'Inscrire le nom de votre ministère',
	'gcRegister:register' => 'S\'inscrire',

	// error messages on the form
	'gcRegister:failedMySQLconnection' => 'Impossible de se connecter à la base de données',
	'gcRegister:invalid_email' => 'adresse de courriel non valide',
	'gcRegister:empty_field' => 'champ vide',
	'gcRegister:mismatch' => 'inadéquation',

	// notice
	'gcRegister:email_notice' => "<strong>NOTA : </strong>Les comptes ne peuvent être créés qu'avec une adresse courriel valide du gouvernement du Canada. Si vous inscrivez une adresse non valide, vous recevez un avis d'<code>adresse courriel non valide</code>. Si vous croyez que l'adresse courriel du gouvernement du Canada que vous avez utilisée est valide, veuillez communiquer avec <a href='mailto:gcconnex@tbs-sct.gc.ca'>GCconnex@tbs-sct.gc.ca</a>",
	'gcRegister:terms_and_conditions' => "J'ai lu, je comprends et j'accepte <a href='http://gcconnex.gc.ca/terms'>les conditions d'utilisation</a>.",

	// error messages that pop up
	'gcRegister:toc_error' => '- Vous devez accepter les conditions d\'utilisation',
	'gcRegister:email_in_use' => 'Cette adresse courriel est déjà utilisée',
	'gcRegister:password_mismatch' => '- les mots de passe ne sont pas identiques',
	'gcRegister:password_too_short' => '- le mot de passe doit contenir au moins 6 caractères',
	'gcRegister:email_mismatch' => '- Les adresses courriel ne sont pas identiques',
	'gcRegister:display_name_is_empty' => '- Le nom à afficher ne peut être vide',
);
 
add_translation("fr", $english);