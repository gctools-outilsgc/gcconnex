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

function decommission_message() {

    echo "<div class='panel panel-default'>
            <div class='panel-body'>
            <div class='col-md-4'>
                <img src='" . $site_url . "/mod/gcconnex_read_only/graphics/GCConnex_Decom_Final_Banner.png' alt='" . elgg_echo('readonly:message') . "' />
            </div>
            <div class='col-md-8'>
            <div class='mrgn-lft-lg'>
                <div class='mrgn-bttm-md h3 mrgn-tp-0'>" . elgg_echo('readonly:message') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:1') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:2') . "</div>
                <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:3') . "</div>
                <div>" . elgg_echo('readonly:message:4') . "</div>
            </div>
        </div>
    </div>
</div>";
}

