<?php

elgg_register_event_handler('init', 'system', 'b_extended_profile_collab_init');

function b_extended_profile_collab_init() {
    // Register the endorsements js library
    $url = 'mod/b_extended_profile_collab/js/endorsements/';
    // js file containing code for edit, save, cancel toggles and the events that they trigger, plus more
    elgg_register_js('gcconnex-profile', $url . "gcconnex-profile.js");

	// register the action for saving profile fields
	$action_path = elgg_get_plugins_path() . 'b_extended_profile_collab/actions/b_extended_profile/';
	elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');

	// The new views used for the Opt-In section.
    elgg_register_ajax_view('b_extended_profile/opt-in');
    elgg_register_ajax_view('b_extended_profile/edit_opt-in');

    // Register the gcconnex profile css libraries
    $css_url = 'mod/b_extended_profile_collab/css/gcconnex-profile.css';
    elgg_register_css('gcconnex-css', $css_url);

    elgg_register_page_handler('email_change_confirmation', 'email_change_confirmation');
}

function email_change_confirmation($page) {
    include elgg_get_plugins_path() . 'b_extended_profile_collab/pages/confirm.php';
}

/**
 * Generate a validation code to change an email address
 *
 * @param ElggUser $user  the user who's email address will be changed
 * @param string   $email the new email address
 *
 * @return string|false the validation code or false
 */
function generate_email_code(ElggUser $user, $email) {
    if (!($user instanceof ElggUser)) {
        return false;
    }
    
    if (empty($email) && !is_email_address($email)) {
        return false;
    }
    
    $site_secret = get_site_secret();

    return hash_hmac('sha256', ($user->getGUID() . '|' . $email . '|' . $user->time_created), $site_secret);
}

/**
 * Checks if a user wants to change his email address and sends out a confirmation message
 *
 * @return void
 */
function prepare_email_change($user_guid, $email) {
    $user = get_user($user_guid);
    
    if (empty($user) || !is_email_address($email)) {
        register_error(elgg_echo('email:save:fail'));
        return;
    }
    
    if (strcmp($email, $user->email) === 0) {
        // no change is email address
        return;
    }
        
    if (get_user_by_email($email)) {
        register_error(elgg_echo('registration:dupeemail'));
        return;
    }
    
    // generate validation code
    $validation_code = generate_email_code($user, $email);
    if (empty($validation_code)) {
        return;
    }
    $site = elgg_get_site_entity();
    $current_email = $user->email;
    
    // make sure notification goes to new email
    $user->email = $email;
    $user->save();
    
    // build notification
    $validation_url = elgg_normalize_url(elgg_http_add_url_query_elements('email_change_confirmation', array(
        'u' => $user->getGUID(),
        'c' => $validation_code,
    )));
    
    $subject = elgg_echo('email_change_confirmation:request:subject', array($site->name), 'en') . " | " . elgg_echo('email_change_confirmation:request:subject', array($site->name), 'fr');
    $message = elgg_echo('email_change_confirmation:request:message', array(
        $user->name,
        $site->name,
        $validation_url,
    ));

    if( elgg_is_active_plugin('cp_notifications') ){
        $message = elgg_view('cp_notifications/site_template', array("cp_msg_title_en" => $subject, "cp_msg_title_fr" => elgg_echo('email_change_confirmation:request:subject', array($site->name), 'fr'), "cp_msg_description_en" => $message, "cp_msg_description_fr" => elgg_echo('email_change_confirmation:request:message', array($user->name, $site->name, $validation_url), 'fr')));
    }

    if( elgg_is_active_plugin('phpmailer') ){
        phpmailer_send($user->email, $user->name, $subject, $message);
    } else {
        mail($user->email, $subject, $message, cp_get_headers());
    }

    // save the validation request
    // but first revoke previous request
    $user->deleteAnnotations('email_change_confirmation');
    
    $user->annotate('email_change_confirmation', $email, ACCESS_PRIVATE, $user->getGUID());
    
    // restore current email address
    $user->email = $current_email;
    $user->save();
    
    system_message(elgg_echo('email_change_confirmation:request', array($email)));
}
