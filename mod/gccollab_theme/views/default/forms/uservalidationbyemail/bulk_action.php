<?php
/**
 * Admin area to view, validate, resend validation email, or delete unvalidated users.
 *
 * @package Elgg.Core.Plugin
 * @subpackage UserValidationByEmail.Administration
 */

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$name = get_input('name', '');

// can't use elgg_list_entities() and friends because we don't use the default view for users.
$ia = elgg_set_ignore_access(TRUE);
$hidden_entities = access_get_show_hidden_status();
access_show_hidden_entities(TRUE);

$display = $_GET['display'];

echo '<div class="elgg-col elgg-col-1of2">';
echo '<font>Display <a href="?display=10">10</a> | <a href="?display=50">50</a> | <a href="?display=100">100</a></font>';
echo '</div>';

if (!isset($display))
{
	$display = 10;
}

echo '<div class="elgg-col elgg-col-1of2"><label for="name">Search by name:</label> ';
echo elgg_view('input/text', array(
    'name' => 'name',
    'id' => 'name',
    'value' => $name,
    'style' => 'width: 200px; margin: 0 10px;'
));
echo elgg_view('input/submit', array(
    'name' => 'search',
    'id' => 'search',
    'value' => elgg_echo('search')
));
echo '</div>';

echo "<script>
$('#search').click(function(e) {
	e.preventDefault();
	var url = location.href;
    if(url.indexOf('name') >= 0){
		url = url.replace(/(name=)[^\&]+/, '$1' + $('#name').val());
    } else {
		url += url.indexOf('?') === -1 ? '?' : '&';
		url = url + 'name=' + $('#name').val();
    }
	location.href = url;
});

$('#name').bind('keyup', function(e) {
	e.preventDefault();
    if ( e.keyCode === 13 ) {
        var url = location.href;
        if(url.indexOf('name') >= 0){
			url = url.replace(/(name=)[^\&]+/, '$1' + $(this).val());
        } else {
			url += url.indexOf('?') === -1 ? '?' : '&';
			url = url + 'name=' + $(this).val();
        }
		location.href = url;
    }
});
</script>";

echo '<div class="clearfix"></div>';

$wheres = uservalidationbyemail_get_unvalidated_users_sql_where();
$options = array(
	'type' => 'user',
	'wheres' => $wheres,
	'limit' => $display,
	'offset' => $offset,
	'count' => TRUE,
);

if( $name != "" ){
	$db_prefix = elgg_get_config('dbprefix');
	$options['joins'] = array("JOIN {$db_prefix}users_entity ue ON e.guid = ue.guid");
	$options['wheres'] = array_merge($wheres, array("(ue.username LIKE '%" . $name . "%' OR ue.name LIKE '%" . $name . "%')"));
}
$count = elgg_get_entities($options);

if (!$count) {
	access_show_hidden_entities($hidden_entities);
	elgg_set_ignore_access($ia);

	echo elgg_autop(elgg_echo('uservalidationbyemail:admin:no_unvalidated_users'));
	return TRUE;
}

$options['count']  = FALSE;

$users = elgg_get_entities($options);

access_show_hidden_entities($hidden_entities);
elgg_set_ignore_access($ia);

// setup pagination
$pagination = elgg_view('navigation/pagination',array(
	'base_url' => 'unvalidated',
	'offset' => $offset,
	'count' => $count,
	'limit' => $limit,
));

$bulk_actions_checkbox = '<label><input type="checkbox" id="uservalidationbyemail-checkall" />'
	. elgg_echo('uservalidationbyemail:check_all') . '</label>';

$validate = elgg_view('output/url', array(
	'href' => 'action/uservalidationbyemail/validate/',
	'text' => elgg_echo('uservalidationbyemail:admin:validate'),
	'title' => elgg_echo('uservalidationbyemail:confirm_validate_checked'),
	'class' => 'uservalidationbyemail-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$resend_email = elgg_view('output/url', array(
	'href' => 'action/uservalidationbyemail/resend_validation/',
	'text' => elgg_echo('uservalidationbyemail:admin:resend_validation'),
	'title' => elgg_echo('uservalidationbyemail:confirm_resend_validation_checked'),
	'class' => 'uservalidationbyemail-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$delete = elgg_view('output/url', array(
	'href' => 'action/uservalidationbyemail/delete/',
	'text' => elgg_echo('uservalidationbyemail:admin:delete'),
	'title' => elgg_echo('uservalidationbyemail:confirm_delete_checked'),
	'class' => 'uservalidationbyemail-submit',
	'is_action' => true,
	'is_trusted' => true,
));

$bulk_actions = <<<___END
	<ul class="elgg-menu elgg-menu-general elgg-menu-hz float-alt">
		<li>$resend_email</li><li>$validate</li><li>$delete</li>
	</ul>

	$bulk_actions_checkbox
___END;

if (is_array($users) && count($users) > 0) {
	$html = '<ul class="elgg-list elgg-list-distinct">';
	foreach ($users as $user) {
		$html .= "<li id=\"unvalidated-user-{$user->guid}\" class=\"elgg-item uservalidationbyemail-unvalidated-user-item\">";
		$html .= elgg_view('uservalidationbyemail/unvalidated_user', array('user' => $user));
		$html .= '</li>';
	}
	$html .= '</ul>';
}

echo <<<___END
<div class="elgg-module elgg-module-inline uservalidation-module">
	<div class="elgg-head">
		$bulk_actions
	</div>
	<div class="elgg-body">
		$html
	</div>
</div>
___END;

if ($count > 5) {
	echo $bulk_actions;
}

echo $pagination;
