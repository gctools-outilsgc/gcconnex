<?php

return array(

// general
'group_tools:decline' => "Refuser",
'group_tools:revoke' => "Retirer",
'group_tools:add_users' => "Ajouter des utilisateurs",
'group_tools:in' => "dans",
'group_tools:remove' => 	"Supprimer",
'group_tools:delete_selected' => "Supprimer la sélection",
'group_tools:clear_selection' => "Effacer la sélection",
'group_tools:all_members' => "Tous les membres",
'group_tools:explain' => "Explication",	
'group_tools:default:access:group' => "Membres du groupe seulement",	
'group_tools:joinrequest:already' => "Retirer la demande d'adhésion.",
'group_tools:joinrequest:already:tooltip' => "Vous avez déjà envoyé une demande pour vous joindre à ce groupe. Cliquer ici pour la retirer.",
'group_tools:join:already:tooltip' => "Vous avez invité à vous joindre ce groupe afin de vous y joindre maintenant",
		
// menu		
'group_tools:menu:mail' => "Envoyer un courriel aux membres",
'group_tools:menu:invitations' => "Gérer les invitations",
'admin:administer_utilities:group_bulk_delete' => "Vrac de Groupe supprimer",		
'admin:appearance:group_tool_presets' => "Outils du groupe préréglé",
		
// plugin settings		
'group_tools:settings:invite:title' => "Options liées aux invitations du groupe",
'group_tools:settings:management:title' => "Options générales liées au groupe",
'group_tools:settings:default_access:title' => "Accès au groupe par défaut",		
'group_tools:settings:admin_transfer' => "Permettre le transfert du propriétaire du groupe.",
'group_tools:settings:admin_transfer:admin' => "Administrateur du site seulement",
'group_tools:settings:admin_transfer:owner' => "Propriétaires de groupes et administrateurs du site",			
'group_tools:settings:multiple_admin' => "Permettre de multiples administrateurs du groupe.",
'group_tools:settings:auto_suggest_groups' => "Selon les renseignements du profil, des suggestions automatiques seront proposées sur la page des groupes « Suggérés ». Ces dernières s'ajouteront à la liste des groupes suggérés prédéfinis. Si vous choisissez l'option « Non », seuls les groupes suggérés prédéfinis seront affichés (s'il y en a).",		
'group_tools:settings:invite' => "Permettre à tous les utilisateurs de recevoir une invitation (pas seulement les collègues).",
'group_tools:settings:invite_email' => "Permettre à tous les utilisateurs de recevoir une invitation par courriel.",
'group_tools:settings:invite_csv' => "Permettre à tous les utilisateurs de recevoir une invitation par fichier CSV.",
'group_tools:settings:invite_members' => "Permettre aux membres du groupe d'inviter de nouveaux utilisateurs.",
'group_tools:settings:invite_members:default_off' => "Oui, désactivé par défaut", 
'group_tools:settings:invite_members:default_on' => "Oui, activé par défaut.",
'group_tools:settings:invite_members:description' => "Les propriétaires ou les administrateurs de groupes peuvent activer/désactiver cette option pour leur groupe.",
'group_tools:settings:domain_based' => "Activer les groupes basé à partir des domaines",
'group_tools:settings:domain_based:description' => "Les utilisateurs peuvent se joindre à un groupe en fonction du domaine de leur courriel. Lors de l'inscription, il seront automatiquement adhérer à des groupes en fonctionne du domaine de leur courriel.",		
'group_tools:settings:mail' => "Permettre des messages de groupe (permet aux administrateurs du groupe d'envoyer un message à tous les membres).",		
'group_tools:settings:listing:default' => "Onglet de liste de groupes par défaut.",
'group_tools:settings:listing:available' => "Onglets de liste de groupes disponibles.",		
'group_tools:settings:default_access' => "Que devrait être le niveau d'accès par défaut du contenu des groupes de ce site?",
'group_tools:settings:default_access:disclaimer' => "<b>AVERTISSEMENT :</b> Ceci ne fonctionnera pas à moins que vous ayez <a href='https://github.com/Elgg/Elgg/pull/253' target='_blank'>https://github.com/Elgg/Elgg/pull/253</a> présenté une demande à votre installation de Elgg.",	
'group_tools:settings:search_index' => "Permettre aux groupes fermés d'être indexés par les moteurs de recherche.",
'group_tools:settings:auto_notification' => "Activer automatiquement les notifications de groupes au moment de l'adhésion à un groupe.",
'group_tools:settings:show_membership_mode' => "Afficher le statut de membre ouvert/fermé sur le profil du groupe et sur le bloc du propriétaire.",
'group_tools:settings:show_hidden_group_indicator' => "Afficher un identifiant si un group est caché",
'group_tools:settings:show_hidden_group_indicator:group_acl' => "Oui, ce groupe est pour les membres seulement",
'group_tools:settings:show_hidden_group_indicator:logged_in' => "Oui, pour tous les groupes qui ne sont pas publics",		
'group_tools:settings:special_states' => "Groupes avec un état particulier",
'group_tools:settings:special_states:featured' => "En vedette",
'group_tools:settings:special_states:featured:description' => "Les administrateurs du site ont décidé de mettre en vedette les groupes suivants :",
'group_tools:settings:special_states:auto_join' => "Adhésion automatique",
'group_tools:settings:special_states:auto_join:description' => "Les nouveaux utilisateurs adhéreront automatiquement aux groupes suivants :",
'group_tools:settings:special_states:suggested' => "Suggérés",
'group_tools:settings:special_states:suggested:description' => "Les groupes suivants ont été suggérés aux (nouveaux) utilisateurs. Il est possible de suggérer automatiquement des groupes, si aucun groupe n'est automatiquement détecté ou que très peu de groupes le sont, la liste sera annexée à ces groupes.",		
'group_tools:settings:fix:title' => "Corriger les problèmes d'accès au groupe.",
'group_tools:settings:fix:missing' => "Il y a %d  utilisateurs qui sont membres d'un groupe, mais qui n'ont pas accès au contenu partagé avec le groupe.",
'group_tools:settings:fix:excess' => "Il y a %d utilisateurs qui ont accès au contenu de groupes auxquels ils ne sont plus membres.",
'group_tools:settings:fix:without' => "Il y a %d groupes qui ne peuvent partager de contenu avec leurs membres.",
'group_tools:settings:fix:all:description' => "Corriger simultanément tous les problèmes ci-dessus.",
'group_tools:settings:fix_it' => "Corriger ceci.",
'group_tools:settings:fix:all' => "Corriger tous les problèmes.",
'group_tools:settings:fix:nothing' => "Tout va bien avec les groupes sur votre site!",		
'group_tools:settings:member_export' => "Autoriser les administrateurs du groupe d'exporter des informations sur les membres",
'group_tools:settings:member_export:description' => "Cela inclut le nom, le nom d'utilisateur et l'adresse courriel de l'utilisateur",

	
// group tool presets
'group_tools:admin:group_tool_presets:description' => "Here you can configure group tool presets.
When a user creates a group he/she gets to choose one of the presets in order to quickly get the correct tools. A blank option is also offered to the user to allow his/her own choices.",
'group_tools:admin:group_tool_presets:header' => "Existing presets",
'group_tools:create_group:tool_presets:description' => "You can select a group tool preset here. If you do so, you will get a set of tools which are configured for the selected preset. You can always chose to add additional tools to a preset, or remove the ones you do not like.",
'group_tools:create_group:tool_presets:active_header' => "Tools for this preset",
'group_tools:create_group:tool_presets:more_header' => "Extra tools",
'group_tools:create_group:tool_presets:select' => "Select a group type",
'group_tools:create_group:tool_presets:show_more' => "More tools",
'group_tools:create_group:tool_presets:blank:title' => "Blank group",
'group_tools:create_group:tool_presets:blank:description' => "Choose this group to select your own tools.",
	
	
	// group invite message
'group_tools:groups:invite:body' => "Bonjour %s,</br></br>%s vous a invité(e) à vous joindre au groupe '%s'.</br>%s</br></br>Voir ci-dessous le message/l'invitation :</br>%s",
		
// group add message		
'group_tools:groups:invite:add:subject' => "Vous avez été ajouté au groupe %s.",
'group_tools:groups:invite:add:body' => "Bonjour %s,</br></br>%s vous a ajouté au groupe %s.</br>%s</br></br>Pour voir le groupe, cliquer sur le lien suivant</br>%s.",
		
// group invite by email		
'group_tools:groups:invite:email:subject' => "Vous avez reçu une invitation pour le groupe %s.",
'group_tools:groups:invite:email:body' => "Bonjour,</br></br>%s vous a invité à vous joindre au groupe %s sur %s.</br>%s</br></br>Si vous n'avez pas de compte sur %s, inscrivez-vous ici</br>%s</br></br>Si vous avez déjà un compte ou lorsque vous vous serez inscrit, cliquer sur le lien suivant pour accepter l'invitation</br>%s</br></br>Vous pouvez également aller à Tous les groupes du site -> Invitations de groupe et entrer le code suivant :</br>%s",
		
// group transfer notification		
'group_tools:notify:transfer:subject' => "L'administration du groupe %s vous a été confiée.",
'group_tools:notify:transfer:message' => "Bonjour %s,</br></br>%s vous a nommé à titre de nouvel administrateur du groupe %s.</br></br>Pour visiter le groupe, cliquer sur le lien suivant :</br>%s",
		
// deline membeship request notification		
'group_tools:notify:membership:declined:subject' => "Votre demande d'adhésion pour '%s' a été refusée",
'group_tools:notify:membership:declined:message' => "Bonjour %s, Votre demande d'adhésion pour le groupe '%s' a été refusée. Vous pouvez trouver le groupe ici : %s",

	// group edit tabbed
'group_tools:group:edit:profile' => "Profil du groupe/outils",
'group_tools:group:edit:access' => "Accès",
'group_tools:group:edit:tools' => "Outils",
'group_tools:group:edit:other' => "Autres options",
		
// admin transfer - form		
'group_tools:admin_transfer:current' => "Garder le propriétaire actuel : %s",
'group_tools:admin_transfer:transfer' => "Transférer la propriété du groupe à",
'group_tools:admin_transfer:myself' => "Moi-même",
'group_tools:admin_transfer:submit' => "Transférer",
'group_tools:admin_transfer:no_users' => "Aucun membre ou collègue à qui transférer la propriété.",
'group_tools:admin_transfer:confirm' => "Êtes-vous sûr de vouloir transférer la propriété?",
		
// special states form		
'group_tools:special_states:title' => "États particuliers du groupe",
'group_tools:special_states:description' => "Un groupe peut avoir plusieurs états particuliers. Voici une vue d'ensemble des états particuliers et de leur valeur actuelle :",
'group_tools:special_states:featured' => "Ce groupe est-il en vedette?",
'group_tools:special_states:auto_join' => "Les utilisateurs vont-ils adhérer automatiquement à ce groupe?",
'group_tools:special_states:auto_join:fix' => "Veuillez %scliquer ici%s pour ajouter tous les membres du site à ce groupe.",
'group_tools:special_states:suggested' => "Ce groupe est-il suggéré aux (nouveaux) utilisateurs?",
		
// group admins		
'group_tools:multiple_admin:group_admins' => "Administrateurs du groupe",
'group_tools:multiple_admin:profile_actions:remove' => "Supprimer un administrateur du groupe.",
'group_tools:multiple_admin:profile_actions:add' => "Ajouter un administrateur de groupe.",		
'group_tools:multiple_admin:group_tool_option' => "Autoriser les administrateurs du groupe à désigner d'autres administrateurs de groupe.",
		
// cleanup options		
'group_tools:cleanup:title' => "Nettoyage de la barre latérale du groupe.",
'group_tools:cleanup:description' => "Nettoyer la barre latérale du groupe. Ceci n'aura aucun effet sur les administrateurs du groupe.",
'group_tools:cleanup:owner_block' => "Limiter le bloc du propriétaire",
'group_tools:cleanup:owner_block:explain' => "Le bloc du propriétaire se trouve au haut de la barre latérale. Quelques liens supplémentaires peuvent être ajoutés à cet endroit (exemple : liens RSS).",
'group_tools:cleanup:actions' => "Voulez-vous permettre à des utilisateurs de se joindre à ce groupe?",
'group_tools:cleanup:actions:explain' => "Selon les paramètres de votre groupe, des utilisateurs peuvent se joindre directement au groupe ou faire une demande d'adhésion.",
'group_tools:cleanup:menu' => "Masquer les éléments de la barre latérale.",
'group_tools:cleanup:menu:explain' => "Masquer les liens du menu vers les différents outils du groupe. Les utilisateurs ne pourront avoir accès aux outils du groupe qu'en utilisant les widgets du groupe.",
'group_tools:cleanup:members' => "Masquer les membres du groupe.",
'group_tools:cleanup:members:explain' => "La liste des membres du groupe se trouve dans la section en surbrillance sur la page de profil du groupe. Vous pouvez choisir de la masquer.",
'group_tools:cleanup:search' => "Masquer la recherche dans le groupe.",
'group_tools:cleanup:search:explain' => "Il y a une boîte de recherche sur la page de profil du groupe. Vous pouvez choisir de la masquer.",
'group_tools:cleanup:featured' => "Afficher les groupes en vedette sur la barre latérale.",
'group_tools:cleanup:featured:explain' => "Vous pouvez choisir d'afficher une liste de groupes en vedette dans la section en surbrillance sur la page de profil du groupe.",
'group_tools:cleanup:featured_sorting' => "Comment trier les groupes en vedette.",
'group_tools:cleanup:featured_sorting:time_created' => "Le plus récent d'abord",
'group_tools:cleanup:featured_sorting:alphabetical' => "Ordre alphabétique",
'group_tools:cleanup:my_status' => "Masquer la barre latérale « Mon statut ».",
'group_tools:cleanup:my_status:explain' => "Vous pouvez consulter votre statut de membre actuel et d'autres renseignements sur celui-ci dans la barre latérale sur la page de profil du groupe. Vous pouvez également décider de masquer cette information.",
'group_tools:default_access:title' => "Accès par défaut du groupe",
'group_tools:default_access:description' => "Vous pouvez contrôler ici le niveau d'accès par défaut du nouveau contenu qui se trouve sur votre groupe.",
		
// group notification		
'group_tools:notifications:title' => "Notifications de groupe",
'group_tools:notifications:description' => "Ce groupe est composé de %s membres, dont %s ont autorisé les notifications sur les activités dans ce groupe. Vous pouvez modifier cette option ci-dessous pour tous les utilisateurs du groupe.",
'group_tools:notifications:disclaimer' => "Dans le cas de grands groupes, ceci pourrait prendre du temps.",
'group_tools:notifications:enable' => "Autoriser les notifications pour tous.",
'group_tools:notifications:disable' => "Désactiver les notifications pour tous,",
		
// group profile widgets		
'group_tools:profile_widgets:title' => "Afficher les widgets de profil du groupe aux non-membres.",
'group_tools:profile_widgets:description' => "Ceci est un groupe fermé. Par défaut, les non-membres ne peuvent voir les widgets. Vous pouvez modifier la configuration ici si vous le souhaitez.",
'group_tools:profile_widgets:option' => "Permettre aux non-membres de voir les widgets sur la page de profil du groupe :",
		
// group mail		
'group_tools:mail:message:from' => "Du groupe",		
'group_tools:mail:title' => "Envoyer un courriel aux membres du groupe.",
'group_tools:mail:form:recipients' => "Nombre de destinataires",
'group_tools:mail:form:members:selection' => "Sélectionner des membres individuels.",	
'group_tools:mail:form:title' => "Objet",
'group_tools:mail:form:description' => "Corps",		
'group_tools:mail:form:js:members' => "Veuillez sélectionner au moins un membre à qui envoyer le message.",
'group_tools:mail:form:js:description' => "Veuillez entrer un message.",
		
// group invite		
'group_tools:groups:invite:title' => "Inviter des utilisateurs à se joindre au groupe.",
'group_tools:groups:invite' => "Inviter des utilisateurs.",		
'group_tools:group:invite:friends:select_all' => "Sélectionner tous les collègues.",
'group_tools:group:invite:friends:deselect_all' => "Désélectionner tous les collègues.",		
'group_tools:group:invite:users' => "Trouver un ou des utilisateur(s).",
'group_tools:group:invite:users:description' => "Entrer le nom ou nom d'utilisateur d'un membre du site et le sélectionner dans la liste.",
'group_tools:group:invite:users:all' => "Inviter tous les membres du site à ce groupe",		
'group_tools:group:invite:email' => "En utilisant l'adresse de courriel",
'group_tools:group:invite:email:description' => "Entrer une adresse de courriel valide et la sélectionner dans la liste.",		
'group_tools:group:invite:csv' => "En utilisant le téléversement en format CSV",
'group_tools:group:invite:csv:description' => "Vous pouvez téléverser un fichier en format CSV qui contient une liste d'utilisateurs à inviter.<br />Le format doit être : nomd'affichage;adresse de courriel. Il ne devrait pas y avoir de ligne d’en-tête.",		
'group_tools:group:invite:text' => "Note personnelle (facultatif)",
'group_tools:group:invite:add:confirm' => "Êtes-vous sûr de vouloir ajouter directement ces utilisateurs?",		
'group_tools:group:invite:resend' => "Renvoyer des invitations aux utilisateurs qui ont déjà été invités.",		
'group_tools:groups:invitation:code:title' => "Invitation de groupe par courriel",
'group_tools:groups:invitation:code:description' => "Si vous avez reçu une invitation par courriel pour vous joindre à un groupe, vous pouvez entrer le code de l'invitation ici pour accepter l'invitation. Si vous cliquez sur le lien dans le courriel d'invitation, le code sera entré pour vous.",
		
// group membership requests		
'group_tools:groups:membershipreq:requests' => "Demandes d'adhésion",
'group_tools:groups:membershipreq:invitations' => "Invitations en suspens",
'group_tools:groups:membershipreq:invitations:none' => "Aucune invitation en suspens",
'group_tools:groups:membershipreq:email_invitations' => "Invitations envoyées par adresse courriel",
'group_tools:groups:membershipreq:email_invitations:none' => "Aucune invitation par courriel en attente",
'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Êtes-vous sûr de vouloir retirer cette invitation?",

	// group invitations
'group_tools:group:invitations:request' => "Demandes d'adhésion en suspens",
'group_tools:group:invitations:request:revoke:confirm' => "Êtes-vous sûr de vouloir retirer votre demande d'adhésion?",
'group_tools:group:invitations:request:non_found' => "Aucune demande d'adhésion en suspens pour le moment.",
		
// group listing		
'group_tools:groups:sorting:alphabetical' => "Ordre alphabétique",
'group_tools:groups:sorting:open' => "Ouverts",
'group_tools:groups:sorting:closed' => "Fermés",
'group_tools:groups:sorting:ordered' => "Ordonnés",
'group_tools:groups:sorting:suggested' => "Suggérés",
		
// discussion status		
'group_tools:discussion:confirm:open' => "Êtes-vous sûr de vouloir rouvrir ce sujet?",
'group_tools:discussion:confirm:close' => "Êtes-vous sûr de vouloir clore ce sujet?",
		
// allow group members to invite		
'group_tools:invite_members:title' => "Les membres du groupe peuvent envoyer des invitations.",
'group_tools:invite_members:description' => "Permettre aux membres de ce groupe d'inviter de nouveaux membres.",
		
// group tool option descriptions		
'activity:group_tool_option:description' => "Afficher sur le contenu lié au groupe dans le fil de nouvelle.",
'forum:group_tool_option:description' => "Permettre aux membres du groupe de commencer une discussion dans un format simple de forum.",
		
// actions		
'group_tools:action:error:input' => "Entrée invalide pour effectuer cette action.",
'group_tools:action:error:entities' => "Les GUID donnés ne désignent pas les bonnes entités", 
'group_tools:action:error:entity' => "Le GUID donné ne désigne pas la bonne entité", 
'group_tools:action:error:edit' => "Vous n'avez pas accès à l'entité donnée.",
'group_tools:action:error:save' => "Une erreur s'est produite lors de la sauvegarde des paramètres.",
'group_tools:action:success' => "Sauvegarde des paramètres réussie.",
		
// admin transfer - action		
'group_tools:action:admin_transfer:error:access' => "Vous n'avez pas l'autorisation de transférer la propriété de ce groupe.",
'group_tools:action:admin_transfer:error:self' => "Vous ne pouvez vous attribuer la propriété puisque vous êtes déjà propriétaire.",
'group_tools:action:admin_transfer:error:save' => "Une erreur inconnue s'est produite lors de la sauvegarde du groupe, veuillez essayer de nouveau.",
'group_tools:action:admin_transfer:success' => "Transfert de propriété du groupe à %s réussi.",
		
// group admins - action		
'group_tools:action:toggle_admin:error:group' => "L'entrée donnée ne désigne aucun groupe, vous ne pouvez modifier ce groupe ou l'utilisateur n'est pas un membre.", 
'group_tools:action:toggle_admin:error:remove' => "Une erreur inconnue s'est produite lors de la suppression de l'utilisateur en tant qu'administrateur du groupe.",
'group_tools:action:toggle_admin:error:add' => "Une erreur inconnue s'est produite lors de l'ajout de l'utilisateur en tant qu'administrateur du groupe.",
'group_tools:action:toggle_admin:success:remove' => "Suppression de l'utilisateur en tant qu'administrateur du groupe réussie.",
'group_tools:action:toggle_admin:success:add' => "Ajout de l'utilisateur en tant qu'administrateur du groupe réussi.",
		
// group mail - action		
'group_tools:action:mail:success' => "Envoi du message réussi.",
		
// group - invite - action		
'group_tools:action:invite:error:invite' => "Aucun utilisateur n'a été invité (%s déjà invités, %s déjà membres).",
'group_tools:action:invite:error:add' => "Aucun utilisateur n'a été ajouté (%s déjà invités, %s déjà membres).",
'group_tools:action:invite:success:invite' => "Invitation de %s utilisateurs réussie (%s déjà invités, %s déjà membres).",
'group_tools:action:invite:success:add' => "Ajout de %s utilisateurs réussi (%s déjà invités, %s déjà membres).",
		
// group - invite - accept e-mail		
'group_tools:action:groups:email_invitation:error:input' => "Veuillez entrer un code d'invitation.",
'group_tools:action:groups:email_invitation:error:code' => "Le code d'invitation entré n'est plus valide.",
'group_tools:action:groups:email_invitation:error:join' => "Une erreur inconnue s'est produite lors de votre adhésion au groupe %s; peut-être êtes-vous déjà membre.",
'group_tools:action:groups:email_invitation:success' => "Adhésion au groupe réussie.",
		
// group - invite - decline e-mail		
'group_tools:action:groups:decline_email_invitation:error:delete' => "Une erreur s'est produite lors de la suppression de l'invitation.",
		
// suggested groups		
'group_tools:suggested_groups:info' => "Les groupes suivants pourraient vous intéresser. Cliquer sur les boutons d'adhésion afin de vous joindre immédiatement ou appuyer sur un titre pour en apprendre davantage sur le groupe.",
'group_tools:suggested_groups:none' => "Nous ne pouvons vous proposer un groupe. Ceci se produit lorsque nous n'avons pas suffisamment de renseignements sur vous ou que vous êtes déjà membre des groupes que nous aimerions vous proposer. Utiliser l'option de recherche pour trouver plus de groupes.",
		
// group toggle auto join		
'group_tools:action:toggle_special_state:error:auto_join' => "Une erreur s'est produite lors de la sauvegarde des nouveaux paramètres d'adhésion automatique.",
'group_tools:action:toggle_special_state:error:suggested' => "Une erreur s'est produite lors de la sauvegarde des nouveaux paramètres proposés.",
'group_tools:action:toggle_special_state:error:state' => "État invalide fourni.",
'group_tools:action:toggle_special_state:auto_join' => "Sauvegarde des nouveaux paramètres d'adhésion automatique réussie.",
'group_tools:action:toggle_special_state:suggested' => "Sauvegarde des nouveaux paramètres suggérés réussie.",
		
// group fix auto_join		
'group_tools:action:fix_auto_join:success' => "Inscriptions au groupe corrigées : %s nouveaux membres, %s étaient déjà membres et %s échecs.",
		
// group cleanup		
'group_tools:actions:cleanup:success' => "Sauvegarde des paramètres de nettoyage réussie.",
		
// group default access		
'group_tools:actions:default_access:success' => "Sauvegarde de l'accès par défaut du groupe réussie.",
		
// group notifications		
'group_tools:action:notifications:error:toggle' => "Option de bascule invalide",
'group_tools:action:notifications:success:disable' => "Désactivation de notifications pour chaque membre réussie.",
'group_tools:action:notifications:success:enable' => "Activation de notifications  pour chaque membre réussie.",
		
// fix group problems		
'group_tools:action:fix_acl:error:input' => "Option(s) invalide(s) que vous ne pouvez corriger : %s.",
'group_tools:action:fix_acl:error:missing:nothing' => "Aucun utilisateur manquant sur les listes de contrôle d'accès (ACL) du groupe.",
'group_tools:action:fix_acl:error:excess:nothing' => "Aucun utilisateur excédentaire sur les listes de contrôle d'accès (ACL) du groupe.",
'group_tools:action:fix_acl:error:without:nothing' => "Aucun groupe sans liste de contrôle d'accès (ACL).",
		
'group_tools:action:fix_acl:success:missing' => "Ajout de %d utilisateurs sur les listes de contrôle d'accès (ACL) du groupe réussi.",
'group_tools:action:fix_acl:success:excess' => "Suppression de %d utilisateurs sur les listes de contrôle d'accès (ACL) du groupe réussie.",
'group_tools:action:fix_acl:success:without' => "Création de listes de contrôle d'accès (ACL) du groupe %d réussie.",

// discussion toggle status
'group_tools:action:discussion:toggle_status:success:open' => "Réouverture du sujet réussie.",
'group_tools:action:discussion:toggle_status:success:close' => "Clôture du sujet réussie.",
		
// Widgets		
// Group River Widget		
'widgets:group_river_widget:title' => "Activité du groupe",
'widgets:group_river_widget:description' => "Affiche l'activité d'un groupe dans un widget.",	
'widgets:group_river_widget:edit:num_display' => "Nombre d'activités",
'widgets:group_river_widget:edit:group' => "Sélectionner un groupe.",
'widgets:group_river_widget:edit:no_groups' => "Vous devez être membre d'au moins un groupe pour utiliser ce widget.",		
'widgets:group_river_widget:view:not_configured' => "Ce widget n'est pas encore configuré.",		
'widgets:group_river_widget:view:more' => "Activité dans le groupe '%s'.",
'widgets:group_river_widget:view:noactivity' => "Aucune activité n'a été trouvée.",
			
// Group Members		
'widgets:group_members:title' => "Membres du groupe.",
'widgets:group_members:description' => "Affiche les membres de ce groupe.",		
'widgets:group_members:edit:num_display' => "Combien de membres désirez-vous afficher?",
'widgets:group_members:view:no_members' => "Aucun membre du groupe n'a été trouvé.",
		
// Group Invitations		
'widgets:group_invitations:title' => "Invitations du groupe",
'widgets:group_invitations:description' => "Affiche les invitations de groupe en suspens de l'utilisateur actuel.",
		
// Discussion		
'widgets:discussion:settings:group_only' => "Afficher seulement les discussions des groupes dont vous êtes membre.",
'widgets:discussion:more' => "Afficher plus de discussions.",
'widgets:discussion:description' => "Affiche les dernières discussions.",
		
// Forum topic widget		
'widgets:group_forum_topics:description' => "Afficher les dernières discussions.",
		
// index_groups		
'widgets:index_groups:description' => "Lister les groupes les plus récents sur GCconnex.",
'widgets:index_groups:show_members' => "Afficher le nombre de membres.",
'widgets:index_groups:featured' => "Afficher seulement les groupes en vedette.",
'widgets:index_groups:sorting' => "Comment trier les groupes?",		
'widgets:index_groups:filter:field' => "Filtrer les groupes selon le champ du groupe.",
'widgets:index_groups:filter:value' => "avec valeur",
'widgets:index_groups:filter:no_filter' => "aucun filtre",
		
// Featured Groups		
'widgets:featured_groups:description' => "Afficher une liste aléatoire de groupes en vedette.",
'widgets:featured_groups:edit:show_random_group' => "Afficher aléatoirement un groupe qui n'est pas en vedette.",
		
// group_news widget		
'widgets:group_news:title' => "Nouvelles du groupe",
'widgets:group_news:description' => "Affiche les 5 blogues les plus récents parmi les différents groupes.",
'widgets:group_news:no_projects' => "Aucun groupe configuré",
'widgets:group_news:no_news' => "Aucun blogue pour ce groupe",
'widgets:group_news:settings:project' => "Groupe",
'widgets:group_news:settings:no_project' => "Sélectionner un groupe",
'widgets:group_news:settings:blog_count' => "Nombre maximum de blogues",
'widgets:group_news:settings:group_icon_size' => "Taille de l'icône du groupe",
'widgets:group_news:settings:group_icon_size:small' => "Petite",
'widgets:group_news:settings:group_icon_size:medium' => "Moyenne",
		
// quick start discussion		
'group_tools:widgets:start_discussion:title' => "Amorcer une discussion.",
'group_tools:widgets:start_discussion:description' => "Amorcer rapidement une discussion dans un groupe sélectionné.",		
'group_tools:widgets:start_discussion:login_required' => "Vous devez ouvrir une session pour utiliser ce widget.",
'group_tools:widgets:start_discussion:membership_required' => "Vous devez être membre d'au moins un groupe pour utiliser ce widget. Vous trouverez des groupes intéressants %sici%s.",		
'group_tools:forms:discussion:quick_start:group' => "Sélectionner un groupe pour cette discussion.",
'group_tools:forms:discussion:quick_start:group:required' => "Veuillez sélectionner un groupe.",		
'groups:search:tags' => "chercher",
'groups:search:title' => "Rechercher des groupe correspondant à '%s'",
'groups:searchtag' => "Recherche de groupes",
		
// welcome message		
'group_tools:welcome_message:title' => "Message d'accueil de groupe",
'group_tools:welcome_message:description' => "Vous pouvez configurer un message d'accueil pour les nouveau utilisateurs qui se joignent à ce groupe. Si vous ne voulez pas envoyer de message d'accueil, veuillez laisser ce champ vide.",
'group_tools:welcome_message:explain' => "Afin de personnaliser le message, vous pouvez utiliser les paramètres suivants:
		[nom] : le nom du nouvel utilisateurs (par exemple : %s)
		[nom_groupe] : le nom de ce groupe (par exemple : %s)
		[adresse url] : l'adresse URL de ce groupe (par exemple : %s)",
		
'group_tools:action:welcome_message:success' => "Le message d'accrueil a été sauvegardé",		
'group_tools:welcome_message:subject' => "Bienvenue à %s",
		
// email invitations		
'group_tools:action:revoke_email_invitation:error' => "Une erreur est survenir lorsque vous avez tenté d'annuler l'invitation, veuillez essayer à nouveau",
'group_tools:action:revoke_email_invitation:success' => "L'invitation a été annulée",
		
// domain based groups		
'group_tools:join:domain_based:tooltip' => "En raison du domaine de votre courriel, vous pouvez joindre ce groupe.",		
'group_tools:domain_based:title' => "Configurer le domaine des adresses courriels",
'group_tools:domain_based:description' => "Lorsque vous configurez un (ou plusieurs) domaines de courriels, les utilisateurs avec ce même domaine pourront automatiquement joindre votre groupe dès leur inscription. De plus, si vous avez un groupe fermé, tous les utilisateurs avec le même domaine de courriel pourront se joindre à votre groupe sans demander l'adhésion. Il vous est possible de configurer plusieurs domaines en utisant une virgule. Ne pas ajouter le signe @",		
'group_tools:action:domain_based:success' => "Le nouveau domaine de courriel a été sauvegardé",
		
// related groups		
'groups_tools:related_groups:tool_option' => "Afficher les groupes connexes",
'groups_tools:related_groups:widget:title' =>  "Groupes connexes",
'groups_tools:related_groups:widget:description' => "Afficher une liste des groupes connexes que vous avez ajouté à ce groupe",	
'groups_tools:related_groups:none' => "Aucun groupe connexe n’a été trouvé",
'group_tools:related_groups:title' => "Groupes connexes",		
'group_tools:related_groups:form:placeholder' => "Chercher un nouveau groupe connexe",
'group_tools:related_groups:form:description' => "Vous pouvez chercher un nouveau groupe connexe, le sélectionner dans la liste, et cliquer sur Ajouter",		
'group_tools:action:related_groups:error:same' => "Vous ne pouvez pas lier ce groupe à lui-même",
'group_tools:action:related_groups:error:already' => "Le groupe sélectionné est déjà un groupe connexe",
'group_tools:action:related_groups:error:add' => "Une erreur inconnue s’est produite pendant l’ajout de la connexion entre les deux groupes, veuillez essayer de nouveau",
'group_tools:action:related_groups:success' => 	"Ce groupe est maintenant un groupe connexe",		
'group_tools:related_groups:notify:owner:subject' => "Un nouveau groupe connexe a été ajouté",
'group_tools:related_groups:notify:owner:message' => "Hi %s, %s added your group %s as a related group to %s.",		
'group_tools:related_groups:entity:remove' => "Supprimer la connexion avec ce groupe",		
'group_tools:action:remove_related_groups:error:not_related' => "Le groupe n’est pas un groupe connexe",
'group_tools:action:remove_related_groups:error:remove' => "Une erreur inconnue s’est produite pendant la suppression de la connexion entre les deux groupes, veuillez essayer de nouveau",
'group_tools:action:remove_related_groups:success' => "Ce groupe n’est plus un groupe connexe",		
'group_tools:action:group_tool:presets:saved' => "Nouveaux outils de groupe préréglés sauvegardés",
		
// group member export		
'group_tools:member_export:title_button' => "Exportez les membres",
		
// group bulk delete		
'group_tools:action:bulk_delete:success' => "The selected groups were deleted", 		
'group_tools:action:bulk_delete:error' => "An error occured while deleting the groups, please try again", 		

);

add_translation("fr", $french);
