<?php
/**
 * sidebar.php
 * 
 * Elgg sidebar contents
 *
 * @uses $vars['sidebar'] Optional content that is displayed at the bottom of sidebar
 *
 * GC_MODIFICATION
 * Description: Removed the owners block and extras menu that normally appears on elgg sites
 */

// optional 'sidebar' parameter
    if (isset($vars['sidebar'])) {
	   echo $vars['sidebar'];
    }

// @todo deprecated so remove in Elgg 2.0
// optional second parameter of elgg_view_layout
    if (isset($vars['area2'])) {
	   echo $vars['area2'];
    }

// @todo deprecated so remove in Elgg 2.0
// optional third parameter of elgg_view_layout
    if (isset($vars['area3'])) {
	   echo $vars['area3'];
    }   
