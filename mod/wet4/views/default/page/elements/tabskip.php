<?php
/*
 * tabskip.php
 * 
 * Creates a list at the top of the page that will allow users who are tabbing through the site to skip to the main content
 * 
 * @package wet4
 * @author GCTools Team
 */

$site_url = elgg_get_site_url();
?>


        <ul class="mrgn-bttm-0">
            <li class="wb-slc">
                <a class="wb-sl" href="#wb-cont"><?php echo elgg_echo('wet:skiptomain');?></a>
            </li>

            <li class="wb-slc visible-sm visible-md visible-lg">
        <a class="wb-sl" href="#wb-info"><?php echo elgg_echo('wet:aboutsite');?></a>
            </li>


        </ul>