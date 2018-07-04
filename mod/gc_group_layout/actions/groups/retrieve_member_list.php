<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$offset = (int)get_input('list_offset');
$limit = (int)get_input('list_limit');
$guid = (int)get_input('group_guid');

$url = "http://192.168.1.18/gcconnex/services/api/rest/json/?method=get.group_member_list&group_guid={$guid}&offset={$offset}&limit={$limit}";

$items = json_decode(file_get_contents($url), true);


$items = $items['result']['members'];


error_log("information: {$items}");

$num = 50;
$pages = ceil($num / 10);
$tbody = array();

foreach ($items as $item) {

    $user = get_entity($item['guid']);
    $user_icon = elgg_view_entity_icon($user, 'medium');

	$tbody[] = "
    <tr class='testing' role='row'>
        <td class='data-table-list-item sorting_1'> 
            <article class='col-xs-12 mrgn-tp-sm  mrgn-bttm-sm'>
                <div aria-hidden='true' class='mrgn-tp-sm col-xs-2'>
                    {$user_icon}
                </div>
                <div class='mrgn-tp-sm col-xs-10 noWrap'>
                    <h3 class='mrgn-bttm-0 summary-title'><a href='{$item['url']}' rel='me'>{$item['name']}</a></h3>
                    <div class='mvs clearfix'><strong>gcconnex-profile-card:</strong></div>
                </div>
            </article>
        </td>
        <td class='data-table-list-item'>
            <p style='padding-top:10px;'>2018-07-01 00:42</p>
        </td>
    </tr>";
}


echo json_encode([
	'member_list' => $tbody,
]);



