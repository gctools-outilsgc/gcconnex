<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage ElggUserValidationByEmail
 */

return array(
	'admin:users:unvalidated' => 'non validées',
	
	'email:validate:subject' => "%s s'il vous plaît confirmer votre adresse e-mail pour %s!",
	'email:validate:body' => "%s,

Avant que vous puissiez utiliser %s, vous devez confirmer votre adresse de courriel.

S'il vous plaît confirmer votre adresse courriel en cliquant sur le lien ci-dessous:

%s

Si vous ne pouvez pas cliquer sur le lien, copier et coller dans votre navigateur manuellement.

%s
%s
",

	'email:confirm:success' => "Vous avez confirmé votre adresse de courriel!",
	'email:confirm:fail' => "Votre adresse de courriel n'a pas pu être vérifiée...",

	'uservalidationbyemail:emailsent' => "E-mail envoyé à <em>%s</em>",
	//'uservalidationbyemail:registerok' => "Pour activer votre compte, s'il vous plaît confirmer votre adresse courriel en cliquant sur le lien que nous venons de vous envoyer..",
    'uservalidationbyemail:registerok' => "Votre compte a été créé, mais avant de pouvoir ouvrir une session vous devez d'abord vérifier votre adresse électronique. Un message a été envoyé à l'adresse que vous avez fournie. Veuillez suivre les instructions que contient le message pour vérifier votre compte.",
	'uservalidationbyemail:login:fail' => "Votre compte n'est pas validé donc la tentative de connexion a échoué. Un autre courriel de validation a été envoyé.",

	'uservalidationbyemail:admin:no_unvalidated_users' => 'Pas de utilisateurs non validées.',

	'uservalidationbyemail:admin:unvalidated' => 'Non validées',
	'uservalidationbyemail:admin:user_created' => '%s enregistré',
	'uservalidationbyemail:admin:resend_validation' => 'Renvoyer la validation',
	'uservalidationbyemail:admin:validate' => 'Valider',
	'uservalidationbyemail:admin:delete' => 'Supprimer',
	'uservalidationbyemail:confirm_validate_user' => 'Valider %s?',
	'uservalidationbyemail:confirm_resend_validation' => 'Renvoyer courriel de validation %s?',
	'uservalidationbyemail:confirm_delete' => 'Supprimer %s?',
	'uservalidationbyemail:confirm_validate_checked' => 'Valider les utilisateurs vérifiés?',
	'uservalidationbyemail:confirm_resend_validation_checked' => 'Renvoyer la validation des utilisateurs vérifiés?',
	'uservalidationbyemail:confirm_delete_checked' => 'Supprimer des utilisateurs vérifiés?',
	'uservalidationbyemail:check_all' => 'Tous',

	'uservalidationbyemail:errors:unknown_users' => 'Utilisateurs inconnus',
	'uservalidationbyemail:errors:could_not_validate_user' => "N'a pas pu valider l'utilisateur.",
	'uservalidationbyemail:errors:could_not_validate_users' => 'Impossible de valider tous les utilisateurs vérifiés.',
	'uservalidationbyemail:errors:could_not_delete_user' => "Impossible de supprimer l'utilisateur.",
	'uservalidationbyemail:errors:could_not_delete_users' => 'Impossible de supprimer tous les utilisateurs vérifiés.',
	'uservalidationbyemail:errors:could_not_resend_validation' => 'Impossible de renvoyer la demande de validation.',
	'uservalidationbyemail:errors:could_not_resend_validations' => 'Impossible de renvoyer toutes les demandes de validation pour les utilisateurs vérifiés.',

	'uservalidationbyemail:messages:validated_user' => 'Utilisateur validé.',
	'uservalidationbyemail:messages:validated_users' => 'Tous les utilisateurs vérifiés validé.',
	'uservalidationbyemail:messages:deleted_user' => 'Utilisateur supprimé.',
	'uservalidationbyemail:messages:deleted_users' => 'Tous les utilisateurs vérifiés supprimé.',
	'uservalidationbyemail:messages:resent_validation' => 'Demande de validation renvoyer.',
	'uservalidationbyemail:messages:resent_validations' => 'Demandes de validation renvoyé à tous les utilisateurs vérifiés.'

);
