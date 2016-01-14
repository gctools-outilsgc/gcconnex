<?php
/**
 * Author: Bryden Arndt
 * Date: 11/5/14
 * Time: 3:45 PM
 * Purpose: initializes the b_extended_profile plugin.
 *
 * Notes: See views/default/profile/wrapper.php for information on adding a new section to the user profile
 */
elgg_register_event_handler('init', 'system', 'b_extended_profile_init');

function b_extended_profile_init() {
    // Register the endorsements js library
    $url = 'mod/b_extended_profile/js/endorsements/';
    elgg_register_js('gcconnex-profile', $url . "gcconnex-profile.js"); // js file containing code for edit, save, cancel toggles and the events that they trigger, plus more

    // Register vendor js libraries
    $url = 'mod/b_extended_profile/vendors/';
 //   elgg_register_js('typeahead', $url . 'typeahead/dist/typeahead.bundle.js'); // developer version typeahead js file !!! COMMENT THIS OuT AND ENABLE MINIFIED VERSIoN IN PRODcd
    elgg_register_js('fancybox', 'vendors/jquery/fancybox/jquery.fancybox-1.3.4.pack.js');
    elgg_register_js('typeahead', $url . 'typeahead/dist/typeahead.bundle.min.js'); // minified typeahead js file
//    elgg_register_js('bootstrap-tour', $url . 'bootstrap-tour/build/js/bootstrap-tour.js');

    // Register the gcconnex profile css libraries
    $css_url = 'mod/b_extended_profile/css/gcconnex-profile.css';
    elgg_register_css('gcconnex-css', $css_url);
 //   elgg_register_css('font-awesome', 'mod/b_extended_profile/vendors/font-awesome/css/font-awesome.min.css'); // font-awesome icons used for social media and some profile fields
//    elgg_register_css('bootstrap-tour-css', 'mod/b_extended_profile/vendors/bootstrap-tour/build/css/bootstrap-tour.css');
    // register views

    // register ajax views for all profile sections that are allowed to be edited and displayed via ajax

    // display views
    // see views/default/profile/wrapper.php for information on adding a new section to the user profile
    elgg_register_ajax_view('b_extended_profile/about-me');
    elgg_register_ajax_view('b_extended_profile/education');
    elgg_register_ajax_view('b_extended_profile/work-experience');
    elgg_register_ajax_view('b_extended_profile/endorsements');
    elgg_register_ajax_view('b_extended_profile/languages');
    elgg_register_ajax_view('b_extended_profile/portfolio');

    // edit views
    elgg_register_ajax_view('b_extended_profile/edit_about-me');
    elgg_register_ajax_view('b_extended_profile/edit_education');
    elgg_register_ajax_view('b_extended_profile/edit_work-experience');
    elgg_register_ajax_view('b_extended_profile/edit_languages');
    elgg_register_ajax_view('b_extended_profile/edit_portfolio');

    // endorsement lightbox
    elgg_register_ajax_view('endorse/endorsement');

    // input views
    elgg_register_ajax_view('input/education');
    elgg_register_ajax_view('input/work-experience');
    elgg_register_ajax_view('input/languages');
    elgg_register_ajax_view('input/portfolio');

    // auto-complete
    // elgg_register_ajax_view('input/autoskill');
    elgg_register_ajax_view('b_extended_profile/edit_basic'); // ajax view for editing the basic profile fields like name, title, department, email, etc.

    // register the action for saving profile fields
    $action_path = elgg_get_plugins_path() . 'b_extended_profile/actions/b_extended_profile/';
    elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');
    elgg_register_action('b_extended_profile/add_endorsement', $action_path . 'add_endorsement.php');
    elgg_register_action('b_extended_profile/retract_endorsement', $action_path . 'retract_endorsement.php');
    elgg_register_action('b_extended_profile/user_find', $action_path . 'userfind.php', "public");

    //elgg_register_plugin_hook_handler('cron', 'hourly', 'userfind_updatelist');
    elgg_register_page_handler('userfind', 'userfind_page_handler');

    //elgg_unregister_page_handler('profile', 'profile_page_handler');
    elgg_register_page_handler('profile', 'extended_profile_page_handler');
}

/*
 * Purpose:
*/

function extended_profile_page_handler($page) {

    if (isset($page[0])) {
        $username = $page[0];
        $user = get_user_by_username($username);
        elgg_set_page_owner_guid($user->guid);
    } elseif (elgg_is_logged_in()) {
        forward(elgg_get_logged_in_user_entity()->getURL());
    }

    // short circuit if invalid or banned username
    if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
        register_error(elgg_echo('profile:notfound'));
        forward();
    }

    $action = NULL;
    if (isset($page[1])) {
        $action = $page[1];
    }

    if ($action == 'edit') {
        // use the core profile edit page
        $base_dir = elgg_get_root_path();
        require "{$base_dir}pages/profile/edit.php";
        return true;
    }

    // main profile page
    $params = array(
        'content' => elgg_view('profile/wrapper'),
        'num_columns' => 3,
    );
    $content = elgg_view_layout('profile_widgets', $params);
    $sidebar = elgg_view('profile/sidebar', array('entity' => $user));

    $body = elgg_view_layout('one_sidebar', array('content' => $content, 'sidebar' => $sidebar,));
    echo elgg_view_page($user->name, $body);
    return true;
}

/*
 * Purpose: Created edit/save/cancel buttons for ajax blocks on profile
 */
function init_ajax_block($title, $section, $user) {

    echo '<div class="panel panel-custom">';
        echo '<div class="panel-heading profile-heading clearfix"><h3 class="profile-info-head pull-left clearfix">' . $title . '</h3>'; // create the profile section title
    
    if ($user->canEdit()) {
        // create the edit/save/cancel toggles for this section
        echo '<span class="gcconnex-profile-edit-controls">';
        echo '<button title="Edit ' . $section . '" class="btn btn-default edit-' . $section . '"><i class="fa fa-pencil"></i> ' . elgg_echo('gcconnex_profile:edit') . '</button>';
//        echo '<span class="save-control save-' . $section . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">' . elgg_echo('gcconnex_profile:save') . '</span>';
        echo '<button title="Cancel ' . $section . '"  class="btn btn-default cancel-control cancel-' . $section . ' hidden wb-invisible"><i class="fa fa-ban"></i> ' . elgg_echo('gcconnex_profile:cancel') . '</button>';
        echo '</span>';
    }
    echo '</div>';
    echo '<div id="edit-' . $section . '" class="gcconnex-profile-section-wrapper panel-body gcconnex-' . $section . '">'; // create the profile section wrapper div for css styling


    
}

function finit_ajax_block($section) {
    echo '</div>';
    echo '<div class="panel-footer clearfix save-' . $section . ' hidden wb-invisible"><button title="Save ' . $section . '" class="btn btn-primary gcconnex-profile-edit-controls save-control save-' . $section . ' hidden wb-invisible"><i class="fa fa-floppy-o"></i> ' . elgg_echo('gcconnex_profile:save') . '</button></div>';
    echo '</div>';
}


/*
 * Purpose: return a list of usernames for user-suggest
 */
function userfind_page_handler() {
    //$user_friends = elgg_get_entities_from_relationship(array('guid' => elgg_get_logged_in_user_guid()));

    $user_friends = get_user_friends(elgg_get_logged_in_user_guid(), null, 0);
    $query = htmlspecialchars($_GET['query']);
    $result = array();

    foreach ($user_friends as $u) {

        // Complete match for first name
        if (strpos(strtolower(' ' . $u['name']) . ' ', ' ' . strtolower($query) . ' ') === 0 ) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false)),
                'pos' => 0
            );
            //error_log('Result: ' . var_dump($result));
        }

        // Complete match for name (first, middle or last)
        elseif (strpos(strtolower(' ' . $u['name']) . ' ', ' ' . strtolower($query) . ' ') !== FALSE) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false)),
                'pos' => 1
            );
            //error_log('Result: ' . var_dump($result));
        }

        // Partial match beginning at start of first name
        elseif (strpos(strtolower(' ' . $u['name']), ' ' . strtolower($query)) === 0 ) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false)),
                'pos' => 2
            );
            //error_log('Result: ' . var_dump($result));
        }

        // Partial match beginning at start of some name (middle, last)
        elseif (strpos(strtolower(' ' . $u['name']), ' ' . strtolower($query)) !== FALSE) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false)),
                'pos' => 3
            );
            //error_log('Result: ' . var_dump($result));
        }

        // Partial match somewhere within some name
        elseif (strpos(strtolower($u['name']), strtolower($query)) !== FALSE) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false)),
                'pos' => 4
            );
            //error_log('Result: ' . var_dump($result));
        }
    }

    $highest_relevance = array();
    $high_relevance = array();
    $med_relevance = array();
    $low_relevance = array();
    $lowest_relevance = array();

    foreach ( $result as $r ) {
        if ( $r['pos'] == 0 ) {
            $highest_relevance[] = $r;
        }
        elseif ( $r['pos'] == 1 ) {
            $high_relevance[] = $r;
        }
        elseif ( $r['pos'] == 2 ) {
            $med_relevance[] = $r;
        }
        elseif ( $r['pos'] == 3 ) {
            $low_relevance[] = $r;
        }
        elseif ( $r['pos'] == 4 ) {
            $lowest_relevance[] = $r;
        }
    }

    $result = array_merge($highest_relevance, $high_relevance, $med_relevance, $low_relevance, $lowest_relevance);

    //error_log(print_r('Result: ' . $result, true));
    //error_log(print_r($med_relevance, true));
    echo json_encode($result);
    return json_encode($result);
}

/*
 * Purpose: check if a profile section has content, so that we know whether or not we should prepare ajax for display
 */
function has_content($user, $section) {
    if ( $user->$section != null ) {
        return true;
    }
    else {
        if ( $user->canEdit() ) {
            return true;
        }
        else {
            return false;
        }
    }
}

/*
 * Purpose: To list colleagues' avatars
 * Paramaters:
 * $guids = array of guids of avatars to be listed
 * $size = tiny, small, medium, large, etc.
 * $limit = max number of avatars to display
 * $class = css class for wrapper div
 */

function list_avatars($options) {

    $list = "";
    $list .= '<div class="list-avatars' . $options['class'] . '">';

    if ( $options['limit'] == 0 ) {
        $options['limit'] = 999;
    }
    else {

        $link = elgg_view('output/url', array(
            'href' => 'ajax/view/b_extended_profile/edit_basic',
            'class' => 'elgg-lightbox gcconnex-basic-profile-edit elgg-button',
            'text' => elgg_echo('gcconnex_profile:edit_profile')
        ));
        //$list .= '<a class="btn gcconnex-avatars-expand" data-toggle="modal" href="#' . $options['id'] . '" >...</a>';

        //$list .= '<a class="btn gcconnex-avatars-expand elgg-lightbox" href="' . elgg_get_site_url() . 'ajax/view/endorse/endorsement" >...</a>';
    }


    if ( $options['use_hover'] === null ) {
        $options['use_hover'] = true;
    }

    if ( $options['guids'] == null ) {
        return false;
    }
    else {
        if (!is_array($options['guids'])) {
            $options['guids'] = array($options['guids']);
        }

        $guids = $options['guids'];

        // display each avatar, up until the limit is reached
        for ( $i=0; $i<$options['limit']; $i++) {
            if( ($user = get_user($guids[$i])) == true ) {
                if ( $options['edit_mode'] == true ) {
                    $list .= '<div class="gcconnex-avatar-in-list" data-guid="' . $guids[$i] . '" onclick="removeColleague(this)">';
                    $list .= '<div class="remove-colleague-from-list">X';
                    $list .= '</div>'; // close div class="remove-colleague-from-list"

                    $list .= elgg_view_entity_icon($user, $options['size'], array(
                        'use_hover' => $options['use_hover'],
                        'href' => false
                    ));
                    $list .= '</div>'; // close div class="gcconnex-avatar-in-list"
                            $list .= '<a class="btn gcconnex-avatars-expand" data-toggle="modal" href="#' . $options['id'] . '" >...</a>';

                            
                }
                else {
                    $passedGuids .= $guids[$i] .  ',';
                    $list .= '<div class="gcconnex-avatar-in-list" data-guid="' . $guids[$i] . '">';
                    $list .= elgg_view_entity_icon($user, $options['size'], array(
                        'use_hover' => $options['use_hover'],
                    ));
                    $list .= '</div>'; // close div class="gcconnex-avatar-in-list"
                            
                }
            }
            else {
                break;
            }
        }
    }
    if($options['id']){
        $list .= '<a class="btn gcconnex-avatars-expand elgg-lightbox" href="' . elgg_get_site_url() . 'ajax/view/endorse/endorsement?guids=' . $passedGuids .'" >...</a>';
    }
    $list .= '</div>'; // close div class="list-avatars"
    return $list;
}

/*
 * Purpose: To sort education and work experience entities by their start date.. called before cmpEndYear so that the list is ordered by both start and end dates.
 */
function cmpStartDate($foo, $bar)
{
    $a = get_entity($foo);
    $b = get_entity($bar);

    if ($a->startyear == $b->startyear) {
        return (0);
    }
    else if ($a->startyear > $b->startyear) {
        return (-1);
    }
    else if ($a->startyear < $b->startyear) {
        return (1);
    }
}

/*
 * Purpose: To sort education and work experience entities by their end date.. called after cmpStartYear so that the list is ordered by both start and end dates.
 */
function sortDate($foo, $bar)
{

    $a = get_entity($foo);
    $b = get_entity($bar);

    if ($a->ongoing == "true" && $b->ongoing == "true") {
        return (0);
    }
    else if ($a->ongoing == "true" && $b->ongoing != "true") {
        return (-1);
    }
    else if ($a->ongoing != "true" && $b->ongoing == "true") {
        return (1);
    }
    else {
        if ($a->endyear == $b->endyear) {
            // @todo: sort by enddate entry (months, saved as strings..)
            return (cmpStartDate($a, $b));
        }
        else if ($a->endyear > $b->endyear) {
            return (-1);
        }
        else if ($a->endyear < $b->endyear) {
            return (1);
        }
    }
}
