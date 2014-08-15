<?php

/**
 * Elgg invite language file
 * 
 * @package ElggInviteFriends
 */

$french = array(

	'friends:invite' => 'Invite friends',
	
	'invitefriends:registration_disabled' => 'New user registration has been disabled on this site; you are unable to invite new users.',
	
#	'invitefriends:introduction' => 'To invite friends to join you on this network, enter their email addresses below (one per line):',
	'invitefriends:message' => 'Écrivez le message qui accompagnera votre invitation:',
	'invitefriends:subject' => 'Invitation to join %s',

	'invitefriends:success' => 'Your friends were invited.',
	'invitefriends:invitations_sent' => 'Invites sent: %s. There were the following problems:',
	'invitefriends:email_error' => 'The following addresses are not valid: %s',
	'invitefriends:already_members' => 'The following are already members: %s',
	'invitefriends:noemails' => 'No email addresses were entered.',
	
	'invitefriends:message:default' => '
Bonjour,

je vous invite à vous joindre à mon réseau, ici, sur %s.',

	'invitefriends:email' => '
You have been invited to join %s by %s. They included the following message:

%s

To join, click the following link:

%s

You will automatically add them as a friend when you create your account.',
	
	);
					
add_translation("fr", $french);
