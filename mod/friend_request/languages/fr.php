<?php
$language = array (

'friend_request' => "Demande d\'ajout à ma liste de collègues",
'friend_request:menu' => "Demande d\'ajout à ma liste de collègues",
'friend_request:title' => "Demandes d\'ajout à ma liste de collègues pour : %s",     
'friend_request:new' => "Nouvelle demande d\'ajout à ma liste de collègues",     
'friend_request:friend:add:pending' => "Demande d\ajout à ma liste de collègues en attente",
      
/************* FRIEND REQUEST *************/      
      
'friend_request:newfriend:subject' => "%s veut être votre collègue! / %s wants to be your colleague! ",
'friend_request:newfriend:body' => "%s veut être votre collègue! À vous de lui répondre... ouvrez une session dès maintenant pour pouvoir approuver sa demande! <br/>
Vous pouvez voir ou can view your pending colleague requests at:

%s <br/>
<i>Assurez-vous d'avoir ouvert une session avant de cliquer sur le lien suivant, sinon vous serez rediriger vers la page d'ouverture de session.</i>

Pour voir le profile de la personne qui vous invite, cliquez ici: %s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s wants to be your colleague! But he or she is waiting for you to approve the request... So login now so you can approve the request! <br/>
You can view your pending colleague requests at:

%s <br/>
<i>Make sure you are logged into the website before clicking on the following link, otherwise you will be redirected to the login page.</i>

To view their profile, click here: %s
",
        
// Actions      
// Add request      
      
'friend_request:add:failure' => "Désolé, nous n\'avons pas pu traiter votre demande à cause d\'une erreur système . S\'il vous plaît essayez de nouveau.",
'friend_request:add:successful' => "Vous avez demandé à %s de faire partie de vos collègues. Votre demande doit être acceptée avant que son nom apparaisse dans votre liste de collègues.",
'friend_request:add:exists' => "Vous avez déjà demandé d\'être collègues avec %s.",
      
// Approve request      // Accepter la demande
      
'friend_request:approve' => "Accepter",
'friend_request:approve:subject' => " %s a accepté votre demande d\’ajout à votre liste de collègue / %s has accepted your colleague request",
'friend_request:approve:message' => "%s, %s a accepté votre demande d\'ajout à votre liste de collègue.",
      
      
      
'friend_request:approve:successful' => "%s fait maintenant partie de vos collègues",
'friend_request:approve:fail' => "Erreur durant la création de l'entrée %s' dans vos collègues",
      
// Decline request      
      
'friend_request:decline' => "Refuser",
'friend_request:decline:subject' => "%s a refusé votre demande à devenir collègue",
'friend_request:decline:message' => "Cher %s, %s a refusé votre invitation pour devenir un de ses collègues.",
      
      
'friend_request:decline:success' => "Demande d\'ajout à la liste des collègues refusée avec succès",
'friend_request:decline:fail' => "Erreur lors du refus de la demande d\'ajout à la liste de collègues, merci de réessayer.",
      
// Revoke request     
      
'friend_request:revoke' => "Annuler",
'friend_request:revoke:success' => "Demande d\'ajout à la liste de collègues annulée avec succès",
'friend_request:revoke:fail' => "Erreur lors de l\'annulation de la demande d\'ajout à la liste de collègues, veuillez réessayer",
      
// Views      
// Received     
      
'friend_request:received:title' => "Demandes d\'ajout à une liste de collègues reçues",
'friend_request:received:none' => "Aucune demandes en attente d\'approbation",
      
// Sent     
      
'friend_request:sent:title' => "Demandes d\'ajout à ma liste de collègues envoyées",
'friend_request:sent:none' => "Aucune demandes envoyées en attente d\'approbation",

);
add_translation("fr", $language);
