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
    // GCConnex change - Ilia: For Issue #24 (https://github.com/tbs-sct/gcconnex/issues/24) move to the right to coincide with log out link location
    $content_right .= $login_dropdown;
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

<div style="width:940px;">
	
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
<div style="position:relative; top:0px; width:940px; background-color:#333; height:27px;">

<div style="vertical-align:top; position:absolute; left:0px;"><img src='$site_url/_graphics/sig-eng-bg.gif' alt='Government of Canada | Gouvenrement du Canada' title='Government of Canada | Gouvenrement du Canada' /></div>

<div style="vertical-align:top;padding-top: 5px; position:absolute; right:0px; color:white;"><b><a href='http://gcpedia.gc.ca' style='color:white;'>GCpedia</a> |  <strong style="font-size:110%;">GCconnex</strong>  |  <a href='http://www.gcforums.gc.ca/' style='color:white;'>GCforums</a></b></div>

</div>
HTML;



echo $fip;

echo $output;


