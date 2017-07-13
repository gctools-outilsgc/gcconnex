<?php

$site_url = elgg_get_site_url();
$jsLocation = $site_url . "mod/wet4/views/default/js/wet-boew.js";
$bootstrap = $site_url . "mod/wet4/views/default/js/bootstrap.min.js";

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$content = elgg_view('page/elements/body', $vars);




$body .= <<<__BODY
	<div class="elgg-page-messages">
    $messages
	</div>
	<main role="main" property="mainContentOfPage">

			$content

	</main>

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
