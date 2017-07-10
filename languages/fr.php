<?php

/**
 * Core English Language
 *
 * @package Elgg.Core
 * @subpackage Languages.English
 */

return array(

  'event_calendar:month:01' => "janvier",
  'event_calendar:month:02' => "février",
  'event_calendar:month:03' => "mars",
  'event_calendar:month:04' => "avril",
  'event_calendar:month:05' => "mai",
  'event_calendar:month:06' => "juin",
  'event_calendar:month:07' => "juillet",
  'event_calendar:month:08' => "août",
  'event_calendar:month:09' => "septembre",
  'event_calendar:month:10' => "octobre",
  'event_calendar:month:11' => "novembre",
  'event_calendar:month:12' => "décembre",

// extra
	'NotificationException:NoEmailAddress' => "Impossible de trouver une adresse e-mail pour GUID:%d",
	'NotificationException:MissingParameter' => "Un argument obligatoire a été omis, '%s'",

/**
 * Sites
 */

	'item:site' => "Sites",

/**
 * Sessions
 */

	'login' => "Ouvrir une session",
	'loginok' => "L'ouverture de session a réussi.",
	'loginerror' => "Nous n'avons pas pu vous connecter. Cette erreur peut être attribuable au fait que vous n'avez pas encore validé votre compte, que les informations entrées sont incorrectes ou que vous avez fait un trop grand nombre de tentatives de connexion. Assurez-vous que les informations que vous avez entrées sont correctes et réessayez.",
	'login:empty' => "Nom d'utilisateur et mot de passe sont requis.",
	'login:baduser' => "Impossible de charger votre compte d'utilisateur.",
	'auth:nopams' => "Erreur interne. Aucune méthode d'authentification des utilisateurs installés.",

	'logout' => "Fermer la session",
	'logoutok' => "La fermeture de session a réussi; vous êtes déconnecté.",
	'logouterror' => "Nous n'avons pas pu mettre fin à votre session. Essayez de nouveau.",
	'session_expired' => "Suite à un temps d'inactivité prolongé, votre session de travail a expiré. Veuillez svp recharger la page afin de vous identifier à nouveau.",

	'loggedinrequired' => "Vous devez être connecté pour voir cette page.",
	'adminrequired' => "Vous devez être administrateur pour voir cette page.",
	'membershiprequired' => "Vous devez être membre de ce groupe pour voir cette page.",
	'limited_access' => "Vous n'avez pas la permission de consulter cette page.",

/**
 * Errors
 */

	'exception:title' => "Erreur Fatale.",
	'exception:contact_admin' => 'Une erreur irrécupérable s\'est produite et a été enregistrée dans le journal. Veuillez SVP contacter l\'administrateur du site avec les informations suivantes :',

	'actionundefined' => "L'action demandée (%s) n'est pas définie dans le système.",
	'actionnotfound' => "Le fichier d'action pour %s n'a pas été trouvé.",
	'actionloggedout' => "Désolé, vous ne pouvez pas effectuer cette action sans être connecté.",
	'actionunauthorized' => "Vous n'êtes pas autorisé à effectuer cette action",

	'ajax:error' => 'Une erreur est survenue lors d\'un appel AJAX. Peut-être que la connexion avec le serveur est perdue.',
	'ajax:not_is_xhr' => 'Vous ne pouvez pas accéder directement aux vues AJAX',

	'PluginException:MisconfiguredPlugin' => "%s (guid : %s) est un plugin non configuré. Il a été désactivé. Veuillez chercher dans le wiki d'Elgg pour connaître les cause possibles (http://docs.elgg.org/wiki/).",
	'PluginException:CannotStart' => "%s (guid : %s) ne peut pas démarrer. Raison : %s",
	'PluginException:InvalidID' => "%s est un ID de plugin invalide.",
	'PluginException:InvalidPath' => "%s est un chemin invalide pour le plugin.",
	'PluginException:InvalidManifest' => "Fichier manifest.xml invalide pour le plugin %s",
	'PluginException:InvalidPlugin' => "%s n'est pas un plugin valide.",
	'PluginException:InvalidPlugin:Details' => "%s n'est pas valide. plugin : %s",
	'ElggPlugin:MissingID' => "Manque l'ID du plugin (guid %s)",
	'ElggPlugin:NoPluginPackagePackage' => "Manque le paquet d'Elgg 'ElggPluginPackage' du plugin ID %s (guid %s)",
	'ElggPluginPackage:InvalidPlugin:MissingFile' => "Manque le fichier %s dans le paquet",
	'ElggPluginPackage:InvalidPlugin:InvalidId' => 'Le dossier du plugin doit être renommé en "%s" pour correspondre à l\'identifiant spécifié dans le manifeste. ',
	'ElggPluginPackage:InvalidPlugin:InvalidDependency' => "Type '%s' des dépendances invalide",
	'ElggPluginPackage:InvalidPlugin:InvalidProvides' => "Type '%s' invalide",
	'ElggPluginPackage:InvalidPlugin:CircularDep' =>"%s invalide dans dépendance '%s', dans le plugin %s. Les plugins peuvent pas être en conflit avec, ou avoir besoin de quelque chose, qu'ils contiennent !",
	'ElggPlugin:Exception:CannotIncludeFile' => "Impossible d'inclure %s pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterViews' => "Impossible d'ouvrir la vue dir pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterLanguages' => "Impossible d'enregistrer les langues pour le plugin %s (guid : %s) sur %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:NoID' => "Aucun ID pour le plugin guid %s !",
	'PluginException:NoPluginName' => "Le nom du plugin n'a pas pu être trouvé",
	'PluginException:ParserError' => "Erreur de syntaxe du fichier manifest.xml avec la version %s de l'API du plugin %s.",
	'PluginException:NoAvailableParser' => "Analyseur syntaxique du fichier manifest.xml introuvable pour l'API version %s du plugin %s.",
	'PluginException:ParserErrorMissingRequiredAttribute' => "L'attribut nécessaire '%s' manque dans le fichier manifest.xml pour le plugin %s.",
	'ElggPlugin:InvalidAndDeactivated' => '%s est un plugin invalide et a été désactivé.',

	'ElggPlugin:Dependencies:Requires' => 'Requiert',
	'ElggPlugin:Dependencies:Suggests' => 'Suggère',
	'ElggPlugin:Dependencies:Conflicts' => 'Est en conflit avec',
	'ElggPlugin:Dependencies:Conflicted' => 'En conflit',
	'ElggPlugin:Dependencies:Provides' => 'Fournit',
	'ElggPlugin:Dependencies:Priority' => 'Priorité',

	'ElggPlugin:Dependencies:Elgg' => "version d'Elgg",
	'ElggPlugin:Dependencies:PhpVersion' => 'Version de PHP',
	'ElggPlugin:Dependencies:PhpExtension' => "extension PHP : %s",
	'ElggPlugin:Dependencies:PhpIni' => "Paramètre PHP ini : %s",
	'ElggPlugin:Dependencies:Plugin' => "Plugin: %s",
	'ElggPlugin:Dependencies:Priority:After' => "Après %s",
	'ElggPlugin:Dependencies:Priority:Before' => "Avant %s",
	'ElggPlugin:Dependencies:Priority:Uninstalled' => "%s n'est pas installé",
	'ElggPlugin:Dependencies:Suggests:Unsatisfied' => "Manquant",

	'ElggPlugin:Dependencies:ActiveDependent' => 'Il existe d\'autres plugins répertoriant %s en tant que dépendance. Vous devez désactiver les plugins suivants avant de désactiver celui-ci: %s',

	'ElggMenuBuilder:Trees:NoParents' => 'Des entrées de menu ont été trouvées sans parent qui soit relié à eux',
	'ElggMenuBuilder:Trees:OrphanedChild' => 'L\'entrée de menu [%s] a été trouvée avec un parent manquant [%s]',
	'ElggMenuBuilder:Trees:DuplicateChild' => 'L\'entrée de menu [%s] est enregistrée plusieurs fois',

	'RegistrationException:EmptyPassword' => "Les champs du mot de passe ne peut pas être vide",
	'RegistrationException:PasswordMismatch' => "Les mots de passe doivent correspondre",
	'LoginException:BannedUser' => "Vous avez été banni de ce site et ne pouvez plus vous connecter",
	'LoginException:UsernameFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:PasswordFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:AccountLocked' => "Votre compte a été verrouillé suite à un trop grand nombre d'échecs de connexion.",
	'LoginException:ChangePasswordFailure' => 'Echec vérification mot de passe courant.',
	'LoginException:Unknown' => 'Nous ne pouvons pas vous connecter à cause d\'une erreur inconnue.',

	'deprecatedfunction' => "Attention : Ce code source utilise une fonction périmée '%s'. Il n'est pas compatible avec cette version de Elgg.",

	'pageownerunavailable' => "Attention : La page de l'utilisateur %d n'est pas accessible.",
	'viewfailure' => "Il ya eu une erreur interne dans la vue %s",
	'view:missing_param' => "Le paramètre obligatoire '%s' manque dans la vue %s",
	'changebookmark' => "Veuillez changer votre favori pour cette page.",
	'noaccess' => 'La contenu que vous essayiez d\'afficher a été supprimé, ou vous n\'avez pas l\'autorisation d\'y accéder.',
	'error:missing_data' => 'Il y avait des données manquantes à votre requête',
	'save:fail' => 'Il y a eu une erreur lors de la sauvegarde de vos données. ',
	'save:success' => 'Vos données ont été sauvegardées',

	'error:default:title' => 'Oups...',
	'error:default:content' => 'Oups... quelque chose est allé de travers.',
	'error:400:title' => 'Mauvaise requête',
	'error:400:content' => 'Désolé, la requête est invalide ou incomplète.',
	'error:403:title' => 'Interdit',
	'error:403:content' => 'Désolé, vous n\'avez pas la permission de consulter la page demandée.',
	'error:404:title' => 'Page non trouvée',
	'error:404:content' => 'Désolé. Nous n\'arrivons pas à trouver la page que vous demandez.',

	'upload:error:ini_size' => 'Le fichier que vous avez essayé de charger est trop grand.',
	'upload:error:form_size' => 'Le fichier que vous avez essayé de télécharger est trop grand.',
	'upload:error:partial' => 'Le chargement du fichier n\'a pas abouti.',
	'upload:error:no_file' => 'Aucun fichier n\'a été sélectionné.',
	'upload:error:no_tmp_dir' => 'Impossible d\'enregistrer le fichier chargé.',
	'upload:error:cant_write' => 'Impossible d\'enregistrer le fichier chargé.',
	'upload:error:extension' => 'Impossible d\'enregistrer le fichier chargé.',
	'upload:error:unknown' => 'Le chargement du fichier a échoué.',


/**
 * User details
 */

	'name' => "Nom à afficher",
	'email' => "Adresse e-mail",
	'username' => "Nom d'utilisateur",
	'loginusername' => "Nom d'utilisateur GCconnex ou adresse courriel",
	'password' => "Mot de passe GCconnex",
	'passwordagain' => "Confirmation du mot de passe",
	'admin_option' => "Définir cet utilisateur comme administrateur ?",

/**
 * Access
 */

	'PRIVATE' => "Privé",
	'LOGGED_IN' => "Utilisateurs connectés",
	'PUBLIC' => "Publique",
	'LOGGED_OUT' => "Utilisateurs non connectés",
	'access:friends:label' => "Contacts",
	'access' => "Accès",
	'access:overridenotice' => "Note : Du fait de la politique de confidentialité du groupe, ce contenu ne sera accessible qu'aux membres du groupe. ",
	'access:limited:label' => "Limité",
	'access:help' => "Le niveau d'accès",
	'access:read' => "Accès en lecture",
	'access:write' => "Accès en écriture",
	'access:admin_only' => "Seulement les administrateurs",
	'access:missing_name' => "Le nom du niveau d'accès est manquant",
	'access:comments:change' => "Cette discussion n'est actuellement visible qu'à un public limité. Faites attention à qui vous la partagez.",

/**
 * Dashboard and widgets
 */

	'dashboard' => "Tableau de bord",
	'dashboard:nowidgets' => "Votre tableau de bord vous permet de suivre l'activité et le contenu qui vous importe.",

	'widgets:add' => "Ajouter des widgets",
	'widgets:add:description' => "Cliquez sur n'importe quel widget ci-dessous pour l'ajouter à la page.",
	'widgets:panel:close' => "Fermer le panneau des widgets",
	'widgets:position:fixed' => '(Position fixe sur la page)',
	'widget:unavailable' => 'Vous avez déjà ajouté ce widget',
	'widget:numbertodisplay' => 'Nombre d\'éléments à afficher ',

	'widget:delete' => "Supprimer le widget <<%s>>", // GCchange - Ilia: Specified that it is the widget that is being deleted
	'widget:edit' => "Personnaliser ce widget",

	'widgets' => "Widgets",
	'widget' => "Widget",
	'item:object:widget' => "Widgets",
	'widgets:save:success' => "La configuration du widget a bien été enregistrée.",
	'widgets:save:failure' => "Un problème est survenu lors de l'enregistrement de la configuration de votre widget. ",
	'widgets:add:success' => "Le widget a bien été ajouté.",
	'widgets:add:failure' => "Nous n'avons pas pu ajouter votre widget.",
	'widgets:move:failure' => "Nous n'avons pas pu enregistrer la position du nouveau widget.",
	'widgets:remove:failure' => "Impossible de supprimer ce widget",

/**
 * Groups
 */

	'group' => "Groupe",
	'item:group' => "Groupes",

/**
 * Users
 */

	'user' => "Utilisateur",
	'item:user' => "Utilisateurs",

/**
 * Friends
 */

	'friends' => "collègues",
	'friends:yours' => "Vos collègues",
	'friends:owned' => "Les collègues de %s",
	'friend:add' => "Ajouter un collègues",
	'friend:remove' => "Supprimer un collègues",

	'friends:add:successful' => "Vous avez ajouté %s à vos contacts.",
	'friends:add:failure' => "%s n'a pas pu être ajouté(e) à vos contacts.",

	'friends:remove:successful' => "Vous avez supprimé %s de vos contacts.",
	'friends:remove:failure' => "%s n'a pas pu être supprimé(e) de vos contacts. Merci de réessayer ultérieurement.",

	'friends:none' => "Cet utilisateur n'a pas encore ajouté de contact.",
	'friends:none:you' => "Vous n'avez pas encore de contact.",

	'friends:none:found' => "Aucun contact n'a été trouvé.",

	'friends:of:none' => "Personne n'a encore ajouté ce membre comme contact.",
	'friends:of:none:you' => "Personne ne vous a encore ajouté comme contact. Commencez par compléter votre page de profil et publiez du contenu pour que les gens vous trouvent !",

	'friends:of:owned' => "Les personnes qui ont %s dans leurs contacts",

	'friends:of' => "Contacts de",
	'friends:collections' => "Groupement de contacts",
	'collections:add' => "Nouvelle collection",
	'friends:collections:add' => "Nouveau groupement de contacts",
	'friends:addfriends' => "Sélectionner des contacts",
	'friends:collectionname' => "Nom du cercle",
	'friends:collectionfriends' => "Contacts dans le groupement",
	'friends:collectionedit' => "Modifier ce cercle",
	'friends:nocollections' => "Vous n'avez pas encore de cercle de contacts.",
	'friends:collectiondeleted' => "Votre groupement de contacts a été supprimé.",
	'friends:collectiondeletefailed' => "Le groupement de contacts n'a pas été supprimer. Vous n'avez pas de droits suffisants, ou un autre problème peut-être en cause.",
	'friends:collectionadded' => "Votre groupement de contact a été créé avec succès",
	'friends:nocollectionname' => "Vous devez nommer votre groupement de contact avant qu'il puisse être créé.",
	'friends:collections:members' => "Membres du cercle",
	'friends:collections:edit' => "Modifier le groupement de contacts",
	'friends:collections:edited' => "Collection sauvegardée",
	'friends:collection:edit_failed' => 'Impossible de sauvegarder la collection.',

	'friendspicker:chararray' => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",

	'avatar' => "Avatar",
	'avatar:noaccess' => "Vous n'êtes pas autorisé à modifier l'avatar de cet utilisateur",
	'avatar:create' => "Créez votre avatar",
	'avatar:edit' => "Modifier mon avatar",
	'avatar:preview' => "Extrait",
	'avatar:upload' => "Envoyer un nouvel avatar",
	'avatar:current' => "Avatar actuel",
	'avatar:remove' => 'Supprime votre avatar et restaure l\'icône par défaut',
	'avatar:crop:title' => "Outil pour recadrer l'avatar",
	'avatar:upload:instructions' => "Votre avatar est affiché sur tout le site. Vous pouvez le changer quand vous le souhaitez. (Formats de fichiers acceptés: GIF, JPG ou PNG)",
	'avatar:create:instructions' => "Cliquez et faites glisser un carré ci-dessous selon la façon dont vous voulez que votre avatar soit recadré. Un aperçu s'affiche sur la droite. Lorsque vous êtes satisfait de l'aperçu, cliquez sur «Créez votre avatar». Cette version recadrée sera utilisée sur le site.",
	'avatar:upload:success' => "Avatar téléchargé avec succès",
	'avatar:upload:fail' => "Échec de l'envoi de l'image",
	'avatar:resize:fail' => "Le redimensionnement de l'avatar a échoué",
	'avatar:crop:success' => "Le redimensionnement de l'avatar a réussi",
	'avatar:crop:fail' => "Le recadrage de l'avatar a échoué",
	'avatar:remove:success' => 'Suppression de l\'avatar terminée',
	'avatar:remove:fail' => 'Échec de la suppression de l\'avatar',

	'profile:edit' => "Modifier mon profil",
	'profile:aboutme' => "A propos de moi",
	'profile:description' => "A propos de moi",
	'profile:briefdescription' => "Brève description",
	'profile:location' => "Lieu",
	'profile:skills' => "Compétences",
	'profile:interests' => "Intérêts",
	'profile:contactemail' => "Courriel",
	'profile:phone' => "Téléphone",
	'profile:mobile' => "Téléphone portable",
	'profile:website' => "Site Web",
	'profile:twitter' => "Nom d'utilisateur Twitter",
	'profile:saved' => "Votre profil a bien été enregistré.",

	'profile:field:text' => 'Texte court',
	'profile:field:longtext' => 'Zone de texte long',
	'profile:field:tags' => 'Tags',
	'profile:field:url' => 'Adresse web ',
	'profile:field:email' => 'Adresse email',
	'profile:field:location' => 'Adresse',
	'profile:field:date' => 'Date',

	'admin:appearance:profile_fields' => "Modifier les champs du profil",
	'profile:edit:default' => "Modifier les champs du profil",
	'profile:label' => "Etiquette du profil",
	'profile:type' => "Type de profil",
	'profile:editdefault:delete:fail' => "Echec de l'enlevement du champ profil par défaut",
	'profile:editdefault:delete:success' => "Le champ profil par défaut est supprimé!",
	'profile:defaultprofile:reset' => "Réinitialisation du profil système par défaut",
	'profile:resetdefault' => "Réinitialisation du profil par défaut",
	'profile:resetdefault:confirm' => 'Confirmez-vous vouloir supprimer vos champs de profil personnalisés ?',
	'profile:explainchangefields' =>"Vous pouvez remplacer les champs de profil existant avec les vôtres en utilisant le formulaire ci-dessous.\n\nDonner une étiquette pour le nouveau champ du profil, par exemple, 'équipe préférée', puis sélectionnez le type de champ (par exemple, texte, url, balises), et cliquez sur le bouton 'Ajouter'. Pour réordonner les champs faites glisser la poignée de l'étiquette du champ. Pour modifier un champ d'étiquette - cliquez sur le texte de l'étiquette pour le rendre modifiable. A tout moment vous pouvez revenir au profil par défaut, mais vous perdrez toutes les informations déjà entrées dans des champs personnalisés des pages de profil.",
	'profile:editdefault:success' => "Champ ajouté au profil par défaut avec succès",
	'profile:editdefault:fail' => "Le profil par défaut n'a pas pu être sauvé",
	'profile:field_too_long' => 'Impossible de sauver vos informations du profil car la section "%s" est trop longue.',
	'profile:noaccess' => "Vous n'avez pas la permission de modifier ce profil.",
	'profile:invalid_email' => '%s doit être une adresse email valide.',


/**
 * Feeds
 */
	'feed:rss' => "S'abonner au fil RSS de cette page",
/**
 * Links
 */
	'link:view' => "voir le lien",
	'link:view:all' => "Voir tout",


/**
 * River
 */
	'river' => "River",
	'river:friend:user:default' => "%s est maintenant ami avec %s",
	'river:update:user:avatar' => '%s a un nouvel avatar',
	'river:update:user:profile' => '%s a mis à jour son profil',
	'river:noaccess' => "Vous n'avez pas la permission de voir cet élément.",
	'river:posted:generic' => "%s envoyé",
	'riveritem:single:user' => "un utilisateur",
	'riveritem:plural:user' => "des utilisateurs",
	'river:ingroup' => "au groupe %s",
	'river:none' => "Aucune activité",
	'river:update' => 'Mise à jour pour %s',
	'river:delete' => 'Retirer cet élément du flux d\'activité',
	'river:delete:success' => 'L\'élément du flux d\'activité a été supprimé',
	'river:delete:fail' => 'L\'élément du flux d\'activité n\'a pas pu être effacé',
	'river:subject:invalid_subject' => 'Utilisateur invalide',
	'activity:owner' => 'Voir le flux d\'activité',
	
	'river:widget:title' => "Activité",
	'river:widget:description' => "Afficher l'activité la plus récente",
	'river:widget:type' => "Type d'activité",
	'river:widgets:friends' => "Activité des amis",
	'river:widgets:all' => "Toutes les activités sur le site",

/**
 * Notifications
 */
	'notifications:usersettings' => "Paramètres de notification",
	'notification:method:email' => 'Email',

	'notifications:usersettings:save:ok' => "Les paramètres de notification ont bien été enregistrées.",
	'notifications:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres de notification.",

	'notification:subject' => 'Notification à propos de %s',
	'notification:body' => 'Voir la nouvelle activité sur %s',

/**
 * Search
 */

	'search' => "Rechercher",
	'searchtitle' => "Rechercher : %s",
	'users:searchtitle' => "Recherche d'utilisateurs : %s",
	'groups:searchtitle' => "Recherche de groupes : %s",
	'advancedsearchtitle' => "%s avec des résultats correspondant à %s",
	'notfound' => "Aucun résultat trouvé.",
	'next' => "Suivant",
	'previous' => "Précédent",

	'viewtype:change' => "Changer le type de liste",
	'viewtype:list' => "Liste",
	'viewtype:gallery' => "Galerie",

	'tag:search:startblurb' => "Éléments avec des tags correspondant à \"%s\" :",

	'user:search:startblurb' => "Membres correspondant à \"%s\" :",
	'user:search:finishblurb' => "Pour en voir plus, cliquez ici.",

	'group:search:startblurb' => "Groupes correspondant à \"%s\" :",
	'group:search:finishblurb' => "Pour en voir plus, cliquez ici.",
	'search:go' => 'Rechercher',
	'userpicker:only_friends' => 'Seulement les contacts',

/**
 * Account
 */

	'account' => "Compte",
	'settings' => "Paramètres",
	'tools' => "Outils",
	'settings:edit' => 'Modifier les paramètres',

	'register' => "S'enregistrer",
	'registerok' => "Vous vous êtes bien enregistré(e) sur %s.",
	'registerbad' => "La création de votre compte a échoué pour une raison inconnue.",
	'registerdisabled' => "La création de compte a été désactivée par l'administrateur du site.",
	'register:fields' => 'Tous les champs sont requis',

	'registration:notemail' => "L'adresse e-mail que vous avez renseigné n'apparaît pas comme valide.",
	'registration:userexists' => "Ce nom d'utilisateur existe déjà",
	'registration:usernametooshort' => "Le nom d'utilisateur doit faire %u caractères au minimum.",
	'registration:usernametoolong' => 'Votre nom d\'utilisateur est trop long. Il peut comporter au maximum %u caractères.',
	'registration:passwordtooshort' => "Le mot de passe doit faire %u caractères au minimum.",
	'registration:dupeemail' => "Cette adresse e-mail est déjà utilisée.",
	'registration:invalidchars' => 'Désolé, votre nom d\'utilisateur contient le caractère invalide %s qui est invalide. Les caractères suivants sont invalides : %s',
	'registration:emailnotvalid' => "Désolé, l'adresse e-mail que vous avez entré est invalide sur ce site.",
	'registration:passwordnotvalid' => "Désolé, le mot de passe que vous avez entré est invalide sur ce site.",
	'registration:usernamenotvalid' => "Désolé, le nom d'utilisateur que vous avez entré est invalide sur ce site.",

	'adduser' => "Ajouter un utilisateur",
	'adduser:ok' => "Vous avez bien ajouté un nouvel utilisateur.",
	'adduser:bad' => "Le nouvel utilisateur n'a pas pu être créé.",

	'user:set:name' => "Nom",
	'user:name:label' => "Votre nom à afficher",
	'user:name:success' => "Votre nom a été changé avec succès.",
	'user:name:fail' => "Impossible de changer votre nom. Assurez-vous que votre nom n'est pas trop long et essayez à nouveau.",

	'user:set:password' => "Mot de passe",
	'user:current_password:label' => "Mot de passe actuel",
	'user:password:label' => "Votre nouveau mot de passe",
	'user:password2:label' => "Veuillez retaper votre nouveau mot de passe",
	'user:password:success' => "Mot de passe modifié avec succès",
	'user:password:fail' => "Impossible de modifier votre mot de passe.",
	'user:password:fail:notsame' => "Les deux mots de passe ne correspondent pas !",
	'user:password:fail:tooshort' => "Le mot de passe est trop court !",
	'user:password:fail:incorrect_current_password' => "Le mot de passe actuel entré est incorrect.",
	'user:resetpassword:unknown_user' => "Utilisateur inconnu.",
	'user:resetpassword:reset_password_confirm' => "Après réinitialisation de votre mot de passe, celui-ci sera envoyé à votre adresse e-mail.",
	'user:changepassword:unknown_user' => 'Utilisateur invalide.',
	'user:changepassword:change_password_confirm' => 'Cela modifiera votre mot de passe.',

	'user:set:language' => "Paramètre de langage",
	'user:language:label' => "Votre langue",
	'user:language:success' => "Votre paramètre de langage a été mis à jour.",
	'user:language:fail' => "Votre paramètre de langage n'a pas pu être sauvegardé.",

	'user:username:notfound' => "Nom d'utilisateur %s non trouvé.",

	'user:password:lost' => "Mot de passe perdu ?",
	'user:password:changereq:success' => 'Vous avez demandé un nouveau mot de passe, un email vous a été envoyé',
	'user:password:changereq:fail' => 'Impossible de demander un nouveau mot de passe.',

	//gcchange: descriptive password reset -  Troy T. Lawson
	'user:password:text' => "Pour générer un nouveau mot de passe, entrez votre nom d'utilisateur ou adresse courriel ci-dessous,  puis cliquez sur le bouton Requête. Un courriel vous sera envoyé pour réinitialiser votre mot de passe.</br></br><b>Nota :</b> Cela peut prendre plusieurs minutes avant de recevoir le courriel en raison de votre pare-feu ministériel. Pour éviter des délais supplémentaires, ne pas soumettre une autre requête – veuillez être patient.",
	
	'user:persistent' => "Se souvenir de moi",

	'walled_garden:welcome' => "Bienvenue à",

/**
 * Administration
 */
	'menu:page:header:administer' => "Administrer",
	'menu:page:header:configure' => "Configurer",
	'menu:page:header:develop' => "Développer",
	'menu:page:header:default' => 'Autre',

	'admin:view_site' => "Voir le site",
	'admin:loggedin' => "Connecté en tant que %s",
	'admin:menu' => "Menu",

	'admin:configuration:success' => "Vos paramètres ont été sauvegardés.",
	'admin:configuration:fail' => "Vos paramètres n'ont pas pu être sauvegardés.",
	'admin:configuration:dataroot:relative_path' => 'Impossible de définir "%s" comme racine pour le dossier de données car ce n\'est pas un chemin absolu.',
	'admin:configuration:default_limit' => 'Le nombre d\'éléments par page doit être d\'au moins 1.',

	'admin:unknown_section' => 'Section Admin invalide.',

	'admin' => "Administration",
	'admin:description' => "Le panneau d'administration vous permet de contrôler tous les aspects du système, de la gestion des utilisateurs au comportement des outils installés. Choisissez une option ci-dessous pour commencer.",

	'admin:statistics' => "Statistiques",
	'admin:statistics:overview' => 'Vue d\'ensemble',
	'admin:statistics:server' => 'Information du serveur',
	'admin:statistics:cron' => 'Table de planification (cron)',
	'admin:cron:record' => 'Dernières tâches planifiées',
	'admin:cron:period' => 'Période de la table de planification (cron)',
	'admin:cron:friendly' => 'Dernière exécution',
	'admin:cron:date' => 'Date et heure',

	'admin:appearance' => 'Apparence',
	'admin:administer_utilities' => 'Utilitaires',
	'admin:develop_utilities' => 'Utilitaires',
	'admin:configure_utilities' => 'Utilitaires',
	'admin:configure_utilities:robots' => 'Robots.txt',

	'admin:users' => "Utilisateurs",
	'admin:users:online' => "Actuellement en ligne",
	'admin:users:newest' => "Le plus récent",
	'admin:users:admins' => 'Administrateurs',
	'admin:users:add' => "Ajouter un nouvel utilisateur",
	'admin:users:description' => "Ce panneau d'administration vous permet de contrôler les paramètres des utilisateurs de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:users:adduser:label' => "Cliquez ici pour ajouter un nouvel utilisateur...",
	'admin:users:opt:linktext' => "Configurer les utilisateurs...",
	'admin:users:opt:description' => "Configurer les utilisateurs et les informations des comptes.",
	'admin:users:find' => "Trouver",

	'admin:administer_utilities:maintenance' => 'Mode maintenance',
	'admin:upgrades' => 'Mises à niveau',

	'admin:settings' => "Paramètres",
	'admin:settings:basic' => "Réglages de base",
	'admin:settings:advanced' => "Paramètres avancés",
	'admin:site:description' => "Ce menu vous permet de définir les paramètres principaux de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:site:opt:linktext' => "Configurer le site...",
	'admin:settings:in_settings_file' => 'Ce paramètre est configuré dans settings.php',

	'admin:legend:security' => 'Sécurité',
	'admin:site:secret:intro' => 'Elgg utilise une clé pour sécuriser les jetons de sécurité pour divers usages.',
	'admin:site:secret_regenerated' => "La clé secrète du site a été régénérée.",
	'admin:site:secret:regenerate' => "Régénérer la clé secrète du site",
	'admin:site:secret:regenerate:help' => "Note : régénérer votre clé peut poser problème à certains utilisateurs en invalidant les tokens utilisés dans les cookies de session, dans les emails de validation de compte, les codes d’invitation, etc.",
	'site_secret:current_strength' => 'Complexité de la clé',
	'site_secret:strength:weak' => "Faible",
	'site_secret:strength_msg:weak' => "Nous vous conseillons fortement de régénérer la clé secrète du site.",
	'site_secret:strength:moderate' => "Moyenne",
	'site_secret:strength_msg:moderate' => "Nous vous conseillons de régénérer la clé secrète du site pour une meilleure sécurité.",
	'site_secret:strength:strong' => "Forte",
	'site_secret:strength_msg:strong' => "La clé secrète de votre site est suffisamment forte. Nul besoin de la régénérer.",

	'admin:dashboard' => "Tableau de bord",
	'admin:widget:online_users' => "Utilisateurs en ligne",
	'admin:widget:online_users:help' => "Affiche la liste des utilisateurs actuellement sur le site",
	'admin:widget:new_users' => "Nouveaux utilisateurs",
	'admin:widget:new_users:help' => "Affiche la liste des nouveaux utilisateurs",
	'admin:widget:banned_users' => 'Utilisateurs bannis',
	'admin:widget:banned_users:help' => 'Liste des utilisateurs bannis',
	'admin:widget:content_stats' => "Statistiques",
	'admin:widget:content_stats:help' => "Gardez une trace du contenu créé par vos utilisateurs",
	'admin:widget:cron_status' => 'Status du cron',
	'admin:widget:cron_status:help' => 'Afficher les statuts du dernier cron finit',
	'widget:content_stats:type' => "Type de contenu",
	'widget:content_stats:number' => "Nombre",

	'admin:widget:admin_welcome' => "Bienvenue",
	'admin:widget:admin_welcome:help' => "Une courte introduction à la zone d'administration de Elgg",
	'admin:widget:admin_welcome:intro' =>
"Bienvenue sur Elgg ! Vous êts actuellement sur le tableau de bord de l'administration. Il permet de faire le suivi de ce qui se passe sur le site.",

	'admin:widget:admin_welcome:admin_overview' =>
"La navigation dans l'administration se fait à l'aide du menu de droite. Il est organisé en"
. " 3 sections :
	<dl>
		<dt>Administrer</dt><dd>Les tâches quotidiennes comme le suivi du contenu signalé, l'aperçu des utilisateurs en ligne, l'affichage des statistiques...</dd>
		<dt>Configurer</dt><dd>Les tâches occasionnelles comme le paramétrage du nom du site ou l'activation d'un plugin.</dd>
		<dt>Développer</dt><dd>Pour les développeurs qui créent des plugins ou conçoient des thèmes. (Nécessite des connaissances en programmation.)</dd>
	</dl>
	",

	// argh, this is ugly
	'admin:widget:admin_welcome:outro' => "<br /> Soyez sûr de vérifier les ressources disponibles via les liens de bas de page et merci d'utiliser Elgg !",
	
	'admin:widget:control_panel' => 'Panneau de Contrôle',
	'admin:widget:control_panel:help' => "Fourni un accès facile aux contrôles communs",

	'admin:cache:flush' => 'Vider les caches',
	'admin:cache:flushed' => "Les caches du site ont été vidés",

	'admin:footer:faq' => "FAQ Administration",
	'admin:footer:manual' => "Guide sur l'administration",
	'admin:footer:community_forums' => "Forums de la communauté Elgg",
	'admin:footer:blog' => "Blog d'Elgg",

	'admin:plugins:category:all' => "Tous les plugins",
	'admin:plugins:category:active' => 'Plugins Actifs',
	'admin:plugins:category:inactive' => 'Plugins Inactifs',
	'admin:plugins:category:admin' => "Admin",
	'admin:plugins:category:bundled' => "Empaqueté",
	'admin:plugins:category:nonbundled' => 'Non-Empaqueté',
	'admin:plugins:category:content' => "Contenu",
	'admin:plugins:category:development' => "Développement",
	'admin:plugins:category:enhancement' => 'Améliorations',
	'admin:plugins:category:api' => 'Service/API',
	'admin:plugins:category:communication' => 'Communication',
	'admin:plugins:category:security' => 'Sécurité et spam',
	'admin:plugins:category:social' => 'Social',
	'admin:plugins:category:multimedia' => 'Multimédia',
	'admin:plugins:category:theme' => 'Thèmes',
	'admin:plugins:category:widget' => 'Widgets',
	'admin:plugins:category:utility' => 'Utilitaires',

	'admin:plugins:markdown:unknown_plugin' => "Plugin inconnu.",
	'admin:plugins:markdown:unknown_file' => "fichier inconnu.",

	'admin:notices:could_not_delete' => "Impossible de supprimer la remarque.",
	'item:object:admin_notice' => 'Note d\'administration',

	'admin:options' => "Options Admin",

/**
 * Plugins
 */

	'plugins:disabled' => 'Les Plugins ne sont pas chargés car un fichier nommé "disabled" (désactivé) est présent dans le répertoire mod.',
	'plugins:settings:save:ok' => "Les paramètres du plugin %s ont bien été enregistrés.",
	'plugins:settings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres du plugin %s.",
	'plugins:usersettings:save:ok' => "Les paramètres utilisateur du plugin %s ont bien été enregistrés.",
	'plugins:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres utilisateur du plugin %s.",
	'item:object:plugin' => "Plugins",

	'admin:plugins' => "Administrer les plugins",
	'admin:plugins:activate_all' => "Tout Activer",
	'admin:plugins:deactivate_all' => "Tout Désactiver",
	'admin:plugins:activate' => 'Activer',
	'admin:plugins:deactivate' => 'Désactiver',
	'admin:plugins:description' => "Ce menu vous permet de contrôler et de configurer les outils installés sur votre site.",
	'admin:plugins:opt:linktext' => "Configurer les outils...",
	'admin:plugins:opt:description' => "Configurer les outils installés sur le site.",
	'admin:plugins:label:author' => "Auteur",
	'admin:plugins:label:copyright' => "Copyright",
	'admin:plugins:label:categories' => "Catégories",
	'admin:plugins:label:licence' => "Licence",
	'admin:plugins:label:website' => "URL",
	'admin:plugins:label:repository' => "Code",
	'admin:plugins:label:bugtracker' => "Signaler un problème",
	'admin:plugins:label:donate' => "Faire un don",
	'admin:plugins:label:moreinfo' => "Plus d'informations",
	'admin:plugins:label:version' => "Version",
	'admin:plugins:label:location' => "Adresse",
	'admin:plugins:label:contributors' => 'Contributeurs',
	'admin:plugins:label:contributors:name' => 'Nom',
	'admin:plugins:label:contributors:email' => 'Email',
	'admin:plugins:label:contributors:website' => 'Site web',
	'admin:plugins:label:contributors:username' => 'Nom d\'utilisateur',
	'admin:plugins:label:contributors:description' => 'Description',
	'admin:plugins:label:dependencies' => "Dépendances",

	'admin:plugins:warning:elgg_version_unknown' => 'Ce plugin utilise un ancien fichier manifest.xml et ne précise pas une version de Elgg compatible. Il ne fonctionnera probablement pas !',
	'admin:plugins:warning:unmet_dependencies' => 'Ce plugin a des dépendances non satisfaites et ne peut pas être activé. Vérifiez les dépendances dans la partie "Plus d\'informations".',
	'admin:plugins:warning:invalid' => 'Ce plugin est invalide : %s',
	'admin:plugins:warning:invalid:check_docs' => 'Vérifiez <a href="http://learn.elgg.org/fr/stable/appendix/faqs.html">la documentation d\'Elgg</a> pour des astuces de débogage. Vous pouvez également consulter <a href="http://learn.elgg.org/en/stable/appendix/faqs.html">version anglophone</a>, qui peut être plus complète / récente.',
	'admin:plugins:cannot_activate' => 'impossible d\'activer',

	'admin:plugins:set_priority:yes' => "%s a été réordonné.",
	'admin:plugins:set_priority:no' => "Impossible de réordonner %s.",
	'admin:plugins:set_priority:no_with_msg' => "Impossible de réordonner %s. Erreur : %s",
	'admin:plugins:deactivate:yes' => "Désactivé %s.",
	'admin:plugins:deactivate:no' => "Impossible de désactiver %s.",
	'admin:plugins:deactivate:no_with_msg' => "Impossible de désactiver %s. Erreur : %s",
	'admin:plugins:activate:yes' => "%s a été activé.",
	'admin:plugins:activate:no' => "Impossible d'activer %s.",
	'admin:plugins:activate:no_with_msg' => "Impossible d'activer %s. Erreur : %s",
	'admin:plugins:categories:all' => 'Toutes les catégories',
	'admin:plugins:plugin_website' => 'Site du plugin',
	'admin:plugins:author' => '%s',
	'admin:plugins:version' => 'Version %s',
	'admin:plugin_settings' => 'Paramètres du plugin',
	'admin:plugins:warning:unmet_dependencies_active' => 'Ce plugin est actif, mais a des dépendances non satisfaites. Cela peut poser des problèmes. Voir "plus d\'informations" ci-dessous pour plus de détails.',

	'admin:plugins:dependencies:type' => 'Type',
	'admin:plugins:dependencies:name' => 'Nom',
	'admin:plugins:dependencies:expected_value' => 'Valeur attentdue',
	'admin:plugins:dependencies:local_value' => 'Valeur réelle',
	'admin:plugins:dependencies:comment' => 'Commentaire',

	'admin:statistics:description' => "Ceci est un aperçu des statistiques du site. Si vous avez besoin de statistiques plus détaillées, une version professionnelle d'administration est disponible.",
	'admin:statistics:opt:description' => "Afficher les informations statistiques sur les utilisateurs et les objets de votre site.",
	'admin:statistics:opt:linktext' => "Voir les statistiques...",
	'admin:statistics:label:basic' => "Statistiques de base du site",
	'admin:statistics:label:numentities' => "Entités sur le site",
	'admin:statistics:label:numusers' => "Nombre d'utilisateurs",
	'admin:statistics:label:numonline' => "Nombre d'utilisateurs en ligne",
	'admin:statistics:label:onlineusers' => "Utilisateurs en ligne en ce moment",
	'admin:statistics:label:admins'=>"Administrateurs",
	'admin:statistics:label:version' => "Version d'Elgg",
	'admin:statistics:label:version:release' => "Version (release)",
	'admin:statistics:label:version:version' => "Version",

	'admin:server:label:php' => 'PHP',
	'admin:server:label:web_server' => 'Serveur web',
	'admin:server:label:server' => 'Serveur',
	'admin:server:label:log_location' => 'Emplacement du journal',
	'admin:server:label:php_version' => 'Version de PHP',
	'admin:server:label:php_ini' => 'Emplacement du fichier PHP .ini',
	'admin:server:label:php_log' => 'Journal PHP',
	'admin:server:label:mem_avail' => 'Mémoire disponible',
	'admin:server:label:mem_used' => 'Mémoire utilisée',
	'admin:server:error_log' => "Journal d'erreur du serveur web",
	'admin:server:label:post_max_size' => 'Taille maximum d\'un envoi POST',
	'admin:server:label:upload_max_filesize' => 'Taille maximale d\'envoi',
	'admin:server:warning:post_max_too_small' => '(Remarque : la valeur de post_max_size doit être supérieure à cette valeur pour supporter des envois de cette taille)',

	'admin:user:label:search' => "Trouver des utilisateurs :",
	'admin:user:label:searchbutton' => "Chercher",

	'admin:user:ban:no' => "Impossible de bannir cet utilisateur",
	'admin:user:ban:yes' => "Utilisateur banni.",
	'admin:user:self:ban:no' => "Vous ne pouvez pas vous bannir vous-même",
	'admin:user:unban:no' => "Impossible de réintégrer cet utilisateur",
	'admin:user:unban:yes' => "Utilisateur réintégré.",
	'admin:user:delete:no' => "Impossible de supprimer cet utilisateur",
	'admin:user:delete:yes' => "L'utilisateur %s a été supprimé",
	'admin:user:self:delete:no' => "Vous ne pouvez pas supprimer votre propre compte",

	'admin:user:resetpassword:yes' => "Mot de passe réinitialisé, utilisateur notifié.",
	'admin:user:resetpassword:no' => "Le mot de passe n'a pas pu être réinitialisé.",

	'admin:user:makeadmin:yes' => "L'utilisateur est maintenant un administrateur.",
	'admin:user:makeadmin:no' => "Nous n'avons pas pu faire de cet utilisateur un administrateur.",

	'admin:user:removeadmin:yes' => "L'utilisateur n'est plus administrateur.",
	'admin:user:removeadmin:no' => "Nous ne pouvons pas supprimer les droits d'administrateur de cet utilisateur.",
	'admin:user:self:removeadmin:no' => "Vous ne pouvez pas supprimer vos propres droits d'administrateur.",

	'admin:appearance:menu_items' => 'Éléments du menu',
	'admin:menu_items:configure' => 'Configurer les éléments du menu principal',
	'admin:menu_items:description' => 'Sélectionnez les éléments de menu que vous voulez afficher en liens vedette. Les éléments de menu inutilisés seront ajoutés sous l\'entrée « Plus » à la fin de la liste.',
	'admin:menu_items:hide_toolbar_entries' => 'Supprimer les liens dans le menu des outils ?',
	'admin:menu_items:saved' => 'Les éléments de menu ont bien été enregistrés.',
	'admin:add_menu_item' => 'Ajouter un élément de menu personnalisé',
	'admin:add_menu_item:description' => 'Remplissez le nom affiché et l\'URL afin d\'ajouter des éléments personnalisés à votre menu de navigation.',

	'admin:appearance:default_widgets' => 'Widgets par défaut',
	'admin:default_widgets:unknown_type' => 'Type de widget Inconnu',
	'admin:default_widgets:instructions' => 'Ajoutez, supprimez, positionnez et configurez les widgets par défaut pour la page de widgets sélectionnée. Ces changements ne concerneront que les nouveaux utilisateurs du site.',

	'admin:robots.txt:instructions' => "Éditez ci-dessous le fichier robots.txt du site",
	'admin:robots.txt:plugins' => "Les plugins ajoutent les lignes suivantes au fichier robots.txt ",
	'admin:robots.txt:subdir' => "L'outil robots.txt ne fonctionnera peut-être pas car Elgg est installé dans un sous-répertoire",
	'admin:robots.txt:physical' => "La configuration de robots.txt ne fonctionnera pas car un fichier robots.txt est physiquement présent",

	'admin:maintenance_mode:default_message' => 'Le site est temporairement fermé pour cause de maintenance',
	'admin:maintenance_mode:instructions' => 'Le mode maintenance devrait être utilisé pour les mises à niveau et les autres changements importants sur le site. 
Quand il est activé, seuls les administrateurs peuvent s\'identifier et naviguer sur le site.',
	'admin:maintenance_mode:mode_label' => 'Mode maintenance',
	'admin:maintenance_mode:message_label' => 'Message affiché aux utilisateurs lorsque le mode maintenance est activé',
	'admin:maintenance_mode:saved' => 'Les paramètres du mode maintenance ont bien été enregistrés.',
	'admin:maintenance_mode:indicator_menu_item' => 'Le site est en maintenance. ',
	'admin:login' => 'Connexion Admin',

/**
 * User settings
 */
		
	'usersettings:description' => "Le panneau de configuration de votre compte vous permet de contrôler tous vos paramètres personnels, de la gestion de vos compte aux fonctionnement des outils du site. Choisissez une option ci-dessous pour commencer.",

	'usersettings:statistics' => "Vos statistiques",
	'usersettings:statistics:opt:description' => "Visualiser les statistiques des utilisateurs et des objets sur le site.",
	'usersettings:statistics:opt:linktext' => "Statistiques du compte.",

	'usersettings:user' => "Paramètres de %s",
	'usersettings:user:opt:description' => "Ceci vous permet de contrôler les paramètres de votre compte.",
	'usersettings:user:opt:linktext' => "Modifier vos paramètres",

	'usersettings:plugins' => "Outils",
	'usersettings:plugins:opt:description' => "Configurer les paramètres de vos outils (s'il y en a).",
	'usersettings:plugins:opt:linktext' => "Configurez vos outils",

	'usersettings:plugins:description' => "Ce panneau vous permet de vérifier et de configurer les paramètres personnels des outils installés par l'administrateur.",
	'usersettings:statistics:label:numentities' => "Vos contenus",

	'usersettings:statistics:yourdetails' => "Vos informations",
	'usersettings:statistics:label:name' => "Votre nom complet",
	'usersettings:statistics:label:email' => "Email",
	'usersettings:statistics:label:membersince' => "Membre depuis",
	'usersettings:statistics:label:lastlogin' => "Dernière connexion",

/**
 * Activity river
 */

	'river:all' => "Toute l'activité du site",
	'river:mine' => "Mon activité",
	'river:owner' => 'Activité de %s',
	'river:friends' => 'Activités des contacts',
	'river:select' => 'Montrer %s',
	'river:comments:more' => '+%u autres',
	'river:comments:all' => 'Voir tous les %u commentaires',
	'river:generic_comment' => 'a commenté %s %s',

	'friends:widget:description' => "Affiche une partie de vos contacts.",
	'friends:num_display' => "Nombre de contacts à afficher",
	'friends:icon_size' => "Taille d'icône",
	'friends:tiny' => "très petit",
	'friends:small' => "petit",

/**
 * Icons
 */

	'icon:size' => "Taille d'icône",
	'icon:size:topbar' => "Topbar (minuscule)",
	'icon:size:tiny' => "Minuscule",
	'icon:size:small' => "Petit",
	'icon:size:medium' => "Moyen",
	'icon:size:large' => "Grand",
	'icon:size:master' => "Très grand",

/**
 * Generic action words
 */

	'save' => "Enregistrer",
	'reset' => "Réinitialiser",
	'publish' => "Publier",
	'cancel' => "Annuler",
	'saving' => "Enregistrement en cours ...",
	'update' => "Mettre à jour",
	'preview' => "Prévisualiser",
	'edit' => "Modifier",
	'delete' => "Supprimer",
	'accept' => "Accepter",
	'reject' => "Rejeter",
	'decline' => "Décliner",
	'approve' => "Accepter",
	'activate' => "Activer",
	'deactivate' => "Désactiver",
	'disapprove' => "Désapprouver",
	'revoke' => "Révoquer",
	'load' => "Charger",
	'upload' => "Charger",
	'download' => "Télécharger",
	'ban' => "Interdire",
	'unban' => "Réintégrer",
	'banned' => "Banni",
	'enable' => "Activer",
	'disable' => "Désactiver",
	'request' => "Requête",
	'complete' => "Complété",
	'open' => "Ouvrir",
	'close' => "Fermer",
	'hide' => 'Cacher',
	'show' => 'Montrer',
	'reply' => "Répondre",
	'more' => "Plus",
	'more_info' => 'Plus d\'informations',
	'comments' => "Commentaires",
	'import' => "Importer",
	'export' => "Exporter",
	'untitled' => "Sans titre",
	'help' => "Aide",
	'send' => "Envoyer",
	'post' => 'Publier',
	'submit' => "Soumettre",
	'comment' => 'Commenter',
	'upgrade' => "Mise à jour",
	'sort' => 'Trier',
	'filter' => 'Filtrer',
	'new' => 'Nouveau',
	'add' => 'Ajouter',
	'create' => 'Créer',
	'remove' => 'Enlever',
	'revert' => 'Rétablir',

	'site' => "Site",
	'activity' => "Activité",
	'members' => "Membres",
	'menu' => 'Menu',

	'up' => 'Haut',
	'down' => 'Bas',
	'top' => 'En haut',
	'bottom' => 'En bas',
	'right' => 'Droite',
	'left' => 'Gauche',
	'back' => 'Retour',

	'invite' => "Inviter",

	'resetpassword' => "Réinitialiser le mot de passe",
	'changepassword' => "Changer le mot de passe",
	'makeadmin' => "Rendre administrateur",
	'removeadmin' => "Retirer administrateur",

	'option:yes' => "Oui",
	'option:no' => "Non",

	'unknown' => "Inconnu",
	'never' => 'Jamais',

	'active' => "Activé",
	'total' => "Total",
	
	'ok' => 'OK',
	'any' => 'N\'importe lequel',
	'error' => 'Erreur',

	'other' => 'Autre',
	'options' => 'Options',
	'advanced' => 'Avancé',

	'learnmore' => "Cliquer ici pour en apprendre plus.",
	'unknown_error' => 'Erreur inconnue',

	'content' => "contenu",
	'content:latest' => 'Dernière activité',
	'content:latest:blurb' => 'Vous pouvez également cliquer ici pour voir les dernières publications du site.',

	'link:text' => 'voir le lien',

/**
 * Generic questions
 */

	'question:areyousure' => "Etês-vous sûr ?",

/**
 * Status
 */

	'status' => 'Statut',
	'status:unsaved_draft' => 'Brouillon non enregistré',
	'status:draft' => 'Brouillon',
	'status:unpublished' => 'Non publié',
	'status:published' => 'Publié',
	'status:featured' => 'En vedette',
	'status:open' => 'Ouvert',
	'status:closed' => 'Fermé',

/**
 * Generic sorts
 */

	'sort:newest' => 'Date',
	'sort:popular' => 'Popularité',
	'sort:alpha' => 'Alphabétique',
	'sort:priority' => 'Priorité',
		
/**
 * Generic data words
 */

	'title' => "Titre",
	'description' => "Description",
	'tags' => "Mots-clés",
	'all' => "Tous",
	'mine' => "à moi",

	'by' => "par",
	'none' => 'aucun',

	'annotations' => "Annotations",
	'relationships' => "Relations",
	'metadata' => "Metadonnées",
	'tagcloud' => "Nuage de tags",

	'on' => 'Activé',
	'off' => 'Désactivé',

/**
 * Entity actions
 */
		
	'edit:this' => 'Modifier ceci',
	'delete:this' => 'Supprimer ceci',
	'comment:this' => 'Commenter ceci',

/**
 * Input / output strings
 */

	'deleteconfirm' => "Confirmez-vous vouloir supprimer cet élément ?",
	'deleteconfirm:plural' => "Confirmez-vous vouloir supprimer ces éléments ?",
	'fileexists' => "Un fichier a déjà été chargé. Pour le remplacer, sélectionnez-le ci-dessous :",

/**
 * User add
 */

	'useradd:subject' => "Compte de l'utilisateur créé",
	'useradd:body' => "
%s,

Un compte utilisateur vous a été créé a %s. Pour vous connecter, rendez-vous :

%s

Et connectez vous avec les identifiants suivant :

Nom d'utilisateur : %s
Mot de passe : %s

Une fois que vous vous êtes connecté(e), nous vous conseillons fortement de changer votre mot de passe.
",

/**
 * System messages
 */

	'systemmessages:dismiss' => "Cliquer pour fermer",


/**
 * Import / export
 */

	'importsuccess' => "L'import des données a été réalisée avec succès",
	'importfail' => "L'import OpenDD des données a échouée.",

/**
 * Time
 */

	'friendlytime:justnow' => "à l'instant",
	'friendlytime:minutes' => "il y a %s minutes",
	'friendlytime:minutes:singular' => "il y a une minute",
	'friendlytime:hours' => "il y a %s heures",
	'friendlytime:hours:singular' => "il y a une heure",
	'friendlytime:days' => "il y a %s jours",
	'friendlytime:days:singular' => "hier",
	'friendlytime:date_format' => "j F Y @ g:ia",
	/*'friendlytime:date_format' => 'j F Y @ G:i',*/
	
	'friendlytime:future:minutes' => "dans %s minutes",
	'friendlytime:future:minutes:singular' => "dans une minute",
	'friendlytime:future:hours' => "dans %s heures",
	'friendlytime:future:hours:singular' => "dans une heure",
	'friendlytime:future:days' => "dans %s jours",
	'friendlytime:future:days:singular' => "demain",

	'date:month:01' => "Janvier %s",
	'date:month:02' => "Février %s",
	'date:month:03' => "Mars %s",
	'date:month:04' => "Avril %s",
	'date:month:05' => "Mai %s",
	'date:month:06' => "Juin %s",
	'date:month:07' => "Juillet %s",
	'date:month:08' => "Août %s",
	'date:month:09' => "Septembre %s",
	'date:month:10' => "Octobre %s",
	'date:month:11' => "Novembre %s",
	'date:month:12' => "Décembre %s",

	'date:weekday:0' => 'Dimanche',
	'date:weekday:1' => 'Lundi',
	'date:weekday:2' => 'Mardi',
	'date:weekday:3' => 'Mercredi',
	'date:weekday:4' => 'Jeudi',
	'date:weekday:5' => 'Vendredi',
	'date:weekday:6' => 'Samedi',
	
	'interval:minute' => 'Chaque minute',
	'interval:fiveminute' => 'Chaque 5 minutes',
	'interval:fifteenmin' => 'Chaque 15 minutes',
	'interval:halfhour' => 'Chaque demi-heure',
	'interval:hourly' => 'Chaque heure',
	'interval:daily' => 'Chaque jour',
	'interval:weekly' => 'Chaque semaine',
	'interval:monthly' => 'Chaque mois',
	'interval:yearly' => 'Chaque année',
	'interval:reboot' => 'Au redémarrage',

/**
 * System settings
 */

	'installation:sitename' => "Le nom de votre site (par exemple 'Mon site de réseau social') :",
	'installation:sitedescription' => "Brève description du site (facultatif) :",
	'installation:wwwroot' => "L'URL du site, suivi de ' / ' :",
	'installation:path' => "Chemin physique des fichiers sur le serveur, suivi de ' / ' :",
	'installation:dataroot' => "Chemin complet où seront hébergés les fichiers uploadés par les utilisateurs, suivi de ' / ' :",
	'installation:dataroot:warning' => "Vous devez créer ce répertoire manuellement. Il doit se situer dans un répertoire différent de votre installation de Elgg.",
	'installation:sitepermissions' => "Les permissions d'accés par défaut :",
	'installation:language' => "La langue par défaut de votre site :",
	'installation:debug' => "Le mode de débogage permet de mettre en évidence certaines erreurs de fonctionnement, cependant il ralenti l'accès au site, il est à utiliser uniquement en cas de problème :",
	'installation:debug:label' => "Niveau de log :",
	'installation:debug:none' => "Désactive le mode debug (recommandé)",
	'installation:debug:error' => "Afficher seulement les erreurs critiques",
	'installation:debug:warning' => "Afficher les erreurs et les avertissements",
	'installation:debug:notice' => "Log toutes les erreurs, les avertissements et les avis",
	'installation:debug:info' => 'Enregistrer tout :',

	// Walled Garden support
	'installation:registration:description' => 'L\'enregistrement des utilisateur est activé par défaut. Désactivez cette option si vous ne voulez pas que de nouvelles personnes soient en mesure de s\'inscrire d\'elles-mêmes.',
	'installation:registration:label' => 'Permettre à de nouveaux utilisateurs de s\'enregistrer',
	'installation:walled_garden:description' => 'Activez ceci pour éviter que les non-membres puissent visiter d\'autres pages que celles expressément spécifiées comme publiques (comme par exemple la page de connexion et d\'inscription).',
	'installation:walled_garden:label' => 'Restreindre l\'accès au site aux membres connectés',

	'installation:httpslogin' => "Activer ceci afin que les utilisateurs puissent se connecter via le protocole HTTPS. Ceci nécessite que votre serveur web supporte HTTPS !",
	'installation:httpslogin:label' => "Activer les connexions via HTTPS",
	'installation:view' => "Entrez le nom de la vue qui sera utilisée par défaut pour l'affichage du site, ou laissez vide pour la vue par défaut (en cas de doute, laissez la valeur par défaut) :",

	'installation:siteemail' => "L'adresse email du site (utilisée lors de l'envoi d'emails par le système)",
	'installation:default_limit' => "Nombre d'éléments par page par défaut",

	'admin:site:access:warning' => "Ceci est le niveau d'accès suggéré aux utilisateurs lorsqu'ils créent un nouveau contenu. Modifier ce réglage n'a aucun effet sur l'accès au contenu existant.",
	'installation:allow_user_default_access:description' => "Activez ce réglage pour permettre aux utilisateurs de définir leur propre niveau d'accès par défaut, qui remplace celui défini par défaut pour le site.",
	'installation:allow_user_default_access:label' => "Autoriser un niveau d’accès par défaut pour l'utilisateur",

	'installation:simplecache:description' => "Le cache simple augmente les performances en mettant en cache du contenu statique comme des fichiers CSS et Javascript.",
	'installation:simplecache:label' => "Utiliser le cache simple (recommandé)",

	'installation:minify:description' => "Le cache peut être amélioré en compressant les fichiers JavaScript et  CSS. (Il est nécessaire que le ache simple soit activé). ",
	'installation:minify_js:label' => "Compresser le JavaScript (recommandé)",
	'installation:minify_css:label' => "Compresser les CSS (recommandé)",

	'installation:htaccess:needs_upgrade' => "Vous devez mettre à jour votre fichier .htaccess afin que le chemin soit injecté dans le paramètre GET __elgg_uri (vous pouvez utiliser le fichier install/config/htaccess_dist comme modèle)",
	'installation:htaccess:localhost:connectionfailed' => "Elgg ne peut pas se connecter à lui-même pour tester les règles de réécriture correctement. Veuillez vérifier que curl fonctionne, et qu'il n'y a pas de restriction au niveau des IP interdisant les connexions depuis localhost.",
	
	'installation:systemcache:description' => "Le cache système diminue le temps de chargement du moteur Elgg en mettant en cache les données dans des fichiers.",
	'installation:systemcache:label' => "Utiliser le cache système (recommandé)",

	'admin:legend:system' => 'Système',
	'admin:legend:caching' => 'Mise en cache',
	'admin:legend:content_access' => 'Accès au contenu',
	'admin:legend:site_access' => 'Accès au site',
	'admin:legend:debug' => 'Débugger et s\'identifier',

	'upgrading' => "Mise à jour en cours",
	'upgrade:db' => "Votre base de données a été mise à jour.",
	'upgrade:core' => "Votre installation de Elgg a été mise à jour",
	'upgrade:unlock' => 'Déverrouiller la mise à jour',
	'upgrade:unlock:confirm' => "La base de données est verrouillée par une autre mise à jour. Exécuter des mises à jours concurrentes est dangereux. Vous devriez continuer seulement si vous savez qu'il n'y a pas d'autre mise à jour en cours d'exécution. Déverrouiller ?",
	'upgrade:locked' => "Impossible de mettre à jour. Une autre mise à jour est en cours. Pour effacer le verrouillage de la mise à jour, visiter la partie administrateur.",
	'upgrade:unlock:success' => "Mise à niveau débloquée.",
	'upgrade:unable_to_upgrade' => 'Impossible de mettre à niveau.',
	'upgrade:unable_to_upgrade_info' =>
		'Cette installation ne peut pas être mise à jour, car des fichiers de l\'ancienne version ont été détectées dans le noyau d\'Elgg. Ces fichiers sont obsolètes et doivent être supprimés pour qu\'Elgg fonctionne correctement. Si vous n\'avez pas modifié les fichiers du noyau d\'Elgg, vous pouvez simplement supprimer le répertoire noyau et le remplacer par celui de la dernière version d\'Elgg téléchargée  depuis <a href="http://elgg.org> elgg.org" </a>. <br /> <br />

Si vous avez besoin d\'instructions détaillées, veuillez visiter la <a href="http://learn.elgg.org/en/stable/admin/upgrading.html">Documentation sur la mise à niveau d\'Elgg</a>. Si vous avez besoin d\'aide, veuillez poser votre question dans les <a href="http://community.elgg.org/pg/groups/discussion/"> Forums d\'aide technique communautaires</a>.',

	'update:twitter_api:deactivated' => 'Le plugin Twitter API (précédemment Twitter Service) a été désactivé lors de la mise à niveau. Veuillez l\'activer manuellement si nécessaire.',
	'update:oauth_api:deactivated' => 'Le plugin OAuth API (précédemment OAuth Lib) a été désactivé lors de la mise à niveau. Veuillez l\'activer manuellement si nécessaire.',
	'upgrade:site_secret_warning:moderate' => "Vous êtes encouragé à régénérer la clé du site afin d'améliorer la sécurité du système. Voir dans Configuration / Paramètres avancés",
	'upgrade:site_secret_warning:weak' => "Vous êtes fortement encouragé à régénérer la clé du site afin d'améliorer la sécurité du système. Voir dans Configuration / Paramètres avancés",

	'deprecated:function' => "%s() a été déclaré obsolète par %s()",

	'admin:pending_upgrades' => 'Le site a des mises à niveau en attente qui nécessitent votre attention immédiate.',
	'admin:view_upgrades' => 'Afficher les mises à niveau en attente.',
	'item:object:elgg_upgrade' => 'Mises à niveau du site',
	'admin:upgrades:none' => 'Votre installation est à jour !',

	'upgrade:item_count' => '<b>%s</b> éléments ont besoin d\'être mis à niveau.',
	'upgrade:warning' => '<b>Attention :</b> Sur un grand site cette mise à jour peut prendre un temps significativement long !',
	'upgrade:success_count' => 'Mis à niveau :',
	'upgrade:error_count' => 'Erreurs :',
	'upgrade:river_update_failed' => 'Impossible de mettre à jour l\'entrée du flux pour l\'élément d\'identifiant %s',
	'upgrade:timestamp_update_failed' => 'Impossible de mettre à jour l\'horodatage de l\'élément d\'identifiant %s',
	'upgrade:finished' => 'Mise à jour terminée',
	'upgrade:finished_with_errors' => '<p>La mise à niveau s\'est terminée avec des erreurs. Rafraîchissez la page et tentez de relancer la mise à niveau.</p><p>Si l\'erreur se produit à nouveau, vérifiez les journaux d\'erreur du serveur web pour identifier une cause possible. Vous pouvez demander de l\'aide pour résoudre cette erreur dans le <a href="https://community.elgg.org/groups/profile/179063/elgg-technical-support">groupe de support technique</a> de la communauté Elgg.</p>',

	// Strings specific for the comments upgrade
	'admin:upgrades:comments' => 'Mise à jour des commentaires',
	'upgrade:comment:create_failed' => 'Impossible de convertir le commentaire d\'id %s en une entité.',
	'admin:upgrades:commentaccess' => 'Mise à jour du niveau d\'accès des commentaires',

	// Strings specific for the datadir upgrade
	'admin:upgrades:datadirs' => 'Répertoire de données mis à jour',

	// Strings specific for the discussion reply upgrade
	'admin:upgrades:discussion_replies' => 'Réponse à la discussion mise à jour',
	'discussion:upgrade:replies:create_failed' => 'Impossible de convertir la réponse à la discussion d\'id %s en une entité.',

/**
 * Welcome
 */

	'welcome' => "Bienvenue",
	'welcome:user' => "Bienvenue %s",

/**
 * Emails
 */

	'email:from' => 'De',
	'email:to' => 'Pour',
	'email:subject' => 'Sujet',
	'email:body' => 'Corps de l\'article',

	'email:settings' => "Paramètres e-mail",
	'email:address:label' => "Adresse e-mail",

	'email:save:success' => "Nouvelle adresse email enregistrée. Une vérification a été envoyée pour confirmer l'adresse.",
	'email:save:fail' => "Votre nouvelle adresse email n'a pas pu être enregistrée.",

	'friend:newfriend:subject' => "%s vous a ajouté comme contact !",
	'friend:newfriend:body' => "%s vous a ajouté comme contact!

Pour voir son profil :
%s

Merci de ne pas répondre à cet email.",

	'email:changepassword:subject' => "Mot de passe modifié !",
	'email:changepassword:body' => "Bonjour %s,

Votre mot de passe a été modifié.",

	'email:resetpassword:subject' => "Mot de passe réinitialisé !",
	'email:resetpassword:body' => "Bonjour %s,

Votre mot de passe vient d'être réinitialisé. Votre nouveau mot de passe est : %s",

	'email:changereq:subject' => "Demander un nouveau mot de passe.",
	'email:changereq:body' => "Bonjour %s,

Quelqu'un (à partir de l'adresse IP %s) a demandé le changement du mot de passe de ce compte.

Si vous êtes au courant ou à l'origine de cette demande, cliquez sur le lien suivant :
%s

Sinon ignorez cet e-mail.
",


/**
 * user default access
 */

	'default_access:settings' => "Votre niveau d'accès par défaut",
	'default_access:label' => "Niveau d'accès par défaut",
	'user:default_access:success' => "Votre nouveau niveau d'accès par défaut a été enregistré.",
	'user:default_access:failure' => "Votre nouveau niveau d'accès par défaut n'a pas pu être enregistré.",

/**
 * Comments
 */

	'comments:count' => "%s commentaires",
	'item:object:comment' => 'Commentaires',

	'river:comment:object:default' => '%s a commenté %s',

	'generic_comments:add' => "Ajouter un commentaire",
	'generic_comments:edit' => "Modifier le commentaire",
	'generic_comments:post' => "Publier un commentaire",
	'generic_comments:text' => "Commentaire",
	'generic_comments:latest' => "Derniers commentaires",
	'generic_comment:posted' => "Votre commentaire a bien été publié.",
	'generic_comment:updated' => "Le commentaire a bien été mis à jour.",
	'generic_comment:deleted' => "Le commentaire a bien été supprimé.",
	'generic_comment:blank' => "Désolé, vous devez écrire quelque chose dans votre commentaire avant de pouvoir l'enregistrer.",
	'generic_comment:notfound' => "Désolé, l'élément recherché n'a pas été trouvé.",
	'generic_comment:notfound_fallback' => "Désolé, le commentaire demandé n'a pas été trouvé, mais vous avez été redirigé sur la page sur laquelle il avait été publié.",
	'generic_comment:notdeleted' => "Désolé, le commentaire n'a pu être supprimé.",
	'generic_comment:failure' => "Une erreur inattendue s'est produite pendant l'enregistrement du commentaire.",
	'generic_comment:none' => 'Pas de commentaire',
	'generic_comment:title' => 'Commentaire de %s',
	'generic_comment:on' => '%s sur %s',
	'generic_comments:latest:posted' => 'a publié un',

	'generic_comment:email:subject' => 'Vous avez un nouveau commentaire !',
	'generic_comment:email:body' => "Vous avez un nouveau commentaire sur l'élément '%s' de %s. Voici son contenu :


%s


Pour répondre ou afficher le contenu de référence :
%s

Pour voir le profil de %s :
%s

Merci de ne pas répondre à cet e-mail.",

/**
 * Entities
 */
	
	'byline' => 'Par %s',
	'entity:default:strapline' => 'Créé %s par %s',
	'entity:default:missingsupport:popup' => 'Cette entité ne peut pas être affichée correctement. C\'est peut-être parce qu\'elle a besoin d\'un plugin qui n\'est plus installé ou activé.',

	'entity:delete:success' => 'L\'entité %s a été supprimée',
	'entity:delete:fail' => 'L\'entité %s n\'a pas pu être supprimée',
	
	'entity:can_delete:invaliduser' => 'Impossible de vérifier canDelete() pour l\'utilisateur user_guid [%s] car l\'utilisateur n\'existe pas.',

/**
 * Action gatekeeper
 */

	'actiongatekeeper:missingfields' => 'Il manque les champs __token ou __ts dans le formulaire. Veuillez recharger la page pour continuer',
	'actiongatekeeper:tokeninvalid' => "La page que vous utilisiez a expiré. Veuillez réessayer.",
	'actiongatekeeper:timeerror' => 'La page que vous utilisiez a expiré. Veuillez la recharger et réessayer.',
	'actiongatekeeper:pluginprevents' => 'Désolé. Votre formulaire n\'a pas pu être envoyé pour une raison inconnue.',
	'actiongatekeeper:uploadexceeded' => 'La taille du ou des fichier(s) dépasse la limite définie par l\'administrateur du site',
	'actiongatekeeper:crosssitelogin' => "Désolé, il n'est pas permis de se connecter depuis un autre nom de domaine. Veuillez réessayer.",

/**
 * Word blacklists
 */

	'word:blacklist' => 'alors, au, aucuns, aussi, autre, avant, avec, avoir, bon, ça, car, ce, cela, cette, ces, ceux, cependant, chaque, ci, comme, comment, dans, début, dedans, dehors, depuis, des, devrait, doit, donc, dos, du, elle, elles, en, encore, essai, est, et, étaient, état, été, étions, être, eu, fait, faites, fois, font, hors, ici, il, ils, je, juste, la, là, le, les, leur, lui, ma, maintenant, mais, malgré, même, mes, moins, mon, mot, ni, nommés, notre, nous, ou, où, par, parce, pas, pendant, peu, peut, plupart, plutôt, pour, pourquoi, quand, que, quel, quelle, quelles, quels, qui, sa, sans, ses, seulement, si, sien, son, sont, sous, soyez, sujet, sur, ta, tandis, tellement, tels, tes, ton, tous, tout, toutefois, très, trop, tu, un, une, voient, vont, votre, vous, vu',

/**
 * Tag labels
 */

	'tag_names:tags' => "Tags",

/**
 * Javascript
 */

	'js:security:token_refresh_failed' => 'Impossible de contacter %s. Vous risquez de ne pas pouvoir enregistrer le contenu. Veuillez rafraîchir cette page.',
	'js:security:token_refreshed' => 'La connexion à %s a été rétablie !',
	'js:lightbox:current' => "image %s de %s",

/**
 * Miscellaneous
 */
	'elgg:powered' => "Propulsé par Elgg",

/**
 * Languages according to ISO 639-1 (with a couple of exceptions)
 */

	"aa" => "Afar",
	"ab" => "Abkhaze",
	"af" => "Afrikaans",
	"am" => "Amharique",
	"ar" => "Arabe",
	"as" => "Assamais",
	"ay" => "Aymara",
	"az" => "Azéri",
	"ba" => "Bachkir",
	"be" => "Biélorusse",
	"bg" => "Bulgare",
	"bh" => "Bihari",
	"bi" => "Bichelamar",
	"bn" => "Bengalî",
	"bo" => "Tibétain",
	"br" => "Breton",
	"ca" => "Catalan",
	"cmn" => "Chinois Mandarin", // ISO 639-3
	"co" => "Corse",
	"cs" => "Tchèque",
	"cy" => "Gallois",
	"da" => "Danois",
	"de" => "Allemand",
	"dz" => "Dzongkha",
	"el" => "Grec",
	"en" => "Anglais",
	"eo" => "Espéranto",
	"es" => "Espagnol",
	"et" => "Estonien",
	"eu" => "Basque",
	"eu_es" => "Basque (Espagne)",
	"fa" => "Persan",
	"fi" => "Finnois",
	"fj" => "Fidjien",
	"fo" => "Féringien",
	"fr" => "Français",
	"fy" => "Frison",
	"ga" => "Irlandais",
	"gd" => "Écossais",
	"gl" => "Galicien",
	"gn" => "Guarani",
	"gu" => "Gujarâtî",
	"he" => "Hébreu",
	"ha" => "Haoussa",
	"hi" => "Hindî",
	"hr" => "Croate",
	"hu" => "Hongrois",
	"hy" => "Arménien",
	"ia" => "Interlingua",
	"id" => "Indonésien",
	"ie" => "Interlingue (ex Occidental)",
	"ik" => "Inupiaq",
	//"in" => "Indonésien",
	"is" => "Islandais",
	"it" => "Italien",
	"iu" => "Inuktitut",
	"iw" => "Hébreu (obsolète)",
	"ja" => "Japonais",
	"ji" => "Yiddish (obsolète)",
	"jw" => "Javanais",
	"ka" => "Géorgien",
	"kk" => "Kazakh",
	"kl" => "Groenlandais",
	"km" => "Khmer",
	"kn" => "Kannara",
	"ko" => "Coréen",
	"ks" => "Kashmiri",
	"ku" => "Kurde",
	"ky" => "Kirghiz",
	"la" => "Latin",
	"ln" => "Lingala",
	"lo" => "Lao",
	"lt" => "Lituanien",
	"lv" => "Letton",
	"mg" => "Malgache",
	"mi" => "Maori",
	"mk" => "Macédonien",
	"ml" => "Malayalam",
	"mn" => "Mongol",
	"mo" => "Moldave",
	"mr" => "Marâthî",
	"ms" => "Malais",
	"mt" => "Maltais",
	"my" => "Birman",
	"na" => "Nauru",
	"ne" => "Népalais",
	"nl" => "Néerlandais",
	"no" => "Norvégien",
	"oc" => "Occitan",
	"om" => "Oromo",
	"or" => "Oriya",
	"pa" => "Panjâbî",
	"pl" => "Polonais",
	"ps" => "Pachto",
	"pt" => "Portugais",
	"pt_br" => "Portugais (Brésil)",
	"qu" => "Quechua",
	"rm" => "Romanche",
	"rn" => "Kirundi",
	"ro" => "Roumain",
	"ro_ro" => "Roumain (Roumanie)",
	"ru" => "Russe",
	"rw" => "Kinyarwanda",
	"sa" => "Sanskrit",
	"sd" => "Sindhi",
	"sg" => "Sangro",
	"sh" => "Serbo-Croate",
	"si" => "Cingalais",
	"sk" => "Slovaque",
	"sl" => "Slovène",
	"sm" => "Samoan",
	"sn" => "Shona",
	"so" => "Somalien",
	"sq" => "Albanais",
	"sr" => "Serbe",
	"sr_latin" => "Serbe (Latin)",
	"ss" => "Siswati",
	"st" => "Sotho du Sud",
	"su" => "Soudanais",
	"sv" => "Suédois",
	"sw" => "Swahili",
	"ta" => "Tamoul",
	"te" => "Télougou",
	"tg" => "Tadjik",
	"th" => "Thaï",
	"ti" => "Tigrinya",
	"tk" => "Turkmène",
	"tl" => "Tagalog",
	"tn" => "Tswana",
	"to" => "Tongien",
	"tr" => "Turc",
	"ts" => "Tsonga",
	"tt" => "Tatar",
	"tw" => "Twi",
	"ug" => "Ouïghour",
	"uk" => "Ukrainien",
	"ur" => "Ourdou",
	"uz" => "Ouzbek",
	"vi" => "Vietnamien",
	"vo" => "Volapük",
	"wo" => "Wolof",
	"xh" => "Xhosa",
	//"y" => "Yiddish",
	"yi" => "Yiddish",
	"yo" => "Yoruba",
	"za" => "Zhuang",
	"zh" => "Chinois",
	"zh_hans" => "Chinois simplifié",
	"zu" => "Zoulou",
);
