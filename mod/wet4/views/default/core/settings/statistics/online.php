<?php
/**
 * Statistics about this user.
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

$label_name = elgg_echo('usersettings:statistics:label:name');
$label_email = elgg_echo('usersettings:statistics:label:email');
$label_member_since = elgg_echo('usersettings:statistics:label:membersince');
$label_last_login = elgg_echo('usersettings:statistics:label:lastlogin');

$time_created = date("r", $user->time_created);
$last_login = date("r", $user->last_login);

$title = elgg_echo('usersettings:statistics:yourdetails');

$content = <<<__HTML
<table class="elgg-table-alt">
	<tr class="odd">
		<td class="column-one"><b>$label_name:</b></td>
		<td style="padding-left:10px">$user->name</td>
	</tr>
	<tr class="even">
		<td class="column-one"><b>$label_email:</b></td>
		<td style="padding-left:10px">$user->email</td>
	</tr>
	<tr class="odd">
		<td class="column-one"><b>$label_member_since:</b></td>
		<td style="padding-left:10px">$time_created</td>
	</tr>
	<tr class="even">
		<td class="column-one"><b>$label_last_login:</b></td>
		<td style="padding-left:10px">$last_login</td>
	</tr>
</table>
__HTML;

echo elgg_view_module('info', $title, $content);
