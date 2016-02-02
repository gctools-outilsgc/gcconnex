<?php
/**
 * WET 4 theme navbar
 * 
 */



?>


<nav role="navigation" id="wb-sm"  data-trgt="mb-pnl" class="wb-menu visible-md visible-lg" typeof="SiteNavigationElement">
		<div class="container nvbar"> <!-- container for screen reader text and list -->
            <h2><?php echo elgg_echo('wet:topicmenu');?>Topics menu</h2>
            <div class="row">
                
                    <?php echo elgg_view_menu('site'); ?>
                
            </div>
        </div>
	</nav>



