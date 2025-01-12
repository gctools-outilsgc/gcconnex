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
    
}

function decommission_message(){
    echo "<div class='panel panel-default'>";
    echo "<div class='panel-body'>";
    echo "<div class='col-md-4'><img src='".$site_url."/mod/wet4/graphics/GCconnex_Decom_Final_Banner.png' alt='".elgg_echo('readonly:message')."' /></div>";
    echo "<div class='col-md-8'>";
    echo "<div class='mrgn-lft-lg'>";
    echo "<div class='mrgn-bttm-md h3 mrgn-tp-0'>". elgg_echo('readonly:message') ."</div>";
    echo "<div class='mrgn-bttm-md'>". elgg_echo('readonly:message:1') ."</div>";
    echo "<div class='mrgn-bttm-md'>". elgg_echo('readonly:message:2') ."</div>";
    echo "<div class='mrgn-bttm-md'>". elgg_echo('readonly:message:3') ."</div>";
    echo "<div>". elgg_echo('readonly:message:4') ."</div>";
    echo "</div>";
    echo "</div></div>";
    echo "</div>";
}
