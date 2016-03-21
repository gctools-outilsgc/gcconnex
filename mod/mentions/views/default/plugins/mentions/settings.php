<?php
/**
 * Plugin settings for mentions
 */

$label = elgg_echo('mentions:fancy_links') . ' ';

$options = array(
	'name' => 'params[fancy_links]',
	'value' => 1
);

if (elgg_get_plugin_setting('fancy_links', 'mentions')) {
	$options['checked'] = 'checked';
}

$input = elgg_view('input/checkbox', $options);

?>

<label>
	<?php
		echo $input;
		echo $label;
	?>
</label>