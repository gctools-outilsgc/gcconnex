<?php

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$option = get_input('option');

$name = get_input('member_name');
$offset = (int)get_input('list_offset');
$limit = (int)get_input('list_limit');
$guid = (int)get_input('group_guid');

$group = get_entity($guid);
$site_url = elgg_get_site_url();

$name_param = ($name != '') ? "&name={$name}" : "";

$url = "{$site_url}services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$offset}&limit={$limit}{$name_param}";
$items = json_decode(file_get_contents($url), true);

$members = $items['result']['members'];
$total_items = $items['result']['count'];

$pages = ceil($total_items / 10);
$tbody = array();

$current_user = elgg_get_logged_in_user_entity();

if ($total_items == 0) {

    $txtNoResults = elgg_echo('group:no_results');

    $tbody[] = "
        <tr class='testing' role='row'>
            <td class='data-table-list-item sorting_1' colspan='2'>
                <article class='col-xs-12 mrgn-tp-sm  mrgn-bttm-sm'>
                    {$txtNoResults}
                </article>
            </td>
        </tr>";

} else {

    foreach ($members as $member) {

        $user = get_entity($member['guid']);
        $user_icon = elgg_view_entity_icon($user, 'medium');

        $user_title = ($user->job) ? "<div class='mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix'>{$user->job}</div>" : "";
        $user_location = ($user->location) ? "<li class='elgg-menu-item-location'><span>{$user->location}</span></li>" : "";

				if($current_user){
	        // remove add pending friend request
	        if ($user->isFriendOf($current_user->getGUID())) {
	            $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/remove?friend={$member[guid]}");
	            $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend:remove")."</a></li>";
	        } else {
	            // pending request
	            if (check_entity_relationship($current_user->getGUID(), "friendrequest", $user->getGUID())) {
	                $addRemoveFriendURL = elgg_add_action_tokens_to_url("friend_request/{$current_user->username}#friend_request_sent_listing");
	                $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend_request:friend:add:pending")."</a></li>";
	            } else {
	                $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/add?friend={$member[guid]}");
	                $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend:add")."</a></li>";
	            }
	        }
				}


        if ($group->canEdit()) {
            $removeMemberURL = elgg_add_action_tokens_to_url("action/groups/remove?user_guid={$member[guid]}");
            $user_RemoveMember = "<li><a href='{$removeMemberURL}'>".elgg_echo('group:member_remove_group')."</a></li>";
        }

        $tbody[] = "
        <tr class='testing' role='row'>
            <td class='data-table-list-item sorting_1'>
                <article class='col-xs-12 mrgn-tp-sm  mrgn-bttm-sm'>
                    <div aria-hidden='true' class='mrgn-tp-sm col-xs-2'>
                        {$user_icon}
                    </div>
                    <div class='mrgn-tp-sm col-xs-10 noWrap'>
                        <h3 class='mrgn-bttm-0 summary-title'><a href='{$member['url']}' rel='me'>{$member['name']}</a></h3>
                        $user_title
                        <div>
                            <ul class='elgg-menu elgg-menu-entity mrgn-tp-sm elgg-menu-entity-default list-unstyled'>
                                $user_location
                                $user_addRemoveFriend
                                $user_RemoveMember
                            </ul>
                        </div>
                    </div>
                </article>
            </td>
            <td class='data-table-list-item'>
                <p style='padding-top:10px;'>{$member['date_joined']}</p>
            </td>
        </tr>";
    }
}


echo json_encode([
    'member_count' => $total_items,
	'member_list' => $tbody,
]);
