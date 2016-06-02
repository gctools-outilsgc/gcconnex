<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$recipient_username = $vars['recipient_username'];
$subject = $vars['subject'];
$body = $vars['body'];

$recipient_input = elgg_view('input/text', array(
		'name' => 'recipients',
		'value' => $recipient_username,
		'id' => 'mission-message-share-recipients-text-input'
));

$subject_input = elgg_view('input/text', array(
		'name' => 'subject',
		'value' => $subject,
		'id' => 'mission-message-share-subject-text-input'
));

$body_input = elgg_view('input/plaintext', array(
		'name' => 'body',
		'value' => $body,
		'id' => 'mission-message-share-body-long-text-input'
));
?>

<div class="form-group">
	<label for="mission-message-share-recipients-text-input" class="col-sm-2" style="text-align:right;">
		<?php echo elgg_echo('missions:share_with') . ': '; ?>
	</label>
	<div class="col-sm-8">
		<?php echo $recipient_input; ?>
		<div>
			<?php echo elgg_echo('missions:share_user_input_help'); ?>
		</div>
	</div>
</div>
<div class="form-group">
	<label for="mission-message-share-subject-text-input" class="col-sm-2" style="text-align:right;">
		<?php echo elgg_echo('missions:subject') . ': '; ?>
	</label>
	<div class="col-sm-8">
		<?php echo $subject_input; ?>
	</div>
</div>
<div class="form-group">
	<label for="mission-message-share-body-long-text-input" class="col-sm-2" style="text-align:right;">
		<?php echo elgg_echo('missions:message') . ': '; ?>
	</label>
	<div class="col-sm-8">
		<?php echo $body_input; ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:send'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-message-user-form-submission-button'
		));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-message-user-form-submission-button'));
	?> 
</div>