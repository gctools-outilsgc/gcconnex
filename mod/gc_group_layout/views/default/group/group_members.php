<?php

// @TODO clean up the conditions
$offset = $_GET['offset'];
$limit = $_GET['limit'];
if (!$offset) $offset = 0;
if (!$limit) $limit = 5;

$guid = $vars['group_guid'];
$site_url = elgg_get_site_url();
$group = get_entity($guid);
$url = "{$site_url}services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$offset}&limit={$limit}";

$items = json_decode(file_get_contents($url), true);

$total_items = $items['result']['count'];
$items = $items['result']['members'];

$current_user = elgg_get_logged_in_user_entity();

$pages = ceil($total_items / $limit);
$tbody = "";

foreach ($items as $item) {

    $user = get_entity($item['guid']);
    $user_icon = elgg_view_entity_icon($user, 'medium');

    
    $user_title = ($user->job) ? "<div class='mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix'>{$user->job}</div>" : "";
    $user_location = ($user->location) ? "<li class='elgg-menu-item-location'><span>{$user->location}</span></li>" : "";

    // friend options
    // @TODO colleague request pending
    if ($user->isFriendsWith($current_user->getGUID())) {
        $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/remove?friend={$item[guid]}");
        $user_addRemoveFriend = "<a href='{$addRemoveFriendURL}'>Remove friend</a>";
    } else {
        $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/add?friend={$item[guid]}");
        $user_addRemoveFriend = "<a href='{$addRemoveFriendURL}'>Add friend</a>";
    }

    if ($group->canEdit()) {
        $removeMemberURL = elgg_add_action_tokens_to_url("action/groups/remove?user_guid={$item[guid]}");
        $user_RemoveMember = "<a href='{$removeMemberURL}'>Remove from group</a>";
    }

    // condition for no members
    $tbody .= "
    <tr class='testing' role='row'>
        <td class='data-table-list-item sorting_1'> 
            <article class='col-xs-12 mrgn-tp-sm  mrgn-bttm-sm'>
                <div aria-hidden='true' class='mrgn-tp-sm col-xs-2'>
                    {$user_icon}
                </div>
                <div class='mrgn-tp-sm col-xs-10 noWrap'>
                    <h3 class='mrgn-bttm-0 summary-title'><a href='{$item['url']}' rel='me'>{$item['name']}</a></h3>
                    $user_title
                    <div>
                        <ul class='elgg-menu elgg-menu-entity list-inline mrgn-tp-sm elgg-menu-hz elgg-menu-entity-default'>
                            $user_location
                            $user_addRemoveFriend
                            $user_RemoveMember
                        </ul>
                    </div>
                </div>
            </article>
            <div class='clearfix'></div>
        </td>
        <td class='data-table-list-item'>
            <p style='padding-top:10px;'>{$item['date_joined']}</p>
        </td>
    </tr>";
}


// pagination for "scrolling" through the list of members
$next = 'next';
$previous = 'previous';

$paginate = "";
$paginate .= "<ul id='custom-pagination' class='elgg-pagination pagination'>";
$paginate .= "<li><a href='#customTable' onclick='return navigate_group_member(0)' id='custom-pagination-previous'>Previous</span></li>";

for ( $k=0; $k<$pages; $k++ ) {
    $pagination_offset = $k * $limit;
    $page_number = $k + 1;
    $url = "{$site_url}services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$pagination_offset}&limit={$limit}";
    $paginate .= "<li id='pagination-page-{$page_number}'><a onclick='return get_user_list({$pagination_offset})' href='#customTable'>$page_number</a></li>";
}
$paginate .= "<li><a id='custom-pagination-next' onclick='return navigate_group_member(1)' href='#customTable'>Next</a></li>";
$paginate .= "</ul>";


// dropdown form to show number of entries per page
$dropdown = "
<select id='dpLimit' aria-controls='wb-tables-id-0'>
    <option value='5'>5</option>
    <option value='10'>10</option>
    <option value='25'>25</option>
    <option value='50'>50</option>
    <option value='100'>100</option>
</select>";



// @TODO jquerify this portion
$display_offset = $offset + 1;
$display_limit = $offset + $limit;

// text with translations
$txtGroupMembers = elgg_echo('group:member_list');
$txtDateJoined = elgg_echo('group:member_date_joined');
$txtRemoveGroup = elgg_echo('group:member_remove_group');
$txtAddFriend = elgg_echo('group:member_add_friend');
$txtRemoveFriend = elgg_echo('group:member_remove_friend');
$txtShowEntries = elgg_echo('group:show_entries', array($display_offset, $display_limit, $total_items, $dropdown));
$txtSearchEntries = elgg_echo('group:search_entries');

$searchbox = "<label>{$txtSearchEntries}</label> <input type='textbox' id='txtSearchMember' value=''></input>";


// assemble the view with components displayed
echo <<<___HTML

<div style='width:100%; overflow:hidden; padding: 5px 5px 25px 5px;'>
    <div style='float:right; padding-top:5px; padding-bottom:5px;'>{$searchbox}</div>
    <div style='padding-top:10px; padding-bottom:5px;'>{$txtShowEntries}</div>    
</div>
<input id='txtHiddenOffset'></input>
<div id='customTable'>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr style='border-bottom:1pt solid gray;'>
                <th style="width:665px; font-weight:700; font-size:1.2em;">{$txtGroupMembers}</th>
                <th style="width:665px; font-weight:700; font-size:1.2em;">{$txtDateJoined}</th>
            </tr> 
        </thead>
        <tbody id='body-member-list'>
            $tbody
        </tbody>
    </table>

    <div style='padding-top:15px; padding-bottom:5px;'>{$paginate}</div>
</div>

___HTML;

?>



<?php // javascript/ajaxy functions will be here ?>

<script>

$(document).ready(function() {
    $('#pagination-page-1').addClass('elgg-state-selected active');
    $('#txtHiddenOffset').val(0);
});


$('#dpLimit').change(function(event) {
    var limit = $('#dpLimit').val();
    var offset = 0;
    var name = $('#txtSearchMember').val();
    var guid = elgg.get_page_owner_guid();

    $('#body-member-list').children().remove();
    elgg.action('groups/retrieve_member_list',{
        data: {
            group_guid: guid,
            option: 'member_search',
            list_offset: offset,
            list_limit: limit,
            member_name: name,
        },
        success: function (content_array) {
            for (var item in content_array.output.member_list)
                $('#body-member-list').append(content_array.output.member_list[item]);
        }
    });
});


$('#txtSearchMember').keyup(function(event) {
    if (event.keyCode == 13) {

        var limit = $('#dpLimit').val();
        var offset = 0;
        var name = $('#txtSearchMember').val();
        var guid = elgg.get_page_owner_guid();
        
        $('#body-member-list').children().remove();
        elgg.action('groups/retrieve_member_list',{
            data: {
                group_guid: guid,
                option: 'member_search',
                list_offset: offset,
                list_limit: limit,
                member_name: name,
            },
            success: function (content_array) {
                for (var item in content_array.output.member_list)
                    $('#body-member-list').append(content_array.output.member_list[item]);
            }
        });

    }
});

function navigate_group_member(direction) {

    console.log("navigation 0 " + direction);
    // when direction is 0:previous and 1:next

    var name = $('#txtSearchMember').val();
    var guid = elgg.get_page_owner_guid();
    var limit = $('#dpLimit').val();

    current_offset = $('#txtHiddenOffset').val();

    if (direction == 0) {
        current_offset = current_offset - limit;
    }

    if (direction == 1) {
        current_offset = current_offset + limit;
    }

    $('#txtHiddenOffset').val(current_offset);
    console.log("current offset : " + current_offset);
    //get_user_list($current_offset);
} 

function get_user_list(offset) {

    var name = $('#txtSearchMember').val();
    var guid = elgg.get_page_owner_guid();
    var limit = $('#dpLimit').val();

    <?php // save the offset in a text field since HTML is stateless ?>
    $('#txtHiddenOffset').val(offset);

    console.log("offset: " + offset);

    offset = $('#txtHiddenOffset').val();
    
    var page = (offset / limit) + 1;



    $('#custom-pagination li').removeClass('elgg-state-selected active');
    $('#pagination-page-' + page).addClass('elgg-state-selected active');
    $('#body-member-list').children().remove();
    elgg.action('groups/retrieve_member_list', {
        data: {
            option: 'get_member_list',
            list_offset: offset,
            list_limit: limit,
            group_guid: guid,
        },
        success: function (content_array) {
            for (var item in content_array.output.member_list)
                $('#body-member-list').append(content_array.output.member_list[item]);
        }
    });

}

</script>
