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
 * Modified by Christine Yu (July 14 2017)
 */

$site_url = elgg_get_site_url();

$metas = elgg_extract('metas', $vars, array());
$links = elgg_extract('links', $vars, array());



// Load in global variable with entity to create metadata tags
global $my_page_entity;

// in case the title is not populated (this typically comes in the format of -  GCconnex content title : GCconnex)
$page_title = $vars['title'];
$gc_language = get_current_language();
$elgg_entity = $my_page_entity;


if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false) {
  // check if this is a (user or group) profile
  if ($elgg_entity instanceof ElggUser || $elgg_entity instanceof ElggGroup) {

    // check if this is a user or a group (TODO: displays the title twice if either language is not present)
    $page_title = ($elgg_entity instanceof ElggUser) ? $elgg_entity->name : gc_explode_translation($elgg_entity->name, 'en').' / '.gc_explode_translation($elgg_entity->name, 'fr');

  } else { 

    $page_title = gc_explode_translation($elgg_entity->title, 'en').' / '.gc_explode_translation($elgg_entity->title, 'fr');
    // if there is no title (meaning only a slash is present) because there is no way to retrieve the entity
    if (trim($page_title) === '/') {
      $current_url = explode('/', $_SERVER['REQUEST_URI']);
      $page_entity = get_entity($current_url[count($current_url) - 1]);
    
      // if the entity is still not found
      if (!($page_entity instanceof ElggEntity))
        $page_entity = get_entity($current_url[count($current_url) - 2]);

      $page_title = (gc_explode_translation($page_entity->title, 'en') !== gc_explode_translation($page_entity->title, 'fr')) 
        ? gc_explode_translation($page_entity->title, 'en').' / '.gc_explode_translation($page_entity->title, 'fr') 
        : gc_explode_translation($page_entity->title, 'en');
    }

  }

} else {

  $current_url = explode('/', $_SERVER['REQUEST_URI']);
  $page_entity = get_entity($current_url[count($current_url) - 1]);

  if ($elgg_entity instanceof ElggUser || $elgg_entity instanceof ElggGroup) {
    $page_title = ($elgg_entity instanceof ElggUser) ? $vars['title'] : gc_explode_translation($elgg_entity->name, $gc_language) . " : {$vars['title']}";
  } else {

      if (!($page_entity instanceof ElggEntity))
        $page_entity = get_entity($current_url[count($current_url) - 2]);
      // wire post does not have any title!
      $page_title = gc_explode_translation($page_entity->title, $gc_language);
  }

}

// if no title is found, place the default title as the page title
$page_title = (!$page_title) ? $vars['title'] : $page_title;

// this populates the title tag
echo elgg_format_element('title', array(), $page_title, array('encode_text' => true));


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

<!--[if gt IE 8]>
	<link rel="stylesheet" href="<?php echo $ie_url; ?>" />
<![endif]-->

<script><?php echo $elgg_init; ?></script>

<?php

foreach ($css as $url) {
  echo elgg_format_element('link', array('rel' => 'stylesheet', 'href' => $url));
}

foreach ($js as $url) {
	echo elgg_format_element('script', array('src' => $url));
}

echo elgg_view_deprecated('page/elements/shortcut_icon', array(), "Use the 'head', 'page' plugin hook.", 1.9);
echo elgg_view_deprecated('metatags', array(), "Use the 'head', 'page' plugin hook.", 1.8);


/*--------------------- Web Experience Toolkit 4 ---------------------*/

?>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->

<!-- Web Experience Toolkit (WET) / Boîte à outils de l'expérience Web (BOEW)
wet-boew.github.io/wet-boew/License-en.html / wet-boew.github.io/wet-boew/Licence-fr.html -->
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<link rel="stylesheet" href="<?php echo $site_url ?>mod/wet4/views/default/css/awesome/font-awesome.min.css" type="text/css" />

<!-- Meta data -->
<?php


if ($my_page_entity) {

  if (elgg_instanceof($my_page_entity, 'group')) {
      $desc = elgg_strip_tags(elgg_get_excerpt(gc_explode_translation($my_page_entity->description,get_current_language())));
      $briefdesc = gc_explode_translation($my_page_entity->briefdescription,get_current_language());
  } else if (elgg_instanceof($my_page_entity, 'user')) {
      $desc = elgg_echo('profile:title', array(gc_explode_translation($my_page_entity->name,get_current_language())));
      $briefdesc = elgg_echo('profile:title', array(gc_explode_translation($my_page_entity->name,get_current_language())));
  } else {
      $desc = gc_explode_translation($my_page_entity->title,get_current_language());
      $briefdesc = gc_explode_translation($my_page_entity->title,get_current_language());
  }

  $pubDate = date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_created));
  $lastModDate = date ("Y-m-d", elgg_get_excerpt($my_page_entity->time_updated));

  $datemeta = '<meta name="dcterms.issued" title="W3CDTF" content="' . $pubDate . '"/>';
  $datemeta .= '<meta name="dcterms.modified" title="W3CDTF" content="' . $lastModDate . '" />';

} else {

  $desc = $vars['title'];
  $briefdesc = $vars['title'];

}

$creator = gc_explode_translation(elgg_get_page_owner_entity()->name, get_current_language());
if (!$creator) $creator = 'GCconnex';


// cyu - prevent crawler to index unsaved draft
if ($my_page_entity instanceof ElggObject) {
  if ($my_page_entity->getSubtype() === 'blog' && strcmp($my_page_entity->status,'unsaved_draft') == 0)
  	echo '<meta name="robots" content="noindex, follow">';
}

// determine whether to index page depending on the url
$no_index_array = array(
  'activity/','activity/all','activity/owner','activity/friends','activity_tabs/mydept','activity_tabs/otherdept',
  'blog/all','blog/owner/','blog/group','blog/friends',
  'bookmarks/all','bookmarks/owner','bookmarks/friends','bookmarks/group',
  'event_calendar/list',
  'file/all','file/owner','file/friends', 'file/group',
  'photos/all','photos/owner','photos/friends',
  'members','members/popular','/members/online','members/department',
  'polls/all','polls/owner','polls/friends/',
  'groups/all','groups/owner','groups/invitation',
  'photos/siteimagesowner', 'photos/siteimagesall',
  'thewire/all','thewire/owner','thewire/friends',
  'file_tools/list', 'newsfeed/', 'groups/', 'discussion/owner', 'ideas/group', 'photos/group', 'pages/all', 'missions/main',
  'pages/history', 'splash/', '/mod', 'login/', 'file/all'
);

/// replace the slashes (maybe use regex instead) then remove the base url and then put the slashes in before comparison 
$base_site_url = str_replace('/', ' ', elgg_get_site_entity()->getURL());
$current_url = str_replace('/', ' ', ((isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"));
$current_url = str_replace($base_site_url, '', $current_url);
$current_url = str_replace(' ', '/', $current_url);
$current_url = explode("?", $current_url);
$current_url = $current_url[0];
$current_url = explode("/", $current_url);
$current_url = "{$current_url[0]}/{$current_url[1]}";


// if url is found, dont index
$can_index = (in_array($current_url, $no_index_array)) ? false : true;
if (!$can_index) {
  echo '<meta name="robots" content="noindex, follow">';
}


if (get_input('language') != 'en' || get_input('language') != 'fr') {
  echo '<meta name="robots" content="noindex, follow">';
}
// TODO closed group - noindex


// group profile url with the group name - noindex will be displayed if group is only accessible to group members
preg_match("/groups\/profile\/[\d]*\/.*\/?/", $_SERVER['REQUEST_URI'], $output_array);
if (sizeof($output_array) > 0) {
  if ($my_page_entity instanceof ElggGroup && $my_page_entity->getContentAccessMode() !== "unrestricted") {
    echo '<meta name="robots" content="noindex, follow">';
  }
} else {
  // if user profile url has a slash at the end, do not index
  preg_match("/\/profile\/.*\//", $_SERVER['REQUEST_URI'], $output_array);
  if (sizeof($output_array) > 0)
    echo '<meta name="robots" content="noindex, follow">';
}


// the wire posts do not have any title, we'll have the page title as the wire post
if ($page_entity instanceof ElggEntity && $page_entity->getSubtype() === 'thewire') {
  $page_title = elgg_echo('thewire:head:title', 'en').' / '.elgg_echo('thewire:head:title', 'fr');
}

// Meta tags for the page
$page_entity_type = "";
if ($my_page_entity instanceof ElggEntity)
  $page_entity_type = $my_page_entity->getSubtype();
if ($my_page_entity instanceof ElggUser) $page_entity_type = "user";
if ($my_page_entity instanceof ElggGroup) $page_entity_type = "group";

// condition for pages
if ($page_entity_type == 'page_top' || $page_entity_type == 'page') {
  $page_entity_type = 'pages';
}

// Meta tags for the page
?>

<?php if ($my_page_entity instanceof ElggEntity) { ?>
<meta name="platform" content="gcconnex" />
<meta name="dcterms.type" content= "<?php echo $page_entity_type; ?>" />
<meta name="dcterms.modified" content="<?php echo date("Y-m-d", $my_page_entity->time_updated); ?>" />
<meta name="dcterms.description" content="<?php echo strip_tags(gc_explode_translation($my_page_entity->description, 'en')) . strip_tags(gc_explode_translation($my_page_entity->description, 'fr')); ?>" /> 
<?php } ?>

<meta name="description" content="<?php echo $desc; ?>" />
<meta name="dcterms.title" content="<?php echo $page_title ?>" />
<meta name="dcterms.creator" content="<?php echo $creator; ?>" />
<?php echo $datemeta; ?>
<meta name="dcterms.subject" title="scheme" content="<?php echo $briefdesc; ?>" />
<meta name="dcterms.language" title="ISO639-2" content="<?php echo get_language(); ?>" />
<link href="<?php echo $site_url; ?>mod/wet4/graphics/favicon.ico" rel="icon" type="image/x-icon" />


<?php // hide the ajax toggle (hide the div)
if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false) { ?>
  <style>
    .change_language {
      display:none;
    } 
  </style>
<?php } ?>

<!-- Meta data-->
<!--[if lt IE 9]>
  <script src="<?php echo $site_url ?>mod/wet4/views/default/js/ie8-wet-boew.min.js"></script>
  <![endif]-->
<!--[if lte IE 9]>
<![endif]-->

<noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>
