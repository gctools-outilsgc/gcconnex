<?php


$languagecode = get_current_language();
$singularvar = $languagecode . 'singular';
$pluralvar = $languagecode . 'plural';

$singular = elgg_get_plugin_setting($singularvar, 'rename_friends');
$plural = elgg_get_plugin_setting($pluralvar, 'rename_friends');

// set defaults if setting can't be found
if(empty($singular)){ $singular = elgg_echo('collègue'); }
if(empty($plural)){ $plural = elgg_echo('collègues'); }

// get first letter of each, and register variables for starting with uppercase and lowercase first letter
// $usingle = uppercase singluar eg. Friend
// $lsingle = lowercase singluar eg. friend
// $uplural = uppercase plural eg. Friends
// $lplural = lowercase plural eg. friends

$lsingle = strtolower($singular);
$lplural = strtolower($plural);

//create our uppercase singular
$first_letter = strtoupper($singular[0]);
$rest_of_word = substr($singular, 1);

$usingle = $first_letter . $rest_of_word;

//create our uppercase plural
$first_letter = strtoupper($plural[0]);
$rest_of_word = substr($plural, 1);

$uplural = $first_letter . $rest_of_word;



// get variables for groups 
$singular = '';
$plural = '';
if(elgg_is_active_plugin('rename_groups')){
  $singular = elgg_get_plugin_setting($singularvar, 'rename_groups');
  $plural = elgg_get_plugin_setting($pluralvar, 'rename_groups');
}

  // set defaults if setting can't be found
  if(empty($singular)){ $singular = elgg_echo('groups:group'); }
  if(empty($plural)){ $plural = elgg_echo('groups'); }

  // get first letter of each, and register variables for starting with uppercase and lowercase first letter
  // $usingle = uppercase singluar eg. Group
  // $lsingle = lowercase singluar eg. group
  // $uplural = uppercase plural eg. Groups
  // $lplural = lowercase plural eg. groups

  $glsingle = strtolower($singular);
  $glplural = strtolower($plural);

  //create our uppercase singular
  $first_letter = strtoupper($singular[0]);
  $rest_of_word = substr($singular, 1);

  $gusingle = $first_letter . $rest_of_word;

  //create our uppercase plural
  $first_letter = strtoupper($plural[0]);
  $rest_of_word = substr($plural, 1);

  $guplural = $first_letter . $rest_of_word;
 
$french = array(
	//
	//	rename_friends language mappings
	//
	'rename_friends:language' => "Language",
	'rename_friends:missing:language:file' => "Language file appears to be missing.  Check that it exists and that the languages directory has read access.",
	'rename_friends:plural' => "Plural",
	'rename_friends:settings' => "Rename Friends for each language",
	'rename_friends:singular' => "Singular",

    /*
     * 	Default Notification Settings
     */
	'notifications_tools:friends_notifications' => "Choose the default notification method for {$lplural} notifications (This will be applied when a new user acount is created)",
    'notifications_tools:friends_batch_method' => "Choose a notification method for {$lplural} notifications (This will affect all site users)",

    /*
     * Elgg Core
     */

'access:friends:label' => "$uplural",
'friends' => "$uplural",
'friends:yours' => "Vos {$lplural}",
'friends:owned' => "%s' {$lplural}",
'friend:add' => "Ajouter un {$lsingle}",
'friend:remove' => "Supprimer {$lsingle}",
'friends:add:successful' => "Vous avez ajouté %s avec succès en tant que  {$lsingle}.",
'friends:add:failure' => "Il nous a été impossible d'ajouter %s en tant que  {$lsingle}. Veuillez essayer à nouveau.",
'friends:remove:successful' => "Vous avez réuss à supprimé %s de votre liste de  {$lplural}.",
'friends:remove:failure' => "Il nous a été impossible de supprimer %s de votre liste de  {$lplural}. Veuillez essayer à nouveau.",
'friends:none' => "Cet utilisateur n'a pas encore ajouter de  {$lsinglel}'' à ce jour.", 
'friends:none:you' => "Vous n'avez pas encore de {$lplural}.",
'friends:none:found' => "Aucun  {$lplural} n'a été trouvé.",
'friends:of:none' => "Personne n'a ajouté cet utilisateur en tant que {$lsingle} à ce jour.",
'friends:of:none:you' => "Personne ne vous encore ajouter en tant que collègue  {$lsingle} jusqu'à maintenant. Commencez à remplir votre profil afin que les gens puissent vous trouver!", 
'friends:of:owned' => "Les gens qui ont ajouté %s en tant que collègue {$lsingle}",
'friends:of' => "Les {$lplural} de",
'friends:collections' => "Cercles de {$lplural}",
'collections:add' => "Nouveau cercle de {$lplural}",
'friends:collections:add' => "Nouveau cercle de {$lplural}",
'friends:addfriends' => "Sélectionner des {$lplural}",
'friends:collectionfriends' => "{$uplural} dans le cercle",
'friends:collections:members' =>  "Cercle {$lplural}",
'river:friend:user:default' => "%s est maintenant {$lsingle} avec %s",
'river:widgets:friends' => "Activité des {$lplural}",
'userpicker:only_friends' => "Seulement les {$lplural}",
'river:friends' => "Activité des {$lplural}",
'friends:widget:description' => "Afficher certains de vos {$lplural}.",
'friends:num_display' => "Nombre de {$lplural} à afficher",
'friend:newfriend:subject' => "%s vous à ajouter en tant que {$lsingle}!",
'friend:newfriend:body' => "%svous à ajouter en tant que {$lsingle}! Pour consulter son profil, cliquez ici : %s Vous ne pouvez pas répondre à ce courriel..",
'friends:nocollections' => "Vous n'avez pas encore de cercle de {$lplural}.",
'friends:collectiondeleted' => "Votre cercle de {$lplural} a été supprimé.",
'friends:collectiondeletefailed' => "Le cercle de {$lplural} n'a pas été supprimé. Vous n'avez pas suffisamment de droits pour effectuer cette tâche.",
'friends:collectionadded' => "Votre cercle de {$lplural} a été créé avec succès",
'friends:nocollectionname' => "Vous devez nommer votre cercle de {$lplural} avant qu'il puisse être créé.",
'friends:collections:edit' => "Modifier le cercle de {$lplural}",	
		
//Extendafriend		
				
'extendafriend:edit:friend' => "Modifier {$usingle}",
'extendafriend:updated' => "Les accès à vos cercle de {$usingle} ont été mis à jour",		
		
//Friend Request		
				
'friend_request' => "Demande de {$usingle}",
'friend_request:menu' => "Demandes de {$usingle} Requests",
'friend_request:title' => "Demande de {$usingle} pour : %s",
'friend_request:new' => "Nouvelle demande de {$lsingle}",
'friend_request:friend:add:pending' => "Demande de {$lsingle} en attente",
'friend_request:newfriend:subject' => "%s veut être votre {$lsingle}!",
'friend_request:newfriend:body' =>  "%s wants to be your colleague! But he or she is waiting for you to approve the request... So login now so you can approve the request! <br/> You can view your pending colleague requests at: %s <br/> <i> Make sure you are logged into the website before clicking on the following link, otherwise you will be redirected to the login page.</i> To view their profile, click here: %s <div> style 'border-top: 1px dotted #999999;' &nbsp;</div> %s souhaite être votre collègue! Il ou elle attend que vous approuviez sa demande... Connectez-vous pour approuver cette demande! <br/> Vous pouvez afficher les demandes de collègue qui sont en attente : %s <br/> <i> Assurez-vous d'être connecté(e) au site avant de cliquer sur le lien suivant. Si vous n'êtes pas connecté(e), vous serez redirigé(e) vers la page d'ouverture de session.</i> Pour consulter son profil, cliquez ici : %s",
		
	// Actions		// Actions
	// Add request		// Add request
'friend_request:add:successful' => 	"Vous avez demandé d'être {$lsingle} avec %s. Ils doivent accepter votre demande avant d'être affiché dans votre liste de {$lplural}.",
'friend_request:add:exists' => "Vous avez déjà fait une demande de {$lsinglel} avec %s.",
		
// Approve request
		// Approve request
		
'friend_request:approve:successful' => "%s est maintenant {lsingle}",
'friend_request:approve:fail' =>  "Une erreur est survenue lorsque vous avez tenté de devenir {$lsingle} avec %s",
		
// Decline request
		// Decline request
		
'friend_request:decline:subject' => "%s a refusé votre demande de {$lsingle}",
'friend_request:decline:message' => "%s, %s a refusé votre demande à devenir {$lsingle}.",		
'friend_request:decline:success' => "Demande de {$usingle} refusée",
'friend_request:decline:fail' => "Une erreur s'est produite lors que vous avez refusé la demande de {$usingle}, veuillez essayer à nouveau",
		
// Revoke request		// Revoke request
'friend_request:revoke:success' => "Demande de {$usingle} annulée avec succès",
'friend_request:revoke:fail' => "Une erreur s'est produite lorsque vous avez annulé la demande de {$usingle}, veuillez essayer à nouveau",
		
// Views		
// Received		
'friend_request:received:title' => "Received {$usingle} requests",
		
// Sent		// Sent
'friend_request:sent:title' => "Demande de {$usingle} envoyée",
		
// HypeEvents		
		
'hj:events:friendevents' => "Événement des {$uplural}",
		
// Invite Friends		
		
'friends:invite' => "Inviter des {$lplural}",
'invitefriends:introduction' => "Pour inviter des {$lplural} à vous joindre sur ce réseau, ajoutez  leurs adresses courriel ci-dessous (une par ligne):",
'invitefriends:success' => "Vos {$lplural} ont été invités.",
'invitefriends:email' => "Vous avez été invité à joindre %s par %s. Ils vous ont écrit ce message : Pour joindre %s, cliquez sur le lien suivant : Vous serez automatiquement ajouter en tant que {$lsingle} lorsque vous aller créer votre compte.",
		
//Rename Groups		
		
'groups:invite' => "Invitez les {$lplural}",
'groups:invite:title' => "Invitez les {$lplural} à ce {$glsingle}",
'groups:inviteto' => "Invitez les {$lplural} à '%s'",
'groups:nofriends' => "Il ne vous reste pu de {$lplural} à inviter à ce {$glsingle}.",
'groups:nofriendsatall' => "Vous n'avez plus de {$lplural} à inviter!",
		
// River Addon		
		
'river_addon:label:friends' => "Voulez-vous afficher les {$lplural} dans l'encadré?",
'river_addon:label:num' => "Nombre de {$lplural} à afficher",
'river_addon:option:default' => "Tous, Les miens, {$uplural}",
'river_addon:option:friend' => "{$uplural}, Les miens, Tous",
'river_addon:option:mine' => "Les miens, {$uplural}, Tous",
		
		
// General / multi-mod		
		
'friends:filterby' => "Mes {$lplural}",


);

add_translation("fr", $french);
