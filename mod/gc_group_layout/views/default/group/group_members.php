<?php

// @TODO clean up the conditions
$offset = $_GET['offset'];
$limit = $_GET['limit'];
if (!$offset) $offset = 0;
if (!$limit) $limit = 1;

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
    if($current_user){
      // @TODO Ajaxify this
      if ($user->isFriendOf($current_user->getGUID())) {
          $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/remove?friend={$item[guid]}");
          $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend:remove")."</a></li>";
      } else {
          // pending request
          if (check_entity_relationship($current_user->getGUID(), "friendrequest", $user->getGUID())) {
              $addRemoveFriendURL = elgg_add_action_tokens_to_url("friend_request/{$current_user->username}#friend_request_sent_listing");
              $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend_request:friend:add:pending")."</a></li>";
          } else {
              $addRemoveFriendURL = elgg_add_action_tokens_to_url("action/friends/add?friend={$item[guid]}");
              $user_addRemoveFriend = "<li><a href='{$addRemoveFriendURL}'>".elgg_echo("friend:add")."</a></li>";
          }
      }
    }

    if ($group->canEdit()) {
        $removeMemberURL = elgg_add_action_tokens_to_url("action/groups/remove?user_guid={$item[guid]}");
        $user_RemoveMember = "<li><a href='{$removeMemberURL}'>".elgg_echo('group:member_remove_group')."</a></li>";
    }

    // @TODO condition for no members
    // @TODO the links should be listed
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
                        <ul class='elgg-menu elgg-menu-entity mrgn-tp-sm elgg-menu-entity-default list-unstyled'>
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
$next = elgg_echo('group:next_set');
$previous = elgg_echo('group:previous_set');

$paginate = "";
$paginate .= "<ul id='custom-pagination' class='elgg-pagination pagination'>";
$paginate .= "<li><a href='#customTable' onclick='return navigate_group_member(0)' id='custom-pagination-previous'>{$previous}</span></li>";

for ( $k=0; $k<$pages; $k++ ) {
    $pagination_offset = $k * $limit;
    $pagination_label = $k + 1;

    if($pagination_label <=5){
      //load first 5 normally
      $paginate .= "<li id='pagination-page-{$pagination_label}' class='pagination-page-number'><a onclick='return get_user_list({$pagination_offset})' href='#customTable'>$pagination_label</a></li>";
    } else if($pages == 6){
      //for certain case, create final page without ...
      $pagination_offset = ($pages - 1) * $limit;
      $paginate .= "<li id='pagination-page-{$pages}' class='pagination-page-number'><a onclick='return get_user_list({$pagination_offset})' href='#customTable'>$pages</a></li>";
    } else {
      //for anything that has more than 6 pages, create ... then final page
      $paginate .= "<li id='pagination-page' class='pagination-page-number'><span>...</span></li>";
      $final_offset = ($pages - 1) * $limit;
      $paginate .= "<li id='pagination-page-{$pages}' class='pagination-page-number'><a onclick='return get_user_list({$final_offset})' href='#customTable'>$pages</a></li>";
      $k = $pages;
    }
}

$paginate .= "<li><a id='custom-pagination-next' onclick='return navigate_group_member(1)' href='#customTable'>{$next}</a></li>";
$paginate .= "</ul>";


// dropdown form to show number of entries per page
$dropdown = "
<select id='dpLimit' aria-controls='wb-tables-id-0'>
    <option value='1'>1</option>
    <option value='2'>2</option>
    <option value='3'>3</option>
    <option value='5'>5</option>
    <option value='10'>10</option>
    <option value='25'>25</option>
    <option value='50'>50</option>
    <option value='100'>100</option>
</select>";

$txtDropDown = '<label style="display:inline-block;">' . elgg_echo('group:show_entries_dropdown', array($dropdown)) . '</label>';


$display_offset = $offset + 1;
$display_limit = $offset + $limit;

//make entries text more readable
if($display_limit > $total_items){
  $display_limit = $total_items;
}

// text with translations
$txtGroupMembers = elgg_echo('group:member_list');
$txtDateJoined = elgg_echo('group:member_date_joined');
$txtRemoveGroup = elgg_echo('group:member_remove_group');
$txtAddFriend = elgg_echo('group:member_add_friend');
$txtRemoveFriend = elgg_echo('group:member_remove_friend');
$txtShowEntries = elgg_echo('group:show_entries', array($display_offset, $display_limit, $total_items)) . $txtDropDown;
$txtSearchEntries = elgg_echo('group:search_entries');

$searchbox = "<label for='txtSearchMember'  aria-live='passive' style='display:inline-block;'>{$txtSearchEntries}</label> <input type='textbox' id='txtSearchMember' value=''></input>";


// assemble the view with components displayed
echo <<<___HTML

<div style='width:100%; overflow:hidden; padding: 5px 5px 25px 5px;'>
    <div style='padding-top:10px; padding-bottom:5px; display:inline-block'>{$txtShowEntries}</div>
    <div style='float:right; padding-top:5px; padding-bottom:5px;'>{$searchbox}</div>
</div>
<input type='hidden' id='txtHiddenOffset'></input>
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
    var limit = parseInt($('#dpLimit').val());
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

            var member_count = parseInt(content_array.output.member_count);
            if (member_count <= limit) {
                $('#custom-pagination').children().remove();
            } else {

                $('#custom-pagination').children().remove();

                // pagination
                var pages = Math.ceil(member_count / limit);
                var pagination_children = '';
                var pagination_offset;
                var k;
                $('#custom-pagination').append("<li><a href='#customTable' onclick='return navigate_group_member(0)' id='custom-pagination-previous'>"+elgg.echo('group:previous_set')+"</span></li>");
                for ( k=0; k<pages; k++ ) {
                    pagination_offset = k * limit;
                    pagination_label = k + 1;
                    if(pagination_label <=5){
                      $('#custom-pagination').append("<li id='pagination-page-"+pagination_label+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pagination_label+"</a></li>");
                    } else if(pages == 6){
                      pagination_offset = (pages - 1) * limit;
                      $('#custom-pagination').append("<li id='pagination-page-"+pages+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pages+"</a></li>");
                    } else {
                      $('#custom-pagination').append("<li id='pagination-page' class='pagination-page-number'><span>...</span></li>");
                      pagination_offset = (pages - 1) * limit;
                      $('#custom-pagination').append("<li id='pagination-page-"+pages+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pages+"</a></li>");
                      k = pages;
                    }
                }
                $('#custom-pagination').append("<li><a id='custom-pagination-next' onclick='return navigate_group_member(1)' href='#customTable'>"+elgg.echo('group:next_set')+"</a></li>");
                $('#pagination-page-1').addClass('elgg-state-selected active');
            }

            console.log(content_array.output.member_count);
        }
    });
    //update entries status
    update_entires_label(offset, limit, 1)
});


$('#txtSearchMember').keyup(function(event) {
    if (event.keyCode == 13) {

        var limit = $('#dpLimit').val();
        var offset = 0;
        var name = $('#txtSearchMember').val();
        var guid = elgg.get_page_owner_guid();

        $('#body-member-list').children().remove();

        if(name != ""){
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
      } else {
        get_user_list(0);
      }
    }
});

function navigate_group_member(direction) {
    // when direction is 0:previous and 1:next

    var name = $('#txtSearchMember').val();
    var guid = elgg.get_page_owner_guid();
    var limit = parseInt($('#dpLimit').val());

    current_offset = parseInt($('#txtHiddenOffset').val());

    if (direction == 0 && current_offset > 0) {
        current_offset = current_offset - limit;
    }

    // @TODO do not exceed the number of members
    if (direction == 1) {
        current_offset = current_offset + limit;
    }

    $('#txtHiddenOffset').val(current_offset);
    get_user_list(current_offset);
}

function get_user_list(offset) {

    var name = $('#txtSearchMember').val();
    var guid = elgg.get_page_owner_guid();
    var limit = $('#dpLimit').val();

    <?php // save the offset in a text field since HTML is stateless ?>
    $('#txtHiddenOffset').val(offset);
    offset = $('#txtHiddenOffset').val();

    var page = (offset / limit) + 1;
    var total = $('.entries-total').html();

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

            //update entries status
            update_entires_label(offset, limit, page, total);
        }
    });

}

function update_entires_label(offset, limit, page, total) {

    var current_number = $('.entries-offset').text();
    var current_limit = $('.entries-limit').text();
    var current_total = $('.entries-total').text();

    $('.entries-offset').html(parseInt(offset) + 1);

    var check  = parseInt(page) * parseInt(limit);
    if (parseInt(current_total) > check){
        $('.entries-limit').html(parseInt(page) * parseInt(limit));
    } else {
        $('.entries-limit').html(parseInt(current_total));
    }

    $('#custom-pagination').children().remove();

    // pagination
    var pages = Math.ceil(total / limit);
    var pagination_children = '';
    var pagination_offset;
    var k;
    //remake the pager easily
    if(page < 5){
      $('#custom-pagination').append("<li><a href='#customTable' onclick='return navigate_group_member(0)' id='custom-pagination-previous'>"+elgg.echo('group:previous_set')+"</span></li>");
      for ( k=0; k<pages; k++ ) {
          pagination_offset = k * limit;
          pagination_label = k + 1;
          if(pagination_label <=5){
            $('#custom-pagination').append("<li id='pagination-page-"+pagination_label+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pagination_label+"</a></li>");
          } else if(pages == 6){
            pagination_offset = (pages - 1) * limit;
            $('#custom-pagination').append("<li id='pagination-page-"+pages+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pages+"</a></li>");
          } else {
            $('#custom-pagination').append("<li id='pagination-page' class='pagination-page'><span>...</span></li>");
            pagination_offset = (pages - 1) * limit;
            $('#custom-pagination').append("<li id='pagination-page-"+pages+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+pages+"</a></li>");
            k = pages;
          }
      }
      $('#custom-pagination').append("<li><a id='custom-pagination-next' onclick='return navigate_group_member(1)' href='#customTable'>"+elgg.echo('group:next_set')+"</a></li>");
    } else {
      //to replicate the full pager we have to do some funky things here
      var low_page = page - 2;
      var high_page = page + 2;
      var final_page_offset = (pages * limit) - 1;
      var p;

      //start by making the buttons that will always be there
      $('#custom-pagination').append("<li><a href='#customTable' onclick='return navigate_group_member(0)' id='custom-pagination-previous'>"+elgg.echo('group:previous_set')+"</span></li>");
      $('#custom-pagination').append("<li id='pagination-page-1' class='pagination-page-number'><a onclick='return get_user_list(0)' href='#customTable'>1</a></li>");
      //add the ... item if big enough gap from start
      if(low_page >= 3){
        $('#custom-pagination').append("<li id='pagination-page' class='pagination-page'><span>...</span></li>");
      }
      //run through possible pages
      for(p = low_page; p <= high_page; p++){
        //make sure we don't go over page limit
        if(p <= pages){
          pagination_offset = (p - 1) * limit;
          $('#custom-pagination').append("<li id='pagination-page-"+p+"' class='pagination-page-number'><a onclick='return get_user_list("+pagination_offset+")' href='#customTable'>"+p+"</a></li>");
        }
      }
      //check to see if we are not on the final pages
      if(page < (pages - 2)){
        //add ... item if needed
        if((pages - page) > 3){
          $('#custom-pagination').append("<li id='pagination-page' class='pagination-page'><span>...</span></li>");
        }
        $('#custom-pagination').append("<li id='pagination-page-"+pages+"' class='pagination-page-number'><a onclick='return get_user_list("+final_page_offset+")' href='#customTable'>"+pages+"</a></li>");
      }
      $('#custom-pagination').append("<li><a id='custom-pagination-next' onclick='return navigate_group_member(1)' href='#customTable'>"+elgg.echo('group:next_set')+"</a></li>");
    }

    //set active page
    $('#pagination-page-'+page).addClass('elgg-state-selected active');

}

</script>
