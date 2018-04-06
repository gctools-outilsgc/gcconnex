<?php

$site_url = elgg_get_site_url();
$french = array(

	'gcforums:notfound' => "page non trouvée",

	'river:create:object:hjforumtopic' => "%s a créé un nouveau suget de forum %s",
	'gcforums:edit:new_forum:heading' => "Nouveau %s",
	'gcforums:edit:edit_forum:heading' => "Modifiez %s",

	'gcforums:user:name' => "Nom (utilisateur) : ",
	'gcforums:user:email' => "Courriel : ",
	'gcforums:user:posting' => "Posting : ",

	'gcforums:delete:success' => "'%s' a été supprimé avec succès",
	'gcforums:delete:nosuccess' => "'%s' n'a pas pu être supprimé",
	'gcforums:saved:success' => "'%s' a été enregistré avec succès",

	'gcforums:translate:subscribe' => "S'abonner",
	'gcforums:translate:unsubscribe' => "Se désabonner",

	'gcforums:translate:hjforumcategory' => "La catégorie",
	'gcforums:translate:hjforum' => "Le forum",
	'gcforums:translate:hjforumtopic' => "Les sujets",
	'gcforums:translate:hjforumpost' => "Les publications",

	'gcforums:translate:edit' => "Modifier",
	'gcforums:translate:delete' => "Supprimer",
	'gcforums:translate:new_topic' => "Le sujet du nouveau forum",
	'gcforums:translate:new_subforum' => "Nouveau forum",
	'gcforums:translate:new_subcategory' => "Nouvelle catégorie",

	'gcforums:label:title' => "Titre",

	'gcforum:heading:default_title' => "Forum du groupe",

	"gcforums:translate:topics" => "les sujets",
	"gcforums:translate:forums" => "le forum",
	"gcforums:translate:posts" => "les sujets",
	"gcforums:translate:latest" => "récent",

	"gcforums:translate:topic_starter" => "Auteur",
	"gcforums:translate:replies" => "Réponses",
	"gcforums:translate:last_posted" => "Dernière publication",


	"gcforums:translate:total_topics" => "Nombre total des sujets",
	"gcforums:translate:total_replies" => "Nombre des messages",
	"gcforums:translate:latest_posts" => "Derniers messages",


	'gcforums:delete:heading' => "Confirmation de suppression ",
	'gcforums:delete:body' => "Êtes-vous certain de vouloir supprimer le %s",
	'gcforums:delete:cancel' => "Annuler",
	'gcforums:delete:delete' => "Supprimer",

	"gcforums:is_sticky" => "Sujet délicat",
	"gcforums:forumpost_saved" => "Votre réponse a été créée avec succès",
	"gcforums:forumtopic_saved" => "Votre sujet de forum '%s' a été créé avec succès",
	"gcforums:forumcategory_saved" => "La catégorie de forum a été créée avec succès",
	"gcforums:forum_saved" => "Le forum a été créé avec succès",
	"gcforums:forumpost_failed" => "Votre réponse n'a pas été créée avec succès",
	"gcforums:forumtopic_failed" => "Votre sujet de forum '%s' n'a pas été créé avec succès",
	"gcforums:forum_failed" => "Le forum n'a pas été créé avec succès",
	"gcforums:gobacktomain" => "Revenir à forum principal",
	"gcforums:categories_requred" => "S'il vous plaît créer des catégories avant de créer un nouveau forum",

	"gcforums:group_forum_title" => "Forum du groupe",
	"gcforums:forum_edit" => "Modifier le forum",
	"gcforums:forum_delete" => "Supprimer le forum",
	"gcforums:forum_title" => "Forum",
	"gcforums:group_nav_label" => "Les forums du groupe",
	"gcforums:posted_on" => "Afficher le : %s",
	"gcforums:edit" => "Modifier",
	"gcforums:delete" => "Effacer",
	"gcforums:create" => "Créer",
	"gcforums:submit" => "Soumettre",
	"gcforums:topics" => "Les sujets",
	"gcforums:forums" => "Les forums",
	"gcforums:posts" => "Les publications",
	"gcforums:latest" => "Récent",
	"gcforums:topic_starter" => "[tbt] Sujet de départ",
	"gcforums:replies" => "Réponses",
	"gcforums:last_posted" => "Dernière publication",

	// this was a mistake, (posting is inverse)

	"gcforums:enable_posting_label" => "Désactiver l'affichage",
	"gcforums:title_label_hjforumcategory" => "Nom de la catégorie",
	"gcforums:title_label_hjforum" => "Nom du forum",
	"gcforums:title_label_hjforumtopic" => "Nom du sujet",
	"gcforums:new_hjforumcategory" => "Nouvelle catégorie",
	"gcforums:description" => "Description",
	"gcforums:topic_reply" => "Réponse",
	"gcforums:access_label" => "Accessibilité/visibilité",
	"gcforums:enable_categories_label" => "Activer les sous-catégories",
	"gcforums:file_under_category_label" => "Classer sous <em> Catégorie</em>",
	"gcforums:new_hjforum" => "Nouveau forum",
	"gcforums:new_hjforumtopic" => "Le sujet du nouveau forum",
	"gcforums:new_hjforumcategory" => "Nouvelle catégorie",
	"gcforums:edit_hjforum" => "Modifier le forum",
	"gcforums:delete_hjforumtopic" => "Effacer le forum",
	"gcforums:total_topics" => "Nombre total des sujets",
	"gcforums:total_posts" => "Nombre des messages",
	"gcforums:latest_posts" => "Derniers messages",
	"gcforums:no_posts" => "Aucun",
	"gcforums:sticky_topic" => "Sujets délicats",
	"gcforums:forums_not_available" => "<i> Actuellement aucun forum de disponible</i> ",
	"gcforums:topics_not_available" => "<i> Actuellement aucun sujet disponible</i> ",
	"gcforums:no_comments" => "<i> Aucun commentaire n'a encore été fait ... Soyez le premier!</i> ",
	"gcforums:categories_not_available" => "<i> Actuellement aucune catégorie disponibles</i> ",
	"gcforums:jmp_menu" => "Carrefour de carrière",
	"gcforums:jmp_url" => $site_url . "groups/profile/7617072",
	"gcforums:notification_subject_topic" => "Nouveau sujet",
	"gcforums:notification_body_topic" => "[tbt] %s a créé un nouveau sujet dans le forum '%s' avec l'information suivante... <br/> %s <br/> Vous pouvez consultez le contenu ici : %s <br/>",
	"gcforums:notification_subject_post" => "Nouvelle publication sur le forum",
	"gcforums:notification_body_post" => "[tbt] %s a répondu dans le forum '%s' avec l'information suivante... <br/> %s <br/> Vous pouvez consultez le contenu ici : %s <br/>",
	'gcforums:time' => 'en fonction',

	//edit page

	'gforums:title_label' => "Nom du forum",
	'gforums:description_label' => "Description",
	'gcforums:save_button' => "Sauvegarder",

	'gcforums:subscribe' => 'S\'abonner',
	'gcforums:unsubscribe' => 'Se désabonner',

	'gcforums:missing_description' => 'Missing Description', // NEW
);

add_translation("fr", $french);
