<?php
//If the user isn't logged in then display some additional links in the footer to register

$site_url = elgg_get_site_url();
?>

			<ul id="gc-tctr" class="list-inline">
	           <li><a  href="<?php echo $site_url; ?>register">Register</a></li>
	           <li><a href="<?php echo $site_url; ?>login">Login</a></li>
            </ul>