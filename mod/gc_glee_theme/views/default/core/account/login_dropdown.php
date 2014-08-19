<?php
/**
 * Elgg drop-down login form
 */

if (elgg_is_logged_in()) {
	return true;
}

$site_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$site_url = str_replace("http:", "https:", $site_url);
}

$title = elgg_echo('login');
$login_form = elgg_view_form('login', array(
	'action' => "{$site_url}action/login",
	'class' => 'navbar-form',
));

$login_url = elgg_normalize_url('login');

// echo <<<HTML
//     <div id="login-dropdown" class="btn-group">
//         <a class="btn btn-primary btn-large login_link" href="$login_url">$title</a>
//         <a class="btn btn-primary btn-large dropdown-toggle" data-toggle="dropdown" href="#">
//         <span class="caret"></span>
//         </a>
//         <ul class="dropdown-menu">
//        		<li>$login_form</li>
//         </ul>
//     </div>
// HTML;

echo <<<HTML
<ul class="nav pull-left">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">$title<b class="caret"></b></a>
        <ul class="dropdown-menu">
        	<li>$login_form</li>
        </ul>
    </li>
</ul>
HTML;
 
