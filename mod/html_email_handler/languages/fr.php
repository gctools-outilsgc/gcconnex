<?php 

$french = array(
	'html_email_handler' => "Envoi d'email en HTML",
	
	'html_email_handler:theme_preview:menu' => "Notification HTML",
	
	// settings
	'html_email_handler:settings:notifications:description' => "Lorsque vous activez cette option, toutes les notifications envoyées aux membres du site seront au format HTML (au lieu du texte brut).",
	'html_email_handler:settings:notifications' => "Utiliser comme gestionnaire d'email de notification par défaut",
	'html_email_handler:settings:notifications:subtext' => "Ceci va envoyer tous les mails sortant au format HTML",
	
	'html_email_handler:settings:sendmail_options' => "Paramètres additionnels pour sendmail (optionnel)",
	'html_email_handler:settings:sendmail_options:description' => "Vous pouvez configurer ici des paramètres additionnels lorsque vous utilisez sendmail, par exemple -f %s (pour mieux éviter que les mails soient marqués comme spam)",
	
	// notification body
	'html_email_handler:notification:footer:settings' => "Configurez vos notifications %sen cliquant sur ce lien%s",
);

add_translation("fr", $french);

