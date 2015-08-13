<?php

$languagecode = get_current_language();
$singularvar = $languagecode . 'singular';
$pluralvar = $languagecode . 'plural';

$singular = elgg_get_plugin_setting($singularvar, 'rename_friends');
$plural = elgg_get_plugin_setting($pluralvar, 'rename_friends');

if(empty($singular)){ $singular = elgg_echo('friend'); }
if(empty($plural)){ $plural = elgg_echo('friends'); }

$lsingle = strtolower($singular);
$lplural = strtolower($plural);

$first_letter = strtoupper($singular[0]);
$rest_of_word = substr($singular, 1);

$usingle = $first_letter . $rest_of_word;

$first_letter = strtoupper($plural[0]);
$rest_of_word = substr($plural, 1);

$uplural = $first_letter . $rest_of_word;

$singular = '';
$plural = '';
if(elgg_is_active_plugin('rename_groups')){
	$singular = elgg_get_plugin_setting($singularvar, 'rename_groups');
	$plural = elgg_get_plugin_setting($pluralvar, 'rename_groups');
}
if(empty($singular)){ $singular = elgg_echo('groups:group'); }
if(empty($plural)){ $plural = elgg_echo('groups'); }

$glsingle = strtolower($singular);
$glplural = strtolower($plural);

$first_letter = strtoupper($singular[0]);
$rest_of_word = substr($singular, 1);

$gusingle = $first_letter . $rest_of_word;

$first_letter = strtoupper($plural[0]);
$rest_of_word = substr($plural, 1);

$guplural = $first_letter . $rest_of_word;
  
$english = array(

/************* FRIEND REQUEST (APPROVAL) *************/
'friend_request:approve:subject' => "%s has accepted your colleague request / %s a accepté votre demande d’ajout de collègue",
	
'friend_request:approve:message' => "
%s has accepted your request to become a colleague! 

To view their profile, click here:
%s
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
http://gcconnex.gc.ca/notifications/personal/
 
<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
%s a accepté votre demande d’ajout de collègue! 

Pour consulter son profil, cliquez ici : 
%s
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
http://gcconnex.gc.ca/notifications/personal/
",


/************* NEW COMMENT *************/
"generic_comment:email:subject" => "You have a new comment in ‘%s’! / Vous avez un nouveau commentaire dans ‘%s’!",
"generic_comment:email:body" => "
Hi %s, <br/>
You have a new comment on your item '%s' from %s. It reads:
<i>%s</i> <br/>
To reply or view the original item, click here:
%s <br/>
To view %s's profile, click here: 
%s <br/>
To change your personal notifications, click here: 
%s
To change your group notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
Vous avez un nouveau commentaire de %s sur l'élément '%s'. Le voici :
<i>%s</i> <br/>
Pour répondre ou voir le contenu original, cliquez sur le lien :
%s <br/>
Pour voir le profil de %s, cliquez sur ce lien :
%s <br/>
Pour modifier vos notifications personnelles, cliquez ici :
%s
Pour changer vos notifications de groupe, cliquez ici : 
%s

",



/************* LIKING A CONTENT (LIKES) *************/
"likes:notifications:subject" => "%s likes your post ‘%s’ / %s aime votre message ‘%s’",
"likes:notifications:body" => "
Hi %s, <br/>
%s likes your post %s on %s <br/>
See your original post here:
%s <br/>
or view %s's profile here:
%s <br/>
To change your personal notifications, click here:
%s
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
%s aime votre publication %s sur %s <br/>
Consultez votre publication originale ici :
%s <br/>
ou consultez le profil de %s ici :
%s <br/>
Pour modifier vos notifications personnelles, cliquez ici : 
%s
Pour changer vos notifications de groupe, cliquez ici : 
%s

",



/************* REPLYING TO DISCUSSION *************/
"discussion:notifications:reply:subject" => "New group discussion reply‏ to ‘%s’ / Nouvelle réponse à une discussion de groupe à ‘%s’",
"discussion:notifications:reply:body" => "
Hi %s, <br/>
%s replied to the discussion topic %s in the group %s:
%s <br/>
View and reply to the discussion:
%s <br/>
To change your group notifications, click here:
%s <br/>
<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
%s a répondu à la discussion %s dans le groupe %s :
%s <br/>
Afficher et répondre à la discussion :
%s <br/>
Pour changer vos notifications de groupe, cliquez ici : 
%s

",


/************* EVENT REMINDERS *************/ // NOT TESTED AND NOT IMPLEMENTED
"event_calendar:reminder:subject" => "Reminder for event: [name of even] / Rappel du cas : [ nom de l'événement ]",
"event_calendar:reminder:body" => "
Hi [name of user],

The event
[name of event]

takes place at
[event location].
         
You can visit the event page here:
[event url]

To change your personal notifications, click here: 
To change your group notifications, click here:

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Bonjour [name of user], 

L'événement 
[name of event]

aura lieu à l'endroit suivant : 
[event location]

Consultez la page de l'événement ici : 
[event url]

Pour modifier vos notifications personnelles, cliquez ici : 
Pour changer vos notifications de groupe, cliquez ici : 
",


/************* GROUP INVITE (JOINED) *************/
"groups:welcome:subject" => "Welcome to %s! / Bienvenue dans le groupe %s!",
"groups:welcome:body" => "
Hi %s, <br/>
You are now a member of the '%s' group! Click below to begin posting!
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/> 
Vous être maintenant membre du groupe '%s'! Cliquez ci-dessous pour commencer à publier!
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici :
%s

",



/************* GROUP INVITES (EXISTING ACCOUNTS) *************/
"c_group_tools:groups:invite:subject" => "You have been invited to join '%s'! / Vous avez été invité(e) à vous joindre à '%s'!",
"c_group_tools:groups:invite:body" => "
Hi %s, <br/>
%s invited you to join the '%s' group. See below to view your message/invitation:
%s <br/>
<u>Invitation</u>:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:  
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
%s vous a invité(e) à vous joindre au groupe '%s'. Regardez ci-dessous pour voir message/l'invitation :
%s <br/>
<u>L'Invitation</u> : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",



/************* GROUP INVITES (NON EXISTING ACCOUNTS) *************/
"group_tools:groups:invite:email:subject" => "You've been invited to the group '%s' / Vous avez été ajouté au groupe '%s'",
"group_tools:groups:invite:email:body" => "
Hi, <br/>
You are receiving this message because %s invited you to join the group %s on %s.
%s <br/>
If you don't have an account on %s, please register here: 
%s <br/>
If you already have an account or you have just registered, please click on the following link to accept the invitation:
%s <br/>
You can also go to All site groups -> Group invitations and enter the following code:
%s
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour,  <br/>
Vous recevez ce messages parce que %s vous a invité(e) à vous joindre au groupe %s dans %s.
%s <br/>
Si vous n'avez pas de compte sur %s, veuillez vous inscrire ici : 
%s <br/>
Si vous avez déjà un compte ou venez tout juste de vous inscrire, cliquez sur le lien suivant pour accepter l'invitation : 
%s <br/>
Vous pouvez aussi allez à la section Tous les groupes du site -> Invitations de groupe et entrer le code suivant : 
%s
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
",



/************* GROUP MAILING SYSTEM *************/
"group_tools:mail:message:from" => "%s",
"c_group_tools:mail:message:body" => "
%s <br/>
You are receiving this message because you are a member of the %s group on GCconnex.
If you wish to comment or reply to the content of this message, contact %s, the owner of the %s group.  

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s <br/>
Vous recevez ce message parce que vous êtes membre du groupe %s sur GCconnex.
Pour y répondre, ou pour commenter le contenu de ce message, contactez %s, le propriétaire du groupe %s.

",



/************* NEW ALBUM *************/
"tidypics:newalbum_subject" => "New photo album / Nouvel album photos",
"tidypics:notify:body_newalbum" => "
%s created a new photo album: %s <br/>
View and/or comment on the album:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a créé un nouvel album photo : %s <br/>
Voir et/ou commenter l'album : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

"group_tidypics:notify:body_newalbum" => "
%s created a new photo album in group %s: %s <br/>
View and/or comment on the album:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a créé un nouvel album photo dans le groupe %s : %s <br/>
Voir et/ou commenter l'album : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",

/************* NEW BLOG *************/
"blog:newpost" => "A new blog post / Un nouveau blogue",
"blog:notification" => "
%s created a blog post. <br/>
<u>Title:</u>
%s <br/>
<u>Excerpt:</u>
%s <br/>
View and/or comment on this blog post:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a publié un nouveau billet de blogue. <br/>
<u>Titre :</u>
%s <br/>
<u>Excerpt :</u>
%s <br/>
Afficher et/ou commenter le nouveau billet de blogue : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

"group_blog:notification" => "
%s created a blog post within the %s group. <br/>
<u>Title:</u>
%s <br/>
<u>Excerpt</u>
%s <br/>
View and/or comment on this blog post:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a publié un nouveau billet de blogue dans le groupe %s. <br/>
<u>Titre :</u>
%s <br/>
<u>Excerpt :</u>
%s <br/>
Afficher et/ou commenter le nouveau billet de blogue : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",


/************* NEW BOOKMARK *************/
"bookmarks:new" => "A new bookmark / Nouveau signet",
"bookmarks:notification" => "
%s added a bookmark: <br/>
<u>Bookmark Title - Link:</u>
%s - %s <br/>
<u>Description:</u>
%s <br/>
View and/or comment on the  bookmark:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté un signet : <br/> 
<u>Titre du Signet - Addresse du signet :</u>
%s - %s <br/>
<u>Description</u>
%s <br/>
Afficher et/ou commenter le signet :
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

"group_bookmarks:notification" => "
%s added a bookmark in the group %s: <br/>
<u>Bookmark Title - Bookmark Link:</u>
%s - %s <br/>
<u>Description</u>
%s <br/>
View and/or comment on the  bookmark:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté un signet dans le groupe %s : <br/>
<u>Titre du Signet - Addresse du signet :</u>
%s - %s <br/>
<u>Description</u>
%s <br/>
Afficher et/ou commenter le signet :
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",



/************* NEW EVENT CALENDAR *************/
"event_calendar:new_event" => "New event / Nouvel événement",
"event_calendar:c_new_event_body" => "
New event:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Il y a un nouvel événement :
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

"group_event_calendar:c_new_event_body" => "
New event in the group %s
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Il y a un nouvel événement dans le groupe %s
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",


/************* NEW TOPIC DISCUSSION *************/
// cyu - 04/29/2015: slight change to the wording (removed parameter)
"discussion:notification:topic:subject" => "New group discussion post / Nouvelle discussion de groupe",
"c_discussion:notification:body" => "
%s added a new discussion topic to %s: <br/>
<u>Title</u>
%s <br/>
<u>Topic Message</u>
%s <br/>
View and/or reply to the discussion:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté un nouveau sujet de discussion dans le groupe %s : <br/>
<u>Titre</u>
%s <br/>
<u>Topic Message</u>
%s <br/>
Afficher et/ou répondre à la discussion : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",


 
/************* NEW FILE *************/
"file:newupload" => "A file has been uploaded / Téléversement de nouveau fichier",
"group_file:notification" => "
%s uploaded a file within the %s group: <br/>
<u>Title</u>
%s <br/>
<u>Description</u>
%s <br/>
View and/or comment on the file:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté un fichier dans le groupe %s : <br/>
<u>Titre</u>
%s <br/>
<u>Description</u>
%s <br/>
Afficher et/ou commenter le fichier : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",

"file:notification" => "
%s uploaded a file:
<u>Title</u>
%s <br/>
<u>Description</u>
%s <br/>
View and/or comment on the file:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté un fichier :
<u>Titre</u>
%s <br/>
<u>Description</u>
%s <br/>
Afficher et/ou commenter le fichier : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

 
/************* NEW PAGE *************/
"pages:new" => "A new page / Une nouvelle page",
"pages:notification" => "
%s added a page within the %s group: <br/>
<u>Title</u>
%s <br/>
<u>Text</u>
%s <br/>
View and/or comment on the page:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté une page dans le groupe %s : <br/>
<u>Titre</u>
%s <br/>
<u>Text</u>
%s <br/>
Afficher et/ou commenter la page : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",



/************* NEW PHOTO UPLOAD *************/
"tidypics:updatealbum_subject" => "New photos in album / Nouvelles photos dans l’album",
"tidypics:updatealbum" => "
%s uploaded photos to the album %s <br/>
To view and/or comment the photo:
%s<br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté des photos dans l’album %s <br/>
Voir et/ou commenter les photos : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

"group_tidypics:updatealbum" => "
%s uploaded photos to the album %s in the group <i>%s</i> <br/>
To view and/or comment the photo:
%s<br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté des photos dans l’album %s dans le groupe <i>%s</i> <br/>
Voir et/ou commenter les photos : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",


/************* NEW TASKS (MISSING BODY) *************/
"tasks:new" => "New Task / Nouvelle tâche",
"group_c_tasks:new_body_email" => "
%s added a new task:
%s in the %s <br/>
View and/or comment on the new task
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté une tâche :
%s dans le groupe %s <br/>
Afficher et/ou commenter la nouvelle tâche
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour changer vos notifications de groupe, cliquez ici : 
%s

",

"c_tasks:new_body_email" => "
%s added a new task: %s  <br/>
View and/or comment on the new task
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a ajouté une tâche : %s <br/>
Afficher et/ou commenter la nouvelle tâche
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",



/************* ADD NEW COLLEAGUE *************/
"friend:newfriend:subject" => "%s has made you a colleague! / %s vous a ajouté(e) comme collègue!",
"friend:newfriend:body" => "
%s has made you a colleague! <br/>
To view their profile, click here:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s vous a ajouté(e) comme collègue! <br/>
Pour consulter son profil, cliquez ici : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",




/************* REPLY TO WIRE POST *************/
"thewire_reply:notify:subject" => "New wire post reply / Nouvelle réponse à votre message sur le fil",
"thewire_reply:notify:reply" => "
%s responded to a wire post
<u>Message</u>
'%s' <br/>
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
%s a répondu à un message sur le fil
<u>Message</u>
'%s' <br/>
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",




/************* WIRE POST (COLLEAGUE) *************/
"thewire:notify:subject" => "New wire post / Nouveau message sur le fil",
"thewire_post:notify:reply" => "
%s posted on the wire:
<u>Message</u>
'%s' <br/>
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
%s a publié ce message sur le fil : 
<u>Message</u>
'%s' <br/>
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",




/************* SEND MESSAGE IN SYSTEM *************/
"messages:email:subject" => "You have a new message: %s / Vous avez un nouveau message : %s",
"messages:email:body" => "
You have a new message from %s. It reads:
%s <br/>
To view your messages, click here:
%s <br/>
To send %s a message, click here:
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Vous avez un nouveau message de %s. Le voici : 
%s <br/>
Pour afficher vos messages, cliquez ici : 
%s <br/>
Pour envoyer un message à %s, cliquez ici : 
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",




/************* VALIDATION EMAIL *************/
"email:validate:subject" => "%s please confirm your email address for %s! / %s s'il vous plaît confirmer votre adresse e-mail pour %s!",
"email:validate:body" => "
Hi %s, <br/>
You are receiving this email because you have registered for GCconnex with this email address. Before you can start using %s, you must confirm your email address.
Please do so by clicking on the link below:
%s <br/>

If you can't click on the link, copy and paste it to your browser manually. <br/>
%s <br/>
%s <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex 
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Bonjour %s,  <br/>
Vous recevez ce message parce que vous vous êtes inscrit(e) à GCconnex avec cette adresse courriel. Avant de pouvoir commencer à utiliser %s, vous devez confirmer votre adresse courriel. 
Pour confirmer, veuillez cliquer sur le lien ci-dessous : 
%s <br/>
Si vous ne pouvez pas cliquer sur le lien, copiez-le et collez-le manuellement dans votre navigateur.  <br/>
%s <br/>
%s <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

/************* PASSWORD RESET PART 1 *************/
"email:resetreq:subject" => "Request for new password / Demande d'un nouveau mot de passe",
"email:resetreq:body" => "
Hi %s, <br/>
Someone (from the IP address %s) has requested a new password for the GCconnex account associated with this email. <br/>
If you requested this, click on the link below. If not, ignore this email.
%s 

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s,  <br/>
Quelqu'un (avec l'adresse IP %s) a demandé un nouveau mot de passe pour le compte GCconnex associé à cette adresse courriel.  <br/>
Si vous êtes à l'origine de cette demande, cliquez sur le lien ci-dessous. Sinon, veuillez ignorer ce courriel. 
%s

",




/************* PASSWORD RESET PART 2 *************/
"email:resetpassword:subject" => "Password reset! / Réinitialisation du mot de passe!",
"email:resetpassword:body" => "
Hi %s, <br/>
Your password has been reset to: %s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/> 
Votre nouveau mot de passe est : %s 

",

/************* USER ACCOUNT CREATION (ADMIN ONLY) *************/
"useradd:subject" => "User account created / Compte de l'utilisateur créé",
"useradd:body" => "
Hi %s, <br/>
A user account has been created for you at %s. To log in, visit:
%s <br/>
And log in with these user credentials: <br/>
Username: %s
Password: %s <br/>
Once you have logged in, we highly recommend that you change your password. <br/>
To learn more about GCconnex and its many features, visit http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GC
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Bonjour %s, <br/>
Un compte d'utilisateur a été créé pour vous dans %s. Pour vous connecter, cliquez sur : 
%s <br/>
Puis, connectez-vous avec les identifiants suivants : 
Nom d'utilisateur : %s
Mot de passe : %s <br/>
Nous vous conseillons fortement de changer votre mot de passe une fois que vous serez connecté.  <br/>
Pour en savoir plus sur GCconnex et ses nombreuses fonctionnalités, visitez la page http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex
Pour modifier vos notifications personnelles, cliquez ici : 
%s

", 



/************* EMAIL TEMPLATE (CONFIGURE YOUR SETTINGS ETC) *************/
"html_email_handler:notification:footer:settings" => "",
"change_configuration_notice" => "",



/************* FRIEND REQUEST *************/
"friend_request:newfriend:subject" => "%s wants to be your colleague! / %s veut être votre collègue!",
"c_friend_request:newfriend:body" => "
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




/************* INVITE FRIENDS TO APPLICATION *************/
"invitefriends:subject" => "You have been invited to %s / Vous avez été invité à rejoindre %s",
"invitefriends:email" => "
You have been invited to join %s by %s. They included the following message:<br/>
%s <br/>
To join, click the following link:
%s <br/>
You will automatically add them as a colleague when you create your account.

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s vous a invité(e) à vous joindre à %s. Il ou elle a inclus le message suivant : <br/>
%s <br/>
Pour vous joindre, cliquez sur le lien ci-dessous : 
%s <br/>
Il ou elle sera ajouté(e) automatiquement à votre liste de collègues lorsque vous créerez votre compte.
 
",




/************* INVITE USERS THROUGH CSV FILE *************/
"upload_users:email:message" => "Your new user account for %s / Votre nouveau compte utilisateur pour %s",
"upload_users:email:subject" => "
Hello %s! <br/>
Welcome to %s! <br/>
A user account has been created for you. 
Login using your username and password as noted below. 
Username: %s
Password: %s <br/>
Click the following link to login:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Bonjour %s! <br/>
Bienvenue sur %s! <br/>
Un compte d'utilisateur a été créé pour vous. 
Utilisez votre nom d'utilisateur et mot de passe pour vous connecter
Nom d'utilisateur : %s            
Mot de passe : %s <br/>
Cliquez sur le lien ci-dessous pour vous connecter :
%s

",



/************* TAGGING USERS IN PHOTOS *************/
"tidypics:tag:subject" => "You have been tagged in a photo / Vous avez été identifié sur une photo",
"c_tidypics:tag:body" => "
You have been tagged in the photo %s by %s <br/>
The photo can be viewed here:
%s <br/>
To change your personal notifications, click here: 
%s
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s vous a identifié(e) dans la photo %s <br/> 
La photo peut être vue ici : 
%s <br/>
Pour modifier vos notifications personnelles, cliquez ici : 
%s
Pour changer vos notifications de groupe, cliquez ici : 
%s

",

/************* MENTION USERS IN THE WIRE *************/
"thewire_tools:notify:mention:subject" => "You've been mentioned on the wire / Vous avez été mentionné(e) sur le fil",
"thewire_tools:notify:mention:message" => "
Hi %s, <br/>
%s mentioned you in his/her wire post. <br/>
To view your mentions on the wire, click here:
%s <br/>
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/> 
%s vous a mentionné(e) dans un message sur le fil. <br/>
Pour afficher vos mentions sur le Fil, cliquez ici : 
%s <br/>
Pour modifier vos notifications personnelles, cliquez ici : 
%s

",

/************* MESSAGE BOARD COMMENT *************/
"messageboard:email:subject" => "You have a new message board comment! / Vous avez un nouveau commentaire sur le babillard!",
"c_messageboard:email:body" => "
You have a new message board comment from %s. It reads:
%s <br/>
To view your message board comments, click here:
%s <br/>
To view %s's profile, click here:
%s <br/>
To change your personal notifications, click here: 
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Vous avez un nouveau message board comment de la part de %s. Le voici : 
%s <br/>
Pour afficher vos message board comments, cliquez ici :
%s <br/>
Pour consulter le profil de %s, cliquez ici :
%s <br/>
Pour modifier vos commentaires sur le babillard, cliquez ici : 
%s

",



/************* REQUEST EVENT TO ADD TO OWN CALENDAR *************/
"event_calendar:request_subject" => "You have received an event request / Vous avez reçu une demande d' événement",
"event_calendar:request_message" => "
%s has asked to have the event '%s' added to his/her personal calendar:
%s <br/>
You can manage calendar requests for this event here:
%s 

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>%s a demandé d'ajouter l'événement '%s' publié à son calendrier personnel : 
%s <br/>
Gérez les demandes d'ajout au calendrier associées à cet événement ici : 
%s

", 



/************* INVITE FRIENDS TO APPLICATION *************/
"invitefriends:message:default" => "",


/************* REQUESTING TO JOIN A CLOSED GROUP *************/
'c_groups:request:subject' => "%s has requested to join '%s' / %s a demandé à se joindre au groupe '%s'",
'c_groups:request:body' => "
Hi %s, <br/>
%s has requested to join the '%s' group. Click below to view their profile:
%s <br/>
or click below to view the group's join requests:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
%s a demandé à se joindre au groupe '%s' . Cliquez ci-dessous pour consulter son profil :
%s <br/>
ou cliquez ci-dessous pour afficher les demandes d'adhésion à du groupe :
%s

",

 
/************* ADDING USER TO GROUP *************/
'group_tools:groups:invite:add:subject' => "You've been added to the group '%s' / Vous avez été ajouté au groupe '%s'",
'group_tools:groups:invite:add:body' => "
Hi %s, <br/>
%s added you to the group %s.
%s <br/>
To view the group click on this link
%s <br/>
To change your group notifications, click here:
%s <br/>

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>
Bonjour %s, <br/>
%s vous ajouté(e) au groupe % s .
%s <br/>
Pour voir le groupe , cliquez sur ce lien
%s <br/>
Pour changer vos notifications de groupe, cliquez ici : 
%s

",
 

/************* TRANSFER NEW GROUP OWNERSHIP *************/

'group_tools:notify:transfer:subject' => "Administration of the group '%s' has been appointed to you / Vous avez été nommé administrateur du groupe '%s'",
'group_tools:notify:transfer:message' => "
Hi %s, <br/>
%s has appointed you as the new administrator of the group %s. <br/>
To visit the group please click on the following link:
%s <br/>
To change your group notifications, click here:
%s

<div style='border-top: 1px dotted #999999;'>&nbsp;</div>Bonjour %s, <br/>
%s vous a nommé comme nouvel administrateur du groupe %s. <br/>
Pour voir le groupe , cliquez sur ce lien
%s <br/>
Pour changer vos notifications de groupe, cliquez ici : 
%s

",

);

add_translation('en', $english);