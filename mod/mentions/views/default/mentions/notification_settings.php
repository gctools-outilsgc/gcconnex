<?php
/**
 * User setting for mentions
 */

$user = elgg_get_page_owner_entity();

// if user has never set this, default it to on
if (false === elgg_get_plugin_user_setting('notify', $user->getGUID(), 'mentions')) {
	elgg_set_plugin_user_setting('notify', 1, $user->getGUID(), 'mentions');
}

$notify_label = elgg_echo('mentions:settings:send_notification');

$options = array(
	'name' => 'mentions_notify',
	'value' => 1
);

if (elgg_get_plugin_user_setting('notify', $user->getGUID(), 'mentions')) {
	$options['checked'] = 'checked';
}

$notify_field = elgg_view('input/checkbox', $options);

echo <<<___END
<p>
	<label>$notify_field $notify_label</label>
</p>
___END;
?>
