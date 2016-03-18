<?php
	/**
	 * Elgg MyCustomText plugin
	 *
	 * @package ElggMyCustomText
	 * @license http://gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Untamed
	 * @copyright Untamed 2008-2010
	 */

	$french = array(
          //
    //error messages
    //
 	'contactform:Errreason' => "<a href='#reason'><span class='prefix'>Erreur [#] :</span> Vous devez choisir une raison - Ce champ est obligatoire.</a>",
    'contactform:Errsubject' => "<a href='#subject'><span class='prefix'>Erreur [#] :</span> Sujet - Ce champ est obligatoire.</a>",
    'contactform:Errname' => "<a href='#name'><span class='prefix'>Erreur [#] :</span> Vous devez ajouter votre nom - Ce champ est obligatoire.</a>",
    'contactform:Errnamebig' => "<a href='#name'><span class='prefix'>Erreur [#] :</span> Limite de caractères atteint pour le nom - Veuillez inscrire moins de 75 caractères.</a>",
    'contactform:Erremail' => "<a href='#email'><span class='prefix'>Erreur [#] :</span> Courriel - Ce champ est obligatoire.</a>",
    'contactform:Erremailbig' => "<a href='#email'><span class='prefix'>Erreur [#] :</span> Limite de caractère atteint pour le courriel - Veuillez inscrire moins de 100 caractères.</a>",
    'contactform:Erremailvalid' => "<a href='#email'><span class='prefix'>Erreur [#] :</span> Courriel invalide - Entrez une adresse courriel valide.</a>",
    'contactform:Errdepart' => "<a href='#depart'><span class='prefix'>Erreur [#] :</span> Ministère - Ce champ est obligatoire.</a>",
    'contactform:Errdepartbig' => "<a href='#depart'><span class='prefix'>Erreur [#] :</span> Limite de caractères atteint pour le ministère. - Veuillez inscrire moins de 255 caractères.</a>",
    'contactform:Errmess' => "<a href='#message'><span class='prefix'>Erreur [#] :</span> Message - Ce champ est obligatoire.</a>",
    'contactform:Errmessbig' => "<a href='#message'><span class='prefix'>Erreur [#] :</span> Limite de caractères atteint pour le message. - Veuillez inscrire moins de 2048 caractères.</a>",
    'contactform:Errfiletypes' => "<a href='#photo'><span class='prefix'>Erreur [#] :</span> Type de fichier invalide. - Types de fichiers valides sont : [##]</a>",
    'contactform:Errfilesize' => "<a href='#photo'><span class='prefix'>Erreur [#] :</span> La taille du fichier dépasse la limite. - La taille du fichier doit être inférieure à [##] MB.</a>",
    'contactform:Errfileup' => "<a href='#photo'><span class='prefix'>Erreur [#] :</span> Une erreur est survenue lors que vous avez téléchargé le fichier.</a>",
		
    //General entries		
		
	'help_menu_item' =>  "Aide / Contactez-nous",
	'help:message' =>  "Pour obtenir de l'aide sur GCconnex, s'il vous plaît consultez la page suivante de GCpedia : ",
	'help:url' =>  "http://gcpedia.gc.ca/wiki/Gouvernement_du_Canada_pilote/GCconnex_utilisateur_aide_et_FAQ_de_r%C3%A9seautage_professionne",
	'help:url-desc' =>  "Pages d'aide GCPEDIA",
	'help:contact' =>  "Contactez-nous: ",	
	'contacform' => "Formulaire de contact",
	'contactform:menu' => "Contactez-nous",
	'contactform:titlemsg' => "Merci.",
	'contactform:requiredfields' => "*sections obligatoires",
	'contactform:fullname' => "Votre nom entier",
	'contactform:email' => "Votre adresse courriel",
	'contactform:phone' => "Votre numéro de téléphone",
	'contactform:message' => "Votre message",		
	'contactform:enteremail' => "Ajoutez votre courriel si vous désirez obtenir de la rétroaction",
	'contactform:thankyoumsg' => "Merci d'avoir communiquer avec nous",
	'contactform:loginreqmsg' => "Doit-on ouvrir une session afin d'utiliser le formulaire de contact?",
	'contactform:yes' => "oui",
	'contactform:no' => "non",
	'contactform:validator:name' => "Veuillez fournir votre noms",
	'contactform:validator:email' => "Veuillez fournir votre adresse courriel",
	'contactform:validator:emailvalid' => "Veuillez fournir une adresse courriel valide",
	'contactform:validator:msgtoolong' => "Veuillez fournir un message valide (<2000 caractères)",
	'contactform:validator:answer' => "Veuillez répondre à la question anti-pourriel",
	'contactform:validator:failed' => "Réponse manqué à la question anti-pourriel",
    'contactform:select' => 'Veuillez choisir une raison',
    'contactform:reason' => 'Choisir...',
		
    //setting page		
    		
    'setting:delete' => 'Supprimer',
    'setting:add' => 'Ajouter',
    'setting:id' => 'Identifiant',
    'setting:eng' => 'Anglais',
    'setting:fr' => 'Français',
    'setting:field' => 'Nouvelle question',

	);

	add_translation("fr",$french);