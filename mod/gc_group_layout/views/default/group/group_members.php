<?php

$urloffset = $_GET['offset'];
if (!$urloffset) {
    $urloffset = 0;
}
error_log($urloffset);
$url = "http://192.168.0.26/gcconnex/services/api/rest/json/?method=get.user_list&api_key=b9e52e09cb8c5df4d5ac1eb6adb0ab6d4507fc00&offset={$urloffset}";

$items = json_decode(file_get_contents($url), true);


$items = $items['result'];
$num = 50;
$pages = ceil($num / 10);
$tbody = "";
foreach ($items as $item) {

    $user = get_entity($item['guid']);
    $user_icon = elgg_view_entity_icon($user, 'medium');
    error_log("item: {$item['guid']}");
    $tbody .= "
    <tr class='testing' role='row'>
        <td class='data-table-list-item sorting_1'> 
            <article class='col-xs-12 mrgn-tp-sm  mrgn-bttm-sm'>
                <div aria-hidden='true' class='mrgn-tp-sm col-xs-2'>
                    {$user_icon}
                </div>
                <div class='mrgn-tp-sm col-xs-10 noWrap'>
                    <h3 class='mrgn-bttm-0 summary-title'><a href='{$item['url']}' rel='me'>{$item['name']['en']}</a></h3>
                    <div class='mvs clearfix'><strong>gcconnex-profile-card:</strong></div>
                </div>
            </article>
        </td>
        <td class='data-table-list-item'>
            <p style='padding-top:10px;'>2018-07-01 00:42</p>
        </td>
    </tr>";
}

$paginate = "";


$paginate .= "<ul class='elgg-pagination pagination'>";
$paginate .= "<li class='elgg-state-disabled'><span>Previous</span></li>";
//$paginate .= "<li class='elgg-state-selected active'><span>1</span></li>";
for ($k=0; $k<=$pages; $k++) {
    $offset = $k * 5;
    $page_num = $k + 1;
    $url = "http://192.168.0.26/gcconnex/services/api/rest/json/?method=get.user_list&api_key=b9e52e09cb8c5df4d5ac1eb6adb0ab6d4507fc00&offset={$offset}";
    $paginate .= "<li><a onclick='return get_user_list({$offset})' href='#customTable'>$page_num</a></li>";
}
$paginate .= "<li><a href='#'>Next</a></li>";
$paginate .= "</ul>";



/*

<ul class="elgg-pagination pagination"><li class="elgg-state-disabled "><span>Previous</span></li><li class="elgg-state-selected active"><span>1</span></li><li><a href="http://192.168.0.26/gccollab/blog/all?offset=10#">2</a></li><li><a href="http://192.168.0.26/gccollab/blog/all?offset=10#">Next</a></li></ul>

*/

echo <<<___HTML

Showing 10 out of $num
<div id='customTable'>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Group members</th>
                <th>Date joined</th>
            </tr>
        </thead>
        <tbody id='body-member-list'>
            $tbody
        </tbody>
    </table>

    $paginate
</div>

___HTML;

?>


<?php // javascript/ajaxy functions will be here ?>

<script>

function get_user_list(offset) {
    console.log("getting user: "+offset);

    $('#body-member-list').children().remove();
    elgg.action('groups/retrieve_member_list', {
        data: {
            list_offset: offset,
        },
        success: function (content_array) {
            for (var item in content_array.output.member_list)
                $('#body-member-list').append(content_array.output.member_list[item]);
        }
    });

    return 'heyhey';
}

</script>
