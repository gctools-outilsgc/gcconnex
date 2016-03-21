<?php
    /*
     *  This file was created as a work around to remove unwanted menu items in user settings
     */

//remove group notifications tab
elgg_unregister_menu_item('page', '2_group_notify');
elgg_unregister_menu_item('page', '1_plugins');

?>