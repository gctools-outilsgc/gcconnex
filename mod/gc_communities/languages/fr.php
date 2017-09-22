<?php

$french = array(
  'gc_communities:title' => "Titre de la page de la communauté",
  'gc_communities:url' => "URL de la page de la communauté",
  'gc_communities:animator' => "Animateur communautaire",
  'gc_communities:tags' => "Mots-clés de la communautaire",
  'gc_communities:delete' => "Supprimer la page de la communauté",

  'gc_communities:communities' => "Communautés",
  'gc_communities:community_newsfeed' => "Fil de nouvelles communautaire",
  'gc_communities:community_wire' => "Les fils communautaire",

  'gc_communities:filtered_activity_index' => "En bref",
  'gc_communities:filtered_blogs_index' => "Derniers billets dans les blogues",
  'gc_communities:filtered_discussions_index' => "Discussions filtrées",
  'gc_communities:filtered_events_index' => "Prochains évènements",
  'gc_communities:filtered_feed_index' => "Informations filtrées",
  'gc_communities:filtered_groups_index' => "Groupes en vedette",
  'gc_communities:filtered_members_index' => "Membres filtrés",
  'gc_communities:filtered_spotlight_index' => "Galerie d'images",
  'gc_communities:filtered_wire_index' => "Derniers messages sur le fil",

  'gc_communities:enable_widgets' => "Activer les widgets sur les pages de la communauté?",
  'gc_communities:newsfeed_shown' => "Fil de nouvelles affichés :",
  'gc_communities:wires_shown' => "Les fils sont affichés :",
    'gc_communities:showing_content' => 'Showing content tagged with: %s and the "Audience tag" %s',
);

$communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'));
foreach($communities as $community){
  $french['widget_manager:widgets:lightbox:title:gc_communities-' . $community->community_url] = "Ajouter des widgets";
}

return $french;


