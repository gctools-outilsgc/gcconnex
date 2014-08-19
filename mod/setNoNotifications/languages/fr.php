<?php
/**
 * "Set No Notification" plugin French language file
 */

$french = array(
'setNoNotifications:disabled' => 'Utilisateurs avec les notifications par email désactivées: ',
'setNoNotifications:enabled' => 'Utilisateurs avec les notifications par email activées: ',
'setNoNotifications:choose:type:a' => 'tous les utilisateurs ou',
'setNoNotifications:choose:type:b' => 'seuls les nouveaux utilisateurs.',
'setNoNotifications:choose:type' => 'Désactiver les notifications par email pour la prochaine (ou la première respectivement) connexion de',
'setNoNotifications:description' => '(Les notifications par courriel sont désactivées, soit sur la prochaine connexion pour tous les utilisateurs existants en plus des futurs nouveaux utilisateurs ou seulement pour les futurs nouveaux utilisateurs sur leur première connexion. La désactivation des notifications par email est effectuée une seule fois, c\'est à dire si un utilisateur permet à nouveau la notification par email,  par la suite, ce paramètre sera respecté même lors de la désactivation à nouveau des notifications par email pour tous les utilisateurs.)',
'setNoNotifications:statistics' => 'Les statistiques de notification par email des utilisateurs existants: ',
);

add_translation('fr',$french);