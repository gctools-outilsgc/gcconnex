<?php
/**
 * Advanced site settings, content access section.
 */

$default_access_label = elgg_echo('installation:sitepermissions');
$default_access_input = elgg_view('input/access', array(
	'options_values' => array(
		ACCESS_PRIVATE => elgg_echo("PRIVATE"),
		ACCESS_FRIENDS => elgg_echo("access:friends:label"),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC"),
	),
	'name' => 'default_access',
	'id' => 'default_access',
	'value' => elgg_get_config('default_access'),
));

$user_default_access_input = elgg_view('input/checkbox', array(
	'name' => 'allow_user_default_access',
	'id' => 'allow_user_default_access',
	'checked' => (bool)elgg_get_config('allow_user_default_access'),
));


$script_access_default = elgg_view('input/checkbox', array(
	'name' => 'remove_logged_in',
	'checked' => (bool)elgg_get_config('remove_logged_in'),
));
?>

<fieldset class="elgg-fieldset" id="elgg-settings-advanced-content-access">
	<legend><?php echo elgg_echo('admin:legend:content_access'); ?></legend>
	
	<div>
		<label for="default_access">
			<?php echo $default_access_label; ?>
		</label>
			<?php echo $default_access_input; ?>

		<p class="elgg-text-help"><?php echo elgg_echo('admin:site:access:warning'); ?></p>
	</div>
		
	<div>
		<?php echo $user_default_access_input; ?>
		<label for="allow_user_default_access"> <?php echo elgg_echo('installation:allow_user_default_access:label'); ?></label>

		<p class="elgg-text-help">
			<?php echo elgg_echo('installation:allow_user_default_access:description'); ?>
		</p>
	</div>

	<div>
		<?php echo $script_access_default; ?>
		<label for="remove_logged_in"> <?php echo elgg_echo('admin:remove:logged_in'); ?></label>
	</div>
	
</fieldset>