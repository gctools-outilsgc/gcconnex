<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	_elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032

$site_url = elgg_get_site_url();
$jsLocation = $site_url . "mod/wet4/views/default/js/wet-boew.js";

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));


$lang = elgg_view('page/elements/chng-lang', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
//$acion
$topcanbar = elgg_view('page/elements/topcanbar', $vars);
$wavyblue = elgg_view('page/elements/wavyblue', $vars);
$site_brand = elgg_view('page/elements/site-brand', $vars);
$tabskip = elgg_view('page/elements/tabskip', $vars);

$breadcrumbs = elgg_view('navigation/breadcrumbs');

//get version of wet4 theme
$wet4plugin = elgg_get_plugin_from_id('wet4');
$version = elgg_echo('admin:plugins:label:version') . ': ' . $wet4plugin->getManifest()->getVersion();

//WIP development banner
if(elgg_is_active_plugin('GoC_dev_banner')){
    $alert = elgg_view('banner/dev_banner');
}

$body = <<<__BODY
    $tabskip
<div class="elgg-page elgg-page-default">
	
__BODY;

//$body .= elgg_view('page/elements/topbar_wrapper', $vars);

$userMenu = elgg_view('page/elements/topbar_wrapper', $vars);

$body .= <<<__BODY
	<header class="" role="banner">
    $alert
    <div class="elgg-inner">
			$lang
		</div>
    	<div id="wb-bnr">
            $wavyblue
            $site_brand
	   </div>   
    
		
        
        
        <nav role="navigation" id="wb-sm"  data-trgt="mb-pnl" class="wb-menu visible-md visible-lg" typeof="SiteNavigationElement">
    
            <div class="container nvbar">

                <div class="row">
                   $navbar
                </div>
            </div>

        </nav>
        
        $breadcrumbs
        
	</header>
	
    
    
	<main role="main" property="mainContentOfPage" class="container">
		<div class="elgg-page-messages">
		$messages
	   </div>
        <div class="elgg-inner">
            $userMenu
        
			$content
		</div>
        
        <p class="mrgn-bttm-md">$version</p>
        
	</main>
    
    
    
	<footer role="contentinfo" id="wb-info" class="visible-sm visible-md visible-lg wb-navcurr">
		
			$footer
		
	</footer>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src=" $jsLocation "></script>
    
    
</div>
__BODY;

    

$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);
