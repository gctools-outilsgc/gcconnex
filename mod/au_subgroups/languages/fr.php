<?php

$french = array(
'au_subgroups' =>  "Sous-groupes",
'au_subgroups:subgroup' => "Sous-groupe",
'au_subgroups:subgroups' => "Sous-groupes",
'au_subgroups:parent' => "Groupe principal",
'au_subgroups:add:subgroup' => 'Créer un sous-groupe',
'au_subgroups:nogroups' => "Aucun sous-groupe n’a été créé",
'au_subgroups:error:notparentmember' =>  "Les utilisateurs ne peuvent se joindre à un sous-groupe s'ils ne sont pas membres du groupe principal.",
'au_subtypes:error:create:disabled' => "La création de sous-groupes est désactivée pour ce groupe",
'au_subgroups:noedit' =>  "Impossible de modifier le groupe",
'au_subgroups:subgroups:delete' => "Supprimer le groupe",
'au_subgroups:delete:label' => "Que voulez-vous faire du contenu de cette page? Toute option sélectionnée s\'appliquera aussi aux sous-groupes qui seront supprimés.",
'au_subgroups:deleteoption:delete' => 'Supprimer tout le contenu lié au groupe',
'au_subgroups:deleteoption:owner' => 'Transférer tout le contenu aux créateurs d\'origine',
'au_subgroups:deleteoption:parent' => 'Transférer tout le contenu au groupe principal',
'au_subgroups:subgroup:of' => "Sous-groupe de %s",
'au_subgroups:setting:display_alphabetically' => "Afficher la liste des groupes personnels en ordre alphabétique?",
'au_subgroups:setting:display_subgroups' => 'Afficher les sous-groupes sous forme de liste',
'au_subgroups:setting:display_featured' => 'Afficher le menu des Groupes en vedette dans ma liste de groupes',
'au_subgroups:error:invite' => "Action annulée. Les utilisateurs suivants ne sont pas membres du groupe principal et ne peuvent être invités/ajoutés.",
'au_subgroups:option:parent:members' => "Membres du groupe principal",
'au_subgroups:subgroups:more' => "Voir tous les sous-groupes",
'subgroups:parent:need_join' =>  '',     
            
// group options            
            
'au_subgroups:group:enable' => "Activer la création de sous-groupes pour ce groupe?",
'au_subgroups:group:memberspermissions' => "Sous-groupes : Voulez-vous permettre à tous les membres de créer des sous-groupes? (Si vous sélectionnez « non », seuls les administrateurs du groupe pourrons créer des sous-groupes)",
            
// Widget           
            
'au_subgroups:widget:order' => 'Trier les résultats par',
'au_subgroups:option:default' => 'Date de création',
'au_subgroups:option:alpha' => 'En ordre alphabétique',
'au_subgroups:widget:numdisplay' => 'Nombre de sous-groupes à afficher',
'au_subgroups:widget:description' => 'Afficher la liste des sous-groupes de ce groupe',
            
 // Move group          
            
'au_subgroups:move:edit:title' => "Faire de ce groupe un sous-groupe d'un autre groupe",
'au_subgroups:transfer:help' => "Vous pouvez définir ce groupe come sous-groupe de tout autre groupe que vous avez le droit de modifier. Si les membres actuels ne sont pas membres du nouveau groupe principal, ils seront retirés de la liste de l'ancien groupe et une invitation à se joindre au nouveau groupe principal et à tous les sous-groupes connexes à l'ancien groupe leur sera envoyée. <b>Tous les sous-groupes de l'ancien groupe seront aussi transférés</b>",
'au_subgroups:search:text' =>  "Rechercher des groupes",
'au_subgroups:search:noresults' => "Aucun groupes n'a été trouvé",
'au_subgroups:error:timeout' => "Le délai de la recherche a exprié",
'au_subgroups:error:generic' => "Une erreur s'est produite pendant la recherche",
'au_subgroups:move:confirm' => "Êtes-vous sûr de vouloir faire de ce groupe un sous-groupe d'un autre groupe?",
'au_subgroups:error:permissions' => "Vous dever avoir le droit de modifier le sous-groupe et chaque sous-groupe précédent jusqu'au dossier principal. En outre, il n'est pas possible de faire d'un groupe un sous-groupe de ses propres sous-groupes.",
'au_subgroups:move:success' => "Group has been moved successfully",
'au_subgroups:error:invalid:group' => "Invalid group identifier",
'au_subgroups:invite:body' =>  "Bonjour %s, le groupe %s est devenu un sous-groupe du groupe %s. Comme vous n'êtes pas membre actuellement du nouveau groupe principal, votre nom a été retiré de la liste des membres de l'ancien groupe. Une nouvelle invitation à vous a été envoyée, en acceptant l'invitation vous deviendrez automatiquement membre de tous les groupes principals. Cliquez ci-dessous pour voir vos invitations : %s",

);
					
add_translation("fr",$french);
