<?php
/*
* GC-Elgg Read Only Mode 
*
* Read only mode for gcconnex
*
* @author Adi github.com/AdiMakkar
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'read_only_mode');

function read_only_mode(){
    elgg_register_event_handler('pagesetup', 'system', 'remove_add_buttons');
}

function remove_add_buttons(){
    $remove_contexts = ['blog', 'discussion', 'bookmarks', 'pages', 'groups'];
    if (in_array(elgg_get_context(), $remove_contexts)) {
        elgg_unregister_menu_item('title', 'add');
    }
}

    $site_url = elgg_get_site_url();
    echo "<div class='panel panel-default'>";
    echo "<div class='panel-body'>";
    echo "<div class='col-md-4'><img src='" . $site_url . "mod/wet4/graphics/gcx_deer_in_snow.png' alt='" . elgg_echo('readonly:message') . "'/></div>";
    echo "<div class='col-md-8'>";
    echo "<div class='mrgn-lft-lg'>";
    echo "<div class='mrgn-bttm-md h3 mrgn-tp-0'>" . elgg_echo('readonly:message') . "</div>";
    echo "<div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:1') . "</div>";
    echo "<div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:2') . "</div>";
    echo "<div>" . elgg_echo('readonly:message:3') . "</div>";
    echo "</div>";
    echo "</div></div>";
    echo "</div>";
}
