<?php
/**
 * GEDS english language file.
 *
 */

$french = array(

	'geds:button'=> 'Synchroniser avec GCannuaire',
	'geds:cancel'=> 'Annuler',
	'geds:save'=> 'Enregistrer',
	'geds:searchfail'=> 'Aucune information trouvée dans GCannuaire pour ',
	'geds:searchfail2'=> 'Vérifiez l\'exactitude de votre adresse courriel dans GCconnex. Pour mettre vos informations à jour dans GCannuaire, consulter les instructions disponibles sur le<a href=\'http://gcdirectory-gcannuaire.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1\'>site Web de GCannuaire.</a>',
	'geds:personsel:title'=> 'Informations trouvées dans GCannuaire',
	'geds:personsel:isthisyou'=> 'Ces informations sont exactes ',
	'geds:personsel:yes' => 'Oui',
	'geds:personsel:no' => 'Non',
	'geds:personsel:name' => 'Nom: ',
	'geds:personsel:job' => 'Titre du poste: ',
	'geds:personsel:department' => 'Ministère: ',
	'geds:personsel:phone' => 'Téléphone: ',
	'geds:sync:title' => 'Choisir les champs à synchroniser',
	'geds:sync:table:field' => 'Champ',
	'geds:sync:table:current' => 'Profil GCconnex',
	'geds:sync:table:ingeds' => 'Disponible dans GCannuaire',
	'geds:sync:table:field:display' => 'Nom',
	'geds:sync:table:field:job' => 'Titre du poste',
	'geds:sync:table:field:department' => 'Ministère',
	'geds:sync:table:field:telephone' => 'Téléphone',
	'geds:sync:table:field:mobile' => 'Cellulaire',
	'geds:success' => 'Félicitations, votre information de GCannuaire a été synchronisée avec votre profil GCconnex.',
	///////////////////////////////////////////////////////////////////////////
	'geds:org:orgTab' => 'Organisations',
	'geds:add:friend' => 'Inviter à GCconnex',
	'geds:invite:friend' => 'Ajouter un collègue',
	'geds:org:orgTitle' => 'Organisations',
	'geds:org:orgPeopleTitle' => '<h3> Personnes</h3> ',
	'geds:noMatch' => "<p>Vos informations n’ont pas été synchronisées avec GCannuaire. Assurez-vous que votre adresse courriel est mise à jour dans votre compte de GCconnex. Pour mettre vos informations à jour dans GCannuaire, consulter les instructions disponibles sur le <a href='http://gcdirectory-gcannuaire.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1'>site Web de GCannuaire</a>.</p>",
	'geds:floor' => "Étage",
	'geds:org:delete' => "Supprimer",
	'geds:org:edit' => "Modifier",
	'geds:org:edit:title' => 'Modifier les paramètres de sécurités de mon information de GCannuaire',
	'geds:org:access:label' => 'Qui peut voir les renseignements sur mon organisation: ',
	'geds:loc:access:label' => 'Qui peut voir les renseignements sur mon lieu de travail: ',
	'geds:save' => 'Enregistrer',
	'geds:map:title' => 'Lieu de travail',

	'geds:sync:info' => "<p>

		N.B. : GCannuaire est seulement visible pour les fonctionnaires.<br />
	Le Gouvernement du Canada a un service d’annuaire distinct, accessible au public: SAGE.gc.ca.<br />
	Aucune information de votre profil GCconnex n'apparaîtra sur le site SAGE.gc.ca, peu importe vos paramètres de confidentialité dans GCconnex.
		</p>
		<p>
		Lorsque vous cliquez sur « enregistrer », deux choses se produiront :<br />

	1-	GCannuaire mettra à jour l’informations de votre lieu de travail et votre organisation dans GCconnex.
	Il s'agit d'une mise à jour unique: si vos informations dans GCannuaire changent, vous devrez synchroniser à nouveau pour mettre à jour GCconnex.<br />
	2-	Vos comptes GCannuaire et GCconnex seront liés et les informations suivantes de votre profil GCconnex apparaîtront automatiquement dans GCannuaire :<br />
	Obligatoire: Votre avatar (photo)<br />
	Facultatif: Au sujet de moi, éducation, expérience de travail, et vos compétences.
		</p>
		<p>
		Important!<br />
	Si vous ne souhaitez pas que votre avatar GCconnex apparaisse sur GCannuaire, cliquez « Annuler ».
		</p>
		<p>
		Pour les informations facultatives, vous pouvez choisir qui les voit en modifiant vos paramètres de confidentialité dans GCconnex (c'est-à-dire «Modifier», «Qui peut voir ma/mon [description, éducation, etc.]».)
		</p>",

	'geds:org:edit:body' => 'Pour mettre à jour l’information au sujet de votre lieu de travail ou votre organisation dans GCannuaire, consulter les instructions disponibles sur le <a href="http://gcdirectory-gcannuaire.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1">site Web de GCannuaire</a>.',
	'geds:org:edit:success' => 'Paramètres de confidentialité sauvegardés.',
	'geds:edit:error' => "Vous n'avez pas la permission de voir cet élément.",
	'geds:button:unsync' => 'Désynchroniser de GCannuaire',
	'geds:unSync:message' => "Si vous désynchronisez, l'information dans votre profile GCconnex n'apparaîtra plus sur GCannuaire.<br /> Êtes-vous certain?",
	'geds:unsync:title' => 'Êtes-vous certain?',

);

add_translation('fr', $french);
