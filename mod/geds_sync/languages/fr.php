<?php
/**
 * GEDS english language file.
 *
 */

$french = array(
'geds:button'=> 'Synchroniser avec les SAGE',
'geds:cancel'=> 'Annuler',
'geds:save'=> 'Enregistrer',
'geds:searchfail'=> 'Aucune information trouvée dans les SAGE pour ',
'geds:searchfail2'=> 'Vérifiez l\'exactitude de votre adresse courriel dans GCconnex. Pour mettre vos informations à jour dans les SAGE, consulter les instructions disponibles sur le<a href=\'http://geds20-sage20.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1\'>site Web SAGE 2.0.</a>',
'geds:personsel:title'=> 'Informations trouvées dans les SAGE',
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
'geds:sync:table:ingeds' => 'Disponible dans les SAGE',
'geds:sync:table:field:display' => 'Nom',
'geds:sync:table:field:job' => 'Titre du poste',
'geds:sync:table:field:department' => 'Ministère',
'geds:sync:table:field:telephone' => 'Téléphone',
'geds:sync:table:field:mobile' => 'Cellulaire',
'geds:success' => 'Félicitations, votre information des SAGE a été synchronisée avec votre profil GCconnex.',
///////////////////////////////////////////////////////////////////////////		
'geds:org:orgTab' => 'Organisations',
'geds:add:friend' => 'Inviter à GCconnex',
'geds:invite:friend' => 'Ajouter un collègue',
'geds:org:orgTitle' => 'Organisations',
'geds:org:orgPeopleTitle' => '<h3> Personnes</h3 ',
'geds:noMatch' => "<p>Vos informations n’ont pas été synchronisées avec les SAGE. Assurez-vous que votre adresse courriel est mise à jour dans votre compte de GCconnex. Pour mettre vos informations à jour dans les SAGE, consulter les instructions disponibles sur le <a href='http://geds20-sage20.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1'>site Web SAGE 2.0</a>.</p>",
'geds:floor' => "Étage",
'geds:org:delete' => "Supprimer",
'geds:org:edit' => "Modifier",
'geds:org:edit:title' => 'Modifier les paramètres de sécurités de mon information des SAGE',
'geds:org:access:label' => 'Qui peut voir les renseignements sur mon organisation: ',
'geds:loc:access:label' => 'Qui peut voir les renseignements sur mon lieu de travail: ',
'geds:save' => 'Enregistrer',
'geds:map:title' => 'Lieu de travail',
//'geds:sync:info' => 'En cliquant sur Enregistrer, vous allez procéder à synchroniser les informations des SAGE sélectionnées avec votre profil GCconnex. Les informations de votre lieu de travail et votre organisation seront également synchronisées avec votre profil GCconnex.',
'geds:sync:info' => '<p>
En cliquant sur Enregistrer, vous sauvegardez les renseignements que vous avez sélectionnés ci-dessus et vous importez du SAGE ceux qui ont trait à votre service et à votre organisation, et vous procédez ainsi à la mise à jour de votre profil GCconnex. Ces renseignements se copient dès que vous cliquez sur Enregistrer, et ils ne se mettent pas à jour automatiquement si les renseignements contenus dans le SAGE changent, à moins que vous ne sélectionniez à nouveau l’option de synchronisation.
</p>
<p>
En outre, une fois le lien établi entre les comptes, certains renseignements figurant dans votre profil seront extraits de GCconnex chaque fois que votre profil SAGE sera téléchargé. La page de votre profil SAGE affichera les renseignements suivants à partir de GCconnex lorsque le degré de visibilité sera réglé à « public » : À mon sujet, Études, Expérience de travail et Évaluations de la langue seconde.  
</p>
<p>
Si vous ne désirez pas qu’une partie de votre profil GCconnex s’affiche dans le SAGE, vous pouvez y imposer une restriction en cliquant sur Modifier dans la partie dont vous voulez changer la visibilité. Cela limitera aussi les renseignements que les autres abonnés de GCconnex pourront voir dans votre profil.
  </p>
<p>
Votre avatar et la partie portant sur vos compétences s’afficheront toujours dans votre profil des SAGE.
</p>
<p>
Ce qui précède s’applique uniquement à la version interne des SAGE à laquelle seuls les fonctionnaires fédéraux ont accès. Aucun des renseignements contenus dans votre profil GCconnex n’apparaîtra dans le site Web SAGE.gc.ca qui est accessible au public, quels que soient les paramètres de confidentialité sélectionnés dans GCconnex.
</p>
',
'geds:org:edit:body' => 'Pour mettre à jour l’information au sujet de votre organisation ou votre lieu de travail dans les SAGE, consulter les instructions disponibles sur le <a href="http://geds20-sage20.ssc-spc.gc.ca/fr/SAGE20/?pgid=005#q1">site Web SAGE 2.0</a>.',
'geds:org:edit:success' => 'Paramètres de sécurités sauvegardés.',
'geds:edit:error' => "Vous n'avez pas la permission de voir cet élément.",

);

add_translation('fr', $french);
