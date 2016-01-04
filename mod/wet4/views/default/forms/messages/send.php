<?php
/**
 * Compose message form
 *
 * @package ElggMessages
 * @uses $vars['$recipient_username']
 * @uses $vars['subject']
 * @uses $vars['body']
 */

$recipient_username = elgg_extract('recipient_username', $vars, '');
$subject = elgg_extract('subject', $vars, '');
$body = elgg_extract('body', $vars, '');

$recipient_autocomplete = elgg_view('input/autocomplete', array(
	'name' => 'recipient_username',
    'id' => 'recipient_username',
	'value' => $recipient_username,
	'match_on' => array('friends'),
));

?>
<div class="mrgn-bttm-md">
	<label for="recipient_username"><?php echo elgg_echo("email:to"); ?>: </label>
	<?php echo $recipient_autocomplete; ?>
	<span class="elgg-text-help"><?php echo elgg_echo("messages:to:help"); ?></span>
	
</div>
<div class="mrgn-bttm-md">
	<label for="subject"><?php echo elgg_echo("messages:title"); ?>: <br /></label>
	<?php echo elgg_view('input/text', array(
		'name' => 'subject',
        'id' => 'subject',
		'value' => $subject,
	));
	?>
</div>
<div class="mrgn-bttm-md">
	<label for="body"><?php echo elgg_echo("messages:message"); ?>:</label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
        'id' => 'body',
		'value' => $body,
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('send'), 'class' => 'btn btn-primary')); ?>
</div>
