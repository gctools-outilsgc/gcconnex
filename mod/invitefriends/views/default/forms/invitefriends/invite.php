<?php

/**
 * Elgg invite form contents
 *
 * @package ElggInviteFriends
 */

$site = elgg_get_site_entity();
$default_message = elgg_echo('invitefriends:message:default', array($site->name));

$introduction = elgg_echo('invitefriends:introduction');

$emails_label = elgg_echo('invitefriends:emails');
$message_label = elgg_echo('invitefriends:message');

$emails = elgg_get_sticky_value('invitefriends', 'emails');
$message = elgg_get_sticky_value('invitefriends', 'emailmessage', $default_message);

$emails_textarea = elgg_view('input/plaintext', array(
	'id' => 'invitefriends-emails',
	'name' => 'emails',
	'value' => $emails,
	'rows' => 4,
));

$message_textarea = elgg_view('input/plaintext', array(
	'id' => 'invitefriends-emailmessage',
	'name' => 'emailmessage',
	'value' => $message,
));

$action_button = elgg_view('input/submit', array('value' => elgg_echo('send'), 'class' => 'mrgn-tp-sm btn btn-primary'));

elgg_load_css('multiple-emails');
elgg_load_js('multiple-emails');

echo <<< HTML
<p class="mbm elgg-text-help">$introduction</p>
<div class="form-group">
	<label for="invitefriends-emails">$emails_label</label>
	$emails_textarea
</div>
<div class="form-group">
	<label for="invitefriends-emailmessage">$message_label</label>
	$message_textarea
</div>
<div class="elgg-foot">
	$action_button
</div>

<script>
	$('#invitefriends-emails').multiple_emails();
	$('.elgg-form-invitefriends-invite').keydown(function(e){
		if( $(e.target).hasClass('multiple_emails-input') && e.keyCode == 13 ){ e.preventDefault(); }
	});
</script>
HTML;
