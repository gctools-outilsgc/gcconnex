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
	'limited_access' => "Vous n'avez pas la permission de consulter la page demandée.",

/**
 * Errors
 */
	'exception:title' => "Bienvenue sur Elgg.",
	'exception:contact_admin' => 'Une erreur irrécupérable a été rencontrée et a été enregistrée. Veuillez svp contacter l\'administrateur du site avec l\'information suivante :',

	'actionundefined' => "L'action demandée (%s) n'est pas définie par le système.",
	'actionnotfound' => "Le fichier d'action pour %s n'a pas été trouvé.",
	'actionloggedout' => "Désolé, vous ne pouvez pas effectuer cette action sans être connecté.",
	'actionunauthorized' => "Vous n'êtes pas autorisé à effectuer cette action",

	'InstallationException:SiteNotInstalled' => "Impossible de traiter cette requête. Ce site n'est pas configuré ou la base de données est en panne.",

	'InstallationException:MissingLibrary' => "Impossible de charger %s",
	'InstallationException:CannotLoadSettings' => "Elgg n'a pas pu charger le fichier de paramètres. Il n'existe pas ou il y a un problème de d'autorisations.",

	'SecurityException:Codeblock' => "Accès non autorisé pour la création de bloc de code.",
	'DatabaseException:WrongCredentials' => "Elgg n'a pas pu se connecter à la base de données avec les informations données. Vérifiez les paramètres.",
	'DatabaseException:NoConnect' => "Elgg n'a pas pu sélectionner la base de données '%s', merci de vérifier que la base de données est bien créée et que vous y avez accès.",
	'SecurityException:FunctionDenied' => "L'accès à la fonction privilégiée '%s' n'est pas autorisé.",
	'DatabaseException:DBSetupIssues' => "Il y a eu plusieurs problèmes :",
	'DatabaseException:ScriptNotFound' => "Elgg n'a pas pu trouver le script de la base de données a %s.",
	'DatabaseException:InvalidQuery' => "Requête non valide",

	'ajax:error' => 'Une erreur est survenue lors d\'un appel Ajax. Peut-être que la connection avec le serveur est perdue.',
	'ajax:not_is_xhr' => 'You cannot access AJAX views directly', 		// NEEDS TRANSLATION

	'IOException:FailedToLoadGUID' => "Echec du chargement du nouveau %s avec le GUID:%d",
	'InvalidParameterException:NonElggObject' => "Passage d'un objet de type non-Elgg vers un constructeur d'objet Elgg !",
	'InvalidParameterException:UnrecognisedValue' => "Valeur non reconnue passés au constructeur.",

	'InvalidClassException:NotValidElggStar' => "guid : %d n'est pas valide %s",

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
	'ElggPluginPackage:InvalidPlugin:InvalidDependency' => "Type '%s' des dépendances invalide",
	'ElggPluginPackage:InvalidPlugin:InvalidProvides' => "Type '%s' invalide",
	'ElggPluginPackage:InvalidPlugin:CircularDep' =>"%s invalide dans dépendance '%s', dans le plugin %s. Les plugins peuvent pas être en conflit avec, ou avoir besoin de quelque chose, qu'ils contiennent !",

	'ElggPlugin:Exception:CannotIncludeFile' => "Impossible d'inclure %s pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterViews' => "Impossible d'ouvrir la vue dir pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterLanguages' => "Impossible d'enregistrer les langues pour le plugin %s (guid : %s) sur %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterClasses' => "Impossible d'enregistrer les classes pour plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:NoID' => "Aucun ID pour le plugin guid %s !",

	'PluginException:ParserError' => "Erreur de syntaxe du fichier manifest.xml avec la version %s de l'API du plugin %s.",
	'PluginException:NoAvailableParser' => "Analyseur syntaxique du fichier manifest.xml introuvable pour l'API version %s du plugin %s.",
	'PluginException:ParserErrorMissingRequiredAttribute' => "L'attribut nécessaire '%s' manque dans le fichier manifest.xml pour le plugin %s.",

	'ElggPlugin:Dependencies:Requires' => "Requis",
	'ElggPlugin:Dependencies:Suggests' => "Suggestion",
	'ElggPlugin:Dependencies:Conflicts' => "Conflits",
	'ElggPlugin:Dependencies:Conflicted' => "En conflit",
	'ElggPlugin:Dependencies:Provides' => "Fournit",
	'ElggPlugin:Dependencies:Priority' => "Priorité",

	'ElggPlugin:Dependencies:Elgg' => "version d'Elgg",
	'ElggPlugin:Dependencies:PhpExtension' => "extension PHP : %s",
	'ElggPlugin:Dependencies:PhpIni' => "Paramètre PHP ini : %s",
	'ElggPlugin:Dependencies:Plugin' => "Plugin: %s",
	'ElggPlugin:Dependencies:Priority:After' => "Après %s",
	'ElggPlugin:Dependencies:Priority:Before' => "Avant %s",
	'ElggPlugin:Dependencies:Priority:Uninstalled' => "%s n'est pas installé",
	'ElggPlugin:Dependencies:Suggests:Unsatisfied' => "Manquant",


	'InvalidParameterException:NonElggUser' => "Passage d'un utilisateur de type non-Elgg vers un constructeur d'utilisateur Elgg !",

	'InvalidParameterException:NonElggSite' => "Passage d'un site non-Elgg vers un constructeur de site Elgg !",

	'InvalidParameterException:NonElggGroup' => "Passage d'un groupe non-Elgg vers un constructeur de groupe Elgg !",

	'IOException:UnableToSaveNew' => "Impossible de sauvegarder le nouveau %s",

	'InvalidParameterException:GUIDNotForExport' => "GUID non spécifié durant l'export, ceci ne devrait pas se produire.",
	'InvalidParameterException:NonArrayReturnValue' => "La fonction de sérialisation de l'entité a retourné une valeur dont le type n'est pas un tableau",

	'ConfigurationException:NoCachePath' => "Le chemin du cache est vide !",
	'IOException:NotDirectory' => "%s n'est pas un répertoire.",

	'IOException:BaseEntitySaveFailed' => "Impossibilité de sauver les informations de base du nouvel objet !",
	'InvalidParameterException:UnexpectedODDClass' => "import() a passé un argument qui n'est pas du type ODD class",
	'InvalidParameterException:EntityTypeNotSet' => "Le type d'entité doit être renseigné.",

	'ClassException:ClassnameNotClass' => "%s n'est pas %s.",
	'ClassNotFoundException:MissingClass' => "La classe '%s' n'a pas été trouvée, le plugin serait-il manquant ?",
	'InstallationException:TypeNotSupported' => "Le type %s n'est pas supporté. Il y a une erreur dans votre installation, le plus souvent causé par une mise à jour non-complète.",

	'ImportException:ImportFailed' => "Impossible d'importer l'élément %d",
	'ImportException:ProblemSaving' => "Une erreur est survenue en sauvant %s",
	'ImportException:NoGUID' => "La nouvelle entité a été créée mais n'a pas de GUID, ceci ne devrait pas se produire.",

	'ImportException:GUIDNotFound' => "L'entité '%d' n'a pas été trouvée.",
	'ImportException:ProblemUpdatingMeta' => "Il y a eu un problème lors de la mise à jour de '%s' pour l'entité '%d'",

	'ExportException:NoSuchEntity' => "Il n'y a pas d'entité telle que GUID:%d",

	'ImportException:NoODDElements' => "Aucun élément OpenDD n'a été trouvé dans les données importées, l'importation a échoué.",
	'ImportException:NotAllImported' => "Tous les éléments n'ont pas été importés.",

	'InvalidParameterException:UnrecognisedFileMode' => "Mode de fichier non-reconnu : '%s'",
	'InvalidParameterException:MissingOwner' => "Tous les fichiers doivent avoir un propriétaire",
	'IOException:CouldNotMake' => "Impossible de faire %s",
	'IOException:MissingFileName' => "Vous devez spécifier un nom avant d'ouvrir un fichier.",
	'ClassNotFoundException:NotFoundNotSavedWithFile' => "Fichiers stockés non trouvés ou classes non sauvegardées avec le fichier !",
	'NotificationException:NoNotificationMethod' => "Aucune méthode de notification spécifiée.",
	'NotificationException:NoHandlerFound' => "Aucune fonction trouvée pour '%s' ou elle ne peut être appelée.",
	'NotificationException:ErrorNotifyingGuid' => "Une erreur s'est produite lors de la notification %d",
	'NotificationException:NoEmailAddress' => "Impossible de trouver une adresse e-mail pour GUID:%d",
	'NotificationException:MissingParameter' => "Un argument obligatoire a été omis, '%s'",

	'DatabaseException:WhereSetNonQuery' => "La requête where ne contient pas de WhereQueryComponent",
	'DatabaseException:SelectFieldsMissing' => "Des champs sont manquants sur la requête de sélection.",
	'DatabaseException:UnspecifiedQueryType' => "Type de requête non-reconnue ou non-spécifiée.",
	'DatabaseException:NoTablesSpecified' => "Aucune table spécifiée pour la requête.",
	'DatabaseException:NoACL' => "Pas de liste d'accès fourni pour la requête",

	'InvalidParameterException:NoEntityFound' => "Aucune entité trouvée, soit elle est inexistante, soit vous n'y avez pas accès.",

	'InvalidParameterException:GUIDNotFound' => "GUID : %s n'a pas été trouvé ou vous n'y avez pas accès.",
	'InvalidParameterException:IdNotExistForGUID' => "Désolé, '%s' n'existe pas pour GUID : %d",
	'InvalidParameterException:CanNotExportType' => "Désolé, je ne sais pas comment exporter '%s'",
	'InvalidParameterException:NoDataFound' => "Aucune donnée trouvée.",
	'InvalidParameterException:DoesNotBelong' => "N'appartient pas à l'entité.",
	'InvalidParameterException:DoesNotBelongOrRefer' => "N'appartient pas ou aucune référence à l'entité.",
	'InvalidParameterException:MissingParameter' => "Paramètre manquant, il faut fournir un GUID.",
	'InvalidParameterException:LibraryNotRegistered' => "%s n'est pas une bibliothèque enregistré",

	'APIException:ApiResultUnknown' => "Les résultats de API sont de types inconnus, ceci ne devrait pas se produire.",
	'ConfigurationException:NoSiteID' => "L'identifiant du site n'a pas été spécifié.",
	'SecurityException:APIAccessDenied' => "Désolé, l'accès API a été désactivé par l'administrateur.",
	'SecurityException:NoAuthMethods' => "Aucune méthode d'authentification n'a été trouvée pour cette requête API.",
	'InvalidParameterException:APIMethodOrFunctionNotSet' => "Methode ou fonction non définie dans expose_method()",
	'InvalidParameterException:APIParametersArrayStructure' => "Le paramètre de structure 'array' est incorrect pour appeller to expose method '%s'",
	'InvalidParameterException:UnrecognisedHttpMethod' => "Methode HTTP %s pour la methode API '%s' non reconnue",
	'APIException:MissingParameterInMethod' => "Argument %s manquant pour la méthode %s",
	'APIException:ParameterNotArray' => "%s n'est semble t-il pas un tableau.",
	'APIException:UnrecognisedTypeCast' => "Type %s non reconnu pour la variable '%s' pour la fonction '%s'",
	'APIException:InvalidParameter' => "Paramètre invalide pour '%s' pour la fonction '%s'.",
	'APIException:FunctionParseError' => "%s(%s) a une erreur d'analyse.",
	'APIException:FunctionNoReturn' => "%s(%s) ne retourne aucune valeur.",
	'APIException:APIAuthenticationFailed' => "Echec d'authentification d'API par l'appel de méthode",
	'APIException:UserAuthenticationFailed' => "Echec d'authentification d'utilisateur par l'appel de méthode",
	'SecurityException:AuthTokenExpired' => "Le jeton d'authentification est manquant, invalide ou expiré.",
	'CallException:InvalidCallMethod' => "%s doit être appelé en utilisant '%s'",
	'APIException:MethodCallNotImplemented' => "L'appel à la méthode '%s' n'a pas été implémenté.",
	'APIException:FunctionDoesNotExist' => "La fonction pour la methode '%s' n'est pas appellable",
	'APIException:AlgorithmNotSupported' => "L'algorithme '%s' n'est pas supporté ou a été désactivé.",
	'ConfigurationException:CacheDirNotSet' => "Le répertoire de cache 'cache_path' n'a pas été renseigné.",
	'APIException:NotGetOrPost' => "La méthode de requête doit être GET ou POST",
	'APIException:MissingAPIKey' => "Clé API manquante",
	'APIException:BadAPIKey' => "Mauvaise clé API",
	'APIException:MissingHmac' => "X-Elgg-hmac manquant dans l'entête",
	'APIException:MissingHmacAlgo' => "X-Elgg-hmac-algo manquant dans l'entête",
	'APIException:MissingTime' => "X-Elgg-time manquant dans l'entête",
	'APIException:MissingNonce' => "X-Elgg-nonce manquant dans l'entête",
	'APIException:TemporalDrift' => "X-Elgg-time est trop éloigné dans le temps. Epoch a échoué.",
	'APIException:NoQueryString' => "Aucune valeur dans la requête",
	'APIException:MissingPOSTHash' => "X-Elgg-posthash manquant dans l'entête",
	'APIException:MissingPOSTAlgo' => "X-Elgg-posthash_algo manquant dans l'entête",
	'APIException:MissingContentType' => "Le content-type est manquant pour les données postées",
	'SecurityException:InvalidPostHash' => "La signature des données POST est invalide.%s attendu mais %s reçu.",
	'SecurityException:DupePacket' => "La signature du paquet a déjà été envoyée.",
	'SecurityException:InvalidAPIKey' => "Clé API invalide ou non-reconnue.",
	'NotImplementedException:CallMethodNotImplemented' => "La méthode '%s' n'est pas supportée actuellement.",

	'NotImplementedException:XMLRPCMethodNotImplemented' => "L'appel à la méthode XML-RPC '%s' n'a pas été implémentée.",
	'InvalidParameterException:UnexpectedReturnFormat' => "L'appel à la méthode '%s' a retourné un résultat inattendu.",
	'CallException:NotRPCCall' => "L'appel ne semble pas être un appel XML-RPC valide",

	'PluginException:NoPluginName' => "Le nom du plugin n'a pas pu être trouvé",

	'SecurityException:authenticationfailed' => "Impossible d'authentifier l'utilisateur",

	'CronException:unknownperiod' => "%s n'est pas une période valide.",

	'SecurityException:deletedisablecurrentsite' => "Impossible de supprimer ou désactiver le site en cours !",

	'RegistrationException:EmptyPassword' => "Les champs du mot de passe ne peut pas être vide",
	'RegistrationException:PasswordMismatch' => "Les mots de passe doivent correspondre",
	'LoginException:BannedUser' => "Vous avez été banni de ce site et ne pouvez plus vous connecter",
	'LoginException:UsernameFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:PasswordFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:AccountLocked' => "Votre compte a été verrouillé suite à un trop grand nombre d'échecs de connexion.",

	'memcache:notinstalled' => "Le module PHP memcache n'est pas installé. Vous devez installer php5-memcache",
	'memcache:noservers' => "Pas de serveur memcache défini, veuillez renseigner la variable",
	'memcache:versiontoolow' => "Memcache nécessite au minimum la version %s pour fonctionner, vous avez la version %s",
	'memcache:noaddserver' => "Le support de serveurs multiples est désactivé, vous avez peut-être besoin de mettre à jour votre bibliothèque memcache PECL",

	'deprecatedfunction' => "Attention : Ce code source utilise une fonction périmée '%s'. Il n'est pas compatible avec cette version de Elgg.",

	'pageownerunavailable' => "Attention : La page de l'utilisateur %d n'est pas accessible.",
	'viewfailure' => "Il ya eu une erreur interne dans la vue %s",
	'changebookmark' => "Veuillez changer votre favori pour cette page.",
/**
 * API
 */
	'system.api.list' => "Liste tous les appels API au système.",
	'auth.gettoken' => "Cet appel API permet à un utilisateur de se connecter, il retourne une clef d'authentification qui permet de rendre la tentative de connexion unique.",

	
	'PluginException:NullInstantiated' => 'ElggPlugin ne peut pas être laissé vide. Vous devez passer un GUID, un ID de plugin, ou un chemin complet.',
	'ElggPluginPackage:InvalidPlugin:InvalidId' => 'Le dossier du plugin doit être renommé en "%s" pour correspondre à l\'identifiant spécifié dans le manifeste. ',
	'ElggPlugin:InvalidAndDeactivated' => '%s est un plugin invalide et a été désactivé.',

	'ElggPlugin:Dependencies:PhpVersion' => 'PHP version',
	'ElggPlugin:Dependencies:ActiveDependent' => 'Il existe d\'autres plugins répertoriant %s en tant que dépendance. Vous devez désactiver les plugins suivants avant de désactiver celui-ci: %s',

	'ElggMenuBuilder:Trees:NoParents' => 'Une entrée de menu a été trouvé sans lien avec un parent',
	'ElggMenuBuilder:Trees:OrphanedChild' => 'L\'entrée de menu [%s] a été trouvée avec un parent manquant [%s]',
	'ElggMenuBuilder:Trees:DuplicateChild' => 'L\'entrée de menu [%s] est enregistrée plusieurs fois',

	'LoginException:ChangePasswordFailure' => 'Echec vérification mot de passe courant.',
	'LoginException:Unknown' => 'Nous ne pouvons pas vous connecter à cause d\'une erreur inconnue.',

	'view:missing_param' => "Le paramètre obligatoire '%s' manque dans la vue %s",
	'noaccess' => 'You need to login to view this content or the content has been removed or you do not have permission to view it.',
	'error:missing_data' => 'Il y avait des données manquantes à votre requête',
	'save:fail' => 'Il y a eu une erreur lors de la sauvegarde de vos données. ',
	'save:success' => 'Vos données ont été sauvegardées',

	'error:default:title' => 'Oups...',
	'error:default:content' => 'Oups... quelque chose est allé de travers.',
	'error:400:title' => 'Bad request',
	'error:400:content' => 'Sorry. The request is invalid or incomplete.',
	'error:403:title' => 'Forbidden',
	'error:403:content' => 'Sorry. You are not allowed to access the requested page.',
	'error:404:title' => 'Page non trouvée',
	'error:404:content' => 'Désolé. Nous n\'arrivons pas à trouver la page que vous demandez.',

	'upload:error:ini_size' => 'Le fichier que vous avez essayé de télécharger est trop grand.',
	'upload:error:form_size' => 'Le fichier que vous avez essayé de télécharger est trop grand.',
	'upload:error:partial' => 'Le téléchargement du fichier ne s\'est pas terminé.',
	'upload:error:no_file' => 'Aucun fichier n\'a été sélectionné.',
	'upload:error:no_tmp_dir' => 'Impossible d\'enregistrer le fichier téléchargé.',
	'upload:error:cant_write' => 'Impossible d\'enregistrer le fichier téléchargé.',
	'upload:error:extension' => 'Impossible d\'enregistrer le fichier téléchargé.',
	'upload:error:unknown' => 'Le téléchargement a échoué.',

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
	'email-in-use' => "courriel-déjà-enregistré",

/**
 * Access
 */

	'PRIVATE' => "Privé",
	'LOGGED_IN' => "Utilisateurs connectés",
	'PUBLIC' => "Publique",
	'LOGGED_OUT' => "Déconnecter les utilisateurs",
	'access:friends:label' => "Contacts",
	'access' => "Accès",
	'access:overridenotice' => "Note : A cause de politique de confidentialité, ce contenu ne sera accessible qu'aux membres du groupe. ",
	'access:limited:label' => "Limité",
	'access:help' => "Le niveau d'accès",
	'access:read' => "Accès en lecture",
	'access:write' => "Accès en écriture",
	'access:admin_only' => "Seulement pour les administrateurs",
	'access:missing_name' => "Le nom du niveau d'accès est manquant",
	'access:comments:change' => "Cette discussion a actuellement des droits d'accès limités. Faites attention lorsque vous la partagez.",

/**
 * Dashboard and widgets
 */

	'dashboard' => "Tableau de bord",
	'dashboard:nowidgets' => "Votre tableau de bord vous permet de suivre l'activité et le contenu vous conçernant.",

	'widgets:add' => "Ajouter des widgets",
	'widgets:add:description' => "Cliquez sur n'importe quel widget ci-dessous pour l'ajouter à la page.",
	'widgets:panel:close' => "Fermer le panneau des widgets",
	'widgets:position:fixed' => "(Position modifiée sur la page)",
	'widget:unavailable' => "Vous avez déjà ajouté ce widget",
	'widget:numbertodisplay' => "Nombre d'éléments à afficher ",

	'widget:delete' => "Supprimer le widget <<%s>>", // GCchange - Ilia: Specified that it is the widget that is being deleted
	'widget:edit' => "Personnaliser ce widget",

	'widgets' => "Widgets",
	'widget' => "Widget",
	'item:object:widget' => "Widgets",
	'widgets:save:success' => "Le widget a été sauvegardé avec succès.",
	'widgets:save:failure' => "Un problème est survenu lors de l'enregistrement de votre widget. Veuillez recommencer.",
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
	'friends:add:failure' => "%s n'a pas pu être ajouté(e) à vos contacts. Merci de réessayer ultérieurement.",

	'friends:remove:successful' => "Vous avez supprimé %s de vos contacts.",
	'friends:remove:failure' => "%s n'a pas pu être supprimé(e) de vos contacts. Merci de réessayer ultérieurement.",

	'friends:none' => "Cet utilisateur n'a pas encore ajouté de contact.",
	'friends:none:you' => "Vous n'avez pas encore de contact !",

	'friends:none:found' => "Aucun contact n'a été trouvé.",

	'friends:of:none' => "Personne n'a encore ajouté cet utilisateur comme contact.",
	'friends:of:none:you' => "Personne ne vous a encore ajouté comme contact. Commencez par remplir votre page profil et publiez du contenu pour que les gens vous trouvent !",

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

	'friends:river:add' => "est maintenant dans les contacts de %s",

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
	'profile:saved' => "Votre profil a été correctement enregistré.",

	'profile:field:text' => 'Texte court',
	'profile:field:longtext' => 'Région de texte importante',
	'profile:field:tags' => 'Tags',
	'profile:field:url' => 'Adresse web ',
	'profile:field:email' => 'Votre adresse e-mail',
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
	'profile:resetdefault:confirm' => 'Etes-vous sûr de vouloir effacer vos champs de profil personnalisé ?',
	'profile:explainchangefields' =>"Vous pouvez remplacer les champs de profil existant avec les vôtres en utilisant le formulaire ci-dessous.\n\nDonner une étiquette pour le nouveau champ du profil, par exemple, 'équipe préférée', puis sélectionnez le type de champ (par exemple, texte, url, balises), et cliquez sur le bouton 'Ajouter'. Pour réordonner les champs faites glisser la poignée de l'étiquette du champ. Pour modifier un champ d'étiquette - cliquez sur le texte de l'étiquette pour le rendre modifiable. A tout moment vous pouvez revenir au profil par défaut, mais vous perdrez toutes les informations déjà entrées dans des champs personnalisés des pages de profil.",
	'profile:editdefault:success' => "Champ ajouté au profil par défaut avec succès",
	'profile:editdefault:fail' => "Le profil par défaut n'a pas pu être sauvé",
	'profile:field_too_long' => 'Impossible de sauver vos informations du profol car la section %s est trop longue.',
	'profile:noaccess' => "Vous n'avez pas la permission d'éditer ce profil.",
	'profile:invalid_email' => '%s doit être une adresse e-mail valide.',

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
	'river:relationship:friend' => "est maintenant dans les contacts de",
	
	'river:update:user:avatar' => '%s a un nouvel avatar',
	'river:update:user:profile' => '%s a mis à jour son profil',
	'river:update' => 'Mise à jour pour %s',
	
	'river:noaccess' => "Vous n'avez pas la permission de voir cet élément.",
	'river:posted:generic' => "%s envoyé",
	'riveritem:single:user' => "un utilisateur",
	'riveritem:plural:user' => "des utilisateurs",
	'river:ingroup' => "au groupe %s",
	'river:none' => "Aucune activité",
	'river:friend:user:default' => "%s est maintenant ami avec %s",
	'river:delete' => 'Retirer l\'item de cette activité',
	'river:delete:success' => 'L\'article du flux a été effacée',
	'river:delete:fail' => 'L\'article du flux ne peut pas être effacée',
	'river:subject:invalid_subject' => 'Utilisateur invalide',
	'activity:owner' => 'Consutler l\'activité',
	
	'river:widget:title' => "Activité",
	'river:widget:description' => "Afficher l'activité la plus récente",
	'river:widget:type' => "Type d'activité",
	'river:widgets:friends' => "Activité des amis",
	'river:widgets:all' => "Toutes les activités sur le site",

/**
 * Notifications
 */
	'notifications:usersettings' => "Configuration des messages du site",
	'notifications:methods' => "Choisissez votre mode de réception des messages du site.",
	'notification:method:email' => 'E-mail',

	'notifications:usersettings:save:ok' => "La configuration des messages du site a été enregistrée avec succès.",
	'notifications:usersettings:save:fail' => "Il y a eu un problème lors de la sauvegarde des paramètres de configuration des messages du site.",

	'user.notification.get' => "Renvoie les paramètres de messages du site pour un utilisateur donné.",
	'user.notification.set' => "Définir les paramètres de messages du site pour un utilisateur donné.",
	'notification:subject' => 'Notification à propos de %s',
	'notification:body' => 'Consulter les nouvelles activités à %s',

/**
 * Search
 */

	'search' => "Rechercher",
	'searchtitle' => "Rechercher : %s",
	'users:searchtitle' => "Recherche des utilisateurs : %s",
	'groups:searchtitle' => "Rechercher des groupes : %s",
	'advancedsearchtitle' => "%s résultat(s) trouvé(s) pour %s",
	'notfound' => "Aucun résultat trouvé.",
	'next' => "Suivant",
	'previous' => "Précédent",

	'viewtype:change' => "Changer le type de liste",
	'viewtype:list' => "Lister les vues",
	'viewtype:gallery' => "Galerie",

	'tag:search:startblurb' => "Eléments avec le(s) mot(s)-clé '%s' :",

	'user:search:startblurb' => "Utilisateurs avec le(s) mot(s)-clé '%s' :",
	'user:search:finishblurb' => "Cliquez ici pour plus de résultats...",

	'group:search:startblurb' => "Groupes qui vérifient le critère : %s",
	'group:search:finishblurb' => "Pour en savoir plus, cliquez ici.",
	'search:go' => "Rechercher",
	'userpicker:only_friends' => "Seulement les amis",

/**
 * Account
 */

	'account' => "Compte",
	'settings' => "Paramètres",
	'tools' => "Outils",
	'settings:edit' => 'Editer les paramètres',

	'register' => "S'enregistrer",
	'registerok' => "Vous vous êtes enregistré avec succès sur %s.",
	'registerbad' => "Votre création de compte n'a pas fonctionné pour une raison inconnue.",
	'registerdisabled' => "La création de compte a été désactivé par l'administrateur du site.",
	'register:fields' => 'Tous les champs sont requis',

	'registration:notemail' => "L'adresse e-mail que vous avez renseigné n'apparaît pas comme valide.",
	'registration:userexists' => "Ce nom d'utilisateur existe déjà",
	'registration:usernametooshort' => "Le nom d'utilisateur doit faire %u caractères au minimum.",
	'registration:passwordtooshort' => "Le mot de passe doit faire %u caractères au minimum.",
	'registration:dupeemail' => "Cette adresse e-mail est déjà utilisée.",
	'registration:invalidchars' => "Désolé, votre adresse courriel est déjà enregistrée dans le système. Essayez de récupérer votre mot de passe à partir de l'écran d’ouverture de session.",
//	'registration:invalidchars' => "Désolé, votre nom d'utilisateur contient les caractères invalides suivants: %s. Tout ces caractères sont invalides: %s",
	'registration:emailnotvalid' => "Désolé, l'adresse e-mail que vous avez entré est invalide sur ce site.",
	'registration:passwordnotvalid' => "Désolé, le mot de passe que vous avez entré est invalide sur ce site.",
	'registration:usernamenotvalid' => "Désolé, le nom d'utilisateur que vous avez entré est invalide sur ce site.",

	'adduser' => "Ajouter un utilisateur",
	'adduser:ok' => "Vous avez ajouté un nouvel utilisateur avec succès.",
	'adduser:bad' => "Le nouvel utilisateur ne peut pas être créé.",

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

	'user:set:language' => "Langue",
	'user:language:label' => "Votre langue",
	'user:language:success' => "Votre paramètre de langage a été mis à jour.",
	'user:language:fail' => "Votre paramètre de langage n'a pas pu être sauvegardé.",

	'user:username:notfound' => "Nom d'utilisateur %s non trouvé.",

	'user:password:lost' => "Mot de passe perdu ?",
	'user:password:resetreq:success' => "Réinitialisation de mot de passe réussi. Vous recevrez un courriel bientôt.",
	'user:password:resetreq:fail' => "Impossible de demander un nouveau mot de passe.",

	//gcchange: descriptive password reset -  Troy T. Lawson
	//'user:password:text' => "Pour générer un nouveau mot de passe, entrez votre nom d'utilisateur ci-dessous. Puis cliquez sur le bouton de demande.",
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
	'admin:configuration:dataroot:relative_path' => 'Impossible de définir %s comme racine de \'dataroot\' car ce n\'est pas un chemin absolu.',
	'admin:configuration:default_limit' => 'Le nombre d\'éléments par page doit être d\'au moins 1.',

	'admin:unknown_section' => "Partie Admin invalide.",

	'admin' => "Administration",
	'admin:description' => "Le panneau d'administration vous permet de contrôler tous les aspects du système d'Elgg, de la gestion des utilisateurs à la gestion des outils installés. Choisissez une option dans le menu ci-contre pour commencer.",

	'admin:statistics' => "Statistiques",
	'admin:statistics:overview' => "Vue d'ensemble",
	'admin:statistics:server' => 'Info Serveur',
	'admin:statistics:cron' => 'Table de planification',
	'admin:cron:record' => 'Dernière table de planification',
	'admin:cron:period' => 'Période de la table de planification',
	'admin:cron:friendly' => 'Dernière exécution',
	'admin:cron:date' => 'Date et heure',

	'admin:appearance' => "Apparence",
	'admin:appearance' => 'Apparence',
	'admin:administer_utilities' => 'Utilitaires',
	'admin:develop_utilities' => 'Utilitaires',
	'admin:configure_utilities' => 'Utilitaires',
	'admin:configure_utilities:robots' => 'Robots.txt',
	'admin:utilities' => "Utilitaires",

	'admin:users' => "Utilisateurs",
	'admin:users:online' => "Actuellement en ligne",
	'admin:users:newest' => "Le plus récent",
	'admin:users:admins' => 'Administrateurs',
	'admin:users:add' => "Ajouter un nouvel utilisateur",
	'admin:users:description' => "Ce panneau d'administration vous permet de contrôler les paramètres des utilisateurs de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:users:adduser:label' => "Cliquez ici pour ajouter un nouvel utilisateur ...",
	'admin:users:opt:linktext' => "Configurer des utilisateurs ...",
	'admin:users:opt:description' => "Configurer les utilisateurs et les informations des comptes.",
	'admin:users:find' => "Trouver",

	'admin:settings' => "Paramètres",
	'admin:settings:basic' => "Réglages de base",
	'admin:settings:advanced' => "Paramètres avancés",
	'admin:site:description' => "Ce menu vous permet de définir les paramètres principaux de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:site:opt:linktext' => "Configurer le site...",
	'admin:site:access:warning' => "Changer les paramètres d'accès n'affectera que les permissions de contenu créées dans le futur.",
	'admin:settings:in_settings_file' => 'Ce paramètre est configuré dans settings.php',

	'admin:legend:security' => 'Sécurité',
	'admin:site:secret:intro' => 'Elgg utilise une clé pour sécuriser les tokens dans un certain nombre d\'usages.',
	'admin:site:secret_regenerated' => "La clé secrète du site a été régénérée.",
	'admin:site:secret:regenerate' => "Régénérer la clé secrète du site",
	'admin:site:secret:regenerate:help' => "Note : régénérer votre clé peut poser problème à certains utilisateurs en invalidant les token utilisés dans les cookies de session, dans les emails de validation de compte, les codes d’invitation, etc.",
	'site_secret:current_strength' => 'Complexité de la clé',
	'site_secret:strength:weak' => "Faible",
	'site_secret:strength_msg:weak' => "Nous vous conseillons fortement de régénérer la clé secrète de votre site.",
	'site_secret:strength:moderate' => "Moyenne",
	'site_secret:strength_msg:moderate' => "Nous vous conseillons de régénérer la clé secrète de votre site pour une meilleure sécurité.",
	'site_secret:strength:strong' => "Forte",
	'site_secret:strength_msg:strong' => "La clé secrète de votre site est suffisamment complexe. Nul besoin de la régénérer.",

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

	'admin:cache:flush' => 'Nettoyer le cache',
	'admin:cache:flushed' => "Le cache du site a été nettoyé",

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
	'admin:plugins:category:extension' => "Extensions",
	'admin:plugins:category:enhancement' => 'Améliorations',
	'admin:plugins:category:api' => 'Service/API',
	'admin:plugins:category:communication' => 'Communication',
	'admin:plugins:category:security' => 'Sécurité et spam',
	'admin:plugins:category:social' => 'Social',
	'admin:plugins:category:multimedia' => 'Multimédia',
	'admin:plugins:category:theme' => 'Thèmes',
	'admin:plugins:category:widget' => 'Widget',
	'admin:plugins:category:utility' => 'Utilitaires',
	'admin:plugins:category:service' => "Service / API",

	'admin:plugins:markdown:unknown_plugin' => "Plugin inconnu.",
	'admin:plugins:markdown:unknown_file' => "fichier inconnu.",


	'admin:notices:could_not_delete' => "Impossible de supprimer la remarque.",
	'item:object:admin_notice' => 'Remarques Administrateur',

	'admin:options' => "Options Admin",

/**
 * Plugins
 */

	'plugins:disabled' => 'Les Plugins ne seront pas lu car un fichier nommé \'disabled\' (désactivée) est dans le répertoire mod.',
	'plugins:settings:save:ok' => "Le paramètrage du plugin %s a été enregistré.",
	'plugins:settings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres du plugin %s.",
	'plugins:usersettings:save:ok' => "Le paramètrage du plugin a été enregistré avec succès.",
	'plugins:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement du paramètrage du plugin %s.",
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
	'admin:plugins:label:bugtracker' => "Signaler le problème",
	'admin:plugins:label:donate' => "Don",
	'admin:plugins:label:moreinfo' => "Plus d'informations",
	'admin:plugins:label:version' => "Version",
	'admin:plugins:label:location' => "Adresse",
	'admin:plugins:label:contributors' => 'Contributeurs',
	'admin:plugins:label:contributors:name' => 'Nom',
	'admin:plugins:label:contributors:email' => 'Courriel',
	'admin:plugins:label:contributors:website' => 'Site web',
	'admin:plugins:label:contributors:username' => 'Nom d\'utilisateur',
	'admin:plugins:label:contributors:description' => 'Description',
	'admin:plugins:label:dependencies' => "Dépendances",

	'admin:plugins:warning:elgg_version_unknown' => "Ce plugin utilise un ancien fichier manifest.xml et ne précise pas si cette version est compatible avec l'Elgg actuel. Il ne fonctionnera probablement pas !",
	'admin:plugins:warning:unmet_dependencies' => "Ce plugin ne retrouve pas certaines dépendances et ne peut être activé. Vérifiez les dépendances pour plus d'infos.",
	'admin:plugins:warning:invalid' => "%s n'est pas un plugin valide d'Elgg. Vérifiez <a href='http://docs.elgg.org/Invalid_Plugin'>la documentation d'Elgg</a> les conseils de dépannage.",
	'admin:plugins:warning:invalid:check_docs' => 'Vérifiez <a href="http://learn.elgg.org/fr/stable/appendix/faqs.html">la documentation d\'Elgg</a> - ou la version <a href="http://learn.elgg.org/en/stable/appendix/faqs.html">anglophone</a>, souvent plus complète - pour des astuces de débogage.',
	'admin:plugins:cannot_activate' => "Activation impossible",

	'admin:plugins:set_priority:yes' => "%s Réordonné",
	'admin:plugins:set_priority:no' => "Impossible de réordonné %s.",
	'admin:plugins:set_priority:no_with_msg' => "Impossible de réordonner %s. Erreur : %s",
	'admin:plugins:deactivate:yes' => "Désactivé %s.",
	'admin:plugins:deactivate:no' => "Impossible de désactiver %s.",
	'admin:plugins:deactivate:no_with_msg' => "Impossible de désactiver %s. Erreur : %s",
	'admin:plugins:activate:yes' => "%s Activé.",
	'admin:plugins:activate:no' => "Impossible d'activer %s.",
	'admin:plugins:activate:no_with_msg' => "Impossible d'activer %s. Erreur : %s",
	'admin:plugins:categories:all' => "Toutes les catégories",
	'admin:plugins:plugin_website' => "Site du plugin",
	'admin:plugins:author' => "%s",
	'admin:plugins:version' => "Version %s",
	'admin:plugins:simple' => "Simple",
	'admin:plugins:advanced' => "Avancé",
	'admin:plugin_settings' => "Paramètres du plugin",
	'admin:plugins:simple_simple_fail' => "Impossible d'enregistrer les paramètres.",
	'admin:plugins:simple_simple_success' => "Paramètres sauvegardés.",
	'admin:plugins:simple:cannot_activate' => "Impossible d'activer ce plugin. Vérifiez les options avancées de plugin dans la zone d'administration pour plus d'informations.",
	'admin:plugins:warning:unmet_dependencies_active' => 'Ce plugin est actif, mais a des dépendances non satisfaites. Cela peut poser des problèmes. Voir \'plus d\'info\' ci-dessous pour plus de détails.',

	'admin:plugins:dependencies:type' => "Type",
	'admin:plugins:dependencies:name' => "Nom",
	'admin:plugins:dependencies:expected_value' => "Valeur testée",
	'admin:plugins:dependencies:local_value' => "Valeur réelle",
	'admin:plugins:dependencies:comment' => "Commentaire",

	'admin:statistics:description' => "Cette page est un résumé des statistiques de votre site. Si vous avez besoin de statistiques plus détaillées, une version professionnelle d'administration est disponible.",
	'admin:statistics:opt:description' => "Voir des informations statistiques sur les utilisateurs et les objets de votre site.",
	'admin:statistics:opt:linktext' => "Voir statistiques...",
	'admin:statistics:label:basic' => "Statistiques basiques du site",
	'admin:statistics:label:numentities' => "Entités sur le site",
	'admin:statistics:label:numusers' => "Nombre d'utilisateurs",
	'admin:statistics:label:numonline' => "Nombre d'utilisateurs en ligne",
	'admin:statistics:label:onlineusers' => "Utilisateurs en ligne actuellement",
	'admin:statistics:label:admins'=>"Administrateurs",
	'admin:statistics:label:version' => "Version d'Elgg",
	'admin:statistics:label:version:release' => "Release",
	'admin:statistics:label:version:version' => "Version",

	'admin:server:label:php' => 'PHP',
	'admin:server:label:web_server' => 'Serveur Web',
	'admin:server:label:server' => 'Serveur',
	'admin:server:label:log_location' => 'Emplacement du journal',
	'admin:server:label:php_version' => 'Version de PHP',
	'admin:server:label:php_ini' => 'Emplacement fichier PHP .ini',
	'admin:server:label:php_log' => 'Log PHP',
	'admin:server:label:mem_avail' => 'Mémoire disponible',
	'admin:server:label:mem_used' => 'Mémoire utilisée',
	'admin:server:error_log' => "Serveur Web erreur du log",
	'admin:server:label:post_max_size' => 'Taille maximum d\'un envoi',
	'admin:server:label:upload_max_filesize' => 'Taille maximum d\'un envoi de fichier',
	'admin:server:warning:post_max_too_small' => '(Remarque : la valeur de post_max_size doit supérieure à cette valeur pour supporter des envois de fichier de cette taille)',

	'admin:user:label:search' => "Trouver des utilisateurs :",
	'admin:user:label:searchbutton' => "Chercher",

	'admin:user:ban:no' => "Cet utilisateur ne peut pas être banni",
	'admin:user:ban:yes' => "Utilisateur banni.",
	'admin:user:self:ban:no' => "Vous ne pouvez pas vous bannir vous même",
	'admin:user:unban:no' => "Cet utilisateur ne peut pas être réintégré",
	'admin:user:unban:yes' => "Utilisateur réintégré.",
	'admin:user:delete:no' => "Cet utilisateur ne peut pas être supprimé",
	'admin:user:delete:yes' => "Utilisateur supprimé",
	'admin:user:self:delete:no' => "Vous ne pouvez pas vous supprimer",
	'admin:user:resetpassword:yes' => "Mot de passe réinitialisé, utilisateur notifié.",
	'admin:user:resetpassword:no' => "Le mot de passe n'a pas pu être réinitialisé.",

	'admin:user:makeadmin:yes' => "L'utilisateur est maintenant un administrateur.",
	'admin:user:makeadmin:no' => "Nous ne pouvons pas faire de cet utilisateur un administrateur.",

	'admin:user:removeadmin:yes' => "L'utilisateur n'est plus administrateur.",
	'admin:user:removeadmin:no' => "Nous ne pouvons pas supprimer les privilèges d'administrateur à cet utilisateur.",
	'admin:user:self:removeadmin:no' => "Vous ne pouvez pas supprimer vos propres privilèges d'administrateur.",

	'admin:appearance:menu_items' => "Les éléments de menu",
	'admin:menu_items:configure' => "Configurer les éléments du menu principal",
	'admin:menu_items:description' => "Sélectionnez les éléments de menu que vous voulez afficher en liens directs. Les éléments de menu inutilisés seront ajoutées dans la liste «Plus».",
	'admin:menu_items:hide_toolbar_entries' => "Supprimer les liens dans le menu barre d'outils ?",
	'admin:menu_items:saved' => "Les éléments de menu sauvés.",
	'admin:add_menu_item' => "Ajouter un élément de menu personnalisé",
	'admin:add_menu_item:description' => "Remplissez le nom et l'URL d'affichage pour ajouter des éléments personnalisés à votre menu de navigation.",

	'admin:appearance:default_widgets' => "Widgets par défaut",
	'admin:default_widgets:unknown_type' => "Type du widget Inconnu",
	'admin:default_widgets:instructions' => "Ajoutez, supprimez, positionnez et configurez les widgets par défaut pour la page des profils. Ces changements s'appliqueront uniquement aux nouveaux utilisateurs sur le site.",

	'admin:robots.txt:instructions' => "Editez le fichier robots.txt du site ci-dessous",
	'admin:robots.txt:plugins' => "Les plugins ajoutent les lignes suivantes au fichier robots.txt ",
	'admin:robots.txt:subdir' => "L'outil pour robots.txt ne fonctionnera peut-être pas car Elgg est installé dans un sous-répertoire",
	'admin:robots.txt:physical' => "The robots.txt tool will not work because a physical robots.txt is present",

	'admin:maintenance_mode:default_message' => 'Le site est fermé pour cause de maintenance',
	'admin:maintenance_mode:instructions' => 'Le mode maintenance devrait être utilisé pour les mises à jour et les autres changements sur le site. 
⇥⇥Quand ce mode est activé, seuls les administrateurs peuvent s\'identifier au site et le naviguer.',
	'admin:maintenance_mode:mode_label' => 'Mode maintenance',
	'admin:maintenance_mode:message_label' => 'Message affiché aux utilisateurs lorsque le mode maintenance est activé',
	'admin:maintenance_mode:saved' => 'Les paramètres du mode maintenance ont été sauvegardés.',
	'admin:maintenance_mode:indicator_menu_item' => 'Le site est en maintenance. ',
	'admin:login' => 'Identification Admin',

/**
 * User settings
 */

	'usersettings:description' => "Le panneau de configuration vous permet de contrôler tous vos paramètres et vos plugins. Choisissez une option ci-dessous pour continuer.",

	'usersettings:statistics' => "Vos statistiques",
	'usersettings:statistics:opt:description' => "VVisualiser les statistiques des utilisateurs et des objets sur votre espace.",
	'usersettings:statistics:opt:linktext' => "Information sur votre compte",

	'usersettings:user' => "Vos paramètres",
	'usersettings:user:opt:description' => "Ceci vous permet de contrôler vos paramètres.",
	'usersettings:user:opt:linktext' => "Changer vos paramètres",

	'usersettings:plugins' => "Outils",
	'usersettings:plugins:opt:description' => "Configurer vos paramètres (s'il y en a) pour activer vos outils.",
	'usersettings:plugins:opt:linktext' => "Configurer vos outils",

	'usersettings:plugins:description' => "Ce panneau de configuration vous permez de mettre à jour les options de vos outils installés par l'administrateur.",
	'usersettings:statistics:label:numentities' => "Vos entités",

	'usersettings:statistics:yourdetails' => "Vos informations",
	'usersettings:statistics:label:name' => "Votre nom",
	'usersettings:statistics:label:email' => "E-mail",
	'usersettings:statistics:label:membersince' => "Membre depuis",
	'usersettings:statistics:label:lastlogin' => "Dernière connexion",

/**
 * Activity river
 */
	'river:all' => "Toute l'activité du site",
	'river:mine' => "Mon activité",
	'river:owner' => 'Activité de %s',
	'river:friends' => "Activités des Amis",
	'river:select' => "Afficher %s",
	'river:comments:more' => "+%u plus",
	'river:comments:all' => 'Voir tous les %u commentaires',
	'river:generic_comment' => "commenté sur %s",

	'friends:widget:description' => "Affiche certains de vos amis.",
	'friends:num_display' => "Nombre d'amis à afficher",
	'friends:icon_size' => "Taille des icônes",
	'friends:tiny' => "minuscule",
	'friends:small' => "petit",


/*
		Forum river items
	*/

	'river:create:group:default' => '%s a créé le groupe %s',
	'river:join:group:default' => "%s s'est joint au groupe %s",
	'river:create:object:groupforumtopic' => '%s a ajouté un nouveau sujet de discussion %s',
	'river:reply:object:groupforumtopic' => '%s répondu sur le sujet de discussion %s',
	
	'groups:nowidgets' => 'répondu sur le sujet de discussion.',

	'groups:widgets:members:title' => 'membres du groupe',
	'groups:widgets:members:description' => "Énumérez les membres d'un groupe.",
	'groups:widgets:members:label:displaynum' => "Énumérez les membres d'un groupe.",
	'groups:widgets:members:label:pleaseedit' => "S'il vous plaît configurer ce widget.",

	'groups:widgets:entities:title' => "Objets dans le groupe",
	'groups:widgets:entities:description' => "Énumérez les objets sauvegardés dans ce groupe",
	'groups:widgets:entities:label:displaynum' => "Énumérez les objets d'un groupe.",
	'groups:widgets:entities:label:pleaseedit' => "S'il vous plaît configurer ce widget.",

	'groups:forumtopic:edited' => 'Sujet du forum modifié avec succès.',

	'groups:allowhiddengroups' => 'Voulez-vous permettre à des groupes privés (invisible)?',

	/**
	 * Action messages
	 */
	'group:deleted' => 'Le contenu du groupe et le groupe supprimé',
	'group:notdeleted' => "Groupe n'a pas pu être supprimé",

	'group:notfound' => 'Impossible de trouver le groupe',
	'grouppost:deleted' => "L'entrée du Groupe supprimé avec succès",
	'grouppost:notdeleted' => "L'entrée du groupe n'a pas pu être supprimé",
	'groupstopic:deleted' => 'Sujet supprimé',
	'groupstopic:notdeleted' => 'Sujet pas supprimé',
	'grouptopic:blank' => 'Pas de sujet',
	'grouptopic:notfound' => 'Impossible de trouver le sujet',
	'grouppost:nopost' => 'Entrée vide',
	'groups:deletewarning' => "Etes-vous sûr de vouloir supprimer ce groupe? Il n'y a pas d'annulation!",

	'groups:invitekilled' => "L'invitation a été supprimé.",
	'groups:joinrequestkilled' => "La demande d'adhésion a été supprimé.",	

/**
 * Icons
 */

	'icon:size' => "Taille des icônes",
	'icon:size:topbar' => "Topbar",
	'icon:size:tiny' => "Mini",
	'icon:size:small' => "Petit",
	'icon:size:medium' => "Moyen",
	'icon:size:large' => "Large",
	'icon:size:master' => "Très large",

/**
 * Generic action words
 */
	'save' => "Enregistrer",
	'reset' => "Réinitialiser",
	'publish' => "Publier",
	'cancel' => "Annuler",
	'saving' => "Enregistrement en cours",
	'update' => "Mettre à jour",
	'preview' => "Prévisualisation",
	'edit' => "Modifier",
	'delete' => "Supprimer",
	'accept' => "Accepter",
	'reject' => "Rejet",
	'decline' => "Refuser",
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
	'hide' => 'Masquer',
	'show' => 'Montrer',
	'reply' => "Répondre",
	'more' => "Plus",
	'more_info' => 'Plus d\'information',
	'comments' => "Commentaires",
	'import' => "Importer",
	'export' => "Exporter",
	'untitled' => "Sans titre",
	'help' => "Aide",
	'send' => "Envoyer",
	'post' => "Poster",
	'submit' => "Soumettre",
	'comment' => "Commentaire",
	'upgrade' => "Mise à jour",
	'sort' => 'Trier',
	'filter' => 'Filtrer',
	'new' => 'Nouveau',
	'add' => 'Ajouter',
	'create' => 'Créer',
	'remove' => 'Enlever',
	'revert' => 'Revenir',

	'site' => "Site",
	'activity' => "Activité",
	'members' => "Membres",
	'menu' => 'Menu',

	'up' => "Monter",
	'down' => "Descendre",
	'top' => "Au dessus",
	'bottom' => "Au dessous",
	'right' => 'Droite',
	'left' => 'Gauche',
	'back' => 'Derrière',

	'invite' => "Inviter",

	'resetpassword' => "Réinitialiser le mot de passe",
	'changepassword' => "Changer le mot de passe",
	'makeadmin' => "Rendre l'utilisateur administrateur",
	'removeadmin' => "Supprimer les droits administrateur de l'utilisateur",

	'option:yes' => "Oui",
	'option:no' => "Non",

	'unknown' => "Inconnu",
	'never' => 'Jamais',

	'active' => "Activé",
	'total' => "Total",
	
	'ok' => 'OK',
	'any' => 'N\'importe',
	'error' => 'Erreur',

	'other' => 'Autre',
	'options' => 'Options',
	'advanced' => 'Avancées',

	'learnmore' => "Cliquer ici pour en apprendre plus.",
	'unknown_error' => 'Erreur inconnue',

	'content' => "contenu",
	'content:latest' => "Dernière activité",
	'content:latest:blurb' => "Vous pouvez également cliquer ici pour voir les dernières modifications effectuées sur le site.",
	
	'link:text' => "voir le lien",
	'preview' => "prévisualisation",

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
	'status:unpublished' => 'Dépublié',
	'status:published' => 'Publié',
	'status:featured' => 'En vedette',
	'status:open' => 'Ouvert',
	'status:closed' => 'Fermé',

/**
 * Generic sorts
 */

	'sort:newest' => 'Nouveaux',
	'sort:popular' => 'Populaires',
	'sort:alpha' => 'Alphabétique',
	'sort:priority' => 'Priorité',
		
/**
 * Generic data words
 */

	'title' => "Titre",
	'description' => "Description",
	'tags' => "Mots-clés",
	'spotlight' => "Projecteur sur",
	'all' => "Tous",
	'mine' => "à moi",

	'by' => "par",
	'none' => 'aucun',

	'annotations' => "Annotations",
	'relationships' => "Relations",
	'metadata' => "Metadonnées",
	'tagcloud' => "Nuage de tags",
	'tagcloud:allsitetags' => "Tous les tags du site",
	
	'on' => 'Oui',
	'off' => 'Non',

/**
 * Entity actions
 */
	'edit:this' => "Modifier",
	'delete:this' => "Supprimer",
	'comment:this' => "Commenter",

/**
 * Input / output strings
 */

	'deleteconfirm' => "Etes-vous sur de voloir supprimer cet élément ?",
	'deleteconfirm:plural' => "Etes-vous sûr de vouloir effacer ces éléments ?",
	'fileexists' => "Un fichier a déjà été chargé. Pour le remplacer sélectionner le ci-dessous :",

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
 **/

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
	'friendlytime:days' => "Il y a %s jours",
	'friendlytime:days:singular' => "hier",
	'friendlytime:date_format' => "j F Y @ g:ia",
	
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

	'date:weekday:0' => 'dimanche',
	'date:weekday:1' => 'lundi',
	'date:weekday:2' => 'mardi',
	'date:weekday:3' => 'mercredi',
	'date:weekday:4' => 'jeudi',
	'date:weekday:5' => 'vendredi',
	'date:weekday:6' => 'samedi',
	
	'interval:minute' => 'chaque minute',
	'interval:fiveminute' => 'chaque cinq minutes',
	'interval:fifteenmin' => 'toutes les 15 minutes',
	'interval:halfhour' => 'toutes les demi-heures',
	'interval:hourly' => 'toutes les heures',
	'interval:daily' => 'tous les jours',
	'interval:weekly' => 'chaque semaine',
	'interval:monthly' => 'tous les mois',
	'interval:yearly' => 'chaque année',
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
	'installation:registration:description' => "L'enregistrement d'un utilisateur est activé par défaut. Désactivez cette option si vous ne voulez pas que de nouveaux utilisateurs soient en mesure de s'inscrire eux-mêmes.",
	'installation:registration:label' => "Permettre à de nouveaux utilisateurs de s'enregistrer eux-mêmes",
	'installation:walled_garden:description' => "Autoriser le site à fonctionner comme un réseau privé. Cela empêchera les utilisateurs non connectés d'afficher les pages du site autres que celles expressément spécifiées publiques.",
	'installation:walled_garden:label' => "Restreindre les pages aux utilisateurs enregistrés",

	'installation:httpslogin' => "Activer ceci afin que les utilisateurs puissent se connecter via le protocole https. Vous devez avoir https activé sur votre serveur afin que cela fonctionne.",
	'installation:httpslogin:label' => "Activer les connexions HTTPS",
	'installation:view' => "Entrer le nom de la vue qui sera utilisée automatiquement pour l'affichage du site (par exemple : 'mobile'), laissez par défaut en cas de doute :",

	'installation:siteemail' => "L'adresse e-mail du site (utilisée lors d'envoi d'e-mail par le système)",

	'installation:disableapi' => "Elgg fournit une API pour l'élaboration de services web qui permettent à des application distantes d'interagir avec votre site.",
	'installation:disableapi:label' => "Activer les services web d'Elgg",

	'installation:default_limit' => "Nombre d'éléments par page par défaut",

	'admin:site:access:warning' => "Changer les paramètres d'accès n'affectera que les permissions de contenu créées dans le futur.",

	'installation:allow_user_default_access:description' => "Si coché, les utilisateurs pourront modifier leur niveau d'accés par défaut et pourront surpasser le niveau d'accés mis en place par défaut dans le système.",
	'installation:allow_user_default_access:label' => "Autoriser un niveau d'accés par défaut pour l'utilisateur",

	'installation:simplecache:description' => "Le cache simple augmente les performances en mettant en cache du contenu statique comme des CSS et des fichiers Javascripts. Normalement vous ne devriez pas avoir besoin de l'activer.",
	'installation:simplecache:label' => "Utiliser un cache simple (recommandé)",

	'installation:viewpathcache:description' => "Le cache utilisé pour stocker les chemins vers les vues des greffons réduit le temps de chargement de ces derniers.",
	'installation:viewpathcache:label' => "Utiliser le cache de stockage des chemins vers les vues des greffons (recommandé)",

	'installation:minify:description' => "Le cache peut être amélioré en compressant les fichiers JavaScript et  CSS. (Il est nécessaire que le ache simple soit activé). ",
	'installation:minify_js:label' => "Compresser le JavaScript (recommandé)",
	'installation:minify_css:label' => "Compresser les CSS (recommandé)",

	'installation:htaccess:needs_upgrade' => "Vous devez mettre à jour votre fichier .htaccess afin que le chemin soit ajouté au paramètre GET __elgg_uri (vous pouvez vous aider de htaccess_dist)",
	'installation:htaccess:localhost:connectionfailed' => "Elgg ne peut pas se connecter à lui-même pour tester les règles de réécriture. Veuillez vérifier si l'extension curl fonctionne, et qu'il n'y a pas de restriction au niveau des IP interdisant de se connecter depuis localhost.",
	
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
	'upgrade:unable_to_upgrade' => "Impossible de mettre à jour.",
	'upgrade:unable_to_upgrade_info' =>
		'This installation cannot be upgraded because legacy views
		were detected in the Elgg core views directory. These views have been deprecated and need to be
		removed for Elgg to function correctly. If you have not made changes to Elgg core, you can
		simply delete the views directory and replace it with the one from the latest
		package of Elgg downloaded from <a href="http://elgg.org">elgg.org</a>.<br /><br />

		If you need detailed instructions, please visit the <a href="http://docs.elgg.org/wiki/Upgrading_Elgg">
		Upgrading Elgg documentation</a>.  If you require assistance, please post to the
		<a href="http://community.elgg.org/pg/groups/discussion/">Community Support Forums</a>.',

	'update:twitter_api:deactivated' => "Twitter API (précédemment Twitter Service) a été désactivé lors de la mise à niveau. S'il vous plaît activer manuellement si nécessaire.",
	'update:oauth_api:deactivated' => "OAuth API (précédemment OAuth Lib) a été désactivé lors de la mise à niveau. S'il vous plaît activer manuellement si nécessaire.",
	'upgrade:site_secret_warning:moderate' => "Vous êtes invité à régénérer la clé de votre site afin d'améliorer sa sécurité. Voir dans Configuration / Paramètres avancés",
	'upgrade:site_secret_warning:weak' => "Vous êtes fortement encouragé à régénérer la clé de votre site afin d'améliorer la sécurité de votre système. Voir dans Configuration / Paramètres avancés",

	'deprecated:function' => "%s() a été déclaré obsolète par %s()",

	'admin:pending_upgrades' => 'Le site a des mises à niveau en attente qui nécessitent votre attention immédiate.',
	'admin:view_upgrades' => 'Afficher les mises à jour en attente.',
 	'admin:upgrades' => 'Mise à niveau',
	'item:object:elgg_upgrade' => 'Site mis à jour',
	'admin:upgrades:none' => 'Votre traduction est à jour !',

	'upgrade:item_count' => 'Il y a <b>%s</b> éléments qui doivent être mis à niveau.',
	'upgrade:warning' => '<b>Attention :</b> Sur un site volumineux cette mise à jour peut prendre un temps significatif (voire très long) !',
	'upgrade:success_count' => 'Mise à jour :',
	'upgrade:error_count' => 'Erreurs :',
	'upgrade:river_update_failed' => 'Impossible de mettre à jour l\'entrée du flux de l\'élément d\'identifiant id %s',
	'upgrade:timestamp_update_failed' => 'Impossible de mettre à jour l\'horodatage de l\'élément d\'identifiant id %s',
	'upgrade:finished' => 'Mise à jour terminée',
	'upgrade:finished_with_errors' => '<p>Mise à jour terminée sans erreurs. Rafraîchissez la page et tentez de relancer la mise à jour.</p></p><br />Si vous avez encore cette erreur, vérifiez le contenu du log d\'erreurs du serveur. Vous pouvez chercher de l\'aide sur cette erreur dans le <a href="http://community.elgg.org/groups/profile/179063/elgg-technical-support">groupe de support technique</a> de la communauté Elgg.</p>',

	// Strings specific for the comments upgrade
	'admin:upgrades:comments' => 'Mise à jour des commentaires',
	'upgrade:comment:create_failed' => 'Impossible de convertir le commentaire id %s en une entité.',
	'admin:upgrades:commentaccess' => 'Mise à jour des commentaires',

	// Strings specific for the datadir upgrade
	'admin:upgrades:datadirs' => 'Répertoire de données mis à jour',

	// Strings specific for the discussion reply upgrade
	'admin:upgrades:discussion_replies' => 'Réponse à la discussion mise à jour',
	'discussion:upgrade:replies:create_failed' => 'Impossible de convertir la discussion id %s en une entité.',

/**
 * Welcome
 */

	'welcome' => "Bienvenue",
	'welcome:user' => "Bienvenue %s",
	'site_update' => "",
//	'site_update' => "GCconnex a maintenant une toute nouvelle allure et une nouvelle fonctionnalité!  Il est possible que certaines caractéristiques ne soient pas là où vous aviez l’habitude de les voir. Veuillez consulter les pages d’aide de GCconnex, à <a href='http://www.gcpedia.gc.ca/wiki/GCconnex_utilisateur_aide'>GCconnex Utilisateur Aide</a>. Veuillez nous faire part de toute rétroaction, bogue ou problème, à : <a href='mailto:GCCONNEX@tbs-sct.gc.ca?Subject=GCconnex'>GCCONNEX@tbs-sct.gc.ca</a>",


/**
 * Emails
 */
	'email:from' => 'De',
	'email:to' => 'Pour',
	'email:subject' => 'Sujet',
	'email:body' => 'Corps de l\'article',

	'email:settings' => "Paramètres e-mail",
	'email:address:label' => "Votre adresse e-mail",

	'email:save:success' => "Votre nouvelle adresse e-mail a été enregistrée, vous allez recevoir un e-mail de confirmation.",
	'email:save:fail' => "Votre nouvelle adresse e-mail n'a pas pu être enregistrée.",

	'friend:newfriend:subject' => "%s vous a ajouté comme contact !",
	'friend:newfriend:body' => "%s vous a ajouté comme contact!

Pour voir son profil cliquer sur le lien ci-dessous

	%s

Vous ne pouvez pas répondre à cet e-mail.",

	'email:changepassword:subject' => "Mot de passe modifié !",
	'email:changepassword:body' => "Bonjour %s,

Votre mot de passe a été modifié.",

	'email:resetpassword:subject' => "Réinitialisation du mot de passe !",
	'email:resetpassword:body' => "Bonjour %s,

Votre nouveau mot de passe est : %s",

	'email:resetreq:subject' => "Demander un nouveau mot de passe.",
	'email:resetreq:body' => "Bonjour %s,

Quelqu'un (avec l'adresse IP %s) a demandé un nouveau mot de passe pour son compte.

Si vous avez demandé ce changement veuillez cliquer sur le lien ci-dessous, sinon ignorez cet e-mail.

%s
",
	'email:changereq:subject' => "Demander un nouveau mot de passe.",
	'email:changereq:body' => "Bonjour %s,

Quelqu'un (à partir de l'adresse IP %s) a demandé un changement de mot de passe pour son compte.

Si vous êtes à l'origine de cette demande, cliquez sur le lien ci-dessous. Sinon ignorez cet e-mail.

%s
",


/**
 * user default access
 */

'default_access:settings' => "Votre niveau d'accés par défaut",
'default_access:label' => "Accés par défaut",
'user:default_access:success' => "Votre nouveau niveau d'accés par défaut a été enregistré.",
'user:default_access:failure' => "Votre nouveau niveau d'accés par défaut n'a pu être enregistré.",

/**
 * XML-RPC
 */
	'xmlrpc:noinputdata'	=>	"Input data missing",

/**
 * Comments
 */

	'comments:count' => "%s commentaire(s)",

	'item:object:comment' => 'Commentaires',

	'river:comment:object:default' => '%s a commenté %s',

	'riveraction:annotation:generic_comment' => "%s a écrit un commentaire sur %s",

	'generic_comments:add' => "Laisser un commentaire",
	'generic_comments:post' => "Poster un commentaire",
	'generic_comments:text' => "Commentaire",
	'generic_comments:latest' => "Derniers commentaires",
	'generic_comment:posted' => "Votre commentaire a été publié avec succés.",
	'generic_comment:updated' => "Le commentaire a été mis à jour.",
	'generic_comment:deleted' => "Votre commentaire a été correctement supprimé.",
	'generic_comment:blank' => "Désolé; vous devez remplir votre commentaire avant de pouvoir l'enregistrer.",
	'generic_comment:notfound' => "Désolé; l'élément recherché n'a pas été trouvé.",
	'generic_comment:notfound_fallback' => "Désolé, le commentaire demandé n'a pas été trouvé. Vous avez été redirigé sur la page précédente.",
	'generic_comment:notdeleted' => "Désolé; le commentaire n'a pu être supprimé.",
	'generic_comment:failure' => "Une erreur est survenue lors de l'ajout de votre commentaire. Veillez réessayer.",
	'generic_comment:none' => "Pas de commentaires",
	'generic_comment:title' => 'Commentaire de %s',
	'generic_comment:on' => '%s sur %s',
	'generic_comments:latest:posted' => 'publié un',

	'generic_comment:email:subject' => "Vous avez un nouveau commentaire !",
	'generic_comment:email:body' => "Vous avez un nouveau commentaire sur l'élément '%s' de %s. Voici son contenu :


%s


Pour répondre ou voir le contenu de référence, suivez le lien :

%s

Pour voir le profil de %s, suivez ce lien :

%s

Ne répondez pas à cet e-mail.",

/**
 * Entities
 */

	'byline' => "Par %s",
	'entity:default:strapline' => "Créé le %s par %s",
	'entity:default:missingsupport:popup' => "Cette entité ne peut pas être affichée correctement. C'est peut-être du à un plugin qui a été supprimé.",

	'entity:delete:success' => "L'entité %s a été effacée",
	'entity:delete:fail' => "L'entité %s n'a pas pu être effacée",
	'entity:can_delete:invaliduser' => 'Can not check canDelete for user_guid [%s] as the user does not exist.',		// NEEDS TRANSLATION

/**
 * Action gatekeeper
 */
	'actiongatekeeper:missingfields' => "Il manque les champs __token ou __ts dans le formulaire.",
	'actiongatekeeper:tokeninvalid' => "Une erreur est survenue. Cela veut probablement dire que la page que vous utilisiez a expirée. Merci de réessayer",
	'actiongatekeeper:timeerror' => "La page a expiré, rafraichissez et recommencez à nouveau.",
	'actiongatekeeper:pluginprevents' => "Une extension a empêché ce formulaire d'être envoyé",
	'actiongatekeeper:uploadexceeded' => 'La taille du fichier dépasse la limite définie par l\'administrateur du site',
	'actiongatekeeper:crosssitelogin' => "Désolé, il n'est pas permis de se connecter depuis un autre nom de domaine. Veuillez réessayer.",

/**
 * Word blacklists
 */
	'word:blacklist' => "and, the, then, but, she, his, her, him, one, not, also, about, now, hence, however, still, likewise, otherwise, therefore, conversely, rather, consequently, furthermore, nevertheless, instead, meanwhile, accordingly, this, seems, what, whom, whose, whoever, whomever",
// from elgg1.12	'word:blacklist' => 'et, le alors, elle, il, son, sa lui, un, une, pas, aussi, maintenant, malgré, cependant, toutefois, mais, plutôt, au, pendant, ce, cette, ces, quel, qui, que',


/**
 * Tag labels
 */

	'tag_names:tags' => "Tags",
	'tags:site_cloud' => "Nuage de tag du site",

/**
 * Javascript
 */

	'js:security:token_refresh_failed' => "Impossible de contacter %s. Vous aurez sans doute des difficultés à enregistrer le contenu.",
	'js:security:token_refreshed' => "La connexion à %s est restaurée !",
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
	"eu_es" => "Basque (Spain)",
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
	"ie" => "Occidental",
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
	"kl" => "Kalaallisut",
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
	"na" => "Nauruan",
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
	"pt_br" => "Portuguese (Brazil)",
	"qu" => "Quechua",
	"rm" => "Romanche",
	"rn" => "Kirundi",
	"ro" => "Roumain",
	"ro_ro" => "Romanian (Romania)",
	"ru" => "Russe",
	"rw" => "Kinyarwanda",
	"sa" => "Sanskrit",
	"sd" => "Sindhi",
	"sg" => "Sango",
	"sh" => "Serbo-Croate",
	"si" => "Cingalais",
	"sk" => "Slovaque",
	"sl" => "Slovène",
	"sm" => "Samoan",
	"sn" => "Shona",
	"so" => "Somalien",
	"sq" => "Albanais",
	"sr" => "Serbe",
	"sr_latin" => "Serbian (Latin)",
	"ss" => "Siswati",
	"st" => "Sotho",
	"su" => "Soundanais",
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
	"zh_hans" => "Chinese Simplified",
	"zu" => "Zoulou",
);
