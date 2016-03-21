<?php
/**
 * Group Operators languages
 *
 * @package ElggGroupOperators
 */

$french = array(

		 //Titles		
		
	"group_operators:title" => 'Administrateurs de %s',
	"group_operators:manage" => 'Gérer les administrateurs du groupe',
	"group_operators:operators" => 'Administrateurs',
	"group_operators:members" => 'Membres',
			
		
	 // Menus		
		
	"group_operators:operators:drop" => 'Retirer les droits d\'administrateur',
	"group_operators:owner" => 	'Propriétaire du groupe',
	"group_operators:owner:make" => 'Transférer la propriété du groupe',
			
		
	 // Form fields		
		
	"group_operators:new" => 'Ajouter un administrateur',
	"group_operators:new:button" => 'Donner des droits d\'administrateur',
	"group_operators:selectone" => 'Sélectionner un...',
			
		
	 // System messages		
		
	"group_operators:added" => '%s est maintenant un administrateur de groupe',
	"group_operatros:add:error" => 'Impossible d,ajoutger %s comme administrateur du groupe',
	"group_operators:owner_changed" => '%s est le nouveau propriétaire du groupe',
	"group_operators:change_owner:error" => 'Seul le propriétaire du groupe peut transférer la propriété',
	"group_operators:removed" => 'Les droits d\'administrateurs ont été retirés',


);

add_translation("fr", $french);
