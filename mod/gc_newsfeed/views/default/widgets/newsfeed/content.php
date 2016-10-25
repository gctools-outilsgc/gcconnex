<?php
/**
 * Newsfeed Activity Widget
 * 
 * This will display Friend and Group activity based on the relationships of the logged in user
 * 
 *
 * content description.
 *
 * @version 1.0
 * @author Owner
 */


//YOLO CODE V2

if(elgg_is_logged_in()){
    $loading = elgg_view('output/img', array(
            'src' => 'mod/wet4/graphics/loading.gif',
            'alt' => 'loading'
        ));

?>
<script>
    $(document).ready(function () {
        $('.elgg-list-river').parent().parent().attr('id', 'activity');

        //add newsfeed settings link
        $('#activity .panel-heading').prepend('<a href="#" title="<?php echo elgg_echo('newsfeed:filter:title'); ?>" class="dropdown  pull-right mrgn-rght-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down fa-2x icon-unsel " aria-hidden="true"></i></a><ul class="dropdown-menu pull-right newsfeed-filter panel-default" aria-labelledby="dropdownMenu2"><li class="panel-body" id="filter_form"></li></ul>');

        //load in form when settings is pressed
        $('#activity .dropdown').on('click', function () {
            //check if form has already been loaded
            if ($('#filter_form').html() == '') {

                //place loading spinner
                $('#filter_form').html('<div class="text-center" style="margin: 10px auto 0;display:block;"><?php echo $loading; ?></div>');
                //load form
                elgg.get('ajax/view/ajax/newsfeed_filter', {
                    success: function (output) {
                        $('#filter_form').html(output);
                    }
                });

            }
        });

        //stop dropdown form from toggling while interacting with form
        $('.dropdown-menu').click(function (e) {
            e.stopPropagation();
        });
    });
</script>
<?PHP
    $_SESSION['Suggested_friends']=0;
    $title = elgg_echo('river:all');
    $user = elgg_get_logged_in_user_entity();
    $db_prefix = elgg_get_config('dbprefix');
    $page_filter = 'all';

    if ($user) {
        //check if user exists and has friends or groups
        $hasfriends = $user->getFriends();
        $hasgroups = $user->getGroups();
        if($hasgroups){
            //loop through group guids
            $groups = $user->getGroups(array('limit'=>0,)); //increased limit from 10 groups to all
            $group_guids = array();
            foreach ($groups as $group) {
                $group_guids[] = $group->getGUID();
            }
        }

    }
    if(!$hasgroups && !$hasfriends){
        //no friends and no groups :(
        $activity = '';
    }else if(!$hasgroups && $hasfriends){
        //has friends but no groups
        $optionsf['relationship_guid'] = elgg_get_logged_in_user_guid();
        $optionsf['relationship'] = 'friend';
        $optionsf['pagination'] = true;

        //turn off friend connections
        //remove friend connections from action types
        $actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
        //load user's preference
        $filteredItems = array($user->colleagueNotif);
        //filter out preference
        $optionsf['action_types'] = array_diff( $actionTypes, $filteredItems);

        $activity = newsfeed_list_river($optionsf);
    }else if(!$hasfriends && $hasgroups){
        //if no friends but groups
        $guids_in = implode(',', array_unique(array_filter($group_guids)));
        //$optionsg['joins'] = array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid");
        //display created content and replies and comments
        $optionsg['wheres'] = array("( oe.container_guid IN({$guids_in})
         OR te.container_guid IN({$guids_in}) )");
        $optionsg['pagination'] = true;
        $activity = newsfeed_list_river($optionsg);
    }else{
        //if friends and groups :3

        ////////////////////// NEWSFEED FILTER TESTING ////////////////////
        //
        //removing group activity test
        //filter out groups you do not want
        /*
        $test = array('534'); //534
        $testGroups = array_diff( $group_guids, $test); //place in $guids_in to filter groups

        $optionsfg['type'] = array('object', 'group', 'user'); //type newsfeed filter

        //removing friend activity test
        //filter out friends you do not want
        $ignoreFriends = array(); //493
        $ignoreFriends = implode(',', $ignoreFriends);
         */
        //
        ///////////////////////////////////////////////////////////////////

        //turn off friend connections
        //remove friend connections from action types
        $actionTypes = array('comment', 'create', 'join', 'update', 'friend', 'reply');
        //load user's preference
        $filteredItems = array($user->colleagueNotif);
        //filter out preference
        $optionsfg['action_types'] = array_diff( $actionTypes, $filteredItems);

        $guids_in = implode(',', array_unique(array_filter($group_guids)));
        //echo $guids_in;
        /*   $optionsfg['joins'] = array(" {$db_prefix}entities e ON e.guid = rv.object_guid",
        " {$db_prefix}entities e1 ON e1.guid = rv.target_guid",

        );*/
        //Groups + Friends activity query
        //This query grabs new created content and comments and replies in the groups the user is a member of *** te.container_guid grabs comments and replies
        $optionsfg['wheres'] = array(
    "( oe.container_guid IN({$guids_in})
         OR te.container_guid IN({$guids_in}) )
        OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$user->guid AND relationship='friend')
        ");
        $optionsfg['pagination'] = true;
        $activity = newsfeed_list_river($optionsfg);
    }

    if (!$activity) {
        //if the user doesn't have any friends or activity display this message
        $site_url = elgg_get_site_url();
        $featuredGroupButton = elgg_view('output/url', array(
            'href' => $site_url .'groups/all?filter=popular',
            'text' => elgg_echo('wetActivity:browsegroups'),
            'class' => 'btn btn-primary',
            'is_trusted' => true,
        ));
        //$activity = elgg_echo('river:none');
        //placeholder panel
        $activity .= '<div class="panel panel-custom elgg-list-river"><div class="panel-body">';
        $activity .= '<h3 class="panel-title mrgn-tp-md">'.elgg_echo('wetActivity:welcome').'</h3>';
        $activity .= '<div class="mrgn-bttm-md mrgn-tp-sm">'.elgg_echo('wetActivity:nocollorgroup').'</div>';
        $activity .= '<div>'.$featuredGroupButton.'</div>';
        $activity .= '</div></div>';
        //$activity .= 'You should join some groups or something dawg.';
        //we can put a link here (or suggested groups and stuff) as well to invite users to join groups or have colleagues and stuff
    }
    else if ( is_null( get_input('offset', null) ) ){
        // add a "Show All button"
        $moreButton = elgg_view('output/url', array(
            'href' => $site_url .'newsfeed/?offset=20',
            'text' => elgg_echo('wet:more'),
            'class' => 'btn btn-primary newsfeed-button',
            'is_trusted' => true,
        ));
        $activity .= $moreButton;
    }
}else{
    //if the user is not logged in then display a login thing to invite users to login and register :3
    $title = elgg_echo('login');
    $body = elgg_view_form('login');
    $login_ = elgg_view_module('index',$title, $body);

    //display the notice message on the home page only when not logged in, and in the language user wants
    $notice_title = elgg_echo('wet4:noticetitle');
    $notice_body = elgg_echo('wet4:homenotice');
    $notice_ = elgg_view_module('index', $notice_title, $notice_body);
    echo $notice_;
    echo $login_;
}


//echo out the yolo code

echo $activity;
