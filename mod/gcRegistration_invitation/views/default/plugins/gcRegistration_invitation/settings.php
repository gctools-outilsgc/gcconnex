<?php
	function getInvitations($sort = 'ASC'){
		$query = "SELECT * FROM email_invitations ORDER BY id {$sort}";
		$result = get_data($query);
		return $result;
	}
?>

<style type="text/css">
	table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
	table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
	.active 			{ font-weight: bold; text-decoration: underline; }
</style>

<div>

<?php

function getActiveClass($type, $value){
	return ($_GET[$type] == $value) ? " class='active'" : "";
}

$sort = $_GET['sort'];
$sort_param = ($sort ? "&sort=" . $sort : "");
$invitations = getInvitations($sort);

if (count($invitations) > 0) {

	echo "<div class='mtm'>SORT: <a".getActiveClass('sort', 'asc')." href='?sort=asc'>0…9</a> / <a".getActiveClass('sort', 'desc')." href='?sort=desc'>9…0</a></div>";

	echo "<table name='display_extensions' width='100%' cellpadding='0' cellspacing='0' class='db-table'>";
	echo '<thead><tr> <th>'.elgg_echo('gcRegistration_invitation:id').'</th> <th>'.elgg_echo('gcRegistration_invitation:email').'</th> <th>'.elgg_echo('gcRegistration_invitation:inviter').'</th> <th>'.elgg_echo('gcRegistration_invitation:invitee').'</th> <th>'.elgg_echo('gcRegistration_invitation:timesent').'</th> <th>'.elgg_echo('gcRegistration_invitation:timeaccepted').'</th> </tr></thead>';
	foreach ($invitations as $invitation) {
		echo "<tbody><tr>";
		echo "<td>{$invitation->id}</td>";
		echo "<td>{$invitation->email}</td>";
		echo "<td>" . get_user($invitation->inviter)->name . "</td>";
		echo "<td>" . get_user($invitation->invitee)->name . "</td>";
		echo "<td>" . ($invitation->time_sent ? date("F j, Y", $invitation->time_sent) : "N/A") . "</td>";
		echo "<td>" . ($invitation->time_accepted ? date("F j, Y", $invitation->time_accepted) : "N/A") . "</td>";
		echo "</tr></tbody>";
	}
	echo "</table>";
}

?>

</div>