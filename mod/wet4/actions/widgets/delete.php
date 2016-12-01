<?php
/**
 * Elgg widget delete action
 *
 * @package Elgg.Core
 * @subpackage Widgets.Management
 */
 /*
 * GC_MODIFICATION
 * Description: makes sure the user is forwarded to the proper page after removing widget
 * Author: 
 */
$owner = elgg_get_logged_in_user_entity()->username;
$widget = get_entity(get_input('widget_guid'));
if ($widget) {
	$layout_owner_guid = $widget->getContainerGUID();
	elgg_set_page_owner_guid($layout_owner_guid);
	if (elgg_can_edit_widget_layout($widget->context) && $widget->delete()) {
        $context = get_input('context');
        if(elgg_instanceof(get_entity($context), 'group')){
            forward(REFERER);
        } else {
            $url = elgg_get_site_url();
            forward($url . 'profile/'.$owner.'?pg=splashboard');
        }
	}
}

register_error(elgg_echo('widgets:remove:failure'));
forward(REFERER);
