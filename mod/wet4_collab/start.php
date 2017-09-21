<?php
/**
 * WET 4 Collab Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init', 'system', 'wet4_collab_theme_init');

function wet4_collab_theme_init() {

	// theme specific CSS
	elgg_extend_view('css/elgg', 'wet4_theme/css');
	elgg_extend_view('css/elgg', 'wet4_theme/custom_css');

	//message preview
    elgg_register_ajax_view("messages/message_preview");
	
	elgg_register_plugin_hook_handler('register', 'menu:user_menu', 'remove_custom_colleagues_menu_item', 1);
	elgg_register_event_handler('pagesetup', 'system', 'add_custom_colleagues_menu_item', 1000);

    elgg_unregister_plugin_hook_handler('usersettings:save', 'user', '_elgg_set_user_email');
    elgg_register_plugin_hook_handler('usersettings:save', 'user', 'change_user_email');

    elgg_define_js('moment', [
        'src' => '/mod/wet4_collab/views/default/js/moment/moment.js',
        'deps' => array('jquery')
    ]);

    elgg_unregister_js('elgg.full_calendar');
    $calendar_js = elgg_get_simplecache_url('js', 'event_calendar/fullcalendar.min.js');
    elgg_register_simplecache_view('js/event_calendar/fullcalendar.min.js');
    elgg_register_js('elgg.full_calendar', $calendar_js);

    $calendar_css = elgg_get_simplecache_url('css', 'event_calendar/fullcalendar.min.css');
    elgg_register_css('elgg.full_calendar', $calendar_css);
}

function remove_custom_colleagues_menu_item($hook, $type, $return, $params) {
    // Remove Colleagues menu item
    foreach($return as $key => $item) {
        if ($item->getName() == 'Colleagues') {
            unset($return[$key]);
        }
    }
    return $return;
}

function add_custom_colleagues_menu_item() {
	$user = elgg_get_logged_in_user_entity();

    if( !empty($user) ){
		$options = array(
			"type" => "user",
			"count" => true,
			"relationship" => "friendrequest",
			"relationship_guid" => $user->getGUID(),
			"inverse_relationship" => true
		);

		$count = elgg_get_entities_from_relationship($options);

		$countTitle = " - ";
		$countBadge = "";
		if( $count > 0 ){
            //display 9+ instead of huge numbers in notif badge
            if( $count >= 10 ){
                $countTitle .= '9+';
            } else {
				$countTitle .= $count;
            }

           $countBadge = "<span class='notif-badge'>" . $count . "</span>";
        }

	    $params = array(
			"name" => "Colleaguess",
			"href" => "friends/" . $user->username,
			"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i>' . $countBadge,
			"title" => elgg_echo('userMenu:colleagues') . $countTitle . elgg_echo('friend_request') .'(s)',
	        "class" => '',
	        "item_class" => '',
			"priority" => '1'
		);

		elgg_register_menu_item("user_menu", $params);
	}
}

function change_user_email() {
	$email = get_input('email');
	$user_guid = get_input('guid');

	if ($user_guid) {
		$user = get_user($user_guid);
	} else {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!is_email_address($email)) {
		register_error(elgg_echo('email:save:fail'));
		return false;
	}

    elgg_load_library('c_ext_lib');
    $isValid = false;

    if ($email) {
        // cyu - check if the email is in the list of exceptions
        $user_email = explode('@',$email);
        $list_of_domains = getExtension();

        if( elgg_is_active_plugin('c_email_extensions') ){
            // Checks against the domain manager list...
            $wildcard_query = "SELECT ext FROM email_extensions WHERE ext LIKE '%*%'";
            $wildcard_emails = get_data($wildcard_query);
            
            if( $wildcard_emails ){
                foreach($wildcard_emails as $wildcard){
                    $regex = str_replace(".", "\.", $wildcard->ext);
                    $regex = str_replace("*", "[\w-.]+", $regex);
                    $regex = "/^@" . $regex . "$/";
                    if(preg_match($regex, "@".$user_email[1]) || strtolower(str_replace("*.", "", $wildcard->ext)) == strtolower($user_email[1])){
                        $isValid = true;
                        break;
                    }
                }
            }
        }

        if( elgg_is_active_plugin('gcRegistration_invitation') ){
            // Checks against the email invitation list...
            $invitation_query = "SELECT email FROM email_invitations WHERE email = '{$email}'";
            $result = get_data($invitation_query);

            if( count($result) > 0 ) 
                $isValid = true;
        }

        if (count($list_of_domains) > 0) {
            while ($row = mysqli_fetch_array($list_of_domains)) {
                if (strtolower($row['ext']) === strtolower($user_email[1])) {
                    $isValid = true;
                    break;
                }
            }
            $error_message = elgg_echo('gcc_profile:error').elgg_echo('gcc_profile:notaccepted');
        }

        // cyu - check if domain is gc.ca
        if (!$isValid) {
            $govt_domain = explode('.',$user_email[1]);
            $govt_domain_len = count($govt_domain) - 1;

            if ($govt_domain[$govt_domain_len - 1].'.'.$govt_domain[$govt_domain_len] === 'gc.ca') {
                $isValid = true;
            } else {
                $isValid = false;
                $error_message = elgg_echo('gcc_profile:error').elgg_echo('gcc_profile:notaccepted');
            }
        }
    }

    if( !$isValid ){
    	if( elgg_is_active_plugin('b_extended_profile_collab') ){
        	prepare_email_change($user_guid, $email);
    	} else {
    		register_error($error_message);
    	}
    } else {
        if ($user) {
			if (strcmp($email, $user->email) != 0) {
				if (!get_user_by_email($email)) {
					if ($user->email != $email) {

						$user->email = $email;
						if ($user->save()) {
							system_message(elgg_echo('email:save:success'));
							return true;
						} else {
							register_error(elgg_echo('email:save:fail'));
						}
					}
				} else {
					register_error(elgg_echo('registration:dupeemail'));
				}
			}
		} else {
			register_error(elgg_echo('email:save:fail'));
		}
    }

    return false;
}