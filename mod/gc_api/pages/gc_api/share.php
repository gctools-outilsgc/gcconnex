<?php
/*
 * Filename: share.php
 * Author: Troy T. Lawson (Troy.Lawson@tbs-sct.gc.ca; lawson.troy@gmail.com)
 * 			based on template produced by Nicholas Pietrantonio
 * 
 * Purpose: Page used to build custom share button form view. Helps control user flow through process.
 * 			due to an issue involving get parameters being passed through through saml login process, 
 * 			it was decided that data would be encoded in a JSON string inorder to be passed back and forth.
 */
 
 //get data about page to be shared. Passed via GET encoded as JSON string
 $data = json_decode($_GET['data']); //GET and decode into php object
 
//get language passed from script (english default)
 $lang = $data->lang;
if ($lang == ''){
	$lang = 'en';
}
//set language cookie and reload page so proper language is displayed.
if ($_COOKIE["connex_lang"]!=$lang){
	$SESSION['language'] = $lang;
	setcookie("connex_lang", $lang, 0, '/');
	echo '<script>window.location.reload();</script>';
}
//in order to ensure user is redirected to the proper page after login, we manually set session variable 
//'last_forward_from' to proper url with url GET parameters intact
$session = elgg_get_session();

$session->set('last_forward_from', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
//if not logged in forward to custom login page
 if (!elgg_is_logged_in()){
 	forward('/share_bookmarks/login');
 }
 
 //if being redirected back from successfull save action, close the window
if (isset($_GET['close'])){
	echo '<script>window.close();</script>';
}
//load custom css for share form 
 elgg_load_css('special-api');
 
//custom minimalist header
$share_header = elgg_view('page/elements/share_header');

//custom share from 
$share_form = elgg_view_form('gc_api/sharer');

//build body view
$body.= '<div class="share-form-holder">'.$share_header. $share_form.'</div>';
$body .= elgg_view('page/elements/foot');

//build header
$headparams = array(
    'title' => 'Share',
    );
$head = elgg_view('page/elements/head', $headparams);

//Create Page
$params = array(

	'head' => $head,
	'body' => $body,
);
echo elgg_view("page/elements/html", $params);
?>
<script>
	//remove cometchat from window
	$(document).ready(function () {
		$('#cometchat').empty();
	});
</script>







