<?php
/**
 * Etherpad plugin settings
 */

// set default value

if (!isset($vars['entity']->etherpad_host)) {
	$vars['entity']->etherpad_host = "http://beta.etherpad.org";
}
if (!isset($vars['entity']->etherpad_key)) {
	$vars['entity']->etherpad_key = 'EtherpadFTW';
}
if (!isset($vars['entity']->integrate_in_pages)) {
	$vars['entity']->integrate_in_pages = 'no';
}
if (!isset($vars['entity']->show_fullscreen)) {
	$vars['entity']->show_fullscreen = 'no';
}
if (!isset($vars['entity']->show_chat)) {
	$vars['entity']->show_chat = 'no';
}

if (!isset($vars['entity']->line_numbers)) {
	$vars['entity']->line_numbers = 'no';
}

if (!isset($vars['entity']->monospace_font)) {
	$vars['entity']->monospace_font = 'no';
}

if (!isset($vars['entity']->show_controls)) {
	$vars['entity']->show_controls = 'yes';
}

if (!isset($vars['entity']->show_comments)) {
	$vars['entity']->show_comments = 'yes';
}

if (!isset($vars['entity']->new_pad_text)) {
	$vars['entity']->new_pad_text = elgg_echo('etherpad:pad:message');
}

?>
<div>
    <br /><label><?php echo elgg_echo('etherpad:etherpadhost'); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'params[etherpad_host]', 'value' => $vars['entity']->etherpad_host, 'class' => 'text_input',)); ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:etherpadkey'); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'params[etherpad_key]', 'value' => $vars['entity']->etherpad_key, 'class' => 'text_input',)); ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:newpadtext'); ?></label><br />
    <?php echo elgg_view('input/text',array('name' => 'params[new_pad_text]', 'value' => $vars['entity']->new_pad_text, 'class' => 'text_input',)); ?>
</div>

<div>
    <br /><label><?php echo elgg_echo('etherpad:integrateinpages'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[integrate_in_pages]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->integrate_in_pages,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:showfullscreen'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[show_fullscreen]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->show_fullscreen,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:showcontrols'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[show_controls]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->show_controls,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:showchat'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[show_chat]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->show_chat,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:linenumbers'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[line_numbers]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->line_numbers,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:monospace'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[monospace_font]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->monospace_font,
	));
    ?>
</div>

<div>
    <label><?php echo elgg_echo('etherpad:showcomments'); ?></label><br />
    <?php echo elgg_view('input/dropdown', array(
		'name' => 'params[show_comments]',
		'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')),
		'value' => $vars['entity']->show_comments,
	));
    ?>
</div>
