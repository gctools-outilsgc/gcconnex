<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

elgg_register_event_handler('init', 'system', missions_organization_init);

function missions_organization_init() {
    elgg_register_page_handler('missions_organization', 'missions_organization_page_handler');
    
    elgg_register_library('elgg:missions-organization', elgg_get_plugins_path() . 'missions_organization/lib/missions-organization.php');
    elgg_load_library('elgg:missions-organization');
    
    elgg_register_action("missions_organization/upload-form", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/upload-form.php");
    elgg_register_action("missions_organization/delete-all", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/delete-all.php");
    elgg_register_action("missions_organization/change-values-form", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/change-values-form.php");
    elgg_register_action("missions_organization/add-node-form", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/add-node-form.php");
    elgg_register_action("missions_organization/merge-node-form", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/merge-node-form.php");
    elgg_register_action("missions_organization/change-parent-form", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/change-parent-form.php");
    elgg_register_action("missions_organization/set-session-node-guid", elgg_get_plugins_path() . "missions_organization/actions/missions_organization/set-session-node-guid.php");
    
    if(elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {     
        $item = new ElggMenuItem('upload_organization', elgg_echo('missions:organization:upload_organization'), 'missions_organization/upload');
        elgg_register_menu_item('mission_main', $item);
    }    
        
    elgg_register_entity_type('object', 'orgnode');
    
    //Hook which sets the url for orgnode entities upon creation.
    elgg_register_plugin_hook_handler('entity:url', 'object', 'orgnode_set_url');
    
    elgg_register_ajax_view('missions_organization/org-dropdown');
    
    elgg_register_menu_item('page', array(
    		'name' => 'organization_tree',
    		'href' => elgg_get_site_url() . 'admin/missions_organization/main',
    		'text' => elgg_echo('missions_organization:organization'),
    		'section' => 'administer'
    ));
}

function missions_organization_page_handler($segments) {
    switch($segments[0]) {
        case 'view':
            include elgg_get_plugins_path() . 'missions_organization/pages/missions_organization/node-view.php';
            break;
    }
}

function orgnode_set_url($hook, $type, $returnvalue, $params) {
	$entity = $params['entity'];
	if(elgg_instanceof($entity, 'object', 'orgnode')) {
		return 'missions_organization/view/' . $entity->guid;
	}
}