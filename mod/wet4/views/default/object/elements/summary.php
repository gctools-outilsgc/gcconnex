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
 */

$checkPage = elgg_get_context();

//Checking the context of the summary so I can modify the specific summaries and stuff
//echo $checkPage;

$entity = $vars['entity'];

$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
	if (isset($entity->title)) {
		$text = $entity->title;
	} else {
		$text = $entity->name;
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

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') {
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
}

if ($title_link) {
    echo "<h3 class=\"mrgn-bttm-0 panel-title\">$title_link</h3>";
    echo elgg_in_context($context);
}
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

echo "<div class=\"tags col-sm-12 col-xs-12\">$tags</div>";


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




