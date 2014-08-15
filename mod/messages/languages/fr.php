<?php
/**
* Elgg send a message action page
* 
* @package ElggMessages
*/

$french = array(
	/**
	* Menu items and titles
	*/
	'messages:displayposts' => "Affiches %s postes",
	'messages' => "Messages",
	'messages:unreadcount' => "%s non lus",
	'messages:back' => "retourner au messages",
	'messages:user' => "%s's inbox",
	'messages:posttitle' => "%s's messages: %s",
	'messages:inbox' => "Inbox",
	'messages:send' => "envoyer",
	'messages:sent' => "envoyer",
	'messages:message' => "Message",
	'messages:title' => "sujet",
	'messages:to' => "À ",
	'messages:from' => "à partir de",
	'messages:fly' => "envoyer",
	'messages:replying' => "Message répondant à",
	'messages:inbox' => "Boîte de réception",
	'messages:sendmessage' => "Envoyer un message",
	'messages:compose' => "Composer un message",
	'messages:add' => "Composer un message",
	'messages:sentmessages' => "messages envoyés",
	'messages:recent' => "messages récents",
	'messages:original' => "Message original",
	'messages:yours' => "Votre message",
	'messages:answer' => "réponse",
	'messages:toggle' => 'toggle tous',
	'messages:markread' => 'marquer comme lu',
	'messages:recipient' => 'Choisissez un destinataire&hellip;',
	'messages:to_user' => 'À : %s',

	'messages:new' => 'Nouveau message',

	'notification:method:site' => 'Site',

	'messages:error' => "Il ya un probléme d'enregistrer votre message. S'il vous plaït essayez de nouveau.",

	'item:object:messages' => 'Messages',

	/**
	* Status messages
	*/

	'messages:posted' => "Votre message a été envoyé.",
	'messages:success:delete:single' => 'Message a été supprimé',
	'messages:success:delete' => 'Message a été supprimé',
	'messages:success:read' => 'Les messages marqués comme lus',
	'messages:error:messages_not_selected' => 'Pas de messages sélectionnés',
	'messages:error:delete:single' => 'Impossible de supprimer le message',

	/**
	* Email messages
	*/

	'messages:email:subject' => 'Vous avez un nouveau message!',
	'messages:email:body' => "vous avez un nouveau message de %s. Il se lit comme suit:


	%s


	Pour afficher vos messages, cliquez ici:

	%s

	Pour envoyer %s un message, cliquez ici:

	%s

	Vous ne pouvez pas répondre á ce message.",

	/**
	* Error messages
	*/

	'messages:blank' => "Désolé, le contenu est nécessaire dans le corps du message avant que nous puissions l'enregistrer.",
	'messages:notfound' => "Désolé, nous n'avons pas pu trouver le message spécifié.",
	'messages:notdeleted' => "Désolé, nous n'avons pas pu supprimer ce message.",
	'messages:nopermission' => "Vous n'avez pas la permission de modifier ce message.",
	'messages:nomessages' => "Il n'y a aucun message.",
	'messages:user:nonexist' => "We could not find the recipient in the user database.",
	'messages:user:blank' => "Vous n'avez pas choisir quelqu'un d'envoyer á .",

	'messages:deleted_sender' => 'utilisateur supprimé',

);
		
add_translation("fr", $french);
