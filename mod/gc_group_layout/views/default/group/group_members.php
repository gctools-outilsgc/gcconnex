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

$paginate = "";

// @TODO Next and Previous
$paginate .= "<ul id='custom-pagination' class='elgg-pagination pagination'>";
$paginate .= "<li class='elgg-state-disabled'><span>Previous</span></li>";

for ( $k=0; $k<$pages; $k++ ) {
    $pagination_offset = $k * $limit;
    $page_num = $k + 1;
    $url = "{$site_url}services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$pagination_offset}&limit={$limit}";
    $paginate .= "<li id='pagination-page-{$page_num}'><a onclick='return get_user_list({$pagination_offset}, {$limit}, {$guid})' href='#customTable'>$page_num</a></li>";
}
$paginate .= "<li><a href='#'>Next</a></li>";
$paginate .= "</ul>";


$dropdown = "<select id='dpLimit' aria-controls='wb-tables-id-0'>
<option value='5'>5</option>
<option value='10'>10</option>
<option value='25'>25</option>
<option value='50'>50</option>
<option value='100'>100</option>
</select>";

$searchbox = "<label>Search entries</label> <input type='textbox' id='txtSearchMember' value=''></input>";


// @TODO jquerify this portion
$display_offset = $offset + 1;
$display_limit = $offset + $limit;

echo <<<___HTML

<div style='width:100%; overflow:hidden; padding: 5px 5px 25px 5px;'>
    <div style='float:right; padding-top:5px; padding-bottom:5px;'>{$searchbox}</div>
    <div style='padding-top:10px; padding-bottom:5px;'>Showing $display_offset to $display_limit out of $total_items entries | <strong>Show {$dropdown} entries</strong></div>
    
</div>

<div id='customTable'>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr style='border-bottom:1pt solid gray;'>
                <th style="width:665px; font-weight:700; font-size:1.2em;">Group members</th>
                <th style="width:665px; font-weight:700; font-size:1.2em;">Date joined</th>
            </tr> 
        </thead>
        <tbody id='body-member-list'>
            $tbody
        </tbody>
    </table>

    <div style='padding-top:15px; padding-bottom:5px;'>$paginate</div>
</div>

___HTML;

?>


<?php // javascript/ajaxy functions will be here ?>

<script>

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


function get_user_list(offset, limit, guid) {

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
