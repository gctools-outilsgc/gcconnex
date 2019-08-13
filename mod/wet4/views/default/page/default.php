<?php
/**
 * default.php
 *
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package wet4
 * @author GCTools Team
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
$bootstrap = $site_url . "mod/wet4/views/default/js/bootstrap.min.js";

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$lang = elgg_view('page/elements/chng-lang', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
$site_brand = elgg_view('page/elements/site-brand', $vars);
$tabskip = elgg_view('page/elements/tabskip', $vars);

$breadcrumbs = elgg_view('navigation/breadcrumbs');

//WIP development banner
if(elgg_is_active_plugin('GoC_dev_banner')){
    $alert = elgg_view('banner/dev_banner');
}

$feedbackText = elgg_echo('wet:feedbackText');
$body = <<<__BODY
<div class="elgg-page-messages">
  $messages
</div>
  $tabskip
<div class="elgg-page elgg-page-default">

__BODY;

$userMenu = elgg_view('page/elements/topbar_wrapper', $vars);

if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') === false && strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'solr-crawler') === false) {
	if(elgg_is_active_plugin('freshdesk_help')){
		$feedback_link = elgg_get_site_url().'/help/knowledgebase';
	} else {
		$feedback_link = elgg_get_site_url().'/mod/contactform';
	}

	$feedback_button = "<a href='{$feedback_link}' class='btn btn-primary'><span class='glyphicon glyphicon-comment mrgn-rght-sm'></span>{$feedbackText}</a>";
}

$body .= <<<__BODY
	<header role="banner">
    $alert
  <div id="wb-bnr" class="container">
	</div>
	$site_brand

	$navbar
	$breadcrumbs
	</header>
  <div class="container">
    $userMenu
  </div>
	<main role="main" property="mainContentOfPage" class="container">
		$content
		<div class="row pagedetails">
			<div class="col-xs-12 text-right">
				$feedback_button
			</div>
		</div>
	</main>
	<footer role="contentinfo" id="wb-info" class="visible-sm visible-md visible-lg wb-navcurr">
			$footer
	</footer>
    <script src="$bootstrap"></script>
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
