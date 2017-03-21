<?php
/**
 * head.php
 *
 * The HTML head
 * 
 * JavaScript load sequence (set in views library and this view)
 * ------------------------
 * 1. Elgg's initialization which is inline because it can change on every page load.
 * 2. RequireJS config. Must be loaded before RequireJS is loaded.
 * 3. RequireJS
 * 4. jQuery
 * 5. jQuery migrate
 * 6. jQueryUI
 * 7. elgg.js
 *
 * @uses $vars['title'] The page title
 * @uses $vars['metas'] Array of meta elements
 * @uses $vars['links'] Array of links
 *
 * @package wet4
 * @author GCTools Team
 *
 * GC_MODIFICATION
 * Description: Added IE9 check that will load the wet IE9 JS
 * Author: Nick P github.com/piet0024
 */
 
$site_url = elgg_get_site_url();

$metas = elgg_extract('metas', $vars, array());
$links = elgg_extract('links', $vars, array());

//Load in global variable with entity to create metadata tags
global $my_page_entity;


// github-685 gcconnex titles in gsa search result
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {
  
  $gc_language = get_current_language();

  $page_title_deliminator = ($my_page_entity->title && $my_page_entity->title2) ? " | " : "";

  // check if this is a profile
  if ($my_page_entity->title == null || $my_page_entity->title === '') {
    $page_title = $my_page_entity->name;
  } else {
    $page_title = $my_page_entity->title;
  }



  /*  
  $title_en = $my_page_entity->title;
  $title_fr = $my_page_entity->title2;
 
  // group profile
  if ($title_en || $title_fr) {
    $page_title_deliminator = ($my_page_entity->name && $my_page_entity->name2) ? " | " : "";
   
    $title_fr = $my_page_entity->name2;
  }

  // check for character length then trim
  if ($page_title_deliminator !== "") {
    $title_en = (strlen($title_en) > 19) ? substr($title_en,0,20)."..." : $title_en;
    $title_fr = (strlen($title_fr) > 19) ? substr($title_fr,0,20)."..." : $title_fr;
  }
  $page_title = (strcmp(get_current_language(),'en') == 0) ? $title_en.$page_title_deliminator.$title_fr : $title_fr.$page_title_deliminator.$title_en;
  

  // profile <titles></title>
  if (!$page_title)
    $page_title = $my_page_entity->name;
  */

  echo elgg_format_element('title', array(), $page_title, array('encode_text' => true));

} else {
  
  echo elgg_format_element('title', array(), $vars['title'], array('encode_text' => true));

}



foreach ($metas as $attributes) {
	echo elgg_format_element('meta', $attributes);
}
foreach ($links as $attributes) {
	echo elgg_format_element('link', $attributes);
}

$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();
$elgg_init = elgg_view('js/initialize_elgg');

$html5shiv_url = elgg_normalize_url('vendors/html5shiv.js');
$ie_url = elgg_get_simplecache_url('css', 'ie');

?>

	<!--[if lt IE 9]>
		<script src="<?php echo $html5shiv_url; ?>"></script>
	<![endif]-->

<?php

foreach ($css as $url) {
	echo elgg_format_element('link', array('rel' => 'stylesheet', 'href' => $url));
}

?>
	<!--[if gt IE 8]>
		<link rel="stylesheet" href="<?php echo $ie_url; ?>" />
	<![endif]-->

	<script><?php echo $elgg_init; ?></script>
<?php
foreach ($js as $url) {
    
    if (strpos($url,'jquery-1.11.0.min.js') !== false) {
        //$url = 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js';
    }
    
    if (strpos($url,'require-2.1.10.min.js') !== false) {
        //$url= str_replace($url,'require-2.1.10.min.js','require-2.1.20.min.js');
    }
    
	echo elgg_format_element('script', array('src' => $url));
}

echo elgg_view_deprecated('page/elements/shortcut_icon', array(), "Use the 'head', 'page' plugin hook.", 1.9);

echo elgg_view_deprecated('metatags', array(), "Use the 'head', 'page' plugin hook.", 1.8);




/*---------------------Web Experience Toolkit 4---------------------*/

?>

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="<?php echo $site_url ?>mod/wet4/views/default/css/awesome/font-awesome.min.css" type="text/css" />
    <meta charset="utf-8" />
		<!-- Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html -->


		<meta content="width=device-width, initial-scale=1" name="viewport" />
<!-- Meta data -->
<?php 


      if($my_page_entity){
          /*
          echo elgg_get_excerpt($my_page_entity->title) . '<br>';
          echo  date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_created)) . '<br>';
          echo  date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_updated));
          */

          if(elgg_instanceof($my_page_entity, 'group')){
              $desc = elgg_strip_tags(elgg_get_excerpt($my_page_entity->description));
              $briefdesc = $my_page_entity->briefdescription;
          } else if(elgg_instanceof($my_page_entity, 'user')) {
              $desc = elgg_echo('profile:title', array($my_page_entity->name));
              $briefdesc = elgg_echo('profile:title', array($my_page_entity->name));
          } else {
              $desc = $my_page_entity->title;
              $briefdesc = $my_page_entity->title;
          }

          $pubDate = date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_created));
          $lastModDate = date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_updated));

          $datemeta = '<meta name="dcterms.issued" title="W3CDTF" content="' . $pubDate . '"/>';
          $datemeta .= '<meta name="dcterms.modified" title="W3CDTF" content="' . $lastModDate . '" />';
      } else {
          $desc = $vars['title'];
          $briefdesc = $vars['title'];
      }

      $creator =  elgg_get_page_owner_entity()->name;
      if(!$creator){
          $creator = 'GCconnex';
      }


		// cyu - prevent crawler to index unsaved draft
		if ($my_page_entity instanceof ElggObject) {
			if ($my_page_entity->getSubtype() === 'blog' && strcmp($my_page_entity->status,'unsaved_draft') == 0)
				echo '<meta name="robots" content="noindex">';
		}

          $no_index_array = array(
            'activity','activity/all','/activity/owner','/activity/friends/','/activity_tabs/mydept','/activity_tabs/otherdept',
            'blog/all','blog/owner/','/blog/group/','/blog/friends/',
            'bookmarks/all','bookmarks/owner/','/bookmarks/friends/','/bookmarks/group/',
            'event_calendar/list',
            'file/all','/file/owner/','/file/friends/',
            'photos/all','photos/owner','photos/friends/',
            'members','/members/popular/','/members/online','/members/department',
            'polls/all','/polls/owner/','/polls/friends/',
            'groups/all','/groups/owner/','/groups/invitation',
            'photos/siteimagesowner/',
            'thewire/all','/thewire/owner/','/thewire/friends/',
            'file_tools/list', '/newsfeed/',
          ); 

          $can_index = true;
          foreach ($no_index_array as $partial_url) {
            // if url is found, dont index
            if (strpos($_SERVER['REQUEST_URI'],$partial_url) !== false ) {
              $can_index = false;
              break;
            }
          }

          if (!$can_index) {
?>

          <!-- cyu - included header meta tags for GSA (limiting pages to index) -->
          <meta name="robots" content="noindex">

        <?php } ?>

        <meta name="description" content="<?php echo $desc; ?>" />
        <meta name="dcterms.title" content="<?php echo $vars['title']; ?>" />
        <meta name="dcterms.creator" content="<?php echo $creator; ?>" />
        <?php echo $datemeta; ?>
        <meta name="dcterms.subject" title="scheme" content="<?php echo $briefdesc; ?>" />
        <meta name="dcterms.language" title="ISO639-2" content="<?php echo get_language(); ?>" />
        <meta name="gcctitle" content="<?php echo $vars['title']; ?>" />
        <link href="<?php echo $site_url; ?>mod/wet4/graphics/favicon.ico" rel="icon" type="image/x-icon" />
<!-- Meta data-->

<!--[if lt IE 9]>

        <script src="<?php echo $site_url ?>mod/wet4/views/default/js/ie8-wet-boew.min.js"></script>
        <![endif]-->
<!--[if lte IE 9]>


<![endif]-->

        <noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>

