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
$lang = get_current_language();
$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {//add translation
	if (isset($entity->title) || isset($entity->name)|| isset($entity->title3)) {
		if($entity->title3){
			$text = gc_explode_translation($entity->title3, $lang);
		}elseif($entity->title2){
			$text = $entity->title2;
		}elseif($entity->title){
			$text = $entity->title;
		}elseif($entity->name){
			$text = $entity->name;
		}elseif($entity->name2){
			$text = $entity->name2;
		}

	} else {
		$text = gc_explode_translation($entity->title3, $lang);
	}

	$params = array(
		'text' => elgg_get_excerpt($text, 100),
		'href' => $entity->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');
$lang = get_current_language();

/*if($entity->excerpt3){
	
	$entity->excerpt = gc_explode_translation($entity->excerpt3, $lang);
	}
*/

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') {
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
}

if ((!$title_link)&& ($entity->title && $entity->title2)){
	if($entity->title1){
		$entity->title3 = gc_implode_translation($entity->title1,$entity->title2);
	}else{
		$entity->title3 = gc_implode_translation($entity->title,$entity->title2);
	}
$title_link = gc_explode_translation($entity->title3, $lang);
}

if ($title_link) {
    echo "<span class=\"mrgn-bttm-0 summary-title\">$title_link</span>"; //put in span because some links would not take classes
    echo elgg_in_context($context);
}/*else{
        echo "<span class=\"mrgn-bttm-0 summary-title\">$entity->title</span>"; //put in span because some links would not take classes
    echo elgg_in_context($context);
}*/
//This tests to see if you are looking at a group list and does't outpout the subtitle variable here, It's called at the end of this file
if($entity->getType() == 'group'){
   echo '';
}else{
  echo "<div class=\" mrgn-bttm-sm mrgn-tp-sm  timeStamp clearfix\">$subtitle</div>";

}

echo "<div class=\"tags col-xs-12\">$tags</div>";


echo elgg_view('object/summary/extend', $vars);

if ($content) {
	echo "<div class=\"elgg-content mrgn-tp-sm mrgn-lft-sm\">$content</div>";
}

if($entity->getType() == 'group' ){

    if ($metadata) {
	   echo '<div class="mrgn-tp-sm"><div class="">' .$metadata . '</div></div>';
}
    
   echo "<div class=\" mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix\">$subtitle</div>"; 
    
}else if($checkPage == 'friends' || $checkPage == 'groups_members' || $checkPage == 'members'){
    echo '<div class=""><div class="">' .$metadata . '</div></div>';
}else{

	if (($entity->getSubtype() == 'event_calendar') && (elgg_get_context() == 'widgets')){

        echo '<div class="row mrgn-tp-md">';

        //echo "<div class=\"tags col-sm-12 col-xs-12\">$tags</div>";


        if ($metadata) {
	        if ($checkPage != 'widgets_calendar'){
                echo '<div class="col-sm-12 col-xs-12"><div class="mrgn-lft-sm">' .$metadata . '</div></div>';   
             }
        }

	}else{

	echo '<div class="row mrgn-tp-sm">';
	if ($metadata) {
	    if ($checkPage != 'widgets_calendar'){
	        echo '<div class="col-xs-12 mrgn-lft-md ">' .$metadata . '</div>';
    	}
	}

	echo '</div>';  
	}
}