<?php
/**
 * Tasks languages (French) 
 *
 * @package ElggTasks
 */

$french = array(

	/**
	 * Menu items and titles
	 */

	'tasks' => "Tâches",
	'tasks:owner' => "Les tâches de %s",
	'tasks:friends' => "les tâches de mes collégues",
	'tasks:all' => "Toutes les tâches du site",
	'tasks:add' => "Ajouter une tâche",

	'tasks:group' => "Tâches de groupe",
	'groups:enabletasks' => 'Activer les tâches de groupe',

	'tasks:edit' => "Modifier cette tâche",
	'tasks:delete' => "Supprimer cette tâche",
	'tasks:history' => "Histoire",
	'tasks:view' => "Afficher la tâche",
	'tasks:revision' => "révision",

	'tasks:navigation' => "Navigation",
	'tasks:via' => "via tâches",
	'item:object:task_top' => 'Les tâches haut-niveau ',
	'item:object:task' => 'Tâches',
	'tasks:nogroup' => "Ce groupe n'a pas encore de des tâches",
	'tasks:more' => 'Plus de tâches',
	'tasks:none' => "Pas de tâches créé pour l'instant",

	/**
	* River
	**/

	'river:create:object:task' => '%s a créé une tâche %s',
	'river:create:object:task_top' => '%s a créé une tâche %s',
	'river:update:object:task' => '%s a mis à jour une tâche %s',
	'river:update:object:task_top' => '%s a mis à jour une tâche %s',
	'river:comment:object:task' => '%s a commenté sur une tâche intitulée %s',
	'river:comment:object:task_top' => '%s a commenté sur une tâche intitulée %s',

	/**
	 * Form fields
	 */

	'tasks:title' => 'titre de la tâche',
	'tasks:description' => 'texte de la tâche',
	'tasks:tags' => 'Mots-clés',
	'tasks:access_id' => 'Accès en lecture',
	'tasks:write_access_id' => 'Accès en écriture',

	/**
	 * Status and error messages
	 */
	'tasks:noaccess' => "Pas d'accès à la tâche",
	'tasks:cantedit' => 'Vous ne pouvez pas éditer cette tâche',
	'tasks:saved' => 'Tâche enregistrée',
	'tasks:notsaved' => "Tâche n'aurait pu être sauvé",
	'tasks:error:no_title' => 'Vous devez spécifier un titre pour cette tâche.',
	'tasks:delete:success' => 'La tâche a été supprimé avec succès.',
	'tasks:delete:failure' => 'La tâche ne peut être supprimé.',

	/**
	 * Task
	 */
	'tasks:strapline' => 'Dernière mise à jour %s de %s',

	/**
	 * History
	 */
	'tasks:revision:subtitle' => 'révision créé %s par %s',

	/**
	 * Widget
	 **/

	'tasks:num' => 'Nombre de tâches à afficher',
	'tasks:widget:description' => "liste de vos tâches.",

	/**
	 * Submenu items
	 */
	'tasks:label:view' => "Afficher tâche",
	'tasks:label:edit' => "Modifier tâche",
	'tasks:label:history' => "Historique de la tâche",

	/**
	 * Sidebar items
	 */
	'tasks:sidebar:this' => "Cette tâche",
	'tasks:sidebar:children' => "sous-tâches",
	'tasks:sidebar:parent' => "parent",

	'tasks:newchild' => "Créer un sous-tâche",
	'tasks:backtoparent' => "retourner à '%s'",
	
	
	
	'tasks:start_date' => "Début",
	 'tasks:end_date' => "Fin",
	 'tasks:percent_done' => " Complété",
	 'tasks:work_remaining' => "Reste.",
	 

	 'tasks:task_type' => 'Type',
	 'tasks:status' => 'Statut',
	 'tasks:assigned_to' => 'Travailleur',
	 
	 'tasks:task_type_'=>"",
	 'tasks:task_type_0'=>"",
	 'tasks:task_type_1'=>"Analyse",
	 'tasks:task_type_2'=>"Spécifications",
	 'tasks:task_type_3'=>"Développement",
	 'tasks:task_type_4'=>"Test",
	 'tasks:task_type_5'=>"Mise en production",
	 
	 'tasks:task_status_'=>"",
	 'tasks:task_status_0'=>"",
	 'tasks:task_status_1'=>"ouvert",
	 'tasks:task_status_2'=>"assigné",
	 'tasks:task_status_3'=>"chargé",
	 'tasks:task_status_4'=>"en cours",
	 'tasks:task_status_5'=>"fermé",
	 
	 'tasks:task_percent_done_'=>"0%",
	 'tasks:task_percent_done_0'=>"0%",
	 'tasks:task_percent_done_1'=>"20%",
	 'tasks:task_percent_done_2'=>"40%",
	 'tasks:task_percent_done_3'=>"60%",
	 'tasks:task_percent_done_4'=>"80%",
	 'tasks:task_percent_done_5'=>"100%",
	 
	 'tasks:tasksboard'=>"TasksBoard",
	 'tasks:tasksmanage'=>"Gérer",
	 'tasks:tasksmanageone'=>"Gérer une tâche",
);

add_translation("fr", $french);