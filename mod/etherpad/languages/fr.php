<?php
/**
 * Etherpads French language file
 * 
 * package ElggPad
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	 
	'etherpad' => "Docs (Beta)",
	'etherpad:single' => "Doc",
	'etherpad:docs' => "Docs (Beta)",
	'etherpad:owner' => "Docs de %s",
	'etherpad:friends' => "Docs des collègues",
	'etherpad:all' => "Tous les Docs",
	'docs:add' => "Ajouter un Doc",
	'etherpad:add' => "Ajouter un Doc",
	'etherpad:timeslider' => 'Historique',
	'etherpad:fullscreen' => 'Plein écran',
	'etherpad:none' => 'Aucun Doc créé',
	'docs:none' => 'Aucun Doc créé',
	'docs:more' => 'Tous les Docs',
	
	'etherpad:group' => 'Docs de groupe',
	'groups:enablepads' => 'Activer la fonction « Docs de groupe »',
	
	/**
	 * River
	 */
	'river:create:object:etherpad' => '%s a créé un nouveau Doc %s',
	'river:create:object:subpad' => '%s a créé un nouveau Doc %s',
	'river:update:object:etherpad' => '%s a mis à jour le Doc %s',
	'river:update:object:subpad' => '%s a mis à jour le Doc %s',
	'river:comment:object:etherpad' => '%s a commenté sur le Doc %s',
	'river:comment:object:subpad' => '%s a commenté sur le Doc %s',
	
	'item:object:etherpad' => 'Docs',
	'item:object:subpad' => 'Sous-Docs',

	/**
	 * Status messages
	 */

	'etherpad:saved' => "Votre Doc a été enregistré.",
	'etherpad:delete:success' => "Votre Doc a été supprimé.",
	'etherpad:delete:failure' => "Votre Doc ne peut pas être supprimé. Veuillez essayer de nouveau.",
	
	/**
	 * Edit page
	 */
	 
	 'etherpad:title' => "Titre",
	 'etherpad:tags' => "Mots-clé",
	 'etherpad:access_id' => "Accès en lecture seule",
	 'etherpad:write_access_id' => "Accès en écriture",

	/**
	 * Admin settings
	 */

	'etherpad:etherpadhost' => "Adresse hôte de Etherpad Lite :",
	'etherpad:etherpadkey' => "Clé API de Etherpad Lite :",
	'etherpad:showfullscreen' => "Afficher le bouton plein écran?",
	'etherpad:showchat' => "Afficher l'option clavardage?",
	'etherpad:linenumbers' => "Afficher les numéros de ligne?",
	'etherpad:showcontrols' => "Afficher les contrôles?",
	'etherpad:monospace' => "Utiliser la police monospace?",
	'etherpad:showcomments' => "Afficher les commentaires?",
	'etherpad:newpadtext' => "Texte du nouveau Doc :",
	'etherpad:pad:message' => 'Nouveau Doc créé avec succès.',
	'etherpad:integrateinpages' => "Intégrer des Docs et des pages? (Le module d'extention Pages doit être activé)",
	
	/**
	 * Widget
	 */
	'etherpad:profile:numbertodisplay' => "Nombre de Docs à afficher",
    'etherpad:profile:widgetdesc' => "Afficher vos Docs les plus récents",
    
    /**
	 * Sidebar items
	 */
	'etherpad:newchild' => "Créer un Sous-Doc",
);

add_translation('fr', $french);
