<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$option = get_input('option');

error_log('option ' . $option);

$name = get_input('member_name');
$offset = (int)get_input('list_offset');
$limit = (int)get_input('list_limit');
$guid = (int)get_input('group_guid');

$site_url = elgg_get_site_url();

$name_param = ($name != '') ? "&name={$name}" : "";
error_log("name - " . $name_param);
$url = "{$site_url}services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$offset}&limit={$limit}{$name_param}";

$items = json_decode(file_get_contents($url), true);


$items = $items['result']['members'];
$total_items = $items['result']['count'];

error_log("information: {$items}");

$pages = ceil($total_items / 10);
$tbody = array();

foreach ($items as $item) {

    $user = get_entity($item['guid']);
    $user_icon = elgg_view_entity_icon($user, 'medium');

	$user_title = ($user->job) ? "<div class='mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix'>{$user->job}</div>" : "";
    $user_location = ($user->location) ? "<li class='elgg-menu-item-location'><span>{$user->location}</span></li>" : "";

    $tbody[] = "
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
                            <li class='elgg-menu-item-friend><a href='#'>Remove friend</a></li>
                            <li class='elgg-menu-item-remove-user'><a href='#'>Remove from group</a></li>
                        </ul>
                    </div>
                </div>
            </article>
        </td>
        <td class='data-table-list-item'>
            <p style='padding-top:10px;'>{$item['date_joined']}</p>
        </td>
    </tr>";
}


echo json_encode([
	'member_list' => $tbody,
]);



