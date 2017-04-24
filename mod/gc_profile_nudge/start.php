<?php
/*
 * Profile Nudge start.php
 */

elgg_register_event_handler('init', 'system', 'gc_profile_nudge_init');

function gc_profile_nudge_init(){
    elgg_register_ajax_view('gc_profile_nudge/profile_nudge');

    if( elgg_is_logged_in() ){

    	$reminder_time = elgg_get_plugin_setting('reminder_time', 'gc_profile_nudge');
    	$in_days = $reminder_time * 86400; // 1 day = 86400 seconds

    	$user = elgg_get_logged_in_user_entity();
		
		// If user hasn't seen nudge, use their last login date as benchmark
		if( !isset( $user->last_profile_nudge ) ){
			$user->last_profile_nudge = $user->prev_last_login;
			$user->save();
		}

    	$last_profile_nudge = $user->last_profile_nudge;

    	// Show nudge if user hasn't seen in XX days
	    if( (time() - $last_profile_nudge) > $in_days ){
	    	elgg_extend_view('page/elements/foot', 'gc_profile_nudge/include');
	    }
	}
}
