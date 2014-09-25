<?php
/**
 * Elgg topbar
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();

$content       = "";
$content_left  = "";
$content_right = "";



// BRAND NAME
$brand_name = <<<HTML
<a class="brand" href="$site_url">$site->name</a>
HTML;

// TOPBAR NAVIGATION
$topbar_menu = elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

//$content .= $brand_name;
$content .= $topbar_menu;

#$content_left .= $gclogo;
#$content_right .= $gclinks;


// LOGIN DROPDOWN
if (!elgg_is_logged_in()) {
    // drop-down login
    $login_dropdown =  elgg_view('core/account/login_dropdown');
    
    // add it to the left
    $content_left .= $login_dropdown;
}
/*
// LOGIN TEXT
if (elgg_is_logged_in()) {
    // "logged in as [username]"
    $username = elgg_get_logged_in_user_entity()->name;
    $url = elgg_get_logged_in_user_entity()->getURL();
    
    $login_text = "<p class=\"navbar-text\">" . elgg_echo('admin:loggedin', array("<a href=\"$url\">$username</a>")) . "</p>";
    
    // add it to the right
    $content_right .= $login_text;
}
*/
$output = <<<HTML

<!--variable width topbar with a minimum-->
<div style="min-width:940px; width: 95%;">
	
    <div class="pull-left"  >
		
			$content_left
		
    </div>


    $content
    <div class="pull-right">
        $content_right
	</div>
	<!--This adds the GCconnex maple leaf in the center of the page-->
	<div style="width:150px; margin-left:275px; margin-right:auto; margin-top:-6px;"><a href="$site_url" class="brand"><img src="$site_url/mod/gc_glee_theme/graphics/flag.gif" alt='GCconnex' title='GCconnex' /></img></a>	</div>

</div>
HTML;

#gc changes, tamara, lines 65-75
$fip = <<<HTML
<div style="position:relative; top:0px; min-width:940px; width:94%; background-color:#333; height:27px;">

<div style="vertical-align:top; position:absolute; left:0px;"><img src='$site_url/_graphics/sig-eng-bg.gif' alt='Government of Canada | Gouvenrement du Canada' title='Government of Canada | Gouvenrement du Canada' /></div>

<div style="vertical-align:top;padding-top: 5px; position:absolute; right:0px;"><b><a href='http://gcpedia.gc.ca' style='color:white;'>GCpedia</a> |  <a href='http://elgg.srv.gc.ca/elgg/' style='color:white;'>GCconnex</a>  |  <a href='http://www.gcforums.gc.ca/' style='color:white;'>GCforums</a></b></div>

</div>
HTML;



echo $fip;

echo $output;


