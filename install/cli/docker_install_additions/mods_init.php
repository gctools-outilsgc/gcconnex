<?php
/**
 * Mods init module for Docker CLI installer script.
 *
 * @access private
 */


function init_mods_config($solr_host=''){
    init_site_menu();
    init_newsfeed_page_widgets();
    elgg_set_plugin_setting("custom_domain_url", "https://support.gccollab.ca", "freshdesk_help");  // this effectively changes the contact us link in the footer and site menu

    init_file_tools();

    if ($solr_host != '')
        init_elgg_solr($solr_host);
}

function init_site_menu(){
    // this is the order that the menu items will appear in, 0 to 5, for 6 items max in total
    $featured_names = array(0 => "newsfeed", 1 => "Colleagues", 2 => "groups", 3 => "career", 4 => "Help");
    elgg_save_config('site_featured_menu_names', $featured_names);
}

function init_elgg_solr($solr_host){
    if ($solr_host == "")
        return false;
    elgg_set_plugin_setting("host", $solr_host, "elgg_solr");
    elgg_set_plugin_setting("port", "8983", "elgg_solr");
    elgg_set_plugin_setting("solr_path", "/solr/", "elgg_solr");
    elgg_set_plugin_setting("solr_core", "dev", "elgg_solr");
    elgg_set_plugin_setting("show_score", "yes", "elgg_solr");
    elgg_set_plugin_setting("use_solr", "yes", "elgg_solr");
}

function init_file_tools(){
    // this is the list of allowed extentions in prod
    // the setting is empty by default on install and will prevent any file uploads until it's set to something
    $allowed_extensions = "txt, jpg, jpeg, png, bmp, gif, pdf, doc, docx, xls, xlsx, ppt, pptx, odt, ods, odp, accdb, mdb, m4a, mp4, grd, map, rar, gdb, dwg, zip, mp3, ppsx, mid, mov, xlsm, ai, xd, svg, indd, vsd, vsdx, mpp, mppx, potx, dotx, .dotx, sas7bdat, dta, oft";
    elgg_set_plugin_setting("allowed_extensions", $allowed_extensions, "file_tools");
}

function init_newsfeed_page_widgets(){
    // set newsfeed layout to the same one as prod - 2 columns, [Big]-[Medium,Small]
    elgg_set_plugin_setting("ciw_layout", "index_2rbms", "custom_index_widgets");

    // create newsfeed widget instance and put it on the home page
    $newsfeed_widget = new ElggWidget();
    $newsfeed_widget->access_id = 1;
    $newsfeed_widget->handler = "stream_newsfeed_index";
    $newsfeed_widget->context = "custom_index_widgets";
    $newsfeed_widget->audience = "";
    $newsfeed_widget->column = 1;
    $newsfeed_widget->order = 0;
    $newsfeed_widget_guid = $newsfeed_widget->save();

    if (!$newsfeed_widget_guid){
        echo "error setting up newsfeed widget \n";
        return false;
    }

	// elgg refuses to update owner_guid and container_guid any other way in this context, so went with a direct update query
    $db_prefix = elgg_get_config('dbprefix');
    $site_guid = elgg_get_site_entity()->guid;
    update_data("UPDATE {$db_prefix}entities SET owner_guid = {$site_guid}, container_guid = {$site_guid}, enabled = 'yes' where guid = '$newsfeed_widget_guid'");

}

function init_mods( $type ){

    // GCcollab
    $plugins_connex = array(
    'garbagecollector',
    'groups',
    'logrotate',
    'group_tools',
    'blog',
    'bookmarks',
    'dashboard',
    'diagnostics',
    'friend_request',
    'externalpages',
    'file',
    'embed',
    'group_operators',
    'htmlawed',
    'invitefriends',
    'likes',
    'logbrowser',
    'gcforums',
    'messageboard',
    'messages',
    'polls',
    'profile',
    'rename_friends',
    'members',
    'thewire',
    'uservalidationbyemail',
    'unvalidatedemailchange',
    'widget_manager',
    'zaudio',
    'custom_index_widgets',
    'file_tools',
    'event_calendar',
    'ideas',
    'pages',
    'analytics',
    'tidypics',
    'translation_editor',
    'gcProfilePictureBadges',
    'upload_users',
    'c_email_extensions',
    'gcRegistration',
    'c_module_dump',
    'au_subgroups',
    'widget_manager_accessibility',
    'b_extended_profile',
    'c_members_byDepartment',
    'blog_tools',
    'ckeditor',
    'contactform',
    'site_notifications',
    'web_services',
    'missions_organization',
    'missions',
    'data_views',
    'mt_activity_tabs',
    'geds_sync',
    'gc_api',
    'achievement_badges',
    'embed_extender',
    'toggle_language',
    'cp_notifications',
    'login_as',
    'thewire_tools',
    'mentions',
    'GoC_dev_banner',
    'questions',
    'wet4',
    'GC_profileStrength',
    'saml_link',
    'simplesaml',
    'elgg-jsonp',
    'machine_translation',
    'phpmailer',
    'gc_newsfeed',
    'gc_onboard',
    'gc_splash_page',
    'gc_group_layout',
    'gcconnex_theme',
    'gc_streaming_content',
    'multi_file_upload',
    'gccollab_stats',
    'gc_communities',
    'gc_tags',
    'gc_elgg_sitemap',
    );
    $plugins_off_connex = array(
    'developers',
    'oauth_api',
    'reportedcontent',
    'search',
    'tagcloud',
    'tasks',
    'twitter',
    'unvalidated_user_cleanup',
    'twitter_api',
    'sphinx',
    'gc_group_deletion',
    'custom_error_page',
    'maintenance',
    'gc_fedsearch_gsa',
    'gc_official_groups',
    'apiadmin',
    'gc_profile_nudge',
    'enhanced_user_search',
    'GC_profileStrength_collab',
    'b_extended_profile_collab',
    'gcRegistration_collab',
    'gc_onboard_collab',
    'gc_splash_page_collab',
    'gccollab_theme',
    );
    
    
    // GCcollab	
    $plugins_collab = array(
    'garbagecollector',
    'groups',
    'logrotate',
    'group_tools',
    'blog',
    'bookmarks',
    'dashboard',
    'diagnostics',
    'friend_request',
    'externalpages',
    'file',
    'embed',
    'group_operators',
    'htmlawed',
    'invitefriends',
    'likes',
    'logbrowser',
    'messageboard',
    'messages',
    'polls',
    'profile',
    'rename_friends',
    'search',
    'members',
    'thewire',
    'uservalidationbyemail',
    'unvalidatedemailchange',
    'widget_manager',
    'zaudio',
    'custom_index_widgets',
    'file_tools',
    'event_calendar',
    'login_as',
    'ideas',
    'pages',
    'analytics',
    'tidypics',
    'translation_editor',
    'gcProfilePictureBadges',
    'upload_users',
    'c_email_extensions',
    'gcRegistration_collab',
    'c_module_dump',
    'au_subgroups',
    'widget_manager_accessibility',
    'b_extended_profile',
    'b_extended_profile_collab',
    'blog_tools',
    'ckeditor',
    'contactform',
    'site_notifications',
    'web_services',
    'missions_organization',
    'missions',
    'missions_collab',
    'data_views',
    'mt_activity_tabs',
    'gc_api',
    'achievement_badges',
    'embed_extender',
    'toggle_language',
    'cp_notifications',
    'thewire_tools',
    'mentions',
    'GoC_dev_banner',
    'wet4',
    'wet4_collab',
    'GC_profileStrength',
    'GC_profileStrength_collab',
    'elgg-jsonp',
    'phpmailer',
    'gc_onboard',
    'gc_onboard_collab',
    'gc_newsfeed',
    'gc_splash_page',
    'gc_splash_page_collab',
    'gc_group_layout',
    'freshdesk_help',
    'gccollab_stats',
    'gccollab_theme',
    'gc_streaming_content',
    'multi_file_upload',
    'vroom',
    'elgg_solr',
    'elgg_recaptcha',
    'loginrequired',
    'gcRegistration_invitation',
    'gc_autosubscribegroup',
    'apiadmin',
    'gc_mobile_api',
    'gc_communities',
    'gc_tags',
    'gc_elgg_sitemap',
    'thewire_images',
    'merge_users',
    );
    $plugins_off_collab = array(
    'developers',
    'gcforums',
    'oauth_api',
    'reportedcontent',
    'tagcloud',
    'tasks',
    'twitter',
    'unvalidated_user_cleanup',
    'twitter_api',
    'sphinx',
    'gcRegistration',
    'c_members_byDepartment',
    'gc_group_deletion',
    'custom_error_page',
    'geds_sync',
    'etherpad',
    'saml_link',
    'simplesaml',
    'maintenance',
    'machine_translation',
    'gcconnex_theme',
    'gc_fedsearch_gsa',
    'gc_official_groups',
    'linkedin_profile_importer',
    'gc_profile_nudge',
    'questions',
    'enhanced_user_search',
    'plugin_loader',
    'member_selfdelete',
    'gc_lang_url_handler',
    'solr_api',
    'talent_cloud_invite_api',
    'delete_old_notif',
    'paas_integration',
    'pleio',	// enable to test with openid, will need to be configured on the admin side in-app
    );
    

    // deactivate plugins that are not active in prod, order doesn't matter.
    // This happens first to ensure we don't run into conflicts when activating mods in the next step
    $plugins_off = ${"plugins_off_$type"};
    foreach ($plugins_off as $key => $id) {
        $plugin = elgg_get_plugin_from_id($id);

        if (!$plugin) {
            unset($plugins_off[$key]);
            continue;
        }

        if (!$plugin->isActive()){
            unset($plugins_off[$key]);
            continue;
        }

        $plugin->deactivate();
    }


    // activate plugins that are not activated on install, arrange those that are
    $plugins = ${"plugins_$type"};
    foreach ($plugins as $key => $id) {
        $plugin = elgg_get_plugin_from_id($id);

        if (!$plugin) {
            unset($plugins[$key]);
            continue;
        }

        $plugin->setPriority('last');	// move to the end of the list

        if ($plugin->isActive()){
            unset($plugins[$key]);
            continue;
        }

        $plugin->activate();
    }
}
