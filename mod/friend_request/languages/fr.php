<?php
$language = array (
  'friend_request' => 'Demande d\'ami',
  'friend_request:menu' => 'Demandes d\'ami',
  'friend_request:title' => 'Demandes d\'ami pour : %s',
  'friend_request:new' => 'Nouvelle demande d\'ami',
  'friend_request:friend:add:pending' => 'Demande d\'ami en attente',
//   'friend_request:newfriend:subject' => '%s veut devenir votre ami!',
//   'friend_request:newfriend:body' => '%s veulent devenir votre ami ! Mais ils attendent que vous approuviez votre requête... alors connectez-vous pour les approuver !

// Vous pouvez voir les demandes d\'ami en attente sur :
// %s

// Assurez-vous d\'être connecté sur le site web avant de cliquer sur le lien suivant, sinon vous serez redirigé sur la page de connexion.

// (Vous ne pouvez pas répondre à cet e-mail.)',

/************* FRIEND REQUEST *************/
"friend_request:newfriend:subject" => "%s wants to be your colleague! / %s veut être votre collègue!",
"friend_request:newfriend:body" => "
%s wants to be your colleague! But he or she is waiting for you to approve the request... So login now so you can approve the request! <br/>
You can view your pending colleague requests at:

%s <br/>
<i>Make sure you are logged into the website before clicking on the following link, otherwise you will be redirected to the login page.</i>

To view their profile, click here: %s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s souhaite être votre collègue! Il ou elle attend que vous approuviez sa demande... Connectez-vous pour approuver cette demande! <br/>
Vous pouvez afficher les demandes de collègue qui sont en attente :
%s <br/>
<i>Assurez-vous d'être connecté(e) au site avant de cliquer sur le lien suivant. Si vous n'êtes pas connecté(e), vous serez redirigé(e) vers la page d'ouverture de session.</i>

Pour consulter son profil, cliquez ici : %s
",
  
  'friend_request:add:failure' => 'Désolé, mais à cause d\'une erreur système nous n\'avons pas pu traiter votre demande. S\'il vous plaît essayez de nouveau.',
  'friend_request:add:successful' => 'Vous avez demandé d\'être amis avec %s. Ils doivent approuver votre demande avant d\'apparaitre dans votre liste d\'amis.',
  'friend_request:add:exists' => 'Vous avez déjà demandé d\'être amis avec %s.',
  'friend_request:approve' => 'Accepter',
  'friend_request:approve:successful' => '%s est maintenant votre ami',
  'friend_request:approve:fail' => 'Erreur durant la création de la relation d\'ami avec %s',
  'friend_request:decline' => 'Décliner',
  'friend_request:decline:subject' => '%s a refusé votre demande d\'ami',
  'friend_request:decline:message' => 'Cher %s,

%s a décliné votre invitation pour devenir son ami.',

  'friend_request:decline:success' => 'Demande d\'ami refusée avec succès',
  'friend_request:decline:fail' => 'Erreur lors du refus de la demande d\'ami, merci de réessayer.',
  'friend_request:revoke' => 'Révoquer',
  'friend_request:revoke:success' => 'Demande d\'ami révoquée avec succès',
  'friend_request:revoke:fail' => 'Erreur lors de la révocation de la demande ami, merci de réessayer',
  'friend_request:received:title' => 'Demandes d\'ami reçues',
  'friend_request:received:none' => 'Pas de demandes en attente de votre approbation',
  'friend_request:sent:title' => 'Demandes d\'ami envoyées',
  'friend_request:sent:none' => 'Pas de demandes envoyées en attente d\'approbation',
);
add_translation("fr", $language);
