<?php
/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 *
 * GC_MODIFICATION
 * Description: testing different contexts to change the layout of summary / language swap elements
 * Author: GCTools Team
 */

$checkPage = elgg_get_context();

//Checking the context of the summary so I can modify the specific summaries and stuff
//echo $checkPage;

$entity = $vars['entity'];
$json_title = json_decode($entity->title);
$lang = get_current_language();
$title_link = gc_explode_translation(elgg_extract('title', $vars, ''), $lang);
if ($title_link === '') {//add translation
	if ( isset($entity->title) || isset($entity->name) ) {
		if( $entity->title ){
			$text = gc_explode_translation( $entity->title, $lang );
		}elseif($entity->name){
			$text = $entity->name;
		}elseif($entity->name2){
			$text = $entity->name2;
		}

	} else {
		$text = gc_explode_translation($entity->title3, $lang);
	}
	if ($entity instanceof ElggEntity) {
		$params = array(
			'text' => elgg_get_excerpt($text, 100),
			'href' => $entity->getURL(),
			'is_trusted' => true,
		);
	}
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');
$lang = get_current_language();

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') {
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
}


if ($title_link) {

    //Nick - putting these titles in headings to make it quicker to navigate for screen readers
    //Nick - each context of the summary view will have a different heading based on it's parent
    if(elgg_in_context('widgets')){
        echo "<div class=\"h4 mrgn-bttm-0 summary-title\">$title_link</div>";
    }else if(elgg_in_context('profile') || elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), "group")){
    	if($entity instanceof ElggEntity && $entity->getSubtype() != 'answer'){//if answer in group question
    		echo "<div class=\"h3 mrgn-bttm-0 summary-title\">$title_link</div>";
    	}
    }else{
		//CL 20220907 - Wraps the activity summary for each activity card in an h3 for smoother 
		//CL 20220907 - screen reader navigation
       echo "<div class=\"h2 mrgn-bttm-0 summary-title\"><h3 class=\"wb-unset\">$title_link</h3></div>";
    }

	// identify available content
$description_json = json_decode($entity->description);
    if (($description_json->en) && ($description_json->fr)) {
	    echo " <span class='indicator_summary' title='".elgg_echo('indicator:summary:title')."'>".elgg_echo('indicator:summary')."</span>"; //indicator translation
	}elseif (elgg_get_context() == 'polls'){
//if poll, check if the choice is the same in both language, if not, show (en/fr) one time

		foreach (polls_get_choice_array($entity) as $key ) {
			$description_json = json_decode($key);
			
 			if ($description_json->en != $description_json->fr) {

	    		echo " <span class='indicator_summary' title='".elgg_echo('indicator:summary:title')."'>".elgg_echo('indicator:summary')."</span>"; //indicator translation for polls
	    		break;
			}
		}   
		
	} elseif ($entity instanceof ElggEntity && $entity->getSubtype() == 'poll'){
//if poll, check if the choice is the same in both language, if not, show (en/fr) one time
		$responses = array();

		$options = array(
				'relationship' => 'poll_choice',
				'relationship_guid' => $entity->guid,
				'inverse_relationship' => TRUE,
				'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC'),
				'limit' => 50,
			);
		$choices = elgg_get_entities_from_relationship($options);

		if ($choices) {
			foreach($choices as $choice) {
				$responses[$choice->text] = $choice->text;
			}
		}
		foreach ($responses as $key ) {
			$description_json = json_decode($key);
	 		if ($description_json->en != $description_json->fr) {

			    echo " <span class='indicator_summary' title='".elgg_echo('indicator:summary:title')."'>".elgg_echo('indicator:summary')."</span>"; //indicator translation for polls
			    break;
			}
		}  
	}
echo elgg_in_context($context);

}

if(elgg_in_context('profile') || elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), "group")){
	if ($entity instanceof ElggUser) {
		$user = $entity;
		$user_type = $user->user_type != "" ? "gcconnex-profile-card:" . $user->user_type : "unknown";
		
		echo '<div class="mvs clearfix"><strong>'.elgg_echo($user_type).'</strong></div>';

		// if user is public servant
		if(strcmp($user->user_type, 'federal') == 0 ) {
		    $deptObj = elgg_get_entities(array(
		        'type' => 'object',
		        'subtype' => 'federal_departments',
		    ));
		    $depts = get_entity($deptObj[0]->guid);

		    $federal_departments = array();
		    if (get_current_language() == 'en'){
		        $federal_departments = json_decode($depts->federal_departments_en, true);
		    } else {
		        $federal_departments = json_decode($depts->federal_departments_fr, true);
		    }

		    echo '<div class="mvs clearfix">' . $federal_departments[$user->federal] . '</div>';

		// otherwise if user is student or academic
		} else if (strcmp($user->user_type, 'student') == 0 || strcmp($user->user_type, 'academic') == 0 ) {
		    $institution = ($user->institution == 'university') ? $user->university : ($user->institution == 'college' ? $user->college : $user->highschool);
		    echo '<div class="mvs clearfix">' . $institution . '</div>';

		// otherwise if user is provincial employee
		} else if (strcmp($user->user_type, 'provincial') == 0 ) {
		    $provObj = elgg_get_entities(array(
		        'type' => 'object',
		        'subtype' => 'provinces',
		    ));
		    $provs = get_entity($provObj[0]->guid);

		    $provinces = array();
		    if (get_current_language() == 'en'){
		        $provinces = json_decode($provs->provinces_en, true);
		    } else {
		        $provinces = json_decode($provs->provinces_fr, true);
		    }

		    $minObj = elgg_get_entities(array(
		        'type' => 'object',
		        'subtype' => 'ministries',
		    ));
		    $mins = get_entity($minObj[0]->guid);

		    $ministries = array();
		    if (get_current_language() == 'en'){
		        $ministries = json_decode($mins->ministries_en, true);
		    } else {
		        $ministries = json_decode($mins->ministries_fr, true);
		    }

		    $provString = $provinces[$user->provincial];
		    if($user->ministry && $user->ministry !== "default_invalid_value"){ $provString .= ' / ' . $ministries[$user->provincial][$user->ministry]; }
		    echo '<div class="mvs clearfix">' . $provString . '</div>';

		// otherwise show basic info
		} else {
		    echo '<div class="mvs clearfix">' . $user->{$user->user_type} . '</div>';
		}
	}
}

//This tests to see if you are looking at a group list and does't outpout the subtitle variable here, It's called at the end of this file
if($entity instanceof ElggEntity && $entity->getType() == 'group'){
   echo '';
}else{
  echo "<div class=\" mrgn-bttm-sm mrgn-tp-sm  timeStamp clearfix\">$subtitle</div>";

}

if($tags){
	echo "<div class=\"tags col-xs-12\">$tags</div>";
}


echo elgg_view('object/summary/extend', $vars);

if ($content) {
	echo "<div class=\"elgg-content mrgn-tp-sm mrgn-lft-sm\">$content</div>";
}

if($entity instanceof ElggEntity && $entity->getType() == 'group' ){

    if ($metadata) {
	   echo '<div class="mrgn-tp-sm"><div class="">' .$metadata . '</div></div>';
}

   echo "<div class=\" mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix\">$subtitle</div>";

}else if($checkPage == 'friends' || $checkPage == 'groups_members' || $checkPage == 'members'){
    echo '<div class=""><div class="">' .$metadata . '</div></div>';
}else{

	if ($entity instanceof ElggEntity && ($entity->getSubtype() == 'event_calendar') && (elgg_get_context() == 'widgets')){

        echo '<div class="row mrgn-tp-md">';

        //echo "<div class=\"tags col-sm-12 col-xs-12\">$tags</div>";


        if ($metadata) {
	        if ($checkPage != 'widgets_calendar'){
                echo '<div class="col-sm-12 col-xs-12"><div class="mrgn-lft-sm">' .$metadata . '</div></div>';
             }
        }

	}else{

	echo '<div class="mrgn-tp-sm">';
	if ($metadata) {
	    if ($checkPage != 'widgets_calendar'){
	        echo '<div class="col-xs-12">' .$metadata . '</div>';
    	}
	}

	echo '</div>';
	}
}
