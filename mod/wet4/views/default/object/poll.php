<?php

/**
 * Elgg poll individual post view
 * 
 * @uses $vars['entity'] Optionally, the poll post to view
 *
 * GC_MODIFICATION
 * Description: Added styling 
 * Author: GCTools Team
 */

if (isset($vars['entity'])) {
	$full = $vars['full_view'];
	$poll = $vars['entity'];
	//$vars['lang'] = 'fr';

	$owner = $poll->getOwnerEntity();
	$container = $poll->getContainerEntity();
	$categories = elgg_view('output/categories', $vars);
		
	$owner_icon = elgg_view_entity_icon($owner, 'medium');
	$owner_link = elgg_view('output/url', array(
				'href' => "polls/owner/$owner->username",
				'text' => $owner->name,
				'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	$tags = elgg_view('output/tags', array('tags' => $poll->tags));
	$date = elgg_view_friendly_time($poll->time_created);

	// TODO: support comments off
	// The "on" status changes for comments, so best to check for !Off
	if ($poll->comments_on != 'Off') {
		$comments_count = $poll->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
						'href' => $poll->getURL() . '#poll-comments',
						'text' => $text,
						'is_trusted' => true,
			));
		} else {
			$comments_link = '';
		}
	} else {
		$comments_link = '';
	}

	// do not show the metadata and controls in widget view
	if (elgg_in_context('widgets')) {
		$metadata = '';
	} else {
		$metadata = elgg_view_menu('entity', array(
					'entity' => $poll,
					'handler' => 'polls',
					'sort_by' => 'priority',
					'class' => 'elgg-menu-hz list-inline',
		));
	}
		
	$subtitle = "$author_text $date $comments_link $categories";
	if ($full) {
		$lang = get_current_language();
		if($poll->title3){
			$title = gc_explode_translation($poll->title3,$lang);
		}else{
			$title = false;
		}
$can_vote = !polls_check_for_previous_vote($poll, $user_guid);
if((polls_get_choice_array2($poll)) && (polls_get_choice_array($poll))) {
	echo'<div id="change_language" class="change_language">';
	if ($can_vote){
		if (get_current_language() == 'fr'){

		?>			
		<span id="indicator_language_en">This content is available in english.<a href="#" onclick="change_language_polls('en','poll-vote-form-container-<?php echo $poll->guid; ?>');" id="activities">Click here to see</a></span>
		<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" >Ce contenu est disponible en français.<a href="#" onclick="change_language_polls('fr','poll-vote-form-container-<?php echo $poll->guid; ?>');" id="activities">Cliquer ici pour voir</a></span>
			<?php	
		}
	}else{
		if (get_current_language() == 'fr'){

		?>			
		<span id="indicator_language_en">This content is available in english.<a href="#" onclick="change_language_polls('en','poll-container-<?php echo $poll->guid; ?>');" id="activities">Click here to see</a></span>
		<?php

		}else{
					
			?>			
			<span id="indicator_language_fr" >Ce contenu est disponible en français.<a href="#" onclick="change_language_polls('fr','poll-container-<?php echo $poll->guid; ?>');" id="activities">Cliquer ici pour voir</a></span>
			<?php	
		}
	}
	
	echo'</div>';
}

		$params = array(
			'entity' => $poll,
			'title' => $title,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags,
		);
		$params = $params + $vars;
		$summary = elgg_view('object/elements/summary', $params);

		echo elgg_view('object/elements/full', array(
			'summary' => $summary,
			'icon' => $owner_icon,
		));
		

		echo elgg_view('polls/body',$vars);



        echo elgg_view('wet4_theme/track_page_entity', array('entity' => $poll));

	} else {
		// brief view
	
	// identify available content
if((polls_get_choice_array2($poll)) && (polls_get_choice_array($poll))) {
		
	echo'<span class="col-md-1 col-md-offset-11"><i class="fa fa-language fa-lg mrgn-rght-sm"></i>' . '<span class="wb-inv">Content available in both language</span></span>';	
}

		$params = array(
			'entity' => $poll,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);
	
		echo elgg_view_image_block($owner_icon, $list_body);
	}
}
?>
<script>
                 	function change_language_polls(lang,guid){
                 		var lang = lang;
                 		var guid = guid;
                 		//alert(lang);
                 		//alert(guid);
                     $("#"+guid).load("gcconnex/mod/polls/views/default/polls/results_for_widget?id="+lang+" #"+guid);
                     if (lang == 'fr'){
                     	change_link_en(guid);
                     }else{
                     	change_link_fr(guid);
                     }

}

function change_link_fr(guid){
	var guid= guid
    var link_available ='<span id="indicator_language_en">Ce contenu est disponible en français.<a href="#" onclick="change_language_polls(\'fr\',\''+guid+'\');" id="activities">Cliquer ici pour voir</a></span>';
    
    $("#change_language").html(link_available)
}
function change_link_en(guid){
	var guid = guid
    var link_available ='<span id="indicator_language_en">This content is available in english.<a href="#" onclick="change_language_polls(\'en\',\''+guid+'\');" id="activities">Click here to see</a></span>';
    
    $("#change_language").html(link_available)
}






</script>

