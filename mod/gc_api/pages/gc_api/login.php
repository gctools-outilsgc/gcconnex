<?php
/*
 * file name: login.php
 * Author: Troy T. Lawson Troy.Lawson@tbs-sct.gc.ca; lawson.troy@gmail.com,
 * 			based on template produced by Nicholas Pietrantonio
 * 
 * purpose: Alternate login page for use with share button widget.
 */
 //load custom css for share form
elgg_load_css('special-api');

//call minimalist header file
$share_header = elgg_view('page/elements/share_header');

//login form has added context check to show minimalist view of form
$share_form = elgg_view_form('login');

//build body view
$body.= '<div class="share-form-holder">'.$share_header. $share_form.'</div>';
$body .= elgg_view('page/elements/foot');
//build header info
$headparams = array(
    'title' => 'Share',
    );
$head = elgg_view('page/elements/head', $headparams);

$params = array(

	'head' => $head,
	'body' => $body,
);
//Create Page
echo elgg_view("page/elements/html", $params);
?>

<script>
	//remove cometchat from view
	$(document).ready(function () {
		$('#cometchat').empty();
	});
</script>
