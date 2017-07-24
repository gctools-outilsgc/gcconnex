<?php
/**
 * Reply form
 *
 * @uses $vars['message']
 */
 /*
 * GC_MODIFICATION
 * Description: Added accessible labels + message preview to form
 * Author: GCTools Team
 */
// fix for RE: RE: RE: that builds on replies
$reply_title = $vars['message']->title;
if (strncmp($reply_title, "RE:", 3) != 0) {
	$reply_title = "RE: " . $reply_title;
}

$username = '';
$user = get_user($vars['message']->fromId);
if ($user) {
	$username = $user->username;
}

echo elgg_view('input/hidden', array(
	'name' => 'recipient_username',
	'value' => $username,
));

echo elgg_view('input/hidden', array(
	'name' => 'original_guid',
	'value' => $vars['message']->guid,
));
?>

<div>
    <label for="subject"><?php echo elgg_echo("messages:title"); ?>: <br /></label>
	<?php echo elgg_view('input/text', array(
        'name' => 'subject',
        'id' => 'subject',
		'value' => $reply_title,
    'required' => 'required',
	));
	?>
</div>
<div>
	<label for="body"><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
        'id' => 'body',
		'value' => '',
    'required' => 'required',
    'class' => 'validate-me',
	));
	?>
</div>
<div class="elgg-foot mrgn-tp-sm">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('send')));
          echo  elgg_view('output/url', array('text' => elgg_echo('preview'), 'href' => 'ajax/view/messages/message_preview', 'class' => 'btn-default btn elgg-lightbox', 'id' => 'preview'));?>
</div>
