<?php
/**
 * content for the open group invitations widget
 */
$invitations = groups_get_invited_groups(elgg_get_logged_in_user_guid());

echo elgg_view("groups/invitationrequests", array("invitations" => $invitations));
